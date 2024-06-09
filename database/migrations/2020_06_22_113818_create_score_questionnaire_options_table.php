<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreQuestionnaireOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *4
     * @return void
     */
    public function up()
    {
        Schema::create('score_questionnaire_options', function (Blueprint $table) {
            $table->bigIncrements('option_id');
            $table->string('questionnaire_uid', 50);
            $table->string('option_value');
            $table->unsignedSmallInteger('option_sequence')->default(0);
            $table->double('option_score')->default(0.0);
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
        Schema::dropIfExists('score_questionnaire_options');
    }
}
