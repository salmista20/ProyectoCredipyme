<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Usuarios\UsuarioController;
use App\Http\Controllers\Mantenimiento\Usuarios\CargoController;
use App\Http\Controllers\Mantenimiento\Usuarios\AgenciaController;
use App\Http\Controllers\Mantenimiento\Credito\SectorController;
use App\Http\Controllers\Mantenimiento\Credito\ProductoController;
use App\Http\Controllers\Mantenimiento\Credito\CategoriaController;
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

Route::GET('/usu/gestion/listar_recursos', [UsuarioController::class, 'listar_recursos']);
Route::POST('/usu/gestion/verificar', [UsuarioController::class, 'verificar']);
Route::POST('/usu/gestion/guardar', [UsuarioController::class, 'guardar']);


Route::GET('/man/usu/cargos/listar_recursos', [CargoController::class, 'listar_recursos']);
Route::POST('/man/usu/cargos/verificar', [CargoController::class, 'verificar']);
Route::POST('/man/usu/cargos/guardar', [CargoController::class, 'guardar']);

Route::GET('/man/usu/agencias/listar_recursos', [AgenciaController::class, 'listar_recursos']);
Route::POST('/man/usu/agencias/verificar', [AgenciaController::class, 'verificar']);
Route::POST('/man/usu/agencias/guardar', [AgenciaController::class, 'guardar']);

Route::GET('/man/cre/sectores/listar_recursos', [SectorController::class, 'listar_recursos']);
Route::POST('/man/cre/sectores/verificar', [SectorController::class, 'verificar']);
Route::POST('/man/cre/sectores/guardar', [SectorController::class, 'guardar']);

Route::GET('/man/cre/productos/listar_recursos', [ProductoController::class, 'listar_recursos']);
Route::POST('/man/cre/productos/verificar', [ProductoController::class, 'verificar']);
Route::POST('/man/cre/productos/guardar', [ProductoController::class, 'guardar']);

Route::GET('/man/cre/categorias/listar_recursos', [CategoriaController::class, 'listar_recursos']);
Route::POST('/man/cre/categorias/verificar', [CategoriaController::class, 'verificar']);
Route::POST('/man/cre/categorias/guardar', [CategoriaController::class, 'guardar']);