<?php

namespace App\Http\Controllers\Mantenimiento\Usuarios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use App\Models\Mantenimiento\Usuarios\Agencia;

class AgenciaController extends Controller
{
    public function listar_recursos()
    {
        $agencias = Agencia::orderBy('agencia', 'asc')->get();

        return ['agencias' => $agencias];
    }

    public function verificar(Request $request)
    {
        $resultado = 'NO_EXISTE';
        $frmDatosAgencia = json_decode($request->frmDatosAgencia);

        $modo = $frmDatosAgencia->modo;
        $agencia = $frmDatosAgencia->agencia;
        $id = $frmDatosAgencia->id;

        $agencia = Agencia::where('agencia', $agencia)
            ->get()->last();

        if ($agencia != null) {
            if ($modo == 'NUEVO') {
                $resultado = 'EXISTE';
            } else if ($modo == 'EDITAR') {
                if ($agencia->id != $id) {
                    $resultado = 'EXISTE';
                }
            }
        }
        return ['resultado' => $resultado];
    }
    public function guardar(Request $request)
    {
        $response = new \stdClass();

        $frmDatosAgencia = json_decode($request->frmDatosAgencia);
        $agencia = mb_strtoupper(trim($frmDatosAgencia->agencia));
        $direccion = mb_strtoupper(trim($frmDatosAgencia->direccion));
        $modo = $frmDatosAgencia->modo;

        if ($modo == 'NUEVO') {
            Agencia::create([
                'agencia' => $agencia,
                'direccion' => $direccion
            ]);
        } else if ($modo == 'EDITAR') {
            $agencia_id = $frmDatosAgencia->id;

            Agencia::where('id', $agencia_id)->update([
                'agencia' => $agencia,
                'direccion' => $direccion

            ]);
        }

        $response->success = true;

        return $response;
    }
}
