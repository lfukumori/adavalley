<?php

namespace App\Http\Controllers;

use App\Temperature;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TemperaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $temperatures = Temperature::latest()->get();
  
        return view('temperatures.index', compact('temperatures'));
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

        if ($temp->save()) {
            return response('Success', 200);
        }

        return response('Error', 404);
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
