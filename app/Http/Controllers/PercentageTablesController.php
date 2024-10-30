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

    function traslateMonth($monthEnglish)
    {
        // Array de traducción de nombres de meses
        $months = [
            'January' => 'Enero',
            'February' => 'Febrero',
            'March' => 'Marzo',
            'April' => 'Abril',
            'May' => 'Mayo',
            'June' => 'Junio',
            'July' => 'Julio',
            'August' => 'Agosto',
            'September' => 'Septiembre',
            'October' => 'Octubre',
            'November' => 'Noviembre',
            'December' => 'Diciembre'
        ];

        return $months[$monthEnglish] ?? $monthEnglish;
    }


    public function getPercentage1(Request $request)
    {
        $data = $request->all();
        $year_now = date('Y');
        $site_now = 1;

        // Obtén los parámetros del request o usa valores predeterminados
        $year = isset($data['year']) ? $data['year'] : $year_now;
        $month = isset($data['month']) ? $data['month'] : '';
        $site = isset($data['site']) ? $data['site'] : '';

        // Construcción de la consulta
        $query = DB::table('hc_production_units')
            ->select([
                'hc_type_collaborators.type',
                'hc_sites.site',
                'hc_production_units.month',
                DB::raw('SUM(amount) AS total_amount'),
                DB::raw("SUM(CASE WHEN company = 'Aviomar' THEN amount ELSE 0 END) AS Aviomar"),
                DB::raw("SUM(CASE WHEN company = 'Snider' THEN amount ELSE 0 END) AS Snider"),
                DB::raw("SUM(CASE WHEN company = 'Colvan' THEN amount ELSE 0 END) AS Colvan"),
            ])
            ->leftJoin('hc_type_collaborators', 'hc_production_units.id_type', '=', 'hc_type_collaborators.id')
            ->leftJoin('hc_sites', 'hc_production_units.id_site', '=', 'hc_sites.id')
            ->where('hc_type_collaborators.id', 1)
            ->where('hc_production_units.year', $year);

        // Filtrar por mes si se proporciona
        if ($month) {
            $query->where('hc_production_units.month', $month);
        }

        // Filtrar por sitio, usando el valor predeterminado si no se proporciona
        $query->where('hc_sites.id', $site ?: $site_now);

        // Agrupar y ordenar los resultados
        $productionData = $query->groupBy('hc_production_units.month', 'hc_type_collaborators.type', 'hc_sites.site')
            ->orderByRaw("
            CASE hc_production_units.month
                WHEN 'Enero' THEN 1
                WHEN 'Febrero' THEN 2
                WHEN 'Marzo' THEN 3
                WHEN 'Abril' THEN 4
                WHEN 'Mayo' THEN 5
                WHEN 'Junio' THEN 6
                WHEN 'Julio' THEN 7
                WHEN 'Agosto' THEN 8
                WHEN 'Septiembre' THEN 9
                WHEN 'Octubre' THEN 10
                WHEN 'Noviembre' THEN 11
                WHEN 'Diciembre' THEN 12
                ELSE 13 -- Valor por defecto para meses no reconocidos
            END ASC
        ")
            ->get();

        // Calcular porcentajes
        $productionData = $productionData->map(function ($item) {
            $total_amount = $item->total_amount ?: 1;
            $item->Aviomar = intval(round(($item->Aviomar * 100) / $total_amount));
            $item->Snider = intval(round(($item->Snider * 100) / $total_amount));
            $item->Colvan = intval(round(($item->Colvan * 100) / $total_amount));
            $item->month = $this->traslateMonth($item->month);
            return $item;
        });

        return response()->json([
            'success' => true,
            'data' => $productionData,
        ]);
    }


    public function getPercentage2(Request $request)
    {
        $data = $request->all();
        $year_now = date('Y');

        $year = isset($data['year']) ? $data['year'] : $year_now;
        $month = isset($data['month']) ? $data['month'] : '';

        // Construcción de la consulta
        $query = DB::table('hc_production_units')
            ->select([
                'hc_type_collaborators.type',
                'hc_sites.site',
                'hc_production_units.month',
                DB::raw('SUM(amount) AS total_amount'),
                DB::raw("SUM(CASE WHEN company = 'Aviomar' THEN amount ELSE 0 END) AS Aviomar"),
                DB::raw("SUM(CASE WHEN company = 'Snider' THEN amount ELSE 0 END) AS Snider"),
                DB::raw("SUM(CASE WHEN company = 'Colvan' THEN amount ELSE 0 END) AS Colvan"),
            ])
            ->leftJoin('hc_type_collaborators', 'hc_production_units.id_type', '=', 'hc_type_collaborators.id')
            ->leftJoin('hc_sites', 'hc_production_units.id_site', '=', 'hc_sites.id')
            ->where('hc_type_collaborators.id', 1)
            ->where('hc_sites.id', 5);


        if ($month) {
            $query->where('hc_production_units.month', $month);
        }

        // Filtrar por sitio, usando el valor predeterminado si no se proporciona
        $query->where('hc_production_units.year', $year ?: $year_now);

        // Agrupar y ordenar los resultados
        $productionData = $query->groupBy('hc_production_units.month', 'hc_type_collaborators.type', 'hc_sites.site')
            ->orderByRaw("
                CASE hc_production_units.month
                    WHEN 'Enero' THEN 1
                    WHEN 'Febrero' THEN 2
                    WHEN 'Marzo' THEN 3
                    WHEN 'Abril' THEN 4
                    WHEN 'Mayo' THEN 5
                    WHEN 'Junio' THEN 6
                    WHEN 'Julio' THEN 7
                    WHEN 'Agosto' THEN 8
                    WHEN 'Septiembre' THEN 9
                    WHEN 'Octubre' THEN 10
                    WHEN 'Noviembre' THEN 11
                    WHEN 'Diciembre' THEN 12
                    ELSE 13 -- Valor por defecto para meses no reconocidos
                END ASC
            ")
            ->get();

        // Calcular porcentajes
        $productionData = $productionData->map(function ($item) {

            $total_s = $item->total_amount ?: 1;
            $item->aviomar = intval(round(($item->Aviomar * 100) / $total_s));
            $item->snider = intval(round(($item->Snider * 100) / $total_s));
            $item->colvan = intval(round(($item->Colvan * 100) / $total_s));
            $item->month = $this->traslateMonth($item->month);
            return $item;
        });


        //dd($productionData);
        return response()->json([
            'success' => true,
            'data' => $productionData,
        ]);
    }

    public function getPercentage3(Request $request)
    {
        $data = $request->all();
        $year_now = date('Y');

        $year = isset($data['year']) ? $data['year'] : $year_now;
        $month = isset($data['month']) ? $data['month'] : '';

        // Construcción de la consulta
        $query = DB::table('hc_production_units')
            ->select([
                'hc_type_collaborators.type',
                'hc_sites.site',
                'hc_production_units.month',
                DB::raw('SUM(amount) AS total_amount'),
                DB::raw("SUM(CASE WHEN company = 'Aviomar' THEN amount ELSE 0 END) AS Aviomar"),
                DB::raw("SUM(CASE WHEN company = 'Snider' THEN amount ELSE 0 END) AS Snider"),
                DB::raw("SUM(CASE WHEN company = 'Colvan' THEN amount ELSE 0 END) AS Colvan"),
            ])
            ->leftJoin('hc_type_collaborators', 'hc_production_units.id_type', '=', 'hc_type_collaborators.id')
            ->leftJoin('hc_sites', 'hc_production_units.id_site', '=', 'hc_sites.id')
            //->where('hc_type_collaborators.id', 1)
            ->where('hc_sites.id', 1);


        if ($month) {
            $query->where('hc_production_units.month', $month);
        }

        // Filtrar por sitio, usando el valor predeterminado si no se proporciona
        $query->where('hc_production_units.year', $year ?: $year_now);

        // Agrupar y ordenar los resultados
        $productionData = $query->groupBy('hc_production_units.month', 'hc_sites.site')
            ->orderByRaw("
                CASE hc_production_units.month
                    WHEN 'Enero' THEN 1
                    WHEN 'Febrero' THEN 2
                    WHEN 'Marzo' THEN 3
                    WHEN 'Abril' THEN 4
                    WHEN 'Mayo' THEN 5
                    WHEN 'Junio' THEN 6
                    WHEN 'Julio' THEN 7
                    WHEN 'Agosto' THEN 8
                    WHEN 'Septiembre' THEN 9
                    WHEN 'Octubre' THEN 10
                    WHEN 'Noviembre' THEN 11
                    WHEN 'Diciembre' THEN 12
                    ELSE 13 -- Valor por defecto para meses no reconocidos
                END ASC
            ")
            ->get();

        // Calcular porcentajes
        $productionData = $productionData->map(function ($item) {

            $total_s = $item->total_amount ?: 1;
            $item->aviomar = intval(round(($item->Aviomar * 100) / $total_s));
            $item->snider = intval(round(($item->Snider * 100) / $total_s));
            $item->colvan = intval(round(($item->Colvan * 100) / $total_s));
            $item->month = $this->traslateMonth($item->month);
            return $item;
        });


        //dd($productionData);
        return response()->json([
            'success' => true,
            'data' => $productionData,
        ]);
    }

    public function getPercentage4(Request $request)
    {
        $data = $request->all();
        $year_now = date('Y');

        $year = isset($data['year']) ? $data['year'] : $year_now;
        $month = isset($data['month']) ? $data['month'] : '';

        // Construcción de la consulta
        $query = DB::table('hc_production_units')
            ->select([
                'hc_type_collaborators.type',
                'hc_sites.site',
                'hc_production_units.month',
                DB::raw("SUM(CASE WHEN (company = 'Aviomar' AND hc_type_collaborators.id = 1) 
                    OR (company = 'Snider' AND hc_type_collaborators.id IN (1, 2)) 
                    OR (company = 'Colvan' AND hc_type_collaborators.id = 1) 
                  THEN amount ELSE 0 END) AS total_amount"),
                DB::raw("SUM(CASE WHEN company = 'Aviomar' AND hc_type_collaborators.id  = 1 THEN amount ELSE 0 END) AS Aviomar"),
                DB::raw("SUM(CASE WHEN company = 'Snider' AND hc_type_collaborators.id IN (1, 2) THEN amount ELSE 0 END) AS Snider"),
                DB::raw("SUM(CASE WHEN company = 'Colvan' AND hc_type_collaborators.id  = 1 THEN amount ELSE 0 END) AS Colvan"),
            ])
            ->leftJoin('hc_type_collaborators', 'hc_production_units.id_type', '=', 'hc_type_collaborators.id')
            ->leftJoin('hc_sites', 'hc_production_units.id_site', '=', 'hc_sites.id')
            ->where('hc_sites.id', 1);


        if ($month) {
            $query->where('hc_production_units.month', $month);
        }

        // Filtrar por sitio, usando el valor predeterminado si no se proporciona
        $query->where('hc_production_units.year', $year ?: $year_now);

        // Agrupar y ordenar los resultados
        $productionData = $query->groupBy('hc_production_units.month', 'hc_sites.site')
            ->orderByRaw("
                CASE hc_production_units.month
                    WHEN 'Enero' THEN 1
                    WHEN 'Febrero' THEN 2
                    WHEN 'Marzo' THEN 3
                    WHEN 'Abril' THEN 4
                    WHEN 'Mayo' THEN 5
                    WHEN 'Junio' THEN 6
                    WHEN 'Julio' THEN 7
                    WHEN 'Agosto' THEN 8
                    WHEN 'Septiembre' THEN 9
                    WHEN 'Octubre' THEN 10
                    WHEN 'Noviembre' THEN 11
                    WHEN 'Diciembre' THEN 12
                    ELSE 13 -- Valor por defecto para meses no reconocidos
                END ASC
            ")
            ->get();

        // Calcular porcentajes

        $productionData = $productionData->map(function ($item) {

            $total_s = $item->total_amount ?: 1;
            $item->Aviomar = intval(round(($item->Aviomar * 100) / $total_s));
            $item->Snider = intval(round(($item->Snider * 100) / $total_s));
            $item->Colvan = intval(round(($item->Colvan * 100) / $total_s));
            $item->month = $this->traslateMonth($item->month);
            return $item;
        });


        //dd($productionData);
        return response()->json([
            'success' => true,
            'data' => $productionData,
        ]);
    }

     public function getPercentage5(Request $request)
     {
        $data = $request->all();
        $year_now = date('Y');

        $year = isset($data['year']) ? $data['year'] : $year_now;
        $month = isset($data['month']) ? $data['month'] : '';

        // Construcción de la consulta
        $query = DB::table('hc_production_units')
            ->select([
                'hc_type_collaborators.type',
                'hc_sites.site',
                'hc_production_units.month',
                DB::raw('SUM(amount) AS total_amount'),
                DB::raw("SUM(CASE WHEN company = 'Aviomar' THEN amount ELSE 0 END) AS Aviomar"),
                DB::raw("SUM(CASE WHEN company = 'Snider' THEN amount ELSE 0 END) AS Snider"),
                DB::raw("SUM(CASE WHEN company = 'Colvan' THEN amount ELSE 0 END) AS Colvan"),
            ])
            ->leftJoin('hc_type_collaborators', 'hc_production_units.id_type', '=', 'hc_type_collaborators.id')
            ->leftJoin('hc_sites', 'hc_production_units.id_site', '=', 'hc_sites.id');
            //->where('hc_type_collaborators.id', 1)
            //->where('hc_sites.id', 1);


        if ($month) {
            $query->where('hc_production_units.month', $month);
        }

        // Filtrar por sitio, usando el valor predeterminado si no se proporciona
        $query->where('hc_production_units.year', $year ?: $year_now);

        // Agrupar y ordenar los resultados
        $productionData = $query->groupBy('hc_production_units.month')
            ->orderByRaw("
                CASE hc_production_units.month
                    WHEN 'Enero' THEN 1
                    WHEN 'Febrero' THEN 2
                    WHEN 'Marzo' THEN 3
                    WHEN 'Abril' THEN 4
                    WHEN 'Mayo' THEN 5
                    WHEN 'Junio' THEN 6
                    WHEN 'Julio' THEN 7
                    WHEN 'Agosto' THEN 8
                    WHEN 'Septiembre' THEN 9
                    WHEN 'Octubre' THEN 10
                    WHEN 'Noviembre' THEN 11
                    WHEN 'Diciembre' THEN 12
                    ELSE 13 -- Valor por defecto para meses no reconocidos
                END ASC
            ")
            ->get();

        // Calcular porcentajes
        $productionData = $productionData->map(function ($item) {

            $total_s = $item->total_amount ?: 1;
            $item->aviomar = intval(round(($item->Aviomar * 100) / $total_s));
            $item->snider = intval(round(($item->Snider * 100) / $total_s));
            $item->colvan = intval(round(($item->Colvan * 100) / $total_s));
            $item->month = $this->traslateMonth($item->month);
            $item->total = $total_s;
            return $item;
        });


        //dd($productionData);
        return response()->json([
            'success' => true,
            'data' => $productionData,
        ]);
    }

    public function getPercentage6(Request $request)
    {
        $data = $request->all();
        $year_now = date('Y');

        $year = isset($data['year']) ? $data['year'] : $year_now;
        $month = isset($data['month']) ? $data['month'] : '';

        // Construcción de la consulta
        $query = DB::table('hc_production_units')
            ->select([
                'hc_type_collaborators.type',
                'hc_sites.site',
                'hc_production_units.month',
                DB::raw('SUM(amount) AS total_amount'),
                DB::raw("SUM(CASE WHEN company = 'Aviomar' THEN amount ELSE 0 END) AS Aviomar"),
                DB::raw("SUM(CASE WHEN company = 'Snider' THEN amount ELSE 0 END) AS Snider"),
                DB::raw("SUM(CASE WHEN company = 'Colvan' THEN amount ELSE 0 END) AS Colvan"),
            ])
            ->leftJoin('hc_type_collaborators', 'hc_production_units.id_type', '=', 'hc_type_collaborators.id')
            ->leftJoin('hc_sites', 'hc_production_units.id_site', '=', 'hc_sites.id');
            //->where('hc_type_collaborators.id', 1)
            //->where('hc_sites.id', 1);


        if ($month) {
            $query->where('hc_production_units.month', $month);
        }

        // Filtrar por sitio, usando el valor predeterminado si no se proporciona
        $query->where('hc_production_units.year', $year ?: $year_now);

        // Agrupar y ordenar los resultados
        $productionData = $query->groupBy('hc_production_units.month')
            ->orderByRaw("
                CASE hc_production_units.month
                    WHEN 'Enero' THEN 1
                    WHEN 'Febrero' THEN 2
                    WHEN 'Marzo' THEN 3
                    WHEN 'Abril' THEN 4
                    WHEN 'Mayo' THEN 5
                    WHEN 'Junio' THEN 6
                    WHEN 'Julio' THEN 7
                    WHEN 'Agosto' THEN 8
                    WHEN 'Septiembre' THEN 9
                    WHEN 'Octubre' THEN 10
                    WHEN 'Noviembre' THEN 11
                    WHEN 'Diciembre' THEN 12
                    ELSE 13 -- Valor por defecto para meses no reconocidos
                END ASC
            ")
            ->get();

        // Calcular porcentajes
        $productionData = $productionData->map(function ($item) {

            $total_s = $item->total_amount ?: 1;
            $item->aviomar = intval(round(($item->Aviomar * 100) / $total_s));
            $item->snider = intval(round(($item->Snider * 100) / $total_s));
            $item->colvan = intval(round(($item->Colvan * 100) / $total_s));
            $item->month = $this->traslateMonth($item->month);
            $item->total = $total_s;
            return $item;
        });


        //dd($productionData);
        return response()->json([
            'success' => true,
            'data' => $productionData,
        ]);
    }
}
