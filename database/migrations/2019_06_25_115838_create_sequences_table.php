<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSequencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sequences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('action');
            $table->json('action_params')->nullable();
            $table->integer('duration');
            $table->unsignedBigInteger('test_case_id');
            $table->timestamps();

            $table->foreign('test_case_id')->references('id')->on('test_cases')->onDelete('Cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sequences');
    }
}
