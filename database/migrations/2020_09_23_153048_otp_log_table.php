<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OtpLogTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('otp_logs', function (Blueprint $table) {
            $table->id();
            $table->string('mobile_no', 11);
            $table->string('encrypted_otp', 100);
            $table->string('otp_type', 20)->nullable();
            $table->integer('otp_status')->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('otp_logs', function (Blueprint $table) {
            //
        });
    }

}
