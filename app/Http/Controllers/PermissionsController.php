<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class PermissionsController extends Controller
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

            $permisos = Permission::all(); // Obtener todos los permisos del modelo Role

            return view('pages.permissions.index', compact('permisos')); // Pasar los permissions a la vista 'permissions.index'
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $session = DB::table(env('DB_SINTAX') . 'sessions')->where('user_id', auth()->user()->id)->get();

        if ($session->isEmpty()) {
            return view('auth.login');
        } else {
            $permisoName = $request->input('name');

            $existingPermiso = Permission::where('name', $permisoName)->first();

            if ($existingPermiso) {
                return response()->json(['success' => false, 'message' => 'Permiso ' . $permisoName . ' ya existe']);
            } else {

                $permiso = Permission::create(['name' => $permisoName, 'guard_name' => 'web']);

                return response()->json(['success' => true, 'message' => 'Permiso creado exitosamente', 'id' => $permiso->id]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $session = DB::table(env('DB_SINTAX') . 'sessions')->where('user_id', auth()->user()->id)->get();

        if ($session->isEmpty()) {
            return view('auth.login');
        } else {
            $permiso = Permission::findOrFail($id); // Buscar el rol por su ID

            $permiso->name = $request->input('name'); // Actualizar el nombre del rol

            $permiso->update(); // Guardar los cambios

            // Devolver la respuesta en formato JSON
            return response()->json(['success' => true, 'message' => 'Permiso actualizado con éxito']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $session = DB::table(env('DB_SINTAX') . 'sessions')->where('user_id', auth()->user()->id)->get();

        if ($session->isEmpty()) {
            return view('auth.login');
        } else {
            $permisoRol = DB::table(env('DB_SINTAX') . "role_has_permissions")->where('permission_id', $id); // Buscar asociación de usuarios al permiso por su ID

            if (!$permisoRol->get()->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No se puede eliminar el permiso porque esta asociado a 1 o mas roles']);
            } else {
                $permiso = DB::table(env('DB_SINTAX') . "permissions")->where('id', $id); // Buscar el permiso por su ID

                DB::table(env('DB_SINTAX') . 'audits')->insert([
                    'user_type' => 'App\Models\User',
                    'user_id' => auth()->user()->id,
                    'event' => 'delete',
                    'auditable_type' => 'Spatie\Permission\Models\Permission',
                    'auditable_id' => $id,
                    'old_values' => '[{"id":"' . $permiso->get()[0]->id . '","name":"' . $permiso->get()[0]->name . '","guard_name":"web"}]',
                    'new_values' => '[]',
                    'url' => request()->fullUrl(),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'tags' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                $permiso->delete(); // Eliminar el permiso

                DB::statement('ALTER TABLE ' . env('DB_SINTAX') . 'permissions AUTO_INCREMENT = 1');

                // Devolver la respuesta en formato JSON
                return response()->json(['success' => true, 'message' => 'Permiso eliminado con éxito']);
            }
        }
    }


    /**
     * Get the list of permisos and send it to a DataTable.
     */
    public function getPermisosData()
    {
        $permisos = Permission::all();   // Obtener todos los permisos del modelo Permissions

        return FacadesDataTables::of($permisos)->toJson(); //tabla de permisos
    }
}
