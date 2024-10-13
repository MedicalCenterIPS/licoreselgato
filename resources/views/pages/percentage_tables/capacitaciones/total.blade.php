<h4 class="text-white text-center bg-dark p-1 mb-1 rounded-3">Capacitaciones totales</h4>
<div class="row filters-standard">
    <div class="col-md-4 continer-filter">
        <label for="filter_month_re">Filtrar por Mes</label>
        <select style="width: 100%;" id="filter_month_re" name="filter_month_re" required>
            <option value="">Todos</option>
            @foreach ($months as $key => $value)
                <option value="{{ $value }}">{{ $key }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 continer-filter">
        <label for="filter_year_re">Filtrar por Año</label>
        <select name="filter_year_ar" style="width: 100%;" id="filter_year_re">
            <option value="">Seleccione...</option>
            @php
                $currentYear = date('Y');
            @endphp
            @for ($year = 2021; $year <= $currentYear; $year++)
                <option value="{{ $year }}">{{ $year }}</option>
            @endfor
        </select>
    </div>
    <div class="col-md-4 continer-filter" style="margin-top: auto;">
        <button class="btn btn-warning">Limpiar Filtro</button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table_energy" id="table_trainings2" style="width: 100%;">
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>%Aviomar</th>
                    <th>%Snider</th>
                    <th>%colvan</th>
                    <th>Total</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
