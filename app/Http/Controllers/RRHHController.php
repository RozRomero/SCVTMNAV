<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\DatosEmpleados;
use App\Models\CatalogoDepartamentos;
use Illuminate\Http\Request;
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
                
                // Leer y validar la fecha de ingreso
                $fecha_ingreso = isset($values['C']) ? $this->clean_and_validate_date($values['C']) : '2025-01-01';

                $antiguedad = $values['D'];
                $dias_vacaciones = $values['E'];
                $dias_utilizados = $values['F'];
                $dias_disponibles = $values['G'];
                $nombre_departamento = isset($values['I']) ? trim($values['I']) : null; // Nueva columna para departamento

                // Si el departamento no existe, se crea automáticamente
                if ($nombre_departamento) {
                    $departamento = CatalogoDepartamentos::firstOrCreate(['nombre_departamento' => $nombre_departamento]);
                    $id_departamento = $departamento->id;
                } else {
                    $id_departamento = null;
                }

                // Datos del usuario
                $userInfo = [
                    "no_empleado" => $no_empleado,
                    "name" => $nombre,
                    "email" => $email,
                ];

                $dataUserInfo = [
                    "fecha_ingreso" => $fecha_ingreso,
                    "antiguedad" => $antiguedad,
                    "dias_vacaciones" => $dias_vacaciones,
                    "dias_utilizados" => $dias_utilizados,
                    "departamento_id" => $id_departamento // Guardar departamento
                ];

                $user = User::where("no_empleado", $no_empleado)->first();

                if ($user) {
                    // No se sobrescribe la contraseña si el usuario ya existe
                    $user->update($userInfo);
                    dump("Usuario " . $userInfo['name'] . " Actualizado");
                    $dataUserInfo["user_id"] = $user->id;
                } else {
                    if ($email && User::where('email', $email)->exists()) {
                        dump("Error: El email $email ya está registrado.");
                        continue;
                    }

                    // Se crea el usuario con contraseña por defecto
                    $userInfo["password"] = Hash::make("12345678");
                    $newUser = User::create($userInfo);
                    dump("Usuario " . $userInfo['name'] . " Registrado");
                    $dataUserInfo["user_id"] = $newUser->id;
                }

                $datosEmpleado = DatosEmpleados::where("user_id", $dataUserInfo["user_id"])->first();
                
                if ($datosEmpleado) {
                    $datosEmpleado->update($dataUserInfo);
                    dump("Info Usuario " . $userInfo['name'] . " Actualizada");
                } else {
                    DatosEmpleados::create($dataUserInfo);
                    dump("Info Usuario " . $userInfo['name'] . " Registrada");
                }
            }
        }
    }

    /**
     * Función para limpiar y validar el formato de la fecha.
     *
     * @param mixed $dateInput Valor de la fecha obtenido del archivo Excel.
     * @return string Fecha en formato Y-m-d o '2025-01-01' si no es válida.
     */
    protected function clean_and_validate_date($dateInput)
    {
        // Si el valor es nulo o está vacío, retornar la fecha predeterminada
        if (empty($dateInput)) {
            return '2025-01-01';
        }

        // Si el valor es una instancia de DateTime (puede ocurrir con PhpSpreadsheet)
        if ($dateInput instanceof \DateTime) {
            return $dateInput->format('Y-m-d');
        }

        // Si el valor es un string, intentar limpiarlo y convertirlo a fecha
        if (is_string($dateInput)) {
            $dateInput = trim($dateInput);

            try {
                return Carbon::createFromFormat('Y-m-d', $dateInput)->format('Y-m-d');
            } catch (\Exception $e) {
                try {
                    return Carbon::parse($dateInput)->format('Y-m-d');
                } catch (\Exception $e) {
                    return '2025-01-01';
                }
            }
        }

        // Si no es un tipo de dato reconocido, retornar la fecha predeterminada
        return '2025-01-01';
    }
}
