<?php

namespace Database\Seeders;

use App\Models\Card;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
 DB::table('cards')->insert([
            ['name' => 'First Card', 'cost' => 180],
            ['name' => 'Second Card', 'cost' => 300],
            ['name' => 'Third Card', 'cost' => 550],
            ['name' => 'Fourth Card', 'cost' => 700],
            ['name' => 'Fifth Card', 'cost' => 800],
        ]);
    }
}
