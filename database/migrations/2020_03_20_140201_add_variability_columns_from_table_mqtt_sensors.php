<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVariabilityColumnsFromTableMqttSensors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mqtt_sensors', function (Blueprint $table) {
            $table->integer('from_condition')->nullable();
            $table->integer('to_condition')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mqtt_sensors', function (Blueprint $table) {
            $table->dropColumn(['from_condition', 'to_condition']);
        });
    }
}
