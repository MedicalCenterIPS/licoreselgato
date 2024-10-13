<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $session = DB::table(env('DB_SINTAX') . 'sessions')->where('user_id', auth()->user()->id)->get();

        if ($session->isEmpty()) {
            return view('auth.login');
        } else {
            Artisan::call('cache:clear');

            $roles = Role::all(); // Obtener todos los roles del modelo Role

            $permissions = DB::table(env('DB_SINTAX') . 'permissions')->get(); // Obtener todos los permisos del modelo Permission

            return view('pages.roles.index', compact('roles', 'permissions')); // Pasar los roles a la vista 'roles.index'
        }
    }

    /**
     */
    public function store(Request $request)
    {
        $session = DB::table(env('DB_SINTAX') . 'sessions')->where('user_id', auth()->user()->id)->get();

        if ($session->isEmpty()) {

            return view('auth.login');
        } else {

            $roleName = $request->input('name');
            $existingRole = Role::where('name', $roleName)->first();

            if ($existingRole) {
                return response()->json(['success' => false, 'message' => 'Rol ' . $roleName . ' ya existe']);
            }

            $role = Role::create(['name' => $roleName, 'guard_name' => 'web']);
            $permisos = $request->input('permisos');
            if (empty($permisos)) {
                $role->syncPermissions(); // Actualizar los permisos del rol
                // Devolver la respuesta en formato JSON
            } else {
                $permisos = $request->input('permisos');
                $permisosNombres = DB::table(env('DB_SINTAX') . 'permissions')->whereIn('id', $permisos)->pluck('name')->toArray();
                $role->syncPermissions($permisosNombres); // Actualizar los permisos del rol
            }

            //$role->syncPermissions($request->input('permisos'));

            return response()->json(['success' => true, 'message' => 'Rol creado exitosamente', 'id' => $role->id]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $session = DB::table(env('DB_SINTAX') . 'sessions')->where('user_id', auth()->user()->id)->get();

        if ($session->isEmpty()) {
            return view('auth.login');
        } else {
            $role = Role::findOrFail($id); // Buscar el rol por su ID

            $role->name = $request->input('name'); // Actualizar el nombre del rol

            $role->update(); // Guardar los cambios

            $permisos = $request->input('permisos');
            if (empty($permisos)) {
                $role->syncPermissions(); // Actualizar los permisos del rol
                // Devolver la respuesta en formato JSON
                return response()->json(['success' => true, 'message' => 'Rol actualizado con éxito']);
            } else {
                $permisosNombres = DB::table(env('DB_SINTAX') . 'permissions')->whereIn('id', $permisos)->pluck('name')->toArray();
                $role->syncPermissions($permisosNombres); // Actualizar los permisos del rol
                // Devolver la respuesta en formato JSON
                return response()->json(['success' => true, 'message' => 'Rol actualizado con éxito']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $session = DB::table(env('DB_SINTAX') . 'sessions')->where('user_id', auth()->user()->id)->get();

        if ($session->isEmpty()) {
            return view('auth.login');
        } else {
            $rolUser = DB::table(env('DB_SINTAX') . "model_has_roles")->where('role_id', $id); // Buscar asociación de usuarios al rol por su ID
            $permissionRol = DB::table(env('DB_SINTAX') . "role_has_permissions")->where('role_id', $id);
            if (!$rolUser->get()->isEmpty() || !$permissionRol->get()->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No se puede eliminar el rol porque tiene usuarios asignados o permisos asociados']);
            } else {
                $role = DB::table(env('DB_SINTAX') . "roles")->where('id', $id); // Buscar el rol por su ID

                DB::table(env('DB_SINTAX') . 'audits')->insert([
                    'user_type' => 'App\Models\User',
                    'user_id' => auth()->user()->id,
                    'event' => 'delete',
                    'auditable_type' => 'Spatie\Permission\Models\Role',
                    'auditable_id' => $id,
                    'old_values' => '[{"id":"' . $role->get()[0]->id . '","name":"' . $role->get()[0]->name . '","guard_name":"web"}]',
                    'new_values' => '[]',
                    'url' => request()->fullUrl(),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'tags' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                $role->delete(); // Eliminar el rol

                DB::statement('ALTER TABLE ' . env('DB_SINTAX') . 'roles AUTO_INCREMENT = 1');

                // Devolver la respuesta en formato JSON
                return response()->json(['success' => true, 'message' => 'Rol eliminado con éxito']);
            }
        }
    }

    /**
     * Get the list of roles and send it to a DataTable.
     */
    public function getRolesData()
    {
        $roles = DB::table(env('DB_SINTAX') . 'roles')
            ->leftjoin(env('DB_SINTAX') . 'role_has_permissions', env('DB_SINTAX') . 'roles.id', '=', env('DB_SINTAX') . 'role_has_permissions.role_id')
            ->leftjoin(env('DB_SINTAX') . 'permissions', env('DB_SINTAX') . 'role_has_permissions.permission_id', '=', env('DB_SINTAX') . 'permissions.id')
            ->select(env('DB_SINTAX') . 'roles.id', env('DB_SINTAX') . 'roles.name as name', DB::raw('GROUP_CONCAT(' . env('DB_SINTAX') . 'permissions.name SEPARATOR ", ") as permissions'), DB::raw('GROUP_CONCAT(' . env('DB_SINTAX') . 'permissions.id SEPARATOR ", ") as id_permissions'))
            ->groupBy(env('DB_SINTAX') . 'roles.name', env('DB_SINTAX') . 'roles.id')
            ->get();

        return FacadesDataTables::of($roles)->toJson(); //tabla de roles
    }
}
