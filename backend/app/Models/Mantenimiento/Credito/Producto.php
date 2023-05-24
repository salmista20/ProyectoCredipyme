<?php

namespace App\Models\Mantenimiento\Credito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'credito_producto';

    protected $primaryKey = 'id';

    protected $fillable = [
        'producto',
        'habilitado',

        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'habilitado' => 'boolean',
    ];
}
