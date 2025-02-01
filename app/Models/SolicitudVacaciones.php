<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SolicitudVacaciones extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "solicitud_vacaciones";

    protected $primaryKey = 'id_sol_vacaciones';

    protected $fillable = [
        'user_id',
        'dias_solicitados',
        'fecha_inicio_vacaciones',
        'nota_de_solicitud',
        'user_jefe_id',
        'flag_envio_correo',
        'contador_envio',
        'flag_aprobada',
        'fecha_aprobada',
        'created_at',
        'updated_at',
        'user_delete_id',
    ];

    protected $dates = ['deleted_at'];

    public function solicitante() {
        return $this->hasOne(User::class, "id", "user_id");
    }
    public function jefeDirecto() {
        return $this->hasOne(User::class, "id", "user_jefe_id");
    }

    public function calcularFechaFinalVacaciones()
    {
        $fechaInicio = Carbon::parse($this->fecha_inicio_vacaciones);
        $diasSolicitados = $this->dias_solicitados;

        $diasHabiles = 1;

        while ($diasHabiles < $diasSolicitados) {
            $fechaInicio->addDay();

            // Si es día laborable (lunes a viernes)
            if ($fechaInicio->isWeekday()) {
                ++$diasHabiles;
            }
        }

        return $fechaInicio->format("Y-m-d");
    }
}
