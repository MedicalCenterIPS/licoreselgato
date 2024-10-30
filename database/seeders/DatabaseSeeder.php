<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(RolSeeder::class);
        $this->call(ProcessesSeeder::class);
        $this->call(StatesSeeder::class);
        $this->call(CompaniesSeeder::class);
        $this->call(HeadquartersSeeder::class);
        $this->call(TypeCollaboratorSeeder::class);
    }
}
