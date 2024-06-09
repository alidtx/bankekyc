<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOcrLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ocr_logs', function (Blueprint $table) {
            $table->id();
            $table->string('image_path',128)->unique();
            $table->string('id_card_type')->nullable();
            $table->string('id_card_no')->nullable();
            $table->json('ocr_data')->nullable();
            $table->string('ocr_status',16)->comment('success/fail');
            $table->string('ocr_fail_reason')->nullable();
            $table->string('source_url')->nullable();
            $table->string('source_id',50)->nullable();
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
        Schema::dropIfExists('ocr_logs');
    }
}
