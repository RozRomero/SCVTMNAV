<?php

namespace App\Mail;

use Auth;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\DatosEmpleados;
use App\Models\SolicitudVacaciones;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class solicitudAprobacionVacaciones extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public static function enviarRespuestaEmpleado($idSolicitud, $respuesta)
    {
        $solicitud = SolicitudVacaciones::where("id_solicitud", $idSolicitud)->get()->first();

        $user = User::where("id", $solicitud->user_id)->first()->toArray();
        $datosEmpleado = DatosEmpleados::where("user_id", $solicitud->user_id)->first()->toArray();
        $jefe = User::where('id', $solicitud->user_jefe_id)->first()->toArray();

        $data = array(
            "user" => $user,
            "datosEmpleado" => $datosEmpleado,
            "solicitud" => $solicitud,
            "jefe" => $jefe,
            "respuesta" => $respuesta,
        );

        $respuestaTxt = "APROBADA";
        if ($respuesta == false) {
            $respuestaTxt = "NO APROBADA";
        }

        // Subject del correo
        $titleMail = " ***TEST MAIL***--[NOTIFICACION-SOLICITUD RESPUESTA] SOLICITUD DE VACACIONES $respuestaTxt - ***TEST MAIL***";
        //dd($correoEmpleado);
        try {
            Mail::send('emails.respuesta_solicitud_vacaciones', $data, function ($message) use ($data, $titleMail) {
                $message->from("notificaciones.tmultimodal@tmultimod.com", "Naviomar/TransporteMultimodal");
                // $message->to($data["user"]['email']);
                //$message->cc("ajimenez@naviomar.com.mx");
                $message->to("andres.jimenez@naviomar.com");
                $message->cc("felipe.alvarez@naviomar.com");

                $message->subject($titleMail);
            });
        } catch (\Throwable $th) {
            throw $th;
        }

        return;
        // dd('Mail Send Successfully');
    }
}
