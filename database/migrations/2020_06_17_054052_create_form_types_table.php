<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('account_type');
            $table->string('type_code',50);
            $table->string('title',56);
            $table->string('icon', 100)->nullable();
            $table->string('color', 20)->nullable();
            $table->string('description')->nullable()->comment('what type od form is this');
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
        Schema::dropIfExists('form_types');
    }
}
