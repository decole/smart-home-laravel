<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('command');
            $table->string('interval')->nullable();
            $table->dateTime('last_run')->nullable();
            $table->dateTime('next_run')->nullable();
            $table->timestamp('created')->useCurrent();
            $table->timestamp('updated')->useCurrent();

            $table->index(['next_run', 'command']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
