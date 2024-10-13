<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PercentageTablesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProcessesController;
use App\Http\Controllers\ProductionUnitsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use LdapRecord\Connection;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login-azure', function () {
    return Socialite::driver('azure')->redirect();
});

Route::get('/callback-azure', function () {

    $user = Socialite::driver('azure')->user();

    $userExist = User::where('name', $user->name)->where('email', $user->email)->first();

    if ($userExist) {

        $userAzure = User::where('azure_id', $user->id)->where('modo_auth', 'azure')->first();

        if ($userAzure != null) {

            Auth::login($userExist);
            return redirect('/dashboard');
        } else {

            $actualizarUsuario = User::findOrFail($userExist->id)->update([
                'user_identification' => $user->user['businessPhones'][0],
                'azure_id' => $user->id,
                'modo_auth' => 'azure',
            ]);

            if ($actualizarUsuario) {
                Auth::login($userExist);
                return redirect('/dashboard');
            }
        }
    } else {

        try {
            $connection = new Connection([
                'hosts' => config('ldap.connections.Argon.hosts'),
                'username' => config('ldap.connections.Argon.username'),
                'password' => config('ldap.connections.Argon.password'),
                'port' => config('ldap.connections.Argon.port'),
                'base_dn' => config('ldap.connections.Argon.base_dn'),
                'timeout' => config('ldap.connections.Argon.timeout'),
                'use_ssl' => config('ldap.connections.Argon.use_ssl'),
                'use_tls' => config('ldap.connections.Argon.use_tls'),
                'version' => config('ldap.connections.Argon.version'),
            ]);

            $connection->connect();

            $usuarioNuevo = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'user_identification' => $user->user['businessPhones'][0],
                'azure_id' => $user->id,
                'modo_auth' => 'azure',
            ]);

            Artisan::call('ldap:import', [
                'provider' => 'ldap',
                '--no-interaction',
                '--filter' => '(mail=' . $user->email . ')',
                '--attributes' => 'cn,mail,samaccountname,postofficebox',
            ]);

            Auth::login($usuarioNuevo);
            return redirect('/dashboard');
        } catch (\LdapRecord\Auth\BindException $e) {

            $usuarioNuevo = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'user_identification' => $user->user['businessPhones'][0],
                'azure_id' => $user->id,
                'modo_auth' => 'azure',
            ]);

            Auth::login($usuarioNuevo);
            return redirect('/dashboard');
        }
    }
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::resource('dashboard', DashboardController::class)->names('dashboard');

    Route::resource('usuarios', UsersController::class)->names('usuarios');
    Route::get('listar_usuarios', [UsersController::class, 'listarUsuarios'])->name('listar_usuarios');
    Route::get('session_usuario', [UsersController::class, 'getSessionUser'])->name('session_usuario');
    Route::put('actualizar_permisos/{usuario_id}', [UsersController::class, 'actualizarPermisosUsuario'])->name('actualizar_permisos_usuario');

    Route::resource('roles', RolesController::class)->names('roles');
    Route::get('roles-data', [RolesController::class, 'getRolesData'])->name('roles-data');

    Route::resource('permisos', PermissionsController::class)->names('permisos');
    Route::get('permisos-data', [PermissionsController::class, 'getPermisosData'])->name('permisos-data');

    Route::resource('procesos', ProcessesController::class)->names('procesos');
    Route::get('procesos-data', [ProcessesController::class, 'getProcessesData'])->name('procesos-data');

    Route::resource('unidades_produccion', ProductionUnitsController::class)->names('unidades_produccion');
    Route::get('upregisters-data', [ProductionUnitsController::class, 'getRegistersData'])->name('registers-data');

    //tablas de porcentajes
    Route::resource('percentage_tables', PercentageTablesController::class)->names('percentage_tables');
    Route::get('getPercentage1', [PercentageTablesController::class, 'getPercentage1'])->name('getPercentage1');
    Route::get('getPercentage2', [PercentageTablesController::class, 'getPercentage2'])->name('getPercentage2');
    Route::get('getPercentage3', [PercentageTablesController::class, 'getPercentage3'])->name('getPercentage3');
    Route::get('getPercentage4', [PercentageTablesController::class, 'getPercentage4'])->name('getPercentage4');
    Route::get('getPercentage5', [PercentageTablesController::class, 'getPercentage5'])->name('getPercentage5');
    Route::get('getPercentage6', [PercentageTablesController::class, 'getPercentage6'])->name('getPercentage6');

    Route::get('/generate-pdf-request/{id}/{option}', [PDFController::class, 'generatePDFRequestService'])->name('generate-request');
});
