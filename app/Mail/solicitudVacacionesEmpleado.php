<?php

namespace App\Mail;

use App\Models\User;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
//use Illuminate\Mail\Mailables\Content;
//use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use App\Models\DatosEmpleados;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;

// use App\Models\catDepartamento;

class solicitudVacacionesEmpleado extends Mailable
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

    public static function sendSolCopiaEmpleado($jefe_directo, $user_id, $dias_solicitados, $fecha_inicio, $nota_contactar)
    {

        $user = User::where("id", Auth::user()->id)->first()->toArray();
        $datosEmpleado = DatosEmpleados::where("user_id", $user['id'])->first()->toArray();
        $jefe = User::where('id', $jefe_directo)->first()->toArray();

        $data = array(
            "user" => $user,
            "datosEmpleado" => $datosEmpleado,
            "jefe" => $jefe,
            "diasSol" => $dias_solicitados,
            "FechaInicio" => $fecha_inicio,
            "Nota" => $nota_contactar,
        );
        // Subject del correo
        $titleMail = " ***TEST MAIL***--[NOTIFICACION-SOLICITUD REALIZADA] SOLICITUD DE VACAIONES - ***TEST MAIL***";
        $correoEmpleado = User::select('email')->where("id", Auth::user()->id)->first()->toArray();
        //dd($correoEmpleado);
        try {
            Mail::send('emails.solicitud_vacaciones_copia_empleado', $data, function ($message) use ($user, $titleMail, $correoEmpleado) {
                $message->from("notificaciones.tmultimodal@tmultimod.com", "Naviomar/TransporteMultimodal");
                // $message->to($user['email']);
                //$message->to($correoEmpleado['email']);//PARA PRUEBAS TENER COMENTADO ESTA PARTE
                //$message->cc("ajimenez@naviomar.com.mx");
                $message->to("andres.jimenez@naviomar.com");
                $message->cc("felipe.alvarez@naviomar.com");

                $message->subject($titleMail);
            });
        } catch (\Throwable $th) {
            throw $th;
        }

        return;
    }
}
