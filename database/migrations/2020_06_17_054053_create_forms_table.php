<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('partner_uid', 50);
            $table->string('name', 128);
            $table->string('form_id', 56)->nullable()->comment('HTML form id');
            $table->string('action_url')->nullable()->comment('form submission url after validation');
            $table->string('form_class')->nullable()->comment('HTML form class');
            $table->unsignedBigInteger('parent_form_id')->nullable()->comment('only for dependant forms');
            $table->string('form_type_code', 50);
            $table->boolean('is_form_step_multiple')->default(false)->comment('single = 0 / multiple = 1');
            $table->boolean('is_layer_type_multiple')->default(false)->comment('single = 0 / multiple = 1');
            $table->boolean('is_scoring_enable')->default(false);
            $table->boolean('status')->default(false)->comment('active/inactive');
            $table->string('score_type_uid', 50)->nullable();
            $table->string('kyc_type', 100)->nullable();
            $table->string('allowed_platform_type')->nullable()->comment('In comma separator');
            $table->enum('method', ['GET', 'POST', 'PATCH', 'PUT', 'DELETE', 'HEAD', 'UPDATE'])->default('GET');
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('partner_uid')->references('partner_uid')->on('partners')->cascadeOnDelete();
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
        Schema::dropIfExists('forms');
    }
}
