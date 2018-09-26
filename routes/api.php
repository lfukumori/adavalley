<?php

use App\Temperature;
use App\TemperatureMonitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use EDI\X12\Parser;
use App\FA997SuccessMapper;
use EDI\X12\SpartanNash\Maps\AcknowledgmentMap;
use ERP\Orders\SalesOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/test', function (Request $request) {
    $output = Artisan::call('edi:watch');
    dd($output);
});

Route::get('/alerts/dismiss/{id}/{name}', function ($id, $name) {
    if (!$name || !$id) return response('Data Error!', 500);

    $monitor = TemperatureMonitor::find($id);
    
    if ($monitor->dismissed) {
        return response("{$monitor->dismissed_by} has already dismissed this alert.", 200);
    }

    if ($monitor->dismiss($name)) {
        $employees = [
            'brian' => 'bdbriandupont@gmail.com',
        ];

        foreach ($employees as $name => $email) {
            if (strtolower($name) != strtolower($monitor->dismissed_by)) {
                Mail::send('emails.alert-dismissed', ['monitor' => $monitor], function ($message) use ($email) {
                    $message->from('brian@adavalley.com', 'Temp Alert');
                    $message->to($email);
                });
            }
        }

        return response('Alert has been dismissed, and other employees have been notified.', 200);
    }

    Mail::send('emails.alert-brian', ['error' => "{$name} tried to dismiss an alert, but could not save the alert ({$monitor->id}) in database."], function ($message) {
        $message->from('brian@adavalley.com', 'Temp Alert');
        $message->to('bdbriandupont@gmail.com');
    });

    return response('Error dismissing the alert!', 500);
})->middleware('cors');

Route::get('/temperatures/{room}', function ($room) {
    $temperature = Temperature::latest()->where('room', '=', $room)->first();

    return $temperature->toJson();
})->middleware('cors');

Route::get('/temperatures', function () {
    $cooler =   Temperature::latest()->where('room', '=', 'cooler')->first();
    $freezer1 = Temperature::latest()->where('room', '=', 'freezer1')->first(); // old freezer
    $freezer2 = Temperature::latest()->where('room', '=', 'freezer2')->first(); // new freezer
    $room6 =    Temperature::latest()->where('room', '=', 'room6')->first();

    return json_encode([
        ['room' => $cooler->room, 'degrees' => $cooler->degrees, 'time' => $cooler->created_at->format('g:i A')],
        ['room' => $freezer1->room, 'degrees' => $freezer1->degrees, 'time' => $freezer1->created_at->format('g:i A')],
        ['room' => $freezer2->room, 'degrees' => $freezer2->degrees, 'time' => $freezer2->created_at->format('g:i A')],
        ['room' => $room6->room, 'degrees' => $room6->degrees, 'time' => $room6->created_at->format('g:i A')]
    ]);
})->middleware('cors');

Route::get('calibration/offset/{room}', function (Request $request) {
    return Storage::get("calibration-offsets/{$request->room}.php");
});

Route::post('calibration/offset', function (Request $request) {
    $offset = $request->offset;
    $room = $request->room;

    if (! $room) return response('Error: Need a room to save calibration offset.', 417);
    if (! $offset) return response('Error: Could not save calibration offset.', 417);

    try {
      $oldOffset = Storage::get("calibration-offsets/{$room}.php");
    } catch (\Exception $e) {
      $oldOffset = 0;
    }
    
    if (is_numeric($offset)) {
      $offset = $oldOffset + $offset;

      if (Storage::put("calibration-offsets/{$room}.php", $offset)) {
        return response()->json([
          "success" => true,
          "offset" => $offset
        ]);
      } else {
        return response()->json([
          "success" => false,
          "offset" => null
        ]);
      }
    }

    return response('Error saving offset.', 417);
});

Route::post('/edi/outgoing', function (Request $request) {
    dd('test');
});

Route::post('/edi/incoming ', function (Request $request) {
    $messages = [];

    try {
        // parse into collection of documents
        $documents = collect(Parser::parse(file_get_contents($request->filepath)));

        foreach ($documents as $document) {
            // insert order into ERP dashboard
            $order = $document->buildErpOrder();

            $erpSuccess = insertErpOrder($order);

            if ($erpSuccess) {
                $mapper = new FA997SuccessMapper($document, new AcknowledgmentMap);

                $filename = "{$document->transactionType()}-{$document->poNumber()}";

                $messages[$filename] = $mapper->map();
            } else {
                Mail::send('emails.alert-brian', ['error' => "ERP insert error. {$document->originalControlNumber()}"], function ($message) {
                    $message->from('brian@adavalley.com', 'Brian DuPont');
                    $message->to('bdbriandupont@gmail.com');
                    $message->subject('EDI CURL Error');
                });
            }
        }

        if (count($messages) > 0) {
            return response()->json(['success' => true, 'messages' => $messages]);
        } else {
            return response()->json(['success' => false]);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => 'error']);
    }
})->middleware('cors');

function insertErpOrder($order) {
    DB::transaction(function () {
        $orderId = DB::connection('av_production')->table('order_header')->insertGetId([
            'PONBR' => $order->po_number,
            'customer_id' => $order->customer_id,
            'order_date' => $order->order_date,
            'ship_date' => $order->expected_date,
            'status' => $order->status,
            'ship_to_id' => $order->ship_to_id,
            'totol_weight_invoiced' => $order->total,
        ]);

        $order->id = $orderId;

        $ch = curl_init("http://192.168.1.10/functions/add_edi_items_to_order.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            [
                'items' => json_encode($order->items),
                'customer_id' => $order->customer_id,
                'order_id' => $order->id
            ]
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $success = curl_exec($ch);

        curl_close($ch);

        if (!$success) {
            Mail::send('emails.alert-brian', ['error' => 'Error adding order_details to ERP sales order. Transaction rolled back.'], function ($message) {
                $message->from('brian@adavalley.com', 'Brian DuPont');
                $message->to('bdbriandupont@gmail.com');
                $message->subject('EDI CURL Error');
            });

            throw new \Exception('Could not add item to edi order_header');
            return false;
        } else {
            Mail::send('emails.alert-brian', ['error' => 'Error adding EDI order_header to ERP system. Transaction rolled back.'], function ($message) {
                $message->from('brian@adavalley.com', 'Brian DuPont');
                $message->to('bdbriandupont@gmail.com');
                $message->subject('EDI Database Error');
            });

            return true;
        }
    });
}