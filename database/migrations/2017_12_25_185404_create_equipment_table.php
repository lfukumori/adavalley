<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('brand', 30)->nullable();
            $table->string('model', 30)->nullable();
            $table->string('serial_number', 30)->nullable();
            $table->string('description')->nullable();
            $table->integer('weight')->nullable();
            $table->date('purchase_date')->nullable();
            $table->integer('purchase_value')->nullable();
            $table->integer('depreciated_value')->nullable();
            $table->integer('depreciation_value')->nullable();
            $table->string('depreciation_note')->nullable();
            $table->integer('current_value')->nullable();
            $table->string('use_of_equipment')->nullable();
            $table->boolean('active')->default(true);
            $table->string('location')->nullable();
            $table->string('manual_url')->nullable();
            $table->string('manual_file_location')->nullable();
            $table->string('procedures_location')->nullable();
            $table->string('schematics_location')->nullable();
            $table->date('date_removed')->nullable();
            $table->integer('service_by_days')->nullable();
            $table->string('status')->nullable();
            $table->date('date_stored')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment');
    }
}