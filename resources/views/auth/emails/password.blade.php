<html>
<body>
<div>
    Uds ha olvidado su contraseña de acceso en el sistema de Gestión de Tareas de FEDEGUAYAS y solicitó reiniciarla .
    <p>Dar click en el siguiente link le permitirá restablecer  su contraseña.
    </p>
    Restablecer contraseña: <br>
    <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
</div>
</body>
</html>




