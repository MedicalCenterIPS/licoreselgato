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

@section('title', 'Permisos | ' . config('app.name'))

@push('css')
@endpush

@section('content')
    <div class="panel border rounded-3 border-black mb-1">
        <div class="panel-heading bg-gray-800 text-white p-1 fs-18px fw-bolder flex justify-content-center">
            Permisos
        </div>
        <div class="p-2">
            <div class="row justify-content-left mb-2">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text border border-dark">
                            Buscar:
                        </span>
                        <input type="text" id="barSearch" class="form-control border border-dark">
                    </div>
                </div>
                <div class="col-sm-1 text-end">
                </div>
                <div class="col-sm-1 text-end">
                    <button class="btn btn-sm bg-gradient-orange text-black fw-bolder" id="btnClearSearch">Limpiar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-7">
                    <table id="permissions-datatable" class="table table-bordered align-middle table-sm">
                        <thead>
                            <tr>
                                <th class="dt-head-center text-center">ID</th>
                                <th class="dt-head-center text-center">Permiso</th>
                                <th class="dt-head-center text-center">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-sm-5 pt-3">
                    <div class="border border-1 rounded-3 border-dark p-2">
                        <form id="form_permission" autocomplete="off">
                            <div class="row mb-2">
                                <div class="col-sm-12">
                                    <input type="hidden" class="form-control bg-white text-center" id="idPermission">
                                    <div class="form-group row">
                                        <div class="col-sm-12 input-group">
                                            <span class="input-group-text pe-4 ps-4 border border-dark">
                                                Permiso
                                            </span>
                                            <input type="text" id="permission" name="permission"
                                                class="form-control form-control-sm border border-dark">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-sm bg-gradient-green text-white fw-bolder"
                                            id="btnCreatePermission">Crear</button>
                                        <button type="button" class="btn btn-sm bg-gradient-blue text-white fw-bolder d-none"
                                            id="btnUpdatePermission">Guardar</button>
                                        <button type="button" class="btn btn-sm bg-gradient-red text-white fw-bolder"
                                            id="btnClearPermission">Limpiar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
    <script src="{{ asset('js/permissions.js') }}"></script>
@endpush
