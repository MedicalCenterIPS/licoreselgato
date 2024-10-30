<?php

namespace App\Http\Controllers;

use App\Models\ProductionUnit;
use App\Models\Site;
use App\Models\TypeCollaborator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class ProductionUnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites = Site::all();
        $type_collaborators = TypeCollaborator::all();
        $months = [
            'Enero' => 'January',
            'Febrero' => 'February',
            'Marzo' => 'March',
            'Abril' => 'April',
            'Mayo' => 'May',
            'Junio' => 'June',
            'Julio' => 'July',
            'Agosto' => 'August',
            'Septiembre' => 'September',
            'Octubre' => 'October',
            'Noviembre' => 'November',
            'Diciembre' => 'December'
        ];
        return view('pages.registers.production_units.index', compact('type_collaborators', 'sites', 'months'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
            Cache::flush();
            DB::beginTransaction();
            $datos = $request->all();
            ProductionUnit::create($datos);
            DB::commit();
            return response()->json(['success' => 200, 'message' => 'Creacion exitosa']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 504, 'message' => 'Creacion exitosa']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $productionUnit = ProductionUnit::findOrFail($id);
        return response()->json($productionUnit);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $datos = $request->all();
            ProductionUnit::findOrFail($id)->update($datos);
            DB::commit();
            return response()->json(['success' => 200, 'message' => 'Actualizacion exitosa']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 504, 'message' => 'Error en Actualizacion']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $productionUnit = ProductionUnit::findOrFail($id);
            $productionUnit->delete();
            return response()->json(['success' => 200, 'message' => 'Eliminacion exitosa']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 504, 'message' => 'Error en eliminacion']);
        }
    }

    public function getRegistersData(Request $request)
    {
        $data = $request->all();
        $year_now = date('Y');
        $site_now = 1;
        $year = isset($data['year']) ? $data['year'] : '';
        $month = isset($data['month']) ? $data['month'] : '';
        $site = isset($data['site']) ? $data['site'] : '';

        
        $production_units = DB::table(env('DB_SINTAX') . 'production_units')
            ->select('hc_production_units.id', 'hc_production_units.company', 'hc_production_units.amount', 'hc_sites.site', 'hc_type_collaborators.type', DB::raw('
        CASE 
            WHEN hc_production_units.month = "January" THEN "Enero"
            WHEN hc_production_units.month = "February" THEN "Febrero"
            WHEN hc_production_units.month = "March" THEN "Marzo"
            WHEN hc_production_units.month = "April" THEN "Abril"
            WHEN hc_production_units.month = "May" THEN "Mayo"
            WHEN hc_production_units.month = "June" THEN "Junio"
            WHEN hc_production_units.month = "July" THEN "Julio"
            WHEN hc_production_units.month = "August" THEN "Agosto"
            WHEN hc_production_units.month = "September" THEN "Septiembre"
            WHEN hc_production_units.month = "October" THEN "Octubre"
            WHEN hc_production_units.month = "November" THEN "Noviembre"
            WHEN hc_production_units.month = "December" THEN "Diciembre"
            ELSE hc_production_units.month
        END AS month'),'hc_production_units.year')
            ->leftJoin('hc_sites', 'hc_production_units.id_site', 'hc_sites.id')
            ->leftJoin('hc_type_collaborators', 'hc_production_units.id_type', 'hc_type_collaborators.id');


            if ($year) {
                $production_units->where('hc_production_units.year', intval($year));
            } else {
                $production_units->where('hc_production_units.year', intval($year_now));
            }
    
            if ($month) {
                $production_units->where('hc_production_units.month', $month);
            }
    
            if ($site) {
                $production_units->where('hc_sites.id', $site);
            }

            $production_units->orderBy('hc_production_units.year', 'desc')->get();

        return FacadesDataTables::of($production_units)->toJson();
    }

}
