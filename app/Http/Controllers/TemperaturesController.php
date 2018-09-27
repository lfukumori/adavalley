<?php

namespace App\Http\Controllers;

use App\Temperature;
use App\Events\TemperatureLogged;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class TemperaturesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        try {
            $date = (new Carbon($request->date))->format('Y-m-d');
        } catch (\Exception $e) {
            $date = (Carbon::now()->format('Y-m-d'));
        }
        
        $cooler = Temperature::latest()
            ->where('room', 'cooler')
            ->whereDate('created_at', '=', $date)
            ->get();

        $freezer1 = Temperature::latest()
            ->where('room', 'freezer1')
            ->whereDate('created_at', '=', $date)
            ->get();

        $freezer2 = Temperature::latest()
            ->where('room', 'freezer2')
            ->whereDate('created_at', '=', $date)
            ->get();

        $room6 = Temperature::latest()
            ->where('room', 'room6')
            ->whereDate('created_at', '=', $date)
            ->get();
     
        return view('temperatures.index', compact('cooler', 'freezer1', 'freezer2', 'room6', 'date'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $temp = new Temperature;
        $temp->degrees = $request->degrees;
        $temp->scale = $request->scale;
	    $temp->room = $request->room;

        if (! $temp->save()) {
            return response('Error, could not save temperature', 500);
        }

        event(new TemperatureLogged($temp));

        return response('Success', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Temperature  $temperature
     * @return \Illuminate\Http\Response
     */
    public function show(Temperature $temperature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Temperature  $temperature
     * @return \Illuminate\Http\Response
     */
    public function edit(Temperature $temperature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Temperature  $temperature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Temperature $temperature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Temperature  $temperature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Temperature $temperature)
    {
        //
    }
}