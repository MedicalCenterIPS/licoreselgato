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

@section('title', 'Porcentajes | ' . config('app.name'))

@push('css')

@endpush

@section('content')
    <div class="panel border border-2 rounded-3 border-black mb-1">
        <div class="panel-heading bg-gray-800 text-white p-1 mb-0 fs-18px fw-bolder flex justify-content-center">
            Porcentajes de consumo por colaboradores y empresa
        </div>
        <div class="panel-body p-1">
            <div class="row p-1">
                <div class="col-sm-12">
                    <ul class="nav nav-pills bg-gradient-gray pb-0 pe-2 pt-2 ps-2 rounded-top border border-dark">
                        <li class="nav-item">
                            <a href="#tab1" data-bs-toggle="tab" class="nav-link pt-1 pb-1 pe-3 ps-3 fs-14px active"
                                id="optTab1">
                                <span class="d-sm-none">Tab 1</span>
                                <span class="d-sm-block d-none">Porcentajes Energia</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab2" data-bs-toggle="tab" class="nav-link pt-1 pb-1 pe-3 ps-3 fs-14px">
                                <span class="d-sm-none">Tab 2</span>
                                <span class="d-sm-block d-none">Porcentajes Agua Sede Cali</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab3" data-bs-toggle="tab" class="nav-link pt-1 pb-1 pe-3 ps-3 fs-14px">
                                <span class="d-sm-none">Tab 3</span>
                                <span class="d-sm-block d-none">Porcentajes Residuos Sede Dorado</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab5" data-bs-toggle="tab" class="nav-link pt-1 pb-1 pe-3 ps-3 fs-14px">
                                <span class="d-sm-none">Tab 5</span>
                                <span class="d-sm-block d-none">Porcentajes Agua y Residuos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab4" data-bs-toggle="tab" class="nav-link pt-1 pb-1 pe-3 ps-3 fs-14px">
                                <span class="d-sm-none">Tab 4</span>
                                <span class="d-sm-block d-none">Capacitaciones</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content box-tercero p-2 pt-2 bg-white rounded-bottom border border-dark">

                        <div class="tab-pane fade active show" id="tab1">
                            @include('pages.percentage_tables.%employees_company.energia')
                        </div>

                        <div class="tab-pane fade" id="tab2">
                            @include('pages.percentage_tables.%employees_company.agua')
                        </div>

                        <div class="tab-pane fade" id="tab3">
                            @include('pages.percentage_tables.%employees_company.residuos')
                        </div>

                        <div class="tab-pane fade" id="tab4">
                            @include('pages.percentage_tables.capacitaciones.presencial')
                            @include('pages.percentage_tables.capacitaciones.total')
                        </div>

                        <div class="tab-pane fade" id="tab5">
                            @include('pages.percentage_tables.%employees_company.agua_residuos')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{ asset('js/percentage_tables.js') }}"></script>
@endpush
