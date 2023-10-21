<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<link href="{{ asset('css/login.css') }}" rel="stylesheet">


<body class="fondo">


    <div id="contenedor">
        <div id="central">
            <div id="login">
                <div class="icono">
                    <img src="{{ asset('imagenes/computadora.png') }}" />
                </div>
                <h5 class="card-title text-center" style="color: red;"></h5>
                <div class="titulo">
                    Login
                </div>
                <form id="loginform" method="POST" action="{{ url('api/users/authenticate')}}">
                    @csrf
                    <div>
                        <input type="email" name="email" placeholder="Correo electronico" required>

                        <input type="password" placeholder="Contraseña" name="password" required>

                        <button type="submit" title="Ingresar" name="Ingresar">INICIAR SESION</button>
                    </div>
                </form>

            </div>

        </div>
    </div>

</body>

</html>