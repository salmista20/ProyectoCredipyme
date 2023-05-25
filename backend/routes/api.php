<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\Usuarios\UsuarioController;
use App\Http\Controllers\Mantenimiento\Usuarios\CargoController;
use App\Http\Controllers\Mantenimiento\Usuarios\AgenciaController;
use App\Http\Controllers\Mantenimiento\Usuarios\PermisoController;
use App\Http\Controllers\Mantenimiento\Credito\SectorController;
use App\Http\Controllers\Mantenimiento\Credito\EstadoController;
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

Route::GET('/login/acceder/{usuario?}/{clave?}', [LoginController::class, 'validar']);

Route::GET('/usu/gestion/listar_recursos', [UsuarioController::class, 'listar_recursos']);
Route::POST('/usu/gestion/verificar', [UsuarioController::class, 'verificar']);
Route::POST('/usu/gestion/guardar', [UsuarioController::class, 'guardar']);
Route::POST('/usu/gestion/habilitar', [UsuarioController::class, 'habilitar']);
Route::POST('/usu/gestion/deshabilitar', [UsuarioController::class, 'deshabilitar']);
Route::POST('/usu/gestion/cambiar_clave', [UsuarioController::class, 'cambiar_clave']);


Route::GET('/man/usu/cargos/listar_recursos', [CargoController::class, 'listar_recursos']);
Route::POST('/man/usu/cargos/verificar', [CargoController::class, 'verificar']);
Route::POST('/man/usu/cargos/guardar', [CargoController::class, 'guardar']);

Route::GET('/man/usu/agencias/listar_recursos', [AgenciaController::class, 'listar_recursos']);
Route::POST('/man/usu/agencias/verificar', [AgenciaController::class, 'verificar']);
Route::POST('/man/usu/agencias/guardar', [AgenciaController::class, 'guardar']);

Route::GET('/man/usu/permisos/listar_recursos', [PermisoController::class, 'listar_recursos']);
Route::POST('/man/usu/permisos/verificar', [PermisoController::class, 'verificar']);
Route::POST('/man/usu/permisos/guardar', [PermisoController::class, 'guardar']);

Route::GET('/man/cre/sectores/listar_recursos', [SectorController::class, 'listar_recursos']);
Route::POST('/man/cre/sectores/verificar', [SectorController::class, 'verificar']);
Route::POST('/man/cre/sectores/guardar', [SectorController::class, 'guardar']);

Route::GET('/man/cre/estados/listar_recursos', [EstadoController::class, 'listar_recursos']);
Route::POST('/man/cre/estados/verificar', [EstadoController::class, 'verificar']);
Route::POST('/man/cre/estados/guardar', [EstadoController::class, 'guardar']);
