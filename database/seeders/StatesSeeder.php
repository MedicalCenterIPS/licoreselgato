<?php

namespace Database\Seeders;

use App\Models\states;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        states::create([
            'state' => 'Nuevo',
        ]);
        states::create([
            'state' => 'Pendiente',
        ]);
        states::create([
            'state' => 'Aprobado',
        ]);
        states::create([
            'state' => 'No aprobado',
        ]);
        states::create([
            'state' => 'Anulada',
        ]);
        states::create([
            'state' => 'Corregida',
        ]);
        states::create([
            'state' => 'Rechazado',
        ]);
        states::create([
            'state' => 'Facturada',
        ]);
        states::create([
            'state' => 'Activo',
        ]);
        states::create([
            'state' => 'Inactivo',
        ]);
    }
}
