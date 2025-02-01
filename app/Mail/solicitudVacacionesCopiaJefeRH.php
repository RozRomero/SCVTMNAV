<?php

namespace App\Mail;

use App\Models\User;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
// use Illuminate\Mail\Mailables\Content;
// use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use App\Models\DatosEmpleados;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;

class solicitudVacacionesCopiaJefeRH extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // public static function sendSolCopiaEmpleado(int $id_master, string $transport_type,string $messageNot = "", bool $isApprove = true) {
    public static function sendSolRHJefe($jefe_directo, $user_id, $dias_solicitados, $fecha_inicio, $nota_contactar)
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
        $titleMail = " ***TEST MAIL***--[NOTIFICACION-SOLICITUD DE VACACIONES REALIZADA]  - ***TEST MAIL***";
        $correoJefe = User::select('email')->where("id", $jefe_directo)->first()->toArray();
        $correoRH = User::select('email')->where('department_id', 2)->get()->toArray();
        // dd($correoJefe,$correoRH);
        try {
            Mail::send('emails.solicitud_vacaciones_jefes', $data, function ($message) use ($user, $titleMail, $correoJefe, $correoRH) {
                $message->from("notificaciones.tmultimodal@tmultimod.com", "Naviomar/TransporteMultimodal");
                // $message->to($user['email']);

                // $message->to($correoJefe['email']);//PARA PRUEBAS TENERLOS COMENTADOS
                // $message->cc($correoRH['email']);////PARA PRUEBAS TENERLOS COMENTADOS

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
