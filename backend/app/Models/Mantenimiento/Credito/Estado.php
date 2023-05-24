<?php

namespace App\Models\Mantenimiento\Credito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'credito_estado';

    protected $primaryKey = 'id';

    protected $fillable = [
        'estado',
        'habilitado',

        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'habilitado' => 'boolean',
    ];
}
