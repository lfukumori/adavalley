<?php

namespace App\Http\Controllers;

use App\Status;
use App\Equipment;
use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
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
    public function store(Request $request)
    {
        $today = date('Ymd');

        $equipmentData = $request->validate([
            "number" => ["required", "alpha_num", "max:6", Rule::unique('equipment')],
            "brand" => "alpha_dash|max:50",
            "model" => "alpha_dash|max:50",
            "serial_number" => "alpha_dash|max:50",
            "description" => "nullable",
            "weight" => "integer|digits_between:0,4",
            "purchase_date" => "date|before_or_equal:{$today}",
            "purchase_value" => "numeric|min:0|nullable",
            "depreciation_amount" => "numeric|min:0|max:{$request->purchase_value}|nullable",
            "use_of_equipment" => "max:100|nullable",
            "manual_url" => "url|nullable",
            "service_by_days" => "integer|between:0,365",
            "size_x" => "numeric|min:0",
            "size_y" => "numeric|min:0",
            "size_z" => "numeric|min:0",
            "account_asset_number" => "alpha_dash|max:50|nullable",
            "department_id" => "exists:departments,id",
            "status_id" => "exists:statuses,id"
        ]);

        $equipment = Equipment::create($equipmentData);

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
    public function update(Request $request, Equipment $equipment)
    {
        $today = date('Ymd');

        $equipmentData = $request->validate([
            "number" => ["required", "alpha_num", "max:6", Rule::unique('equipment')->ignore($equipment->id)],
            "brand" => "alpha_dash|max:50",
            "model" => "alpha_dash|max:50",
            "serial_number" => "alpha_dash|max:50",
            "description" => "nullable",
            "weight" => "integer|digits_between:0,4",
            "purchase_date" => "date|before_or_equal:{$today}",
            "purchase_value" => "numeric|min:0|nullable",
            "depreciation_amount" => "numeric|min:0|max:{$request->purchase_value}|nullable",
            "use_of_equipment" => "max:100|nullable",
            "manual_url" => "url|nullable",
            "service_by_days" => "integer|between:0,365",
            "size_x" => "numeric|min:0",
            "size_y" => "numeric|min:0",
            "size_z" => "numeric|min:0",
            "account_asset_number" => "alpha_dash|max:50|nullable",
            "department_id" => "exists:departments,id",
            "status_id" => "exists:statuses,id"
        ]);

        $equipment->update($equipmentData);

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
