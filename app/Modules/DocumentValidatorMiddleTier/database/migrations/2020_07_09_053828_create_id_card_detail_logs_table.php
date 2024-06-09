<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdCardDetailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('id_card_detail_logs', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('dob')->nullable();
            $table->string('id_card_type');
            $table->string('id_card_no');
            $table->json('details')->nullable();
            $table->string('status', 16)->comment('success/fail');
            $table->string('fail_reason')->nullable();
            $table->string('request_from_url')->nullable();
            $table->string('request_client_id', 50)->nullable();
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
        Schema::dropIfExists('id_card_detail_logs');
    }
}
