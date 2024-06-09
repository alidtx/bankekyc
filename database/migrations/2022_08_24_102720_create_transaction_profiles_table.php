<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('account_name')->nullable();
            $table->string('account_nature')->nullable();
            $table->string('account_no')->nullable();
            $table->string('cif_id')->nullable();
            $table->unsignedBigInteger('cash_deposit_num_of_trn')->nullable();
            $table->double('cash_deposit_size_trn')->nullable();
            $table->double('cash_deposit_size_total_amount')->nullable();
            $table->unsignedBigInteger('deposit_trnsfer_num_of_trn')->nullable();
            $table->double('deposit_trnsfer_size_trn')->nullable();
            $table->double('deposit_trnsfer_size_total_amount')->nullable();
            $table->unsignedBigInteger('foreign_rmtnce_num_of_trn')->nullable();
            $table->double('foreign_rmtnce_size_trn')->nullable();
            $table->double('foreign_rmtnce_size_total_amount')->nullable();
            $table->unsignedBigInteger('export_prcds_num_of_trn')->nullable();
            $table->double('export_prcds_size_transactions')->nullable();
            $table->double('export_prcds_size_total_amount')->nullable();
            $table->unsignedBigInteger('bo_stock_num_of_trn')->nullable();
            $table->double('bo_stock_size_trn')->nullable();
            $table->double('bo_stock_size_total_amount')->nullable();
            $table->unsignedBigInteger('othr_num_of_trn')->nullable();
            $table->double('othr_size_trn')->nullable();
            $table->double('othr_size_total_amount')->nullable();
            $table->unsignedBigInteger('cash_withdrl_num_of_trn')->nullable();
            $table->double('withdrl_deposit_size_trn')->nullable();
            $table->double('cash_withdrl_size_total_amount')->nullable();
            $table->unsignedBigInteger('withdrl_trnsfer_num_of_trn')->nullable();
            $table->double('withdrl_trnsfer_size_trn')->nullable();
            $table->double('withdrl_trnsfer_size_total_amount')->nullable();
            $table->unsignedBigInteger('withdrl_foreign_rmtnce_num_of_trn')->nullable();
            $table->double('withdrl_foreign_rmtnce_size_trn')->nullable();
            $table->double('withdrl_foreign_rmtnce_size_total_amount')->nullable();
            $table->unsignedBigInteger('import_prcds_num_of_trn')->nullable();
            $table->double('import_prcds_size_transactions')->nullable();
            $table->double('import_prcds_size_total_amount')->nullable();
            $table->unsignedBigInteger('trnsf_bo_stock_num_of_trn')->nullable();
            $table->double('trnsf_bo_stock_size_trn')->nullable();
            $table->double('trnsf_bo_stock_size_total_amount')->nullable();
            $table->unsignedBigInteger('withdrl_othr_num_of_trn')->nullable();
            $table->double('withdrl_othr_size_trn')->nullable();
            $table->double('withdrl_othr_size_total_amount')->nullable();
            $table->longText('source_of_fund')->nullable();
            $table->longText('additional_info')->nullable();
            $table->double('monthly_turn_over')->nullable();
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
        Schema::dropIfExists('transaction_profiles');
    }
}
