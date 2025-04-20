<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RejectShippingReasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reject_shipping_reasons')->insert([
            ['reason' => 'Client refused to receive',],
            ['reason' => 'The Client traveled',],
            ['reason' => 'The Delegate did not arrive on time',],
            ['reason' => 'Error in address',],
            ['reason' => 'The Client did not answer',],
            ['reason' => 'The Client cancelled the order at one of the stages',],
        ]);
    }
}
