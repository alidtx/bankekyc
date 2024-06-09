<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEkycFormRequestsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ekyc_form_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('request_tracking_uid', 50);
            $table->string('status')->comment('pending, generated...');
            $table->string('partner_uid', 50);
            $table->unsignedBigInteger('form_id');
            $table->double('calculated_score', 8, 2);
            $table->string('requested_via')->comment(' (customer/agent)');
            $table->string('platform_type',20)->comment(' (i.e. web, android, ios)');
            $table->string('agent_uid', 50)->nullable();
            $table->string('unique_key')->nullable()->comment('(i.e. NID, mobile, passport)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('ekyc_form_requests');
    }

}
