<?php

namespace Database\Seeders;

use App\Models\Companies;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Companies::create([
            'company' => 'Aviomar',
        ]);
        Companies::create([
            'company' => 'Snider',
        ]);
        Companies::create([
            'company' => 'Colvan',
        ]);
    }
}
