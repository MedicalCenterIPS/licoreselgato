<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Admin_ambiental']);
        $role3 = Role::create(['name' => 'Consulta']);

        Permission::create(['name' => 'home'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'modulo_usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'modulo_roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'modulo_permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'modulo_procesos'])->syncRoles([$role1]);
        Permission::create(['name' => 'modulo_registros_cantidades'])->syncRoles([$role1, $role2]);
    }
}
