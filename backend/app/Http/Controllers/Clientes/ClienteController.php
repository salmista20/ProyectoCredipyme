<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use App\Models\Usuarios\Usuario;

use App\Models\Clientes\Cliente;

use App\Models\Mantenimiento\Usuarios\Cargo;

use App\Models\General\Departamento;
use App\Models\General\Distrito;
use App\Models\General\Provincia;


class ClienteController extends Controller
{
    public function listar_recursos()
    {
        $distritos = Distrito::orderBy('distrito', 'asc')->get();
        $provincias = Provincia::orderBy('provincia', 'asc')->get();
        $departamentos = Departamento::orderBy('departamento', 'asc')->get();

        $cargos = Cargo::select('id')->whereIn('cargo', ['ASESOR DE NEGOCIOS'])->get();

        $asesores = Usuario::select(
            'id',
            'usuario',
            'agencia_id'

        )->whereIn('cargo_id', $cargos)
            ->where('habilitado', 1)
            ->get();

        return [
            'asesores' => $asesores,

            'departamentos' => $departamentos,
            'provincias' => $provincias,
            'distritos' => $distritos
        ];
    }

    // public function verificar(Request $request)
    // {
    //     $resultado = 'NO_EXISTE';
    //     $frmDatosEstado = json_decode($request->frmDatosEstado);

    //     $modo = $frmDatosEstado->modo;
    //     $estado = $frmDatosEstado->estado;
    //     $id = $frmDatosEstado->id;

    //     $estado = Estado::where('estado', $estado)
    //         ->get()->last();

    //     if ($estado != null) {
    //         if ($modo == 'NUEVO') {
    //             $resultado = 'EXISTE';
    //         } else if ($modo == 'EDITAR') {
    //             if ($estado->id != $id) {
    //                 $resultado = 'EXISTE';
    //             }
    //         }
    //     }
    //     return ['resultado' => $resultado];
    // }

    // public function guardar(Request $request)
    // {
    //     $response = new \stdClass();

    //     $frmDatosEstado = json_decode($request->frmDatosEstado);
    //     $estado = mb_strtoupper(trim($frmDatosEstado->estado));
    //     $modo = $frmDatosEstado->modo;

    //     if ($modo == 'NUEVO') {
    //         Estado::create([
    //             'estado' => $estado
    //         ]);
    //     } else if ($modo == 'EDITAR') {
    //         $estado_id = $frmDatosEstado->id;
    //         $habilitado = $frmDatosEstado->habilitado;

    //         Estado::where('id', $estado_id)->update([
    //             'estado' => $estado,
    //             'habilitado' => $habilitado
    //         ]);
    //     }

    //     $response->success = true;

    //     return $response;
    // }
}
