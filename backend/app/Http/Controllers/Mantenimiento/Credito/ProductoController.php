<?php

namespace App\Http\Controllers\Mantenimiento\Credito;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use App\Models\Mantenimiento\Credito\Producto;

class ProductoController extends Controller
{
    public function listar_recursos()
    {
        $productos = Producto::orderBy('producto', 'asc')->get();

        return ['productos' => $productos];
    }

    public function verificar(Request $request)
    {
        $resultado = 'NO_EXISTE';
        $frmDatosProducto = json_decode($request->frmDatosProducto);
    
                $modo = $frmDatosProducto->modo;
              $producto = $frmDatosProducto->producto;
        $id = $frmDatosProducto->id;

        $producto = Producto::where('producto', $producto)
            ->get()->last();

        if ($producto != null) {
            if ($modo == 'NUEVO') {
                $resultado = 'EXISTE';
            } else if ($modo == 'EDITAR') {
                if ($producto->id != $id) {
                    $resultado = 'EXISTE';
                }
            }
        }
        return ['resultado' => $resultado];
    }

    public function guardar(Request $request)
    {
        $response = new \stdClass();

        $frmDatosProducto = json_decode($request->frmDatosProducto);
        $producto = mb_strtoupper(trim($frmDatosProducto->producto));
        $modo = $frmDatosProducto->modo;

        if ($modo == 'NUEVO') {
            Producto::create([
                'producto' => $producto
            ]);
        } else if ($modo == 'EDITAR') {
            $producto_id = $frmDatosProducto->id;
            $habilitado = filter_var($frmDatosProducto->habilitado, FILTER_VALIDATE_BOOLEAN);

            Producto::where('id', $producto_id)->update([
                'producto' => $producto,
                'habilitado' => $habilitado
            ]);
        }

        $response->success = true;

        return $response;
    }
}
