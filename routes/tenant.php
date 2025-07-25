<?php

declare(strict_types=1);

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\TesteController;
use App\Services\Escola;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return Inertia::render('welcome');
    })->name('home');
    Route::get('/teste', [ TesteController::class,'index'])->name('teste');
    // Route::get('/', function () {
    //     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    // });
});

Route::name('api.')->prefix('api/v1')->middleware([
    'api',
    // 'auth:sanctum',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::fallback(function () {
        return view('erro404_site');
    });
    Route::post('/login',[AuthController::class,'login']);
    // Route::middleware('auth:sanctum')->get('/user', [AuthController::class,'user']);
    Route::middleware('auth:sanctum')->post('/add-presenca-massa', [Escola::class,'add_presenca'])->name('add_presenca');
    // Route::middleware('auth:sanctum')->post('/clientes-update/{cpf}', [ClientesController::class,'update']);
    // // Route::middleware('auth:sanctum')->put('/clientes/{cpf}', [ClientesController::class,'update']);
    // Route::middleware('auth:sanctum')->get('/clientes/{cpf}', [ClientesController::class,'show']);
    // Route::middleware('auth:sanctum')->delete('/clientes/{id}', [ClientesController::class,'destroy']);
    // Route::middleware('auth:sanctum')->post('/clientes-cancelar/{id}', [ClientesController::class,'cancelar_contrato']);
});
