@extends('layouts.app', [
	'paceTop' => true,
	'appSidebarHide' => true,
	'appHeaderHide' => true,
	'appContentClass' => 'p-0'
])

@section('title', '403 Acceso Denegado')

@section('content')
	<!-- BEGIN error -->
	<div class="error">
		<div class="error-code">403</div>
		<div class="error-content">
			<div class="error-message">Acceso Denegado</div>
			<div class="error-desc mb-4">
				No tienes los permisos necesarios para acceder a esta página.
			</div>
			<div>
				<a href="/requests" class="btn btn-success px-3">Volver</a>
			</div>
		</div>
	</div>
	<!-- END error -->
@endsection
