<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreTypesTable extends Migration
{
    /**
     * Run the migrations.
     * 1
     * @return void
     */
    public function up()
    {
        Schema::create('score_types', function (Blueprint $table) {
            $table->unsignedBigInteger('score_type_id');
            $table->string('score_type_uid',56);
            $table->string('score_type_title');
            $table->foreign('score_type_id')->references('id')->on('score_types')
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
        Schema::dropIfExists('score_types');
    }
}
