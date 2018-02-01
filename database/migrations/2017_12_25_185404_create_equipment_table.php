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
            $table->string('number', 5)->nullable();
            $table->string('brand', 50)->nullable();
            $table->string('model', 50)->nullable();
            $table->string('serial_number', 50)->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('weight')->nullable();
            $table->string('purchase_value', 20)->nullable();
            $table->date('purchase_date')->nullable();
            $table->unsignedInteger('depreciation_amount')->nullable();
            $table->string('depreciation_note', 255)->nullable();
            $table->string('use_of_equipment', 100)->nullable();
            $table->string('manual_url')->nullable();
            $table->string('manual_file_location')->nullable();
            $table->string('procedures_location')->nullable();
            $table->string('schematics_location')->nullable();
            $table->unsignedInteger('service_by_days')->nullable();
            $table->string('account_asset_number', 50)->nullable();
            $table->string('size_x', 10)->nullable();
            $table->string('size_y', 10)->nullable();
            $table->string('size_z', 10)->nullable();

            $table->softDeletes();
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
