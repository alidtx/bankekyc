<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaceCompareLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('face_compare_logs', function (Blueprint $table) {
            $table->id();
            $table->string('image1_path', 128);
            $table->string('image2_path', 128);
            $table->string('compare_type');
            $table->double('score', 4, 2)->default(0.0);
            $table->boolean('matched')->default(false);
            $table->string('face_compare_status', 16)->comment('success/fail');
            $table->string('face_compare_fail_reason')->nullable();
            $table->string('source_url')->nullable();
            $table->string('source_id', 50)->nullable();
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
        Schema::dropIfExists('face_compare_logs');
    }
}
