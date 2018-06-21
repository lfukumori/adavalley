<?php

use App\Temperature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

Route::get('/temperatures/{room}', function ($room) {
    do {
        usleep(500000); // 1/2 second

        $data = json_decode(
            str_replace("'", '"', file_get_contents("http://192.168.1.170/{$room}")),
            true
        );
    } while ($data['status'] != 200);
    
    echo $data['degrees'];
})->middleware('cors');

Route::get('/temperatures', function () {
    $cooler = Temperature::latest()->where('room', '=', 'cooler')->first();
    $freezer = Temperature::latest()->where('room', '=', 'freezer')->first();

    return json_encode([
        ['room' => $cooler->room, 'degrees' => $cooler->degrees, 'time' => $cooler->created_at->format('g:i A')],
        ['room' => $freezer->room, 'degrees' => $freezer->degrees, 'time' => $freezer->created_at->format('g:i A')]
    ]);
})->middleware('cors');

Route::get('calibration-offset', function () {
    return Storage::get('calibration-offset.txt');
});

Route::post('calibration-offset', function (Request $request) {
    $offset = $request->all()['offset'];

    if (is_numeric($offset)) {

        if (Storage::put('calibration-offset.txt', $offset)) {
            return response('Success', 200);
        }
    }

    return response('Error: Could not save calibration offset', 417);
});
