<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de Vacaciones</title>
</head>
<body>
@if ($respuesta)
    <!-- Notificación de Aprobación -->
    <div style="margin-bottom: 20px; font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
        <h2 style="margin-bottom: 10px;">Aprobación de Solicitud de Vacaciones</h2>
        <p>Estimado {{ $user['name'] }},</p>
        <p>Es un placer informarte que tu solicitud de vacaciones ha sido aprobada. Nos complace poder brindarte este tiempo para que puedas disfrutar de un merecido descanso. Agradecemos tu compromiso y contribución al equipo, y esperamos que regreses renovado/a y listo/a para continuar con tus responsabilidades.</p>

        <!-- Detalles de las vacaciones aprobadas -->
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f2f2f2;">EMPLEADO:</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f2f2f2;">DIAS SOLICITADOS:</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f2f2f2;">FECHA DE INICIO DE VACACIONES:</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f2f2f2;">JEFE DIRECTO:</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left; background-color: #f2f2f2;">EN MI AUSENCIA CONTACTAR A :</td>
            </tr>
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{ $user['name'] }}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{ $solicitud->dias_solicitados }}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{ $solicitud->fecha_inicio_vacaciones }}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{ $jefe['name'] }}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: left;">{{ $solicitud->nota_de_solicitud }}</td>
            </tr>
        </table>

        <p style="margin-top: 10px;">Si tienes alguna pregunta o necesitas más información, no dudes en comunicarte con Recursos Humanos. ¡Disfruta de tus vacaciones!</p>
        {{-- <p>Atentamente, <br style="margin-bottom: 10px;">[Tu Nombre] <br style="margin-bottom: 10px;">[Tu Cargo] <br style="margin-bottom: 10px;">[Nombre de la Empresa]</p> --}}
    </div>
@else 
    <!-- Notificación de Denegación -->
    <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
        <h2 style="margin-bottom: 10px;">Denegación de Solicitud de Vacaciones</h2>
        <p>Estimado {{ $user['name'] }},,</p>
        <p>Lamentamos informarte que tu solicitud de vacaciones ha sido denegada en esta ocasión. Apreciamos tu comprensión y paciencia en este asunto.</p>

        <!-- Detalles de la denegación -->
        {{-- <p>Entendemos que tomarte un tiempo libre es importante, pero en este momento no podemos aprobar la solicitud debido a [razón específica, por ejemplo, carga de trabajo, proyecto urgente, etc.].</p> --}}

        <p>Agradecemos tu compromiso y esperamos que puedas reprogramar tus planes de vacaciones en el futuro. Si tienes alguna pregunta o necesitas más información, no dudes en comunicarte con Recursos Humanos. Apreciamos tu dedicación y colaboración.</p>

        {{-- <p>Atentamente, <br style="margin-bottom: 10px;">[Tu Nombre] <br style="margin-bottom: 10px;">[Tu Cargo] <br style="margin-bottom: 10px;">[Nombre de la Empresa]</p> --}}
    </div>
@endif
</body>
</html>
