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

@section('title', 'Dashboard')

@push('css')

@endpush

@section('content')
    <div class="panel border rounded-3 border-black mb-1">
        <div class="panel-heading bg-gray-800 text-white p-1 fs-18px fw-bolder flex justify-content-center">
            Dashboard
        </div>
        <div class="p-2">
            Graficas
        </div>
    </div>
@endsection

@push('scripts')

@endpush
