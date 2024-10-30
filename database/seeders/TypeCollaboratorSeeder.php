<?php

namespace Database\Seeders;

use App\Models\TypeCollaborator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeCollaboratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeCollaborator::create([
            'type' => 'Administrativo',
        ]);
        TypeCollaborator::create([
            'type' => 'Operativo',
        ]);
        TypeCollaborator::create([
            'type' => 'Administrativo y Bodega',
        ]);
        TypeCollaborator::create([
            'type' => 'Bodega',
        ]);
    }
}
