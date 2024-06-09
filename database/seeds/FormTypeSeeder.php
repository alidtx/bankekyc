<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FormTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$form_types = [
    		['type_code' => 'savings_account', 'title' => 'Savings account', 'created_at' => Carbon::now() ],
    		['type_code' => 'current_account', 'title' => 'Current account', 'created_at' => Carbon::now() ],
    		['type_code' => 'fdr', 'title' => 'FDR', 'created_at' => Carbon::now() ],
    		['type_code' => 'deposit_scheme', 'title' => 'Deposit Scheme', 'created_at' => Carbon::now() ]
    	];

        DB::table('form_types')->insert($form_types);
    }
}
