<html>

<body>
    <main>
        <h1 style="color: #00277a;">SOLICITUD DE VACACIONES</h1>
        <p>Estimado <span style="color: #00277a;">{{ $user['name'] }}</span>,</p>
        <p style="color: #222222;">Ha solicitado vacaciones. A continuación encontrará la información de la solicitud.</p>
        <p style="color: #222222;">Tomar nota de que recibirá en las próximas horas, a través del correo electrónico, la respuesta a su solicitud, una vez esta sea aprobada o no aprobada.</p>

        <table style="border-collapse: collapse; width: 100%; border: 1px solid #222222;">
            <tr>
                <td style="border: 1px solid #222222; padding: 8px; background-color: #999999;">EMPLEADO:</td>
                <td style="border: 1px solid #222222; padding: 8px; background-color: #999999;">DIAS SOLICITADOS:</td>
                <td style="border: 1px solid #222222; padding: 8px; background-color: #999999;">FECHA DE INICIO DE VACACIONES:</td>
                <td style="border: 1px solid #222222; padding: 8px; background-color: #999999;">JEFE DIRECTO:</td>
                <td style="border: 1px solid #222222; padding: 8px; background-color: #999999;">EN MI AUSENCIA CONTACTAR A :</td>
            </tr>
            <tr>
                <td style="border: 1px solid #222222; padding: 8px;">{{ $user['name'] }}</td>
                <td style="border: 1px solid #222222; padding: 8px;">{{ $diasSol }}</td>
                <td style="border: 1px solid #222222; padding: 8px;">{{ $FechaInicio }}</td>
                <td style="border: 1px solid #222222; padding: 8px;">{{ $jefe['name']}}</td>
                <td style="border: 1px solid #222222; padding: 8px;">{{ $Nota }}</td>
            </tr>
        </table>

        <p>Saludos Cordiales.</p>
    </main>
</body>

</html>
