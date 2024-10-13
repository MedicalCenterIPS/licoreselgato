@extends('layouts.app', [
	'paceTop' => true,
	'appSidebarHide' => true,
	'appHeaderHide' => true,
	'appContentClass' => 'p-0'
])

@section('title', '404 Error Page')

@section('content')
	<!-- BEGIN error -->
	<div class="error">
		<div class="error-code">404</div>
		<div class="error-content">
			<div class="error-message">Página No Encontrada.</div>
			<div class="error-desc mb-4">
				La página que estás buscando no existe o ha sido movida. <br />
                Verifica la URL o regresa a la página de inicio.
			</div>
			<div>
				<a href="/requests" class="btn btn-success px-3">volver</a>
			</div>
		</div>
	</div>
	<!-- END error -->
@endsection
