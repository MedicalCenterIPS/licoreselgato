@extends('layouts.app', [
    'appHeaderInverse' => true,
    'appTopMenu' => false,
    'appSidebarEnd' => false,
    'appSidebarLight' => false,
    'appSidebarWide' => false,
    'appSidebarHide' => false,
    'appSidebarTransparent' => true,
    'appSidebarMinified' => false,
    'appSidebarSearch' => false,
    'appContentClass' => false,
    'appContentFullHeight' => false,
    'appSidebarProfile' => false,
])

@section('title', 'Consumos de Servicios| ' . config('app.name'))

@push('css')
@endpush

@section('content')
    <div class="panel border border-2 rounded-3 border-black mb-1">
        <div class="panel-heading bg-gray-800 text-white p-1 fs-18px fw-bolder flex justify-content-center">
            Registro de Consumos en Servicios
        </div>

        <div class="panel-body p-0">
            <div class="row m-1">
                <div class="col-sm-2">
                    <label for="site_id" class="fw-bolder">Filtro por Sede</label>
                    <select class="SelectIn" name="site_id" style="width: 100%;" id="">
                        <option value="">Todos</option>
                        @foreach ($sites as $site)
                            <option value="{{ $site->id }}">{{ $site->site }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="month" class="fw-bolder">Filtrar por Mes</label>
                    <select class="SelectIn" style="width: 100%;" id="" name="month" required>
                        <option value="">Todos</option>
                        @foreach ($months as $key => $value)
                            <option value="{{ $value }}">{{ $key }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="year" class="fw-bolder">Filtrar por Año</label>
                    <select class="SelectIn" name="year" style="width: 100%;" id="">
                        <option value="">---</option>
                        @php
                            $currentYear = date('Y');
                        @endphp
                        @for ($year = 2021; $year <= $currentYear; $year++)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-sm-6 d-flex align-items-end justify-content-between">
                    <button class="btn bg-gradient-orange text-black fw-bolder" onclick="clear_f_cons()">
                        Limpiar Filtro
                    </button>
                    <div>
                        <button type="button" class="btn bg-gradient-green text-white fw-bolder" id="download_template_services">
                            <i class="fas fa-download"></i> Descargar plantilla
                        </button>
                        <button type="button" class="btn bg-gradient-blue text-white fw-bolder" id="upload_template_services">
                            <i class="fas fa-upload"></i> Cargar plantilla
                        </button>
                    </div>
                    <button class="btn bg-gradient-green text-white fw-bolder" id='btnAddConsumption'>
                        Agregar
                    </button>
                </div>
            </div>

            <div class="row m-1">
                <table class="table table-sm border border-2 border-dark table-bordered align-middle" id="table_service_consumption_records">
                    <thead>
                        <tr class="border border-2 border-dark">
                            <th>Sede</th>
                            <th>Servicio</th>
                            <th>Cuenta</th>
                            <th>Mes</th>
                            <th>Año</th>
                            <th>Empresa</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @include('pages.registers.services.modal_service_consumption_records')
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{ asset('js/service_consumption_records.js') }}"></script>
@endpush
