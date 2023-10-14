<!DOCTYPE html>
<html>

<head>
    <title>Cuenta creada</title>
</head>

<body>
    <h1>Cuenta creada</h1>

    <p>Hola {{ $user->firstName }}.</p>

    <p>Tu cuenta ha sido creada exitosamente. A continuación, encontrarás los detalles de tu cuenta:</p>


    <ul>
        <li>Ci:{{ $user->ciNumber }}</li>
        <li>Nombre: {{ $user->firstName }}</li>
        <li>Apellido: {{ $user->lastName }}</li>
        <li>Correo: {{ $user->email }}</li>
        <li>Celular: {{ $user->phoneNumber }}</li>
        <li>Direccion: {{ $user->address }}</li>
        <li>Fecha de nacimiento: {{ $user->birthDate }}</li>

        <p>Por favor cambie su contraseña</p>
    </ul>

    <p>¡Gracias por registrarte!</p>
</body>

</html>
