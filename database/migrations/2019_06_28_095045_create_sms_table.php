<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('serial_number')->unique()->index();
            $table->bigInteger('imei')->nullable();
            $table->string('event_name')->nullable();
            $table->string('session_id')->nullable();
            $table->string('sim_ccid')->nullable();
            $table->string('network_operator')->nullable();
            $table->smallInteger('signal_quality')->nullable();
            $table->double('battery_voltage')->nullable();
            $table->string('firmware_version')->nullable();
            $table->integer('network_fail')->nullable();
            $table->integer('modem_fail')->nullable();
            $table->integer('gprs_fail')->nullable();
            $table->text('other')->nullable();
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
        Schema::dropIfExists('sms');
    }
}
