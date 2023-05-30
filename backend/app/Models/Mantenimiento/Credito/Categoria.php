<?php

namespace App\Models\Mantenimiento\Credito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'credito_categoria';

    protected $primaryKey = 'id';

    protected $fillable = [
        'categoria',
        'habilitado',

        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'habilitado' => 'boolean',
    ];
}
