<html>
    <body>
    <div>
        <h3><b>{{$receiver->getFullName()}}</b></h3><hr>

        <b> {{$sender->getFullname()}}</b> , ha creado un nuevo evento para ud en el sistema de Gestión de Tareas de FEDEGUAYAS.
        <br>

        <div>

        <p>

            Tarea: {{$task->task}}<br>

            Descripción: {{$task->description}}<br>

            Creada el: {{$task->created_at}}<br>

            Fecha inicio{{$task->start_day}}<br>

            Fecha termino{{$task->performance_day}}<br>

        </p>

            <a href="{{route('home')}}">Entrar</a>
        </div>

        Atentamente, Dpto Administrativo.
    </div>
    </body>
</html>