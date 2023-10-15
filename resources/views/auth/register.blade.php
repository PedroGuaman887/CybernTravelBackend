<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>
    <div class="formulario" style="font-size: 18px;">
        <div class="tab-pane active" id="post-object-form">
            <form method="POST" action="{{ url('api/users/')}}">
                @csrf
                <div class="row" style=" margin: 10px;">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-7">
                        <fieldset>


                            <div class="form-group">
                                <label class="col-sm-3 control-label" title="Campo obligatorio">
                                    Nombre(s) <label style="color: red;">*</label>
                                </label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="firstName" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" title="Campo obligatorio">
                                    Apellido <label style="color: red;">*</label>
                                </label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="lastName" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label" title="Campo obligatorio">
                                    Número de teléfono <label style="color: red;">*</label>
                                </label>

                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="phoneNumber" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" title="Campo obligatorio">
                                    Fecha de nacimiento <label style="color: red;">*</label>
                                </label>

                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="birthDate" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label" title="Campo obligatorio">
                                    Correo electronico <label style="color: red;">*</label>
                                </label>

                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label" title="Campo obligatorio">
                                    Contraseña <label style="color: red;">*</label>
                                </label>

                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>



                            <button class="btn btn-primary js-tooltip" title="" id="botonGuardar" style="background-color: #1976d2;margin-top:15px;">
                                REGISTRARSE
                            </button>

                        </fieldset>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>