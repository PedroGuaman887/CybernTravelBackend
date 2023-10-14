<!DOCTYPE html>
<html>

<head>
    <title>Cuenta creada</title>
</head>

<body>
    <h1>Cuenta creada</h1>

    <p>Hola {{ $user->firstName }},</p>

    <p>Tu cuenta ha sido creada exitosamente. A continuación, encontrarás los detalles de tu cuenta:</p>


    <ul>
        <li>Ci:{{ $user->ciNumber }}</li>
        <li>firstName: {{ $user->firstName }}</li>
        <li>lastName: {{ $user->lastName }}</li>
        <li>Email: {{ $user->email }}</li>
        <li>phoneNumber: {{ $user->phoneNumber }}</li>
        <li>role: {{ $user->role }}</li>
        <li>address: {{ $user->address }}</li>
        <li>birthDate: {{ $user->birthDate }}</li>

        <p>Por favor cambie su contraseña</p>
    </ul>

    <p>¡Gracias por registrarte!</p>
</body>

</html>
