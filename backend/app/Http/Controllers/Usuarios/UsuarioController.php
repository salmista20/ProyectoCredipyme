<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;


use App\Models\Usuarios\Usuario;
use App\Models\Mantenimiento\Usuarios\Cargo;
use App\Models\Mantenimiento\Usuarios\Agencia;
use App\Models\Mantenimiento\Usuarios\Rol;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function listar_recursos()
    {
        $usuarios = Usuario::from('usuario as usu')->select(
            'usu.id',
            'usu.usuario',
            'usu.apellido_paterno',
            'usu.apellido_materno',
            'usu.nombres',
            DB::raw("CONCAT(usu.apellido_paterno,' ',
            usu.apellido_materno,' ',usu.nombres) as colaborador"),
            'usu.dni',
            'usu.cargo_id',
            'usu.agencia_id',
            'usu.habilitado',

            'car.cargo',
            'age.agencia',
            'rol.rol'
        )->join('cargo as car', 'usu.cargo_id', 'car.id')
            ->join('agencia as age', 'usu.agencia_id', 'age.id')
            ->join('rol', 'usu.rol_id', 'rol.id')
            ->get();

        $cargos = Cargo::orderBy('cargo', 'asc')->get();
        $agencias = Agencia::orderBy('agencia', 'asc')->get();

        return [
            'usuarios' => $usuarios,
            'cargos' => $cargos,
            'agencias' => $agencias
        ];
    }

    public function verificar(Request $request)

    {
        $modo = $request->modo;
        $dni = $request->dni;
        $usuario = $request->usuario;

        if ($modo == 'EDITAR') {

            $existe_usuario = Usuario::select('usuario', 'dni')->where('usuario', $usuario)->get();

            if (count($existe_usuario) == 0) {
                return "CORRECTO";
            } else {
                if ($existe_usuario[0]['dni'] == $dni) {
                    return "CORRECTO";
                } else {
                    return "INCORRECTO_U";
                }
            }
        } else if ($modo == 'NUEVO') {

            $existe_dni = Usuario::select('dni')->where('dni', $dni)->get();
            $existe_usuario = Usuario::select('usuario')->where('usuario', $usuario)->get();

            if (count($existe_dni) == 0) {
                if (count($existe_usuario) == 0) {
                    return 'CORRECTO';
                } else {
                    return 'INCORRECTO_U';
                }
            } else {
                return 'INCORRECTO_D';
            }
        }
    }

    public function guardar(Request $request)
    {
        $response = new \stdClass;
        $datos_registro = (new MainController)->datos_registro();
        $frmDatosUsuario = json_decode($request->frmDatosUsuario);

        $modo = $frmDatosUsuario->modo;
        $dni = $frmDatosUsuario->dni;
        $usuario = mb_strtolower($frmDatosUsuario->usuario);
        $nombres = mb_strtoupper($frmDatosUsuario->nombres);
        $apellido_paterno = mb_strtoupper($frmDatosUsuario->apellido_paterno);
        $apellido_materno = mb_strtoupper($frmDatosUsuario->apellido_materno);
        $cargo_id = $frmDatosUsuario->cargo_id;
        $agencia_id = $frmDatosUsuario->agencia_id;

        $rol = Rol::select('id')->where('rol', 'USUARIO')->get()->last();
        $rol_id = $rol->id;

        if ($modo == 'NUEVO') {
            $clave = Hash::make($dni);

            Usuario::create(array(
                'dni' => $dni,
                'usuario' => $usuario,
                'clave' => $clave,
                'nombres' => $nombres,
                'apellido_paterno' => $apellido_paterno,
                'apellido_materno' => $apellido_materno,
                'agencia_id' => $agencia_id,
                'cargo_id' => $cargo_id,
                'rol_id' => $rol_id,
                'habilitado' => 1,
                'datos_creacion' => $datos_registro
            ));
        } else if ($modo == 'EDITAR') {

            Usuario::where('dni', $dni)->update([
                'usuario' => $usuario,
                'nombres' => $nombres,
                'apellido_paterno' => $apellido_paterno,
                'apellido_materno' => $apellido_materno,
                'agencia_id' => $agencia_id,
                'cargo_id' => $cargo_id,
                'datos_actualizacion' => $datos_registro
            ]);
        }

        $response->success = true;

        return $response;
    }
}
