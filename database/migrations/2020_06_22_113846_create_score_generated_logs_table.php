<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreGeneratedLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_generated_logs', function (Blueprint $table) {
            $table->bigIncrements('scoring_request_id');
            $table->json('request_payload');
            $table->double('generated_score')->default(0.0);
            $table->json('user_agent_data')->nullable();
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('application_user_id')->nullable();
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
        Schema::dropIfExists('score_generated_logs');
    }
}
