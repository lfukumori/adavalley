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
            $table->string('number', 10)->nullable();
            $table->string('brand', 50)->nullable();
            $table->string('model', 50)->nullable();
            $table->string('serial_number', 50)->nullable();
            $table->text('description')->nullable();
            $table->string('department')->nullable();
            $table->string('category')->nullable();
            $table->unsignedInteger('weight')->nullable();
            $table->date('purchase_date')->nullable();
            $table->unsignedInteger('purchase_value')->nullable();
            $table->unsignedInteger('depreciation_value')->nullable();
            $table->string('depreciation_note')->nullable();
            $table->unsignedInteger('depreciated_value')->nullable();
            $table->unsignedInteger('real_value')->nullable();
            $table->unsignedInteger('current_value')->nullable();
            $table->string('use_of_equipment', 100)->nullable();
            $table->boolean('active')->default(true);
            $table->string('location')->nullable();
            $table->string('manual_url')->nullable();
            $table->string('manual_file_location')->nullable();
            $table->string('procedures_location')->nullable();
            $table->string('schematics_location')->nullable();
            $table->date('date_removed')->nullable();
            $table->unsignedInteger('service_by_days')->nullable();
            $table->string('status')->nullable();
            $table->string('account_asset_number')->nullable();
            $table->string('size_x')->nullable();
            $table->string('size_y')->nullable();
            $table->string('size_z')->nullable();

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
