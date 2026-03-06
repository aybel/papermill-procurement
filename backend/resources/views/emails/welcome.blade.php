<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Papermill Procurement</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #004080;
            color: #fff;
            padding: 10px 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .footer {
            text-align: center;
            font-size: 0.9em;
            color: #777;
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bienvenido a Papermill Procurement</h1>
        </div>
        <div class="content">
            <h2>¡Hola, {{ $user->name }}!</h2>
            <p>Te damos la bienvenida a la plataforma de gestión de compras de Papermill. Estamos muy contentos de tenerte con nosotros.</p>
            <p>Tu cuenta ha sido creada exitosamente. Para empezar, por favor, establece tu contraseña haciendo clic en el siguiente botón:</p>
            <p>Este enlace es válido por {{ config('auth.passwords.users.expire') }} minutos.</p>
            <a href="{{ env('FRONTEND_URL', 'http://localhost:3000') }}/auth/reset-password?token={{ $token }}&email={{ urlencode($user->email) }}" class="button">Establecer Contraseña</a>
            <p>Si no puedes hacer clic en el botón, copia y pega la siguiente URL en tu navegador:</p>
            <p>{{ env('FRONTEND_URL', 'http://localhost:3000') }}/auth/reset-password?token={{ $token }}&email={{ urlencode($user->email) }}</p>
            <p>Si no creaste esta cuenta, puedes ignorar este correo.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Papermill Procurement. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
