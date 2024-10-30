<div class="row filters-standard">
    <div class="col-md-4 continer-filter">
        <label for="filter_site">Filtro por Sede</label>
        <select name="filter_site" style="width: 100%;" id="filter_site">
            <option value="1">Dorado</option>
            <option value="4">Cartagena</option>
        </select>
    </div>
    <div class="col-md-3 continer-filter">
        <label for="filter_month">Filtrar por Mes</label>
        <select style="width: 100%;" id="filter_month" name="filter_month" required>
            <option value="">Todos</option>
            @foreach ($months as $key => $value)
                <option value="{{ $value }}">{{ $key }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 continer-filter">
        <label for="filter_year">Filtrar por Año</label>
        <select name="filter_year" style="width: 100%;" id="filter_year">
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
        <button class="btn btn-warning" onclick="clear_indicators()">Limpiar Filtro</button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table_energy" id="table_energy" style="width: 100%;">
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

