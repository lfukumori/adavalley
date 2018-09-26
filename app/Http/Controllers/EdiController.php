<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use EDI\X12\Parser;
use EDI\X12\Document;

class EdiController extends Controller
{
	public function index(Request $request)
    {
    	return 'ok';
    }

    public function store(Request $request)
    {
    	$message = $request->message;
    	$name = $request->name;

    	if (empty($name) || empty($message)) {
    		return 'Error getting name and message body';
    	}

        if (Storage::put("{$name}.txt", $message)) {
            $path = storage_path() . "/edi-messages/{$name}.txt";

            $parsedDocuments = collect(Parser::parse($message));
            dd($parsedDocuments);
            $orders = new Collection;

            // Convert EDI message to AVG ERP order.
            $parsedDocuments->each(function ($document, $key) {
                try {
                    $orders->put($document->buildErpOrder());
                } catch (\Exception $e) {
                    return 'Build Error';
                }
            });

            // Save message into database.
            dd($orders);

            // Send email?

            return $message;
        } else {
            return 'Storage Error';
        }
    }
}
