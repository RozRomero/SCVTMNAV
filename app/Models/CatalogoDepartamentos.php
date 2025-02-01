<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogoDepartamentos extends Model
{
    use HasFactory;

    protected $table = 'catalogo_departamentos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre_departamento',
    ];
}
