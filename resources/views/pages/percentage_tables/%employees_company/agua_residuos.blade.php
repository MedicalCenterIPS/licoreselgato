<div class="row filters-standard">
    <div class="col-md-4 continer-filter">
        <label for="filter_month_r">Filtrar por Mes</label>
        <select style="width: 100%;" id="filter_month_r" name="filter_month_r" required>
            <option value="">Todos</option>
            @foreach ($months as $key => $value)
                <option value="{{ $value }}">{{ $key }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 continer-filter">
        <label for="filter_year_r">Filtrar por Año</label>
        <select name="filter_year_r" style="width: 100%;" id="filter_year_r">
            <option value="">Seleccione...</option>
            @php
                $currentYear = date('Y');
            @endphp
            @for ($year = 2021; $year <= $currentYear; $year++)
                <option value="{{ $year }}">{{ $year }}</option>
            @endfor
        </select>
    </div>
    <div class="col-md-2 continer-filter" style="margin-top: auto;">
        <button class="btn btn-warning" onclick="clear_indicators1()">Limpiar Filtro</button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table_energy" id="table_whater_r" style="width: 100%;">
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Total C presenciales</th>
                    <th>%Aviomar</th>
                    <th>%Snider</th>
                    <th>%colvan</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
