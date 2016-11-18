<div class="col-lg-12">
    <table class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            {{--<th>id</th>--}}
            <th>Trabajador</th>
            <th>Area</th>
            <th>Tareas</th>
            <th>Cumplidas</th>
            <th>Sin cumplir</th>

        </tr>
        </thead>
        <tbody>
        {{--@foreach($users as $user)--}}
        <tr>
            <td>{{$user->getFullNameAttribute()}}</td>
            <td>{{$user->area->area}}</td>
            <td>@foreach($tareas as $task)
                    {{$task->task}}<br>
                @endforeach
            </td>
            <td>{{$cumplidas}}</td>
            <td>{{$incumplidas}}</td>
        </tr>

        {{--@endforeach--}}
        </tbody>
    </table>
</div>