<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $table = 'distrito';
    protected $primaryKey = 'id';
    protected $fillable = [
        'distrito',
        'provincia_id',
    ];
}
