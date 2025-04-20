<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stages')->insert([
            ['name' => 'New'],
            ['name' => 'Not Answered'],
            ['name' => 'Cold'],
            ['name' => 'Not Interested'],
            ['name' => 'Hot'],
            ['name' => 'Follow Up'],
        ]);
    }
}
