<?php

namespace App\Http\Controllers\Mantenimiento\Credito;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use App\Models\Mantenimiento\Credito\Categoria;

class CategoriaController extends Controller
{
    public function listar_recursos()
    {
        $categorias = Categoria::orderBy('categoria', 'asc')->get();

        return ['categorias' => $categorias];
        
    }

    public function verificar(Request $request)
    {
        $resultado = 'NO_EXISTE';
        $frmDatosCategoria = json_decode($request->frmDatosCategoria);
    
                $modo = $frmDatosCategoria->modo;
              $categoria = $frmDatosCategoria->categoria;
        $id = $frmDatosCategoria->id;

        $categorias = Categoria::where('categoria', $categoria)->get()->last();
            

        if ($categoria != null) {
            if ($modo == 'NUEVA') {
                $resultado = 'EXISTE';
            } else if ($modo == 'EDITAR') {
                if ($categorias != null && $categorias->id != $id) {
                    $resultado = 'EXISTE';
                }
            }
        }
        return ['resultado' => $resultado];
    }

    public function guardar(Request $request)
    {
        $response = new \stdClass();

        $frmDatosCategoria = json_decode($request->frmDatosCategoria);
        $categoria = mb_strtoupper(trim($frmDatosCategoria->categoria));
        $descripcion = $frmDatosCategoria->descripcion;
        $modo = $frmDatosCategoria->modo;

        if ($modo == 'NUEVO') {
            Categoria::create([
                'categoria' => $categoria,
                'descripcion' => $descripcion
            ]);
        } else if ($modo == 'EDITAR') {
            $categoria_id = $frmDatosCategoria->id;
            $habilitado = filter_var($frmDatosCategoria->habilitado, FILTER_VALIDATE_BOOLEAN);

            Categoria::where('id', $categoria_id)->update([
                'categoria' => $categoria,
                'descripcion' => $descripcion,
                'habilitado' => $habilitado
            ]);
        }

        $response->success = true;

        return $response;
    }
}
