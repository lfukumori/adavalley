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
    $cooler = Temperature::latest()->where('room', '=', 'cooler')->first();
    $freezer = Temperature::latest()->where('room', '=', 'freezer')->first();

    return json_encode([
        ['room' => $cooler->room, 'degrees' => $cooler->degrees, 'time' => $cooler->created_at->format('g:i A')],
        ['room' => $freezer->room, 'degrees' => $freezer->degrees, 'time' => $freezer->created_at->format('g:i A')]
    ]);
})->middleware('cors');
