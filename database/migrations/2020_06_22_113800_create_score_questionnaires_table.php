<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreQuestionnairesTable extends Migration
{
    /**
     * Run the migrations.
     *3
     * @return void
     */
    public function up()
    {
        Schema::create('score_questionnaires', function (Blueprint $table) {
            $table->bigIncrements('questionnaire_id');
            $table->unsignedBigInteger('group_id');
            $table->string('questionnaire_uid', 50);
            $table->string('score_type_uid', 50);
            $table->string('questionnaire_title');
            $table->unsignedSmallInteger('questionnaire_sequence');
            $table->boolean('has_multiple_option')->default(false);
            $table->boolean('is_active')->default(false);
            $table->boolean('is_required')->default(false);
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
        Schema::dropIfExists('score_questionnaires');
    }
}
