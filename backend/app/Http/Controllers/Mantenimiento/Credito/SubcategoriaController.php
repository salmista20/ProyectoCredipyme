<?php

namespace App\Http\Controllers\Mantenimiento\Credito;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use App\Models\Mantenimiento\Credito\Subcategoria;

class SubcategoriaController extends Controller
{
    public function listar_recursos()
    {
        $subcategorias = Subcategoria::orderBy('subcategoria', 'asc')->get();

        return ['subcategorias' => $subcategorias];
        
    }

    public function verificar(Request $request)
    {
        $resultado = 'NO_EXISTE';
        $frmDatosSubcategoria = json_decode($request->frmDatosSubcategoria);
    
                $modo = $frmDatosSubcategoria->modo;
              $subcategoria = $frmDatosSubcategoria->subcategoria;
        $id = $frmDatosSubcategoria->id;

        $subcategorias = Subcategoria::where('subcategoria', $subcategoria)->get()->last();
            

        if ($subcategoria != null) {
            if ($modo == 'NUEVA') {
                $resultado = 'EXISTE';
            } else if ($modo == 'EDITAR') {
                if ($subcategorias != null && $subcategorias->id != $id) {
                    $resultado = 'EXISTE';
                }
            }
        }
        return ['resultado' => $resultado];
    }

    public function guardar(Request $request)
    {
        $response = new \stdClass();

        $frmDatosSubcategoria = json_decode($request->frmDatosSubcategoria);
        $subcategoria = mb_strtoupper(trim($frmDatosSubcategoria->subcategoria));
        $descripcion = $frmDatosSubcategoria->descripcion;
        $modo = $frmDatosSubcategoria->modo;

        if ($modo == 'NUEVO') {
            Subcategoria::create([
                'subcategoria' => $subcategoria,
                'descripcion' => $descripcion
            ]);
        } else if ($modo == 'EDITAR') {
            $categoria_id = $frmDatosSubcategoria->id;
            $habilitado = filter_var($frmDatosSubcategoria->habilitado, FILTER_VALIDATE_BOOLEAN);

            Subcategoria::where('id', $categoria_id)->update([
                'subcategoria' => $subcategoria,
                'descripcion' => $descripcion,
                'habilitado' => $habilitado
            ]);
        }

        $response->success = true;

        return $response;
    }
}
