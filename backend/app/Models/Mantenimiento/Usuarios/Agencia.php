<?php

namespace App\Models\Mantenimiento\Usuarios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agencia extends Model
{
    use HasFactory;

    protected $table = 'agencia';

    protected $primaryKey = 'id';

    protected $fillable = [
        'agencia',
        'direccion'
    ];

    public $timestamps = false;
}
