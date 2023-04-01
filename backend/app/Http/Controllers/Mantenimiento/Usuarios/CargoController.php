<?php

namespace App\Http\Controllers\Mantenimiento\Usuarios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use App\Models\Mantenimiento\Usuarios\Cargo;

class CargoController extends Controller
{
    public function listar_recursos()
    {
        $cargos = Cargo::orderBy('cargo', 'asc')->get();

        return ['cargos' => $cargos];
    }

    public function verificar(Request $request)
    {
        $resultado = 'NO_EXISTE';
        $frmDatosCargo = json_decode($request->frmDatosCargo);

        $modo = $frmDatosCargo->modo;
        $cargo = $frmDatosCargo->cargo;
        $id = $frmDatosCargo->id;

        $cargo = Cargo::where('cargo', $cargo)
            ->get()->last();

        if ($cargo != null) {
            if ($modo == 'NUEVO') {
                $resultado = 'EXISTE';
            } else if ($modo == 'EDITAR') {
                if ($cargo->id != $id) {
                    $resultado = 'EXISTE';
                }
            }
        }
        return ['resultado' => $resultado];
    }
    public function guardar(Request $request)
    {
        $response = new \stdClass();

        $datos_registro = (new MainController)->datos_registro();

        $frmDatosCargo = json_decode($request->frmDatosCargo);
        $cargo = mb_strtoupper(trim($frmDatosCargo->cargo));
        $modo = $frmDatosCargo->modo;

        if ($modo == 'NUEVO') {
            Cargo::create([
                'cargo' => $cargo,
                'datos_creacion' => $datos_registro
            ]);
        } else if ($modo == 'EDITAR') {
            $cargo_id = $frmDatosCargo->id;
            $habilitado = filter_var($frmDatosCargo->habilitado, FILTER_VALIDATE_BOOLEAN);

            Cargo::where('id', $cargo_id)->update([
                'cargo' => $cargo,
                'habilitado' => $habilitado,
                'datos_actualizacion' => $datos_registro
            ]);
        }

        $response->success = true;

        return $response;
    }
}
