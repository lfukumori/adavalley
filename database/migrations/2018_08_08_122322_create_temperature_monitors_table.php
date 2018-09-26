<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemperatureMonitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temperature_monitors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('room');
            $table->integer('degrees');
            $table->string('scale')->default('F');
            $table->boolean('dismissed')->default(false);
            $table->string('dismissed_by')->nullable();
            $table->unsignedInteger('minutes')->default(0);
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
        Schema::dropIfExists('temperature_monitors');
    }
}
