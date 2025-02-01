<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosEmpleados extends Model
{
    use HasFactory;

    protected $table = "datos_empleados";

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'fecha_ingreso',
        'antiguedad',
        'dias_vacaciones',
        'dias_utilizados',
        'created_at',
        'updated_at',
    ];
}
