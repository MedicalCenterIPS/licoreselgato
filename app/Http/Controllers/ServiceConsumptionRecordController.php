<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceConsumptionRecordRequest;
use App\Models\ServiceConsumptionRecord;
use App\Models\Site;
use App\Models\TypeCollaborator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ServiceConsumptionRecordController extends Controller
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


        return view('pages.registers.services.index', compact('type_collaborators', 'sites', 'months'));
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
    public function store(ServiceConsumptionRecordRequest $request)
    {
        Cache::flush();
        try {
            $serviceConsumptionRecord = ServiceConsumptionRecord::create($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Registro de consumo de servicio creado con éxito.',
                'data' => $serviceConsumptionRecord,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el registro de consumo de servicio.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getRegistersData(Request $request){

        $data = $request->all();
        $year_now = date('Y');
        $site_now = 1;
        $year = isset($data['year']) ? $data['year'] : '';
        $month = isset($data['month']) ? $data['month'] : '';
        $site = isset($data['site']) ? $data['site'] : '';

        
        $consumption_registers = DB::table(env('DB_SINTAX') . 'service_consumption_records')
            ->select('hc_service_consumption_records.id', 'hc_service_consumption_records.company_service_consumption', 'hc_service_consumption_records.amount', 'hc_sites.site', 'hc_service_consumption_records.account',
            'hc_service_consumption_records.measurement_unit', DB::raw('
        CASE 
            WHEN hc_service_consumption_records.month = "January" THEN "Enero"
            WHEN hc_service_consumption_records.month = "February" THEN "Febrero"
            WHEN hc_service_consumption_records.month = "March" THEN "Marzo"
            WHEN hc_service_consumption_records.month = "April" THEN "Abril"
            WHEN hc_service_consumption_records.month = "May" THEN "Mayo"
            WHEN hc_service_consumption_records.month = "June" THEN "Junio"
            WHEN hc_service_consumption_records.month = "July" THEN "Julio"
            WHEN hc_service_consumption_records.month = "August" THEN "Agosto"
            WHEN hc_service_consumption_records.month = "September" THEN "Septiembre"
            WHEN hc_service_consumption_records.month = "October" THEN "Octubre"
            WHEN hc_service_consumption_records.month = "November" THEN "Noviembre"
            WHEN hc_service_consumption_records.month = "December" THEN "Diciembre"
            ELSE hc_service_consumption_records.month
        END AS month'),'hc_service_consumption_records.year')
            ->leftJoin('hc_sites', 'hc_service_consumption_records.id_site_service', 'hc_sites.id');


            if ($year) {
                $consumption_registers->where('hc_service_consumption_records.year', intval($year));
            } else {
                $consumption_registers->where('hc_service_consumption_records.year', intval($year_now));
            }
    
            if ($month) {
                $consumption_registers->where('hc_service_consumption_records.month', $month);
            }
    
            if ($site) {
                $consumption_registers->where('hc_sites.id', $site);
            }

            $consumption_registers->orderBy('hc_service_consumption_records.year', 'desc')->get();

        return DataTables::of($consumption_registers)->toJson();
    }
}
