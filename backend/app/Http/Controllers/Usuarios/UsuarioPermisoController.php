<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use App\Models\Usuarios\Usuario;
use App\Models\Usuarios\UsuarioPermiso;
use App\Models\Mantenimiento\Usuarios\Permiso;
use App\Models\Mantenimiento\Usuarios\Cargo;

use Illuminate\Support\Facades\DB;

class UsuarioPermisoController extends Controller
{
    public function listar_recursos()
    {
        $usuarios = Usuario::from('usuario as usu')
            ->select(
                'usu.id',
                'usu.usuario',
                'usu.dni',
                'usu.agencia_id',
                DB::raw("CONCAT(usu.apellido_paterno,' ',
                usu.apellido_materno,' ',usu.nombres) as colaborador"),
                'car.cargo',
                'age.agencia'

            )
            ->join('cargo as car', 'usu.cargo_id', 'car.id')
            ->join('agencia as age', 'usu.agencia_id', 'age.id')
            ->where('usu.habilitado', 1)
            ->get();

        $cargos = Cargo::where('habilitado', 1)->orderBy('cargo', 'asc')->get();

        return  [
            'usuarios' => $usuarios,
            'cargos' => $cargos
        ];
    }

    public function listar_permisos($usuario_id)
    {
        $permisos_actuales = UsuarioPermiso::from('usuario_permiso as usu_per')
            ->select(
                'usu_per.id',
                'usu_per.permiso_id',

                'per.modulo',
                'per.submodulo'
            )
            ->join('permiso as per', 'usu_per.permiso_id',  'per.id')
            ->where([
                ['usu_per.usuario_id', $usuario_id]
            ])
            ->orderBy('modulo', 'asc')
            ->orderBy('submodulo', 'asc')
            ->get();


        $modulos_actuales = $permisos_actuales->unique('modulo')->map->only(['modulo'])->values();

        $rango_actuales = $permisos_actuales->map->only(['permiso_id'])->values();

        $permisos_disponibles = Permiso::select(
            'id',
            'modulo',
            'submodulo'
        )
            ->whereNotIn('id', $rango_actuales)
            ->get();

        $modulos_disponibles =  $permisos_disponibles->unique('modulo')->map->only(['modulo'])->values();

        return [
            'permisos_actuales' => $permisos_actuales,
            'modulos_actuales' => $modulos_actuales,
            'permisos_disponibles' => $permisos_disponibles,
            'modulos_disponibles' => $modulos_disponibles,
        ];
    }

    public function copiar(Request $request)
    {
        $response = new \stdClass();

        $frmDatosUsuario = json_decode($request->frmDatosUsuario);
        $datos_registro = (new MainController())->datos_registro();

        $usuario_seleccionado = $request->usuario_seleccionado;

        UsuarioPermiso::from('usuario_permiso as usu_per')
            ->join('permiso as per', 'usu_per.permiso_id', 'per.id')
            ->where([
                ['usu_per.usuario_id', $frmDatosUsuario->id]
            ])
            ->delete();

        $permisos = UsuarioPermiso::from('usuario_permiso as usu_per')
            ->select(
                'usu_per.permiso_id',
            )
            ->join('permiso as per', 'usu_per.permiso_id', 'per.id')
            ->where([
                ['usu_per.usuario_id', $usuario_seleccionado]
            ])
            ->get();


        foreach ($permisos as $item) {
            UsuarioPermiso::create([
                'usuario_id' => $frmDatosUsuario->id,
                'permiso_id' => $item->permiso_id,
                'datos_creacion' => $datos_registro,
                'datos_actualizacion' => $datos_registro,
            ]);
        }

        $response->success = true;

        return $response;
    }

    public function asignar(Request $request)
    {
        $response = new \stdClass;

        $frmDatosUsuario = json_decode($request->frmDatosUsuario);
        $seleccionados_disponibles = json_decode($request->seleccionados_disponibles);

        $datos_registro = (new MainController)->datos_registro();

        foreach ($seleccionados_disponibles->permisos as $key => $item) {

            UsuarioPermiso::create([
                'usuario_id' => $frmDatosUsuario->id,
                'permiso_id' => $item->id,

                'datos_creacion' => $datos_registro,
                'datos_actualizacion' => $datos_registro
            ]);
        }

        $response->success = true;

        return $response;
    }

    public function eliminar($usuario_permiso_id)
    {
        $response = new \stdClass;

        UsuarioPermiso::where('id', $usuario_permiso_id)->delete();

        $response->succes = true;

        return $response;
    }
    public function eliminar_todos($usuario_id)
    {
        $response = new \stdClass;

        UsuarioPermiso::where('usuario_id', $usuario_id)->delete();

        $response->succes = true;

        return $response;
    }
}
