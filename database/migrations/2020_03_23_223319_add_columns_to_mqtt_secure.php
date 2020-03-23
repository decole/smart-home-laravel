<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToMqttSecure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mqtt_secure', function (Blueprint $table) {
            $table->string('normal_condition')->nullable();
            $table->string('alarm_condition')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mqtt_secure', function (Blueprint $table) {
            $table->dropColumn(['normal_condition', 'alarm_condition']);
        });
    }
}
