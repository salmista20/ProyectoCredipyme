<?php

namespace App\Models\Usuarios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario';

    protected $primaryKey = 'id';

    protected $fillable = [
        'usuario',
        'clave',
        'apellido_materno',
        'apellido_paterno',
        'nombres',
        'dni',
        'rol_id',
        'cargo_id',
        'agencia_id',
        'habilitado',
        'datos_creacion',
        'datos_actualizacion',
        'created_at',
        'updated_at'
    ];
}
