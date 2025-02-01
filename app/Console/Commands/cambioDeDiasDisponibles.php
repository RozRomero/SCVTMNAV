<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\DatosEmpleados;
use Illuminate\Console\Command;

class cambioDeDiasDisponibles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rutina:CambioDeDiasDisponibles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::now()->format("Y-m-d");
        $mes = Carbon::now()->format('m');
        $dia = Carbon::now()->format('d');

        $datosEmpleados = DatosEmpleados::whereMonth("fecha_ingreso", $mes)->whereDay("fecha_ingreso", $dia)->where("fecha_ingreso", "!=", $today)->get();
        foreach($datosEmpleados as $userInfo) {
            $diasVacasiones = $userInfo->dias_vacaciones;
            $antiguedad = $userInfo->antiguedad + 1;

            // Validamos la antiguiedad del usuario
            if (($userInfo->antiguedad >= 1 && $userInfo->antiguedad <=6) ||  in_array($userInfo->antiguedad, [10, 15, 20, 25, 30, 35])) {
                $diasVacasiones = $diasVacasiones+2;
            }

            $dataUser = DatosEmpleados::where("user_id", $userInfo->user_id);
            $dataUser->update([
                "antiguedad" => $antiguedad,
                "dias_vacaciones" => $diasVacasiones,
                "dias_utilizados" => 0,
            ]);
        }

        return Command::SUCCESS;
    }
}
