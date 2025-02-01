<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DatosEmpleados;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RRHHController extends Controller
{
    //

    public function show_add_info(Request $request)
    {

        return view('rrhh.formulario_agregar_info');
        // $jefesDeArea = User::jefesPorDepartamentoDeUsuario()->get();
        
        // return view('empleados.formulario_vacaciones', compact('jefesDeArea'));
    }

    public function set_info_users(Request $request) {

        if($request->file('excel_users')) { // valida si se esta resiviendo un archivo

            $file = $request->file('excel_users');

            try {
                $reader = IOFactory::createReader('Xlsx');
                $reader->setLoadAllSheets();
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($request->file('excel_users'));

                // Lectura de hojas por nombre
                $import = [
                    $spreadsheet->getSheetByName("Naviomar"),
                    $spreadsheet->getSheetByName("Multimodal"),
                    $spreadsheet->getSheetByName("Taormina"),
                ];

                // Envio de informacion
                foreach ($import as $sheet) {
                    $this->read_info_users($sheet);
                }

                dd("Fin de la lectura del archivo");
                
                return back()->with('success', ['Uploaded successfully']);
            } catch (Exception $ex) {
                return '0' . $ex;
            }
        }
    }

    public function read_info_users($sheet) {
        $titleSheet = $sheet->getTitle();
        $array = $sheet->toArray(null, true, true, true);
        
        foreach ($array as $key => $values) {
            // Ingnoramos las primeras 2 columnas y validamos que el nombre y numero esten asignados
            if (!in_array($key, [1, 2]) && !empty($values['B']) && (int)$values['A'] > 0) { // ignora las primeras dos tablas
                $no_empleado = (int)$values['A'];
                $nombre = $values['B'];
                $fecha_ingreso = get_date($values['C']);
                $antiguedad = $values['D'];
                $dias_vacaciones = $values['E'];
                $dias_utilizados = $values['F'];
                $dias_disponibles = $values['G'];

                $nombre = explode(" ",$nombre);
                $nombre = array_filter($nombre, fn ($item) => !empty($item));
                $nombre = implode(" ", $nombre);

                $userInfo = [
                    "no_empleado" => $no_empleado,
                    "name" => $nombre,
                    "password" => Hash::make("12345678"),//moverlo al if de si existe usuario o no
                ];

                $dataUserInfo = [
                    "fecha_ingreso" => $fecha_ingreso,
                    "antiguedad" => $antiguedad,
                    "dias_vacaciones" => $dias_vacaciones,
                    "dias_utilizados" => $dias_utilizados
                ];

                // Registrar nuevo usuario
                $user = User::where("no_empleado", $no_empleado);
                // Actualizacion de usuario
                if ($user->count() > 0) {
                    $id_user = $user->value('id');
                    $user->update($userInfo);
                    dump("Usuario ".$userInfo['name']." Actualizado");
                    $dataUserInfo["user_id"] = $id_user;
                } 
                // Insertar Usuario
                else {
                    $newUser = new User($userInfo);
                    $newUser->save();
                    dump("Usuario ".$userInfo['name']." Registrado");
                    $id_user = $newUser->id;
                    $dataUserInfo["user_id"] = $id_user;
                }
                
                // Informacion de Usuario
                $datosEmpleado = DatosEmpleados::where("user_id", $id_user);
                if ($datosEmpleado->count() > 0) {
                    $datosEmpleado->update($dataUserInfo);
                    dump("Info Usuario ".$userInfo['name']." Actualizada");
                } else {
                    $newDatosEmpleado = new DatosEmpleados($dataUserInfo);
                    $newDatosEmpleado->save();
                    dump("Info Usuario ".$userInfo['name']." Registrada");
                }
            }
        }
        // dump($array);
    }
}
