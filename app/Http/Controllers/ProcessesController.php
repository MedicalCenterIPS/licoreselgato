<?php

namespace App\Http\Controllers;

use App\Models\processes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class ProcessesController extends Controller
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

            $procesos = DB::table(env('DB_SINTAX') . 'processes')->get(); // Obtener todos los permisos del modelo Permission

            return view('pages.processes.index', compact('procesos'));
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

            $datos = $request->all();

            $existingConcepto = processes::where('process', $datos['process'])->first();

            if ($existingConcepto) {

                return response()->json(['success' => false, 'message' => 'Proceso ' . $datos['process'] . ' ya existe']);
            } else {

                $proceso = processes::create($datos);

                // Return a JSON response with the message and the ID of the created process
                return response()->json([
                    'success' => true,
                    'message' => 'Proceso creado exitosamente',
                    'id' => $proceso
                ]);
            }
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
            // Update the process with the given ID
            $datos = $request->all();

            processes::findOrFail($id)->update($datos);

            // Return a JSON response with the message and the ID of the updated process
            return response()->json([
                'success' => true,
                'message' => 'Proceso actualizado exitosamente',
                'id' => $id
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete the process with the given ID
        processes::findOrFail($id)->delete();

        // Return a JSON response with the message and the ID of the deleted process
        return response()->json([
            'success' => true,
            'message' => 'Proceso eliminado exitosamente',
            'id' => $id
        ]);
    }

    public function getProcessesData()
    {
        $roles = DB::table(env('DB_SINTAX') . 'processes')->get();

        return FacadesDataTables::of($roles)->toJson(); //tabla de roles
    }
}
