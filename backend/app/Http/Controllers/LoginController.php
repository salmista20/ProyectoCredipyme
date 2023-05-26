<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Usuarios\Usuario;
use App\Models\Mantenimiento\Usuarios\Rol;
use App\Models\Mantenimiento\Usuarios\Cargo;
use App\Models\Mantenimiento\Usuarios\Agencia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use Inertia\Inertia;

class LoginController extends Controller
{
    public function validar($usuario, $clave)
    {
        $datos_usuario = Usuario::where('usuario', $usuario)->get()->last();

        $resultado = 'NO_AUTORIZADO';
        $datos_sesion = null;
        if ($datos_usuario  != null) {
            $clave_usuario = $datos_usuario->clave;

            if (Hash::check($clave, $clave_usuario)) {
                $resultado = 'AUTORIZADO';

                $rol = Rol::find($datos_usuario->rol_id);
                $cargo = Cargo::find($datos_usuario->cargo_id);
                $agencia = Agencia::find($datos_usuario->agencia_id);

                $datos_sesion = (object)[
                    'id' => $datos_usuario->id,
                    'usuario' => $datos_usuario->usuario,
                    'apellido_paterno' => $datos_usuario->apellido_paterno,
                    'apellido_materno' => $datos_usuario->apellido_materno,
                    'nombres' => $datos_usuario->nombres,
                    'rol' => $rol ? $rol->rol : null,
                    'cargo' => $cargo ? $cargo->cargo : null,
                    'agencia' => $agencia ? $agencia->agencia : null
                ];

                $agencias = Agencia::orderBy('agencia', 'asc')->get();
            }
        }

        return [
            'resultado' => $resultado,
            'datos_sesion' => $datos_sesion,
            'agencias' => $agencias
        ];
    }
}
