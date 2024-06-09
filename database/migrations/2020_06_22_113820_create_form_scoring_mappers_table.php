<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormScoringMappersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_scoring_mappers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->string('score_type_uid', 50);
            $table->string('questionnaire_uid', 50);
            $table->unsignedBigInteger('form_field_id');
            $table->boolean('is_required')->default(false);
            $table->json('map_data')->nullable();
            $table->foreign('form_field_id')->references('id')->on('form_fields')
                ->onDelete('No Action');
            $table->foreign('form_id')->references('id')->on('forms')
                ->onDelete('No Action');
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
        Schema::dropIfExists('form_scoring_mappers');
    }
}
