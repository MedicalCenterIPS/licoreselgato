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

@section('title', 'Procesos | ' . config('app.name'))

@push('css')
@endpush

@section('content')
    <div class="panel mb-0 border border-1 border-black">
        <div class="panel-heading bg-gray-800 text-white text-center p-1">
            <h4 class="panel-title fs-22px">Procesos</h4>
        </div>
        <div class="panel-body p-1">
            <div class="p-2 bg-white rounded-3">


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
                        <table id="processes-datatable" class="table table-bordered align-middle table-sm">
                            <thead>
                                <tr>
                                    <th class="dt-head-center text-center">ID</th>
                                    <th class="dt-head-center text-center">Proceso</th>
                                    <th class="dt-head-center text-center">Sigla</th>
                                    <th class="dt-head-center text-center">Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="col-sm-5 pt-3">
                        <div class="border border-1 rounded-3 border-dark p-2">
                            <input type="hidden" id="idProcess">
                            <input type="hidden" id="roleNames" name="roleNames" value="{{ auth()->user()->getRoleNames()}}">
                            <form id="form_process">
                                <div class="row mb-2">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label><b>Process</b></label>
                                                <input type="text" id="process" name="process"
                                                    class="form-control border border-dark">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label><b>Sigla</b></label>
                                                <input type="text" id="abbreviation" name="abbreviation"
                                                    class="form-control border border-dark">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 d-flex align-items-end justify-content-between">
                                        <button type="button" class="btn btn-sm bg-gradient-green text-white fw-bolder" id="btnCreateProcess">Crear</button>
                                        <button type="button" class="btn btn-sm bg-gradient-blue text-white fw-bolder d-none"
                                            id="btnUpdateProcess">Guardar</button>
                                        <button type="button" class="btn btn-sm bg-gradient-red text-white fw-bolder" id="btnClearProcess">Limpiar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
    <script src="{{ asset('js/processes.js') }}"></script>
@endpush
