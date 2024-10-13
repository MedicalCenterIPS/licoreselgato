<?php

namespace App\Http\Controllers;

use App\Models\ProductionUnit;
use App\Models\rc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LdapRecord\Models\Attributes\Timestamp;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

use function PHPUnit\Framework\isEmpty;

class PercentageTablesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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

        return view('pages.percentage_tables.%employees_company.index', compact('months'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($rc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($rc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }

    public function getPercentage1(Request $request)
    {
        $data = $request->all();
        $year_now = date('Y');
        $site_now = 1;
        $year = isset($data['year']) ? $data['year'] : '';
        $month = isset($data['month']) ? $data['month'] : '';
        $site = isset($data['site']) ? $data['site'] : '';

        // Configurar el idioma de la conexión a la base de datos a español
        DB::statement("SET lc_time_names = 'es_ES'");

        $query = DB::table('hc_production_units')
            ->select([
                'hc_type_collaborators.type',
                'hc_sites.site',
                DB::raw('DATE_FORMAT(hc_production_units.created_at, "%M") AS month'),
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('ROUND((SUM(CASE WHEN company="Aviomar" THEN amount ELSE 0 END) * 100) / NULLIF(SUM(amount), 0), 2) AS Aviomar'),
                DB::raw('ROUND((SUM(CASE WHEN company="Snider" THEN amount ELSE 0 END) * 100) / NULLIF(SUM(amount), 0), 2) AS Snider '),
                DB::raw('ROUND((SUM(CASE WHEN company="Colvan" THEN amount ELSE 0 END) * 100) / NULLIF(SUM(amount), 0), 2) AS Colvan')
            ])
            ->leftJoin('hc_type_collaborators', 'hc_production_units.id_type', '=', 'hc_type_collaborators.id')
            ->leftJoin('hc_sites', 'hc_production_units.id_site', '=', 'hc_sites.id')
            ->where('hc_type_collaborators.id', 1);

        // Aplicar filtros opcionales con valores predeterminados
        $query->whereYear('hc_production_units.created_at', $year ?? $year_now);

        if ($month) {
            $query->where('hc_production_units.month', $month);
        }

        $query->where('hc_sites.id', $site ?? $site_now);

        // Agrupar los resultados
        $productionData = $query->groupBy('month', 'hc_type_collaborators.type', 'hc_sites.site')->get();

        return response()->json(['success' => true, 'data' => $productionData]);
    }


    public function getPercentage2(Request $request)
    {
        // Obtener los parámetros del request
        $data = $request->all();

        // Obtener el mes y año actuales como fallback
        $mesActual = date('F');
        $anioActual = date('Y');

        $month = isset($data['month']) ? $data['month'] : $mesActual;
        $year = isset($data['year']) ? $data['year'] : $anioActual;


        // Consulta SQL con los filtros de mes y año
        $productionData = DB::table('hc_production_units')
            ->select([
                'hc_sites.site',
                'hc_production_units.month',
                DB::raw('SUM(CASE WHEN hc_production_units.company = "Snider" THEN amount ELSE 0 END) AS snider_amount'),
                DB::raw('SUM(CASE WHEN hc_production_units.company = "Aviomar" AND hc_type_collaborators.type = "administrativo" THEN amount ELSE 0 END) AS aviomar_amount'),
                DB::raw('SUM(CASE WHEN hc_production_units.company = "Colvan" AND hc_type_collaborators.type = "administrativo" THEN amount ELSE 0 END) AS colvan_amount'),
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('ROUND((SUM(CASE WHEN hc_production_units.company = "Aviomar" AND hc_type_collaborators.type = "administrativo" THEN amount ELSE 0 END) * 100) / SUM(amount), 2) AS aviomar_percentage'),
                DB::raw('ROUND((SUM(CASE WHEN hc_production_units.company = "Snider" THEN amount ELSE 0 END) * 100) / SUM(amount), 2) AS snider_percentage'),
                DB::raw('ROUND((SUM(CASE WHEN hc_production_units.company = "Colvan" AND hc_type_collaborators.type = "administrativo" THEN amount ELSE 0 END) * 100) / SUM(amount), 2) AS colvan_percentage')
            ])
            ->leftJoin('hc_sites', 'hc_production_units.id_site', '=', 'hc_sites.id')
            ->leftJoin('hc_type_collaborators', 'hc_production_units.id_type', '=', 'hc_type_collaborators.id')
            ->where('hc_sites.id', 1)
            ->where('hc_production_units.month', $month)
            ->where('hc_production_units.year', $year)
            ->groupBy('hc_sites.site', 'hc_production_units.month')
            ->get();


        return response()->json(['success' => true, 'data' => $productionData]);
    }


    public function getPercentage3(Request $request)
    {
        $data = $request->all();
        $year_now = date('Y');
        $year = isset($data['year']) ? $data['year'] : '';
        $month = isset($data['month']) ? $data['month'] : '';
        $site = isset($data['site']) ? $data['site'] : '';


        // Configurar el idioma de la conexión a la base de datos a español
        DB::statement("SET lc_time_names = 'es_ES'");

        $query = DB::table('hc_production_units')
            ->select([
                'hc_type_collaborators.type',
                'hc_sites.site',
                DB::raw('DATE_FORMAT(hc_production_units.created_at, "%M") AS month'),
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('ROUND((SUM(CASE WHEN company="Aviomar" THEN amount ELSE 0 END) * 100) / NULLIF(SUM(amount), 0), 2) AS Aviomar'),
                DB::raw('ROUND((SUM(CASE WHEN company="Snider" THEN amount ELSE 0 END) * 100) / NULLIF(SUM(amount), 0), 2) AS Snider'),
                DB::raw('ROUND((SUM(CASE WHEN company="Colvan" THEN amount ELSE 0 END) * 100) / NULLIF(SUM(amount), 0), 2) AS Colvan')
            ])
            ->leftJoin('hc_type_collaborators', 'hc_production_units.id_type', '=', 'hc_type_collaborators.id')
            ->leftJoin('hc_sites', 'hc_production_units.id_site', '=', 'hc_sites.id')
            ->where('hc_type_collaborators.id', 1)
            ->where('hc_sites.id', 5);

        // Aplicar filtros si se proporcionan
        if ($year) {
            $query->whereYear('hc_production_units.created_at', $year);
        } else {
            $query->whereYear('hc_production_units.created_at', $year_now);
        }

        if ($month) {
            $query->where('hc_production_units.month', $month);
        }

        // Agrupar los resultados
        $productionData = $query->groupBy('month', 'hc_type_collaborators.type', 'hc_sites.site')->get();

        return response()->json(['success' => true, 'data' => $productionData]);
    }

    public function getPercentage4(Request $request)
    {
        $data = $request->all();
        $year_now = date('Y');
        $year = isset($data['year']) ? $data['year'] : '';
        $month = isset($data['month']) ? $data['month'] : '';
        $site = isset($data['site']) ? $data['site'] : '';

        // Configurar el idioma de la conexión a la base de datos a español
        DB::statement("SET lc_time_names = 'es_ES'");

        $query = DB::table('hc_production_units')
            ->select([
                'hc_sites.site',
                DB::raw('DATE_FORMAT(hc_production_units.created_at, "%M") AS month'),
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('ROUND((SUM(CASE WHEN company="Aviomar" THEN amount ELSE 0 END) * 100) / NULLIF(SUM(amount), 0), 2) AS Aviomar'),
                DB::raw('ROUND((SUM(CASE WHEN company="Snider" THEN amount ELSE 0 END) * 100) / NULLIF(SUM(amount), 0), 2) AS Snider'),
                DB::raw('ROUND((SUM(CASE WHEN company="Colvan" THEN amount ELSE 0 END) * 100) / NULLIF(SUM(amount), 0), 2) AS Colvan')
            ])
            ->leftJoin('hc_type_collaborators', 'hc_production_units.id_type', '=', 'hc_type_collaborators.id')
            ->leftJoin('hc_sites', 'hc_production_units.id_site', '=', 'hc_sites.id')
            ->whereIn('hc_type_collaborators.id', [1, 2])
            ->where('hc_sites.id', 1);

        // Aplicar filtros si se proporcionan
        if ($year) {
            $query->whereYear('hc_production_units.created_at', $year);
        } else {
            $query->whereYear('hc_production_units.created_at', $year_now);
        }

        if ($month) {
            $query->where('hc_production_units.month', $month);
        }

        // Agrupar los resultados
        $productionData = $query->groupBy('hc_sites.site', 'month')->get();


        return response()->json(['success' => true, 'data' => $productionData]);
    }

    public function getPercentage5(Request $request)
    {
        $data = $request->all();
        $year_now = date('Y');
        $year = isset($data['year']) ? $data['year'] : '';
        $month = isset($data['month']) ? $data['month'] : '';

        // Configurar el idioma de la conexión a la base de datos a español
        DB::statement("SET lc_time_names = 'es_ES'");

        $sums = DB::table('hc_production_units')
            ->select([
                'hc_sites.site',
                DB::raw('DATE_FORMAT(hc_production_units.created_at, "%M") AS month'),
                DB::raw('SUM(CASE WHEN company = "Aviomar" THEN amount ELSE 0 END) AS Aviomar'),
                DB::raw('SUM(CASE WHEN company = "Snider" THEN amount ELSE 0 END) AS Snider'),
                DB::raw('SUM(CASE WHEN company = "Colvan" THEN amount ELSE 0 END) AS Colvan'),
                DB::raw('SUM(CASE WHEN company = "Aviomar" THEN amount ELSE 0 END) +
                 SUM(CASE WHEN company = "Snider" THEN amount ELSE 0 END) +
                 SUM(CASE WHEN company = "Colvan" THEN amount ELSE 0 END) AS Total')
            ])
            ->leftJoin('hc_sites', 'hc_production_units.id_site', '=', 'hc_sites.id');

        if ($year) {
            $sums->whereYear('hc_production_units.created_at', $year);
        } else {
            $sums->whereYear('hc_production_units.created_at', $year_now);
        }

        if ($month) {
            $sums->where('hc_production_units.month', $month);
        }

        $productionData = $sums->groupBy('hc_sites.site', 'month')->get();

        return response()->json(['success' => true, 'data' => $productionData]);
    }

    public function getPercentage6(Request $request)
    {
        $data = $request->all();
        $year_now = date('Y');
        $year = isset($data['year']) ? $data['year'] : '';
        $month = isset($data['month']) ? $data['month'] : '';

        // Configurar el idioma de la conexión a la base de datos a español
        DB::statement("SET lc_time_names = 'es_ES'");

        $sums = DB::table('hc_production_units')
            ->select([
                'hc_sites.site',
                DB::raw('MONTHNAME(hc_production_units.created_at) AS month'), // Obtener el mes en español
                DB::raw('SUM(CASE WHEN company = "Aviomar" THEN amount ELSE 0 END) AS Aviomar'),
                DB::raw('SUM(CASE WHEN company = "Snider" THEN amount ELSE 0 END) AS Snider'),
                DB::raw('SUM(CASE WHEN company = "Colvan" THEN amount ELSE 0 END) AS Colvan'),
                DB::raw('SUM(CASE WHEN company = "Aviomar" THEN amount ELSE 0 END) +
                 SUM(CASE WHEN company = "Snider" THEN amount ELSE 0 END) +
                 SUM(CASE WHEN company = "Colvan" THEN amount ELSE 0 END) AS Total')
            ])
            ->leftJoin('hc_sites', 'hc_production_units.id_site', '=', 'hc_sites.id');

        if ($year) {
            $sums->whereYear('hc_production_units.created_at', $year);
        } else {
            $sums->whereYear('hc_production_units.created_at', $year_now);
        }

        if ($month) {
            $sums->where('hc_production_units.month', $month);
        }

        // Agrupar por sitio y mes
        $productionData = $sums->groupBy('hc_sites.site', 'month')->get();


        //return response()->json(['success' => true, 'data' => $productionData]);
    }
}
