<?php

namespace App\Http\Controllers\Mantenimiento\Credito;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use App\Models\Mantenimiento\Credito\Tipo;

class TipoController extends Controller
{
    public function listar_recursos()
    {
        $tipos = Tipo::orderBy('tipo', 'asc')->get();

        return ['tipos' => $tipos];
    }

    public function verificar(Request $request)
    {
        $resultado = 'NO_EXISTE';
        //Usar el mismo patron del requerimiento : frmDatosTipo
        $frmDatosSector = json_decode($request->frmDatosTipo);

        $modo = $frmDatosSector->modo;
        $tipo = $frmDatosSector->tipo;
        $id = $frmDatosSector->id;

        $tipo = Tipo::where('tipo', $tipo)
            ->get()->last();

        if ($tipo != null) {
            if ($modo == 'NUEVO') {
                $resultado = 'EXISTE';
            } else if ($modo == 'EDITAR') {
                if ($tipo->id != $id) {
                    $resultado = 'EXISTE';
                }
            }
        }
        return ['resultado' => $resultado];
    }

    public function guardar(Request $request)
    {
        $response = new \stdClass();

        $frmDatosTipo = json_decode($request->frmDatosTipo);
        $tipo = mb_strtoupper(trim($frmDatosTipo->tipo));
        $modo = $frmDatosTipo->modo;

        if ($modo == 'NUEVO') {
            Tipo::create([

                'tipo' => $tipo
            ]);
        } else if ($modo == 'EDITAR') {
            $tipo_id = $frmDatosTipo->id;
            $habilitado = filter_var($frmDatosTipo->habilitado, FILTER_VALIDATE_BOOLEAN);

            Tipo::where('id', $tipo_id)->update([
                'tipo' => $tipo,
                'habilitado' => $habilitado
            ]);
        }

        $response->success = true;

        return $response;
    }
}
