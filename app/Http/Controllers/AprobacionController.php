<?php

namespace App\Http\Controllers;

use Auth;      
use Illuminate\Http\Request;
use App\Models\DatosEmpleados;
use App\Models\SolicitudVacaciones;
use App\Mail\solicitudAprobacionVacaciones;

class AprobacionController extends Controller
{
    public function index_show_aprobacion(Request $request)
    {
        $solicitudes = SolicitudVacaciones::where("user_jefe_id", Auth::user()->id)->where("flag_aprobada", 0)->orderBy("created_at","desc")->paginate(10);

        return view('aprobacion.formulario_show_info', compact("solicitudes"));
    }
    public function enviarRespuesta($idSolicitud, Request $request) {
        $respuesta = $request->respuesta;
        $solicitud = SolicitudVacaciones::where("id_solicitud", $idSolicitud);

        if ($solicitud->get()->first()->flag_aprobada == 0) {
            if($respuesta == "aprobada") {
                $solicitud->update(["flag_aprobada" => 1]);
                // Actualizar datos de usuario 
                $solcitudUsuario = $solicitud->get()->first();
                $diasSolicitados = $solcitudUsuario->dias_solicitados;
                $idUsuario = $solcitudUsuario->user_id;
                // Actualizacion de info de empleados
                $infoUsuario = DatosEmpleados::where("user_id", $idUsuario);
                $diasUsados = $infoUsuario->get()->first()->dias_utilizados;
                $infoUsuario->update([
                    "dias_utilizados" => $diasUsados+$diasSolicitados,
                ]);
                // Enviar Respuesta de Solicitud
                $enviarRespuesta = new solicitudAprobacionVacaciones;
                $enviarRespuesta->enviarRespuestaEmpleado($idSolicitud, true);

                return back()->with('success', "Solicitud $idSolicitud Aprobada");
            } else {
                $solicitud->update(["flag_aprobada" => 2]);
                // Enviar Respuesta de Solicitud
                $enviarRespuesta = new solicitudAprobacionVacaciones;
                $enviarRespuesta->enviarRespuestaEmpleado($idSolicitud, false);

                return back()->with('error', "Solicitud $idSolicitud No Aprobada");
            }
        } else {
            return back()->with('error', "Accion No Disponible");
        }
    }
}
