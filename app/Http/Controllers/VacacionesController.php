<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DatosEmpleados;
use App\Models\SolicitudVacaciones;
use Illuminate\Support\Facades\Auth;
use App\Mail\solicitudVacacionesEmpleado;
use App\Mail\solicitudVacacionesCopiaJefeRH;

class VacacionesController extends Controller
{
    public function vista_solicitud_vacaciones(Request $request)
    {
        $fechaInicial = Carbon::now()->addWeekdays(5)->format("Y-m-d");
        
        $departamento = Auth::user()->departamento->nombre_departamento;
        $jefesDeArea = User::jefesPorDepartamentoDeUsuario()->get();
        return view('empleados.formulario_vacaciones', compact('jefesDeArea', 'fechaInicial','departamento'));
    }

    public function enviar_solicitud_vacaciones(Request $request) {
        // Info post 
        $user_id = Auth::user()->id;

        $jefe_directo = $request->jefe_directo;
        $dias_solicitados = $request->dias_solicitados;
        $fecha_inicio = $request->fecha_inicio;
        $nota_contactar = $request->nota_contactar;

        $datosSolicitud = [
            "user_id" => $user_id,
            "dias_solicitados" => $dias_solicitados,
            "fecha_inicio_vacaciones" => $fecha_inicio,
            "nota_de_solicitud" => $nota_contactar,
            "user_jefe_id" => $jefe_directo,
        ];

        $infoUsuario = DatosEmpleados::where("user_id", $datosSolicitud['user_id'])->get()->first();
        
        if ($datosSolicitud['dias_solicitados'] > ($infoUsuario->dias_vacaciones - $infoUsuario->dias_utilizados)) {
            return back()->with("errors", "Los dias solicitados superan el total de dias disponibles");
        } else {
            $respuesta = $this->generarSolicitud($datosSolicitud);
    
            if (!isset($respuesta['errors']) || count($respuesta['errors']) == 0) {
                $empleadoMail = new solicitudVacacionesEmpleado;
                $empleadoMail ->sendSolCopiaEmpleado($jefe_directo,$user_id,$dias_solicitados,$fecha_inicio,$nota_contactar);
                $JefeRhMail = new solicitudVacacionesCopiaJefeRH;
                $JefeRhMail->sendSolRHJefe($jefe_directo,$user_id,$dias_solicitados,$fecha_inicio,$nota_contactar);
    
                return back()->with("success", $respuesta['success']);
            } else {
                return back()->with("errors", $respuesta['errors']);
            }
        }
    }

    public function generarSolicitud($datosSolicitud) {
        $respuesta = array();

        $existeSolicitud = SolicitudVacaciones::where("user_id", $datosSolicitud['user_id'])->whereIn("flag_aprobada",[1, 0]); 
        // Si la solicitud esta aprobado o le falta aprobacion
        
        $flagRegistrar = 0;
        if ($existeSolicitud->count() > 0) {
            $solicitud = $existeSolicitud->get()->last();
            $fechaInicio = Carbon::parse($solicitud->fecha_inicio_vacaciones);
            $diasSolicitados = $solicitud->dias_solicitados;

            $fechaFinalVacaciones = $this->sumarDiasLaborables($fechaInicio, $diasSolicitados)->format("Y-m-d");

            if (Carbon::parse($fechaFinalVacaciones) < Carbon::parse($datosSolicitud['fecha_inicio_vacaciones'])) {
                $flagRegistrar = 1;
            } else {
                $respuesta["errors"] = ["Ya existe una solicitud pendiente, favor esperar respuesta"];
            }
        }

        if ($existeSolicitud->count() == 0 || $flagRegistrar > 0) {
            $newSolicitud = new SolicitudVacaciones();
            $newSolicitud->insert($datosSolicitud);

            $respuesta['success'] = ["Solicitud Generada"];
        }

        return $respuesta;
    }
    
    // Función para sumar días laborables
    public function sumarDiasLaborables(Carbon $fecha, $dias) {
        // Empieza en uno por que se toma el dia de inicio
        $diasHabiles = 1;

        while ($diasHabiles < $dias) {
            $fecha->addDay();

            // Si es día laborable (lunes a viernes)
            if ($fecha->isWeekday()) {
                ++$diasHabiles;
            }
        }
        return $fecha;
    }
}
