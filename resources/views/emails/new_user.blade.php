<html>
    <body>
    <div>Estimado: <b>{{$user->getFullName()}}</b><hr>
        Se ha creado una cuenta para ud en el sistema de Gestión de Tareas de FEDEGUAYAS.
        <p>El siguiente link le permitirá activar  su cuenta. Este enlace será de un solo uso.
        </p>
        Activar cuenta : {{$link}}
        <p>
            El sistema genera una contraseña aleatoria para ud, una ves en el puede cambiarla si asi lo desea
        </p>
        <div>
            <p>
                Sus datos de acceso son: <br>
                usuario: {{$user->email}} <br>
                contraseña: {{$passw}} <br>
            </p>
        </div>
        Atentamente, Dpto Administrativo.
    </div>
    </body>
</html>