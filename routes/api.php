<?php

use App\Temperature;
use Illuminate\Http\Request;

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
    echo Temperature::where('room', $room)
	->orderBy('id', 'desc')
	->take(1)
	->value('degrees');
})->middleware('cors');

Route::get('/temperatures', function () {
    $temps = Temperature::latest()->take(2)->get();

    return json_encode([
        ['room' => $temps->first()->room, 'degrees' => $temps->first()->degrees, 'time' => $temps->first()->created_at->format('g:i A')],
        ['room' => $temps->last()->room, 'degrees' => $temps->last()->degrees, 'time' => $temps->last()->created_at->format('g:i A')]
    ]);
})->middleware('cors');
