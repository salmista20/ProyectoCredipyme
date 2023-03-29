<?php

namespace App\Http\Controllers\Mantenimiento\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Mantenimiento\Usuarios\Cargo;

class CargoController extends Controller
{
    public function listar_recursos()
    {
        $cargos = Cargo::orderBy('cargo', 'asc')->get();

        return ['cargos' => $cargos];
    }
}
