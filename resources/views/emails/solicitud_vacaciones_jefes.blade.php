<html>

<body>
    <main>
        <h1 style="color: #00277a;">SOLICITUD DE VACACIONES DE {{ strtoupper($user['name']) }}</h1>
        <p>Estimado <span style="color: #00277a;">{{ $jefe['name'] }}</span>,</p>
        <p style="color: #222222;">{{ $user['name'] }} ha solicitado vacaciones. A continuación encontrará la información de la solicitud.</p>
        <p style="color: #222222;">Tomar nota de que {{ $user['name'] }} cuenta con {{ $datosEmpleado['dias_vacaciones'] - $datosEmpleado['dias_utilizados'] }} días restantes.</p>

        <table style="border-collapse: collapse; width: 100%; border: 1px solid #222222;">
            <tr>
                <td style="border: 1px solid #222222; padding: 8px; background-color: #999999;">EMPLEADO:</td>
                <td style="border: 1px solid #222222; padding: 8px; background-color: #999999;">DIAS SOLICITADOS:</td>
                <td style="border: 1px solid #222222; padding: 8px; background-color: #999999;">FECHA DE INICIO DE VACACIONES:</td>
                <td style="border: 1px solid #222222; padding: 8px; background-color: #999999;">JEFE DIRECTO:</td>
                <td style="border: 1px solid #222222; padding: 8px; background-color: #999999;">EN MI AUSENCIA CONTACTAR A:</td>
            </tr>
            <tr>
                <td style="border: 1px solid #222222; padding: 8px;">{{ $user['name'] }}</td>
                <td style="border: 1px solid #222222; padding: 8px;">{{ $diasSol }}</td>
                <td style="border: 1px solid #222222; padding: 8px;">{{ $FechaInicio }}</td>
                <td style="border: 1px solid #222222; padding: 8px;">{{ $jefe['name']}}</td>
                <td style="border: 1px solid #222222; padding: 8px;">{{ $Nota }}</td>
            </tr>
        </table>

        {{-- <a href="http://172.23.10.116/andres/SCV-TMNAV/public/dashboard/Aprobar-Vacaciones">MENU AUTORIZAR</a> --}}

        <p>Saludos Cordiales.</p>
    </main>
</body>

</html>
