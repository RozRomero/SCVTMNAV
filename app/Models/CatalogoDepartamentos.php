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

    public function empleados()
    {
        return $this->belongsToMany(User::class, 'departamento_empleado', 'departamento_id', 'user_id');
    }

    public function jefes()
    {
        return $this->belongsToMany(User::class, 'departamento_jefe', 'departamento_id', 'user_id');
    }
}