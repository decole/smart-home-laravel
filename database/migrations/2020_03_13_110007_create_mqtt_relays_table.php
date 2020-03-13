<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMqttRelaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mqtt_relays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('topic');
            $table->string('check_topic')->nullable();
            $table->string('command_on')->nullable();
            $table->string('command_off')->nullable();
            $table->string('check_command_on')->nullable();
            $table->string('check_command_off')->nullable();
//          $table->string('payload')->nullable();
            $table->string('last_command')->nullable();
            $table->string('message_info')->nullable();
            $table->string('message_ok')->nullable();
            $table->string('message_warn')->nullable();
            $table->unsignedBigInteger('type')->nullable();
            $table->unsignedBigInteger('location')->nullable();
            $table->boolean('notifying')->nullable();
            $table->boolean('active')->nullable();
            $table->timestamps();

            $table->index(['name', 'topic', 'check_topic', 'location']);
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
        Schema::dropIfExists('mqtt_relays');
    }
}
