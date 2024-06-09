<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreQuestionnaireGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *2
     * @return void
     */
    public function up()
    {
        Schema::create('score_questionnaire_groups', function (Blueprint $table) {
            $table->bigIncrements('group_id');
            $table->string('score_type_uid',50);
            $table->string('group_title',128);
            $table->unsignedSmallInteger('group_sequence');
            $table->boolean('is_display_title')->default(true);
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
        Schema::dropIfExists('score_questionnaire_groups');
    }
}
