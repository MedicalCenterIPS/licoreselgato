<?php

namespace Database\Seeders;

use App\Models\processes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcessesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        processes::create([
            'process' => 'Área De Cumplimiento',
            'abbreviation' => 'OC'
        ]);
        processes::create([
            'process' => 'Área Juridica',
            'abbreviation' => 'JUR'
        ]);
        processes::create([
            'process' => 'Calidad',
            'abbreviation' => 'Q'
        ]);
        processes::create([
            'process' => 'Capital Humano',
            'abbreviation' => 'CH'
        ]);
        processes::create([
            'process' => 'Carga',
            'abbreviation' => 'CA'
        ]);
        processes::create([
            'process' => 'Compras',
            'abbreviation' => 'CO'
        ]);
        processes::create([
            'process' => 'Control Interno',
            'abbreviation' => 'CI'
        ]);
        processes::create([
            'process' => 'Correspondencia',
            'abbreviation' => 'CR'
        ]);
        processes::create([
            'process' => 'Depósito Aduanero',
            'abbreviation' => 'DA'
        ]);
        processes::create([
            'process' => 'Facturación Menaje',
            'abbreviation' => 'FAC AV'
        ]);
        processes::create([
            'process' => 'Gestión Administrativa',
            'abbreviation' => 'GA'
        ]);
        processes::create([
            'process' => 'Gestión Comercial (AC / C / S)',
            'abbreviation' => 'GC'
        ]);
        processes::create([
            'process' => 'Gestión Comercial Menaje - Expo',
            'abbreviation' => 'GCIAL EXP'
        ]);
        processes::create([
            'process' => 'Gestión Comercial Menaje - Impo',
            'abbreviation' => 'GCIAL IMP'
        ]);
        processes::create([
            'process' => 'Gestión Comercial Menaje - Pricing',
            'abbreviation' => 'GCIAL PRI'
        ]);
        processes::create([
            'process' => 'Gestión Comercial Menaje - Satisfacción al cliente',
            'abbreviation' => 'GCIAL SC'
        ]);
        processes::create([
            'process' => 'Gestión De Seguridad',
            'abbreviation' => 'GS'
        ]);
        processes::create([
            'process' => 'Gestión Documental',
            'abbreviation' => 'GD'
        ]);
        processes::create([
            'process' => 'Gestión Financiera',
            'abbreviation' => 'GF'
        ]);
        processes::create([
            'process' => 'Logistica Y Almacenamiento',
            'abbreviation' => 'LYA'
        ]);
        processes::create([
            'process' => 'Marketing Y Comunicaciones ',
            'abbreviation' => 'M&C'
        ]);
        processes::create([
            'process' => 'Menaje Cl 96 - Diplomaticos, Locales Y Nacionales',
            'abbreviation' => 'DP L|N'
        ]);
        processes::create([
            'process' => 'Menaje Cl 96 - Exportaciones',
            'abbreviation' => 'ME EXP'
        ]);
        processes::create([
            'process' => 'Menaje Cl 96 - Importaciones',
            'abbreviation' => 'ME IMP'
        ]);
        processes::create([
            'process' => 'Menaje Dorado',
            'abbreviation' => 'ME'
        ]);
        processes::create([
            'process' => 'Operaciones Colvan',
            'abbreviation' => 'OP'
        ]);
        processes::create([
            'process' => 'Planeación Estrategica',
            'abbreviation' => 'PE'
        ]);
        processes::create([
            'process' => 'Sostenibilidad Ambiental',
            'abbreviation' => 'SA'
        ]);
        processes::create([
            'process' => 'SST',
            'abbreviation' => 'SST'
        ]);
        processes::create([
            'process' => 'Tecnología De La Información',
            'abbreviation' => 'TI'
        ]);
        processes::create([
            'process' => 'Unidad De Transporte',
            'abbreviation' => 'UT'
        ]);
        processes::create([
            'process' => 'Zona Franca',
            'abbreviation' => 'ZF'
        ]);
    }
}
