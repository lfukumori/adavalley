<?php

use Tests\Feature\Equipment\AddEquipmentTest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/tests', function() {
    $tests = preg_grep('/^equipment/', get_class_methods(new \Tests\Feature\Equipment\PurchaseEquipmentTest));

    $response = "<h3>Purchasing Equipment</h3><ol>";

    foreach ($tests as $test) {
        $response .= "<li>{$test}</li>";
    }

    return $response . "</ol>";
});

Route::post('/temperature', 'TemperaturesController@store');
Route::get('/temperature/{date?}', 'TemperaturesController@index');

Route::get('/', 'HomeController@index');

Route::resource('equipment', 'EquipmentController');

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
