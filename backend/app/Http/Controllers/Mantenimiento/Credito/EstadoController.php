<?php

namespace App\Http\Controllers\Mantenimiento\Credito;

use App\Http\Controllers\Controller;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use App\Models\Mantenimiento\Credito\Estado;

class EstadoController extends Controller
{
    public function listar_recursos()
    {
        $estados = Estado::orderBy('estado', 'asc')->get();

        return ['estados' => $estados];
    }

    public function verificar(Request $request)
    {
        $resultado = 'NO_EXISTE';
        $frmDatosEstado = json_decode($request->frmDatosEstado);

        $modo = $frmDatosEstado->modo;
        $estado = $frmDatosEstado->estado;
        $id = $frmDatosEstado->id;

        $estado = Estado::where('estado', $estado)
            ->get()->last();

        if ($estado != null) {
            if ($modo == 'NUEVO') {
                $resultado = 'EXISTE';
            } else if ($modo == 'EDITAR') {
                if ($estado->id != $id) {
                    $resultado = 'EXISTE';
                }
            }
        }
        return ['resultado' => $resultado];
    }

    public function guardar(Request $request)
    {
        $response = new \stdClass();

        $frmDatosEstado = json_decode($request->frmDatosEstado);
        $estado = mb_strtoupper(trim($frmDatosEstado->estado));
        $modo = $frmDatosEstado->modo;

        if ($modo == 'NUEVO') {
            Estado::create([
                'estado' => $estado
            ]);
        } else if ($modo == 'EDITAR') {
            $estado_id = $frmDatosEstado->id;
            $habilitado = $frmDatosEstado->habilitado;

            Estado::where('id', $estado_id)->update([
                'estado' => $estado,
                'habilitado' => $habilitado
            ]);
        }

        $response->success = true;

        return $response;
    }
}
