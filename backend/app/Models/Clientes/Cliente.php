<?php

namespace App\Models\Clientes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';

    protected $primaryKey = 'id';

    protected $fillable = [
        'dni',
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'fecha_nacimiento',
        'estado_civil',
        'genero',
        'email',
        'expediente',
        'asesor_id',
        'agencia_id',
        'direccion',
        'departamento_id',
        'provincia_id',
        'distrito_id',
        'referencia_direccion',
        'telefonos',
        'imagen_dni',
        'notas',

        'datos_creacion',
        'datos_actualizacion',
        'created_at',
        'updated_at'
    ];
}
