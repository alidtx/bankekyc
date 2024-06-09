<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->string('field_type', 16)->comment('input,select,textarea..');
            $table->string('data_type', 16)->comment('text,number,email,password...')->nullable();
            $table->string('label', 128);
            $table->string('placeholder')->nullable();
            $table->string('field_name')->comment('input field name attribute');
            $table->string('field_default_value')->comment('default value of input field value attribute')->nullable();
            $table->unsignedSmallInteger('min_length')->nullable();
            $table->unsignedSmallInteger('max_length')->nullable();
            $table->string('pattern')->nullable();
            $table->string('custom_validation')->nullable();//@todo need to use in back0
            $table->json('additional_attributes')->nullable();
            $table->json('options')->nullable()->comment('option is needed when you field_type is select or radio-box');
            $table->boolean('is_required')->default(false);
            $table->boolean('is_disabled')->default(false);
            $table->boolean('is_readonly')->default(false);
//            $table->unsignedSmallInteger('sequence');
            $table->boolean('is_validation_required')->default(false);
            $table->boolean('is_nid_verification')->default(false);
            $table->boolean('is_score_mapping')->default(false);
            $table->string('validation_api_url')->nullable();
            $table->string('api_endpoint',255)->nullable();
            $table->string('file_source',100)->nullable();
            $table->string('response_required_keys')->nullable()->comment('comma separated if multiple');
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('form_fields');
    }
}
