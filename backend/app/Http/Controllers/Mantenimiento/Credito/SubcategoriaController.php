<?php

namespace App\Http\Controllers\Mantenimiento\Credito;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

use App\Models\Mantenimiento\Credito\Sector;

class SectorController extends Controller
{
    public function listar_recursos()
    {
        $sectores = Sector::orderBy('sector', 'asc')->get();

        return ['sectores' => $sectores];
    }

    public function verificar(Request $request)
    {
        $resultado = 'NO_EXISTE';
        $frmDatosSector = json_decode($request->frmDatosSector);

        $modo = $frmDatosSector->modo;
        $sector = $frmDatosSector->sector;
        $id = $frmDatosSector->id;

        $sector = Sector::where('sector', $sector)
            ->get()->last();

        if ($sector != null) {
            if ($modo == 'NUEVO') {
                $resultado = 'EXISTE';
            } else if ($modo == 'EDITAR') {
                if ($sector->id != $id) {
                    $resultado = 'EXISTE';
                }
            }
        }
        return ['resultado' => $resultado];
    }

    public function guardar(Request $request)
    {
        $response = new \stdClass();

        $frmDatosSector = json_decode($request->frmDatosSector);
        $sector = mb_strtoupper(trim($frmDatosSector->sector));
        $modo = $frmDatosSector->modo;

        if ($modo == 'NUEVO') {
            Sector::create([
                'sector' => $sector
            ]);
        } else if ($modo == 'EDITAR') {
            $sector_id = $frmDatosSector->id;
            $habilitado = filter_var($frmDatosSector->habilitado, FILTER_VALIDATE_BOOLEAN);

            Sector::where('id', $sector_id)->update([
                'sector' => $sector,
                'habilitado' => $habilitado
            ]);
        }

        $response->success = true;

        return $response;
    }
}
