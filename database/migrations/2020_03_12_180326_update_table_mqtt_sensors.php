<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableMqttSensors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mqtt_sensors', function (Blueprint $table) {
            $table->string('message_info')->nullable()->change();
            $table->string('message_ok')->nullable()->change();
            $table->string('message_warn')->nullable()->change();
            $table->unsignedBigInteger('type')->nullable()->change();
            $table->unsignedBigInteger('location')->nullable()->change();
            $table->dropColumn('payload');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
