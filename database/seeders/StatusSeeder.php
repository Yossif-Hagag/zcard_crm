<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create(['name' => 'Request',]);
        Status::create(['name' => 'Confirmation',]);
        Status::create(['name' => 'Print',]);
        Status::create(['name' => 'Shipping',]);
        Status::create(['name' => 'Reception',]);
    }
}
