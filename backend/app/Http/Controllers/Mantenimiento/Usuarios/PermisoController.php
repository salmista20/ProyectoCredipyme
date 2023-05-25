<?php

namespace App\Http\Controllers\Mantenimiento\Usuarios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use App\Models\Mantenimiento\Usuarios\Permiso;

class PermisoController extends Controller
{
    public function listar_recursos()
    {
        $modulos = Permiso::select('modulo')->distinct('id', 'modulo')
            ->orderBy('modulo', 'asc')
            ->get();

        $permisos = Permiso::select('id', 'modulo', 'submodulo')
            ->orderBy('modulo', 'asc')
            ->get();

        return [
            'modulos' => $modulos,
            'permisos' => $permisos
        ];
    }

    public function verificar(Request $request)
    {
        $resultado = 'NO_EXISTE';
        $frmDatosPermiso = json_decode($request->frmDatosPermiso);

        $modo = $frmDatosPermiso->modo;
        $id = $frmDatosPermiso->id;
        $submodulo = mb_strtoupper(trim($frmDatosPermiso->submodulo));
        $tipo_modulo = $frmDatosPermiso->tipo_modulo;

        if ($tipo_modulo == 'MODULO_EXISTENTE') {
            $modulo = $frmDatosPermiso->modulo_existente;
        } else if ($tipo_modulo  == 'MODULO_NUEVO') {
            $modulo =  mb_strtoupper(trim($frmDatosPermiso->modulo_nuevo));
        }

        $permiso = Permiso::where([['modulo', $modulo], ['submodulo', $submodulo]])
            ->get()->last();

        if ($permiso != null) {
            if ($modo == 'NUEVO') {
                $resultado = 'EXISTE';
            } else if ($modo == 'EDITAR') {
                if ($permiso->id != $id) {
                    $resultado = 'EXISTE';
                }
            }
        }

        return ['resultado' => $resultado];
    }
    public function guardar(Request $request)
    {
        $response = new \stdClass;
        $datos_registro = (new MainController)->datos_registro();

        $frmDatosPermiso = json_decode($request->frmDatosPermiso);
        $submodulo = mb_strtoupper(trim($frmDatosPermiso->submodulo));
        $tipo_modulo = $frmDatosPermiso->tipo_modulo;
        $modo = $frmDatosPermiso->modo;

        if ($tipo_modulo == 'MODULO_EXISTENTE') {
            $modulo = $frmDatosPermiso->modulo_existente;
        } else if ($tipo_modulo  == 'MODULO_NUEVO') {
            $modulo =  mb_strtoupper(trim($frmDatosPermiso->modulo_nuevo));
        }

        if ($modo == 'NUEVO') {
            Permiso::create([
                'modulo' => $modulo,
                'submodulo' => $submodulo,
                'datos_creacion' => $datos_registro
            ]);
        } else if ($modo == 'EDITAR') {
            $permiso_id = $frmDatosPermiso->id;
            Permiso::where('id', $permiso_id)->update([
                'modulo' => $modulo,
                'submodulo' => $submodulo,
                'datos_actualizacion' => $datos_registro
            ]);
        }

        $response->success = true;

        return $response;
    }
}
