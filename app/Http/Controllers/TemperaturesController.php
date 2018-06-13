<?php

namespace App\Http\Controllers;

use App\Temperature;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    public function index()
    {
        $cooler = Temperature::latest()->where('room', '=', 'cooler')->get();
	$freezer = Temperature::latest()->where('room', '=', 'freezer')->get();
        
        return view('temperatures.index', compact('cooler', 'freezer'));
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

        if ($temp->save()) {
            return response('Success', 200);
        } else {
            return response('Error, could not save temperature', 404);
	}
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

    public function cooler(Temperature $temperature)
    {
        $temps = Temperature::where('id', '<', 79)->orderBy('id', 'asc')->get();

        $avg = Temperature::select(
	    \DB::raw('avg(degrees) avg,
	    min(degrees) min,
	    max(degrees) max,
	    count(id) count'))->where('id', '<', 79)->first();

        return view('temperatures.index', [
	    'temperatures' => $temps,
	    'avg' => $avg->avg,
	    'min' => $avg->min,
	    'max' => $avg->max,
	    'count' => $avg->count
	]);
    }
}
