<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
                'phone' => '01236525415',
            ]);
        $dirctor = \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'Dirctor',
                'email' => 'dirctor1@dirctor.com',
                'password' => \Hash::make('dirctor'),
                'phone' => '01236525415',
            ]);
        $teamleader1 = \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'Team Leader 1',
                'email' => 'teamleader1@teamleader.com',
                'password' => \Hash::make('teamleader'),
                'phone' => '01236525415',
            ]);
        $teamleader2 = \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'Team Leader 2',
                'email' => 'teamleader2@teamleader.com',
                'password' => \Hash::make('teamleader'),
                'phone' => '01236525415',
            ]);
        $teamleader3 = \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'Team Leader 3',
                'email' => 'teamleader3@teamleader.com',
                'password' => \Hash::make('teamleader'),
                'phone' => '01236525415',
            ]);
        $teamleader4 = \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'Team Leader 4',
                'email' => 'teamleader4@teamleader.com',
                'password' => \Hash::make('teamleader'),
                'phone' => '01236525415',
            ]);
        $teamleader5 = \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'Team Leader 5',
                'email' => 'teamleader5@teamleader.com',
                'password' => \Hash::make('teamleader'),
                'phone' => '01236525415',
            ]);
        $this->call(PermissionsSeeder::class);

        // $this->call(AddressSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(ContractSeeder::class);
        // $this->call(DealSeeder::class);
        // $this->call(LeadSeeder::class);
        // $this->call(OrderSeeder::class);
        $this->call(StageSeeder::class);
        $this->call(SourceSeeder::class);
        $this->call(CardSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RejectShippingReasonsSeeder::class);
        // $this->call(PrintingTableSeeder::class);
    }
}
