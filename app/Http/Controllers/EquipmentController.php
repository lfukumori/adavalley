<?php

namespace App\Http\Controllers;

use App\Status;
use App\Equipment;
use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\PurchaseEquipmentRequest;

class EquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('equipment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('equipment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\PurchaseEquipmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseEquipmentRequest $request)
    {
        $equipment = Equipment::create($request->validate());

        return view('equipment.show', compact('equipment'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function show(Equipment $equipment)
    {
        return view('equipment.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipment $equipment)
    {
        return view('equipment.edit', compact('equipment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseEquipmentRequest $request, Equipment $equipment)
    {
        $equipment->update($request->validate());

        return view('equipment.show', compact('equipment'));
    }

    /**
     * Remove the specified resource from production to storage.
     *
     * @param  \App\Equipment  $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);

        $equipment->store();

        return view('equipment.index');
    }
}
