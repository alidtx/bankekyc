<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->string('name', 128);
            $table->string('form_platform_type', 32)->comment('Android,IOS,WEB...');
            $table->string('section_id', 128)->nullable()->comment('HTML ID');
            $table->string('section_class', 128)->nullable()->comment('HTML Class');
            $table->string('api_endpoint')->nullable()->comment('Submission end point');
            $table->boolean('should_validated')->default(false)->comment('validation required = 1, not required = 0');
            $table->string('validation_api_url')->nullable()->comment('if validation required then validation api also required for validation');
            $table->json('field_mapper_data')->default('[]')->nullable()->comment('Field IDs ant other info for get field for current section');
            $table->boolean('carry_forward_data')->default(false);
            $table->string('verification_type', 50)->nullable()->comment('based on this app end will add a tag on media api');
            $table->string('section_type', 20)->default('basic_form')->comment('based on this frontend will show different ui. can be basic_form and uploader_form and both_form');
            $table->boolean('is_preview_on')->default(false);
            $table->boolean('can_go_previous_step')->default(false);
            $table->unsignedSmallInteger('sequence');
            $table->enum('is_show_on_tab', ['yes', 'no'])->default('yes');
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
        Schema::dropIfExists('form_sections');
    }
}
