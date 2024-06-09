<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEkycFormAuditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ekyc_form_audit_logs', function (Blueprint $table) {
            $table->id();;
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('field_id');
            $table->unsignedBigInteger('form_request_id');
            $table->text('old_value');
            $table->text('new_value');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('No Action');
            $table->foreign('section_field_id')->references('id')->on('form_fields')->onDelete('No Action');
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
        Schema::dropIfExists('ekyc_form_audit_logs');
    }
}
