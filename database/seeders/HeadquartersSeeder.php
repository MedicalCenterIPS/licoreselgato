<?php

namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeadquartersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Site::create([
            'site' => 'Dorado',
        ]);
        Site::create([
            'site' => 'Calle 96',
        ]);
        Site::create([
            'site' => 'Buenaventura',
        ]);
        Site::create([
            'site' => 'Cartagena',
        ]);
        Site::create([
            'site' => 'Cali',
        ]);
        Site::create([
            'site' => 'Intexona',
        ]);
        Site::create([
            'site' => 'Cota',
        ]);
    }
}
