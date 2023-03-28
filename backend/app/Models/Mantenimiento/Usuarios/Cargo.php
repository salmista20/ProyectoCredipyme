<?php

namespace App\Models\Mantenimiento\Usuarios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargo';

    protected $primaryKey = 'id';

    protected $fillable = [
        'cargo',
        'habilitado',

        'datos_creacion',
        'datos_actualizacion',
        'created_at',
        'updated_at'
    ];
}
