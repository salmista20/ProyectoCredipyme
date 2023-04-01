<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use Inertia\Inertia;

class MainController extends Controller
{
    public function fecha()
    {
        date_default_timezone_set("America/Lima");
        $data = date('Y-m-d h:i:s');

        return $data;
    }

    public function datos_registro()
    {
        $fecha = $this->fecha();
        // $usuario = session('dni');
        // $nombre_dispositivo = session('dispositivo')->nombre;
        // $tipo_dispositivo = session('dispositivo')->tipo;

        $datos_registro = (object)[
            'fecha' => $fecha,
            // 'usuario' => $usuario,
            // 'nombre_dispositivo' => $nombre_dispositivo,
            // 'tipo_dispositivo' => $tipo_dispositivo
        ];

        return json_encode($datos_registro);
    }
}
