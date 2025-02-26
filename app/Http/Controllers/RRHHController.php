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
    public function show_add_info(Request $request)
    {
        return view('rrhh.formulario_agregar_info');
    }

    public function set_info_users(Request $request)
    {
        if ($request->file('excel_users')) {
            $file = $request->file('excel_users');

            try {
                $reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file);

                foreach ($spreadsheet->getAllSheets() as $sheet) {
                    $this->read_info_users($sheet);
                }

                return back()->with('success', ['Uploaded successfully']);
            } catch (Exception $ex) {
                return '0' . $ex;
            }
        }
    }

    public function read_info_users($sheet)
    {
        if (!$sheet) {
            dump("Error: La hoja es nula, no se puede procesar.");
            return;
        }

        $array = $sheet->toArray(null, true, true, true);

        foreach ($array as $key => $values) {
            if (!in_array($key, [1, 2]) && !empty($values['B']) && (int)$values['A'] > 0) {
                $no_empleado = (int)$values['A'];
                $nombre = trim($values['B']);
                $email = isset($values['H']) ? strtolower(trim($values['H'])) : null;
                $fecha_ingreso = get_date($values['C']);
                $antiguedad = $values['D'];
                $dias_vacaciones = $values['E'];
                $dias_utilizados = $values['F'];
                $dias_disponibles = $values['G'];

                $userInfo = [
                    "no_empleado" => $no_empleado,
                    "name" => $nombre,
                    "email" => $email,
                    "password" => Hash::make("12345678"),
                ];

                $dataUserInfo = [
                    "fecha_ingreso" => $fecha_ingreso,
                    "antiguedad" => $antiguedad,
                    "dias_vacaciones" => $dias_vacaciones,
                    "dias_utilizados" => $dias_utilizados
                ];

                $user = User::where("no_empleado", $no_empleado);
                if ($user->count() > 0) {
                    $id_user = $user->value('id');
                    $user->update($userInfo);
                    dump("Usuario " . $userInfo['name'] . " Actualizado");
                    $dataUserInfo["user_id"] = $id_user;
                } else {
                    if ($email && User::where('email', $email)->exists()) {
                        dump("Error: El email $email ya está registrado.");
                        continue;
                    }
                    
                    $newUser = new User($userInfo);
                    $newUser->save();
                    dump("Usuario " . $userInfo['name'] . " Registrado");
                    $id_user = $newUser->id;
                    $dataUserInfo["user_id"] = $id_user;
                }

                $datosEmpleado = DatosEmpleados::where("user_id", $id_user);
                if ($datosEmpleado->count() > 0) {
                    $datosEmpleado->update($dataUserInfo);
                    dump("Info Usuario " . $userInfo['name'] . " Actualizada");
                } else {
                    $newDatosEmpleado = new DatosEmpleados($dataUserInfo);
                    $newDatosEmpleado->save();
                    dump("Info Usuario " . $userInfo['name'] . " Registrada");
                }
            }
        }
    }
}
