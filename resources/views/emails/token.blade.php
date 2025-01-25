<!DOCTYPE html>
<html>

<head>
    <title>Token de Verificación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            text-align: center;
            padding: 20px;
        }

        .token {
            font-size: 24px;
            font-weight: bold;
            color: #007BFF;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <h2>¡Hola!</h2>
    <p>Tu token de verificación es:</p>
    <p class="token">{{ $token }}</p>
    <p>Por favor, usa este token para completar tu proceso de registro.</p>
    <p>Gracias,</p>
    <p>El equipo de soporte</p>
    <div class="footer">Este es un mensaje automático. No respondas a este correo.</div>
</body>

</html>
