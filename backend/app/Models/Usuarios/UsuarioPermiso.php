<?php

namespace App\Models\Usuarios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioPermiso extends Model
{
    use HasFactory;

    protected $table = 'usuario_permiso';

    protected $primaryKey = 'id';

    protected $fillable = [
        'usuario_id',
        'permiso_id',

        'datos_creacion',
        'datos_actualizacion',
        'created_at',
        'updated_at'
    ];
}
