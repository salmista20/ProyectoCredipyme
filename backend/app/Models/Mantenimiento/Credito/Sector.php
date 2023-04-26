<?php

namespace App\Models\Mantenimiento\Credito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $table = 'credito_sector';

    protected $primaryKey = 'id';

    protected $fillable = [
        'sector',
        'habilitado',

        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'habilitado' => 'boolean',
    ];
}
