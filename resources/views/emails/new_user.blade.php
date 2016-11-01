<html>
    <body>
        <div>
            <p>
               Estimado, se le ha creado una cuenta en el sistema de Gestión de Tareas.
            </p>
            <p>
                Debe dar clic en el siguiente link para activar su cuenta
                {{$link}}
            </p>
            <p>
                Este enlace será de un solo uso
            </p>
            <p>
                Sus datos de acceso son: <br>
                usuario: {{$user->email}} <br>
                contraseña: {{$passw}} <br>
            </p>

        </div>
    </body>
</html>