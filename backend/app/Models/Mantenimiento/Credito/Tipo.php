<?php

namespace App\Models\Mantenimiento\Credito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;

    protected $table = 'credito_tipo';

    protected $primaryKey = 'id';

    protected $fillable = [
        'tipo',
        'habilitado',

        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'habilitado' => 'boolean',
    ];
}
