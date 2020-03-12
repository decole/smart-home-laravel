<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMqttSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->timestamps();

            $table->index(['name', 'type']);
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->timestamps();

            $table->index(['name', 'location']);
        });

        Schema::create(/**
         * @param Blueprint $table
         */
            'mqtt_sensors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('topic');
            $table->string('payload');
            $table->string('message_info');
            $table->string('message_ok');
            $table->string('message_warn');
            $table->unsignedBigInteger('type');
            $table->unsignedBigInteger('location');
            $table->timestamps();

            $table->index(['name', 'topic', 'type']);
            $table->foreign('type')->references('id')->on('type_devices');
            $table->foreign('location')->references('id')->on('locations');
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
            $table->dropForeign('type');
            $table->dropForeign('locations');
            $table->dropIndex(['name', 'topic', 'type']);
        });

        Schema::table('type_devices', function (Blueprint $table) {
            $table->dropIndex(['name', 'type']);
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropIndex(['name', 'location']);
        });

        Schema::dropIfExists('mqtt_sensors');

        Schema::dropIfExists('type_devices');

        Schema::dropIfExists('locations');
    }
}
