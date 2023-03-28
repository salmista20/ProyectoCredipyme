<?php

namespace App\Http\Controllers\Mantenimiento\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Mantenimiento\Usuarios\Cargo;

class CargoController extends Controller
{
    public function listar()
    {
        $cargos = Cargo::all();

        return $cargos;
    }
}
