<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestCaseLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_case_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('test_case_summary_id')->index();
            $table->string('action')->index();
            $table->unsignedBigInteger('sequence_id')->index();
            $table->text('response');
            $table->integer('status');
            $table->integer('wait_time');
            $table->timestamps();

            $table->foreign('test_case_summary_id')->references('id')->on('test_case_summaries');
            $table->foreign('sequence_id')->references('id')->on('sequences');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_case_logs');
    }
}
