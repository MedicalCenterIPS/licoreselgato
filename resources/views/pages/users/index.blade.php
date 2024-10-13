@extends('layouts.app', [
    'appHeaderInverse' => config('config_app.general.appHeaderInverse'),
    'appTopMenu' => config('config_app.general.appTopMenu'),
    'appSidebarEnd' => config('config_app.general.appSidebarEnd'),
    'appSidebarLight' => config('config_app.general.appSidebarLight'),
    'appSidebarWide' => config('config_app.general.appSidebarWide'),
    'appSidebarHide' => config('config_app.general.appSidebarHide'),
    'appSidebarTransparent' => config('config_app.general.appSidebarTransparent'),
    'appSidebarMinified' => config('config_app.general.appSidebarMinified'),
    'appSidebarSearch' => config('config_app.general.appSidebarSearch'),
    'appContentClass' => config('config_app.general.appContentClass'),
    'appContentFullHeight' => config('config_app.general.appContentFullHeight'),
    'appSidebarProfile' => config('config_app.general.appSidebarProfile'),
])

@section('title', 'Usuarios | '.config('app.name'))

@push('css')
    <link href="{{ asset('css/usuarios.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/general/general.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="panel mb-0 border border-1 border-black">
        <div class="panel-heading bg-gray-800 text-white text-center p-1">
            <h4 class="panel-title fs-22px">Usuarios</h4>
        </div>
        <div class="panel-body p-1">
            <div class="p-2 bg-white rounded-3">
                <div class="row justify-content-center mb-2">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                Buscar:
                            </span>
                            <input type="text" id="barSearch" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-text">Rol</span>
                            <select class="form-select form-select-sm select-filtrar" data-column="5" aria-label="Default select example">
                                <option value="" selected>---</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->name }}">
                                        {{ $rol->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-text">Estado</span>
                            <select class="form-select form-select-sm select-filtrar" data-column="6" aria-label="Default select example">
                                <option value="" selected>---</option>
                                <option value="1">Activo</option>
                                <option value="0">Retirado</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <table id="users-datatable" class="table table-bordered align-middle table-sm">
                            <thead>
                                <tr>
                                    <th class="dt-head-center text-center">ID</th>
                                    <th class="dt-head-center text-center">Nombre</th>
                                    <th class="dt-head-center text-center">Identificación</th>
                                    <th class="dt-head-center text-center">Correo</th>
                                    <th class="dt-head-center text-center">Proceso</th>
                                    <th class="dt-head-center text-center">Rol</th>
                                    <th class="dt-head-center text-center">Estado</th>
                                    <th class="dt-head-center text-center">Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pages.users.modal_gestion_usuario')
@endsection

@push('scripts')
    <script src="{{ asset('js/usuarios.js') }}"></script>
@endpush
