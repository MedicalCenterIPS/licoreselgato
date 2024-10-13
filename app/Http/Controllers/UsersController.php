<?php

namespace App\Http\Controllers;

use App\Models\processes;
use App\Models\settings;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /*  public function __construct()
    {
        $this->middleware('can:permisos_usuarios')->only('index');
        $this->middleware('can:asignar_permiso_usuario')->only('create', 'store');
        $this->middleware('can:editar_permiso_usuario')->only('edit', 'update');
        $this->middleware('can:listado_usuarios')->only('show');
    } */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Artisan::call('cache:clear');

        $this->asignarRol();

        $roles = Role::get();

        $procesos = processes::get();

        return view('pages.users.index', compact('roles', 'procesos'));
    }

    public function listarUsuarios()
    {
        try {
            $datos = User::leftjoin(env('DB_SINTAX') . 'model_has_roles AS mr', 'mr.model_id', '=', env('DB_SINTAX') . 'users.id')
                ->leftjoin(env('DB_SINTAX') . 'roles AS r', 'mr.role_id', '=', 'r.id')
                ->leftjoin(env('DB_SINTAX') . 'settings', env('DB_SINTAX') . 'settings.user_id', '=', env('DB_SINTAX') . 'users.id')
                ->leftjoin(env('DB_SINTAX') . 'processes as p', env('DB_SINTAX') . 'users.process_id', '=', 'p.id')
                ->get([env('DB_SINTAX') . 'users.*', 'r.id as id_role', 'r.name as rol_usuario','p.process']);
            return DataTables::of($datos)->make(true);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al traer los usuarios de la base de datos ' . $th], 500);
        }
    }

    public function actualizarPermisosUsuario(Request $request, $usuario_id)
    {
        try {
            //$this->actualizarAccesoEmpresas($usuario_id, $request->valor_permiso_aviomar, $request->valor_permiso_colvan, $request->valor_permiso_snider);
            $this->actualizarProcesoUsuario($usuario_id, $request->process_id);
            $this->actualizarRolUsuario($usuario_id, $request->rol_id);
            $this->actualizarPermisoAprobacion($usuario_id, $request->approve);
            $this->actualizarEstadoUsuario($usuario_id, $request->state);
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Ocurrio un error al actualizar los datos' . $th], 500);
        }
    }

    public function actualizarProcesoUsuario($usuario_id, $proceso_id)
    {

        try {
            $usuario = User::find($usuario_id);
            $usuario->process_id = $proceso_id;
            $usuario->save();
        } catch (\Throwable $th) {

            return response()->json(['message' => 'Error al actualizar el proceso del usuario ' . $th], 500);
        }
    }

    public function actualizarRolUsuario($usuario_id, $rol_id)
    {
        try {
            $usuario = User::find($usuario_id);
            $usuario->syncRoles($rol_id);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al actualizar el rol del usuario ' . $th], 500);
        }
    }

    public function actualizarPermisoAprobacion($usuario_id, $aprueba)
    {

        try {
            $usuario = User::find($usuario_id);
            $usuario->approve = $aprueba;
            $usuario->save();
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al actualizar el permisos de aprobacion del usuario ' . $th], 500);
        }
    }

    public function actualizarEstadoUsuario($usuario_id, $estado)
    {
        try {

            $usuario = User::find($usuario_id);
            //$usuario->state = $estado;

            if ($estado == 0) {

                $usuario->state = $estado;
                $usuario->email = null;
                $usuario->guid = null;
                $usuario->domain = null;
                $usuario->azure_id = null;
                $usuario->modo_auth = null;

                $usuario->save();

                $session = DB::table(ENV('DB_SINTAX') . 'sessions')->where('user_id', $usuario_id)->get();
                DB::table('pt_sessions')->where('id', $session[0]->id)->delete();
            } else {
                $usuario->state = $estado;
                $usuario->save();
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al actualizar el permisos de Estado del usuario ' . $th], 500);
        }
    }

    /* public function actualizarAccesoEmpresas($usuario_id, $valor_acceso_aviomar, $valor_acceso_colvan, $valor_acceso_snider)
    {

        try {
            $configuracion_usuario = settings::where('user_id', $usuario_id)->get()->first();


            $json_configuracion_usuario = json_decode($configuracion_usuario->valor);
            $json_configuracion_usuario->permisos_empresas->Aviomar = $valor_acceso_aviomar;

            $json_configuracion_usuario->permisos_empresas->Colvan = $valor_acceso_colvan;

            $json_configuracion_usuario->permisos_empresas->Snider = $valor_acceso_snider;

            $configuracion_usuario->valor = json_encode($json_configuracion_usuario);
            $configuracion_usuario->save();
            //dd($configuracion_usuario);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al actualizar los accesos por empresa del usuario ' . $th], 500);
        }
    } */

    public function getSessionUser()
    {
        $session = DB::table(ENV('DB_SINTAX') . 'sessions')->where('user_id', auth()->user()->id)->get();
        //dd($session->isEmpty());
        if ($session->isEmpty()) {
            return view('auth.login');
        } else {
            return response()->json(['message' => 'Session del usuario encontrada', 'session' => $session], 200);
        }
    }

    public function asignarRol()
    {
        try {
            $user = User::find(auth()->user()->id);
            $roles = $user->getRoleNames();
            if (empty($roles[0])) {
                if (auth()->user()->username == 'analista.desarrollo' || auth()->user()->username == 'Desarrollador.JR2') {
                    $user->assignRole('Admin');
                } else {
                    $user->assignRole('Consulta');
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al traer la información de la base de datos'], 500);
        }
    }
}
