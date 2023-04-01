<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Mantenimiento\Usuarios\CargoController;
use App\Http\Controllers\Mantenimiento\Usuarios\AgenciaController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::GET('/man/usu/cargos/listar_recursos', [CargoController::class, 'listar_recursos']);
Route::POST('/man/usu/cargos/verificar', [CargoController::class, 'verificar']);
Route::POST('/man/usu/cargos/guardar', [CargoController::class, 'guardar']);

Route::GET('/man/usu/agencias/listar_recursos', [AgenciaController::class, 'listar_recursos']);
Route::POST('/man/usu/agencias/verificar', [AgenciaController::class, 'verificar']);
Route::POST('/man/usu/agencias/guardar', [AgenciaController::class, 'guardar']);
