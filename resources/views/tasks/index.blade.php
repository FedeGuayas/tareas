@extends ('layouts.dashboard')
@section('title','Tareas')
@section('page_heading','Listado de Tareas')



@section('section')
    <div class="col-sm-12 col-lg-6">
        <div class="row">
            <a href="{{ route('admin.tasks.create' )}}" class="btn btn-success tip pull-left" data-placement="right"
               title="Nueva"><i class="fa fa-tasks" aria-hidden="true"></i>
                Nueva</a>
        </div>
    </div>

    <div class="col-sm-12">
        @include('alert.success')
        <div id="msg-send" class="alert alert-success alert-dismissible" role="alert" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong id="send"></strong>
        </div>
        <div class="row">
            <div class="col-lg-12">

                <table id="task_table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-order='[[ 3, "asc"]]' style="display: none">
                    <thead>
                        <tr>
                            <th>Tarea</th>
                            <th>Trabajadores</th>
                            <th>Area</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Termino Planificado</th>
                            <th>Fecha Termino Real</th>
                            <th>Adjunto</th>
                            <th>Comentarios</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Tarea</th>
                            <th>Trabajadores</th>
                            <th>Area</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Termino Planificado</th>
                            <th>Fecha Termino Real</th>
                            <th>Adjunto</th>
                            <th>Comentarios</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @foreach($events as $event)
                        <tr>

                            <td>{{$event->title}}</td>
                            <td>
                                @foreach($event->task->users as $user)
                                    {{$user->getFullNameAttribute()}}<br>
                                @endforeach
                            </td>
                            <td>{{$event->task->area->area}}</td>
                            <td>{{$event->start}}</td>
                            <td>{{$event->end}}</td>
                            <td>
                                @if ($event->state==1)
                                    {{$event->end_day}}
                                @endif
                            </td>
                            <td>
                                @foreach($event->files as $file)
                                    <a href="{{route('task.download.file',$file->name)}}">
                                        {{$file->name}}<br>
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                @if(count($event->comments)>0)
                                    <a href="{{route('task.show.comment',$event)}}" class="btn btn-primary">
                                        Comentarios<span class="badge">{{$event->comments->count()}}</span>
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if ($event->state==0)
                                    <span class="label label-warning">Pendiente</span>
                                @else
                                    @if ($event->end_day > $event->end)
                                        <span class="label label-danger">Terminada</span>
                                    @else
                                        <span class="label label-success">Terminada</span>
                                    @endif

                                @endif
                            </td>
                            <td>
                                @role(['supervisor','administrador'])
                                @if ($event->task->repeats==0)<!--Tarea no recurrente-->
                                    <a href="{{ route('admin.tasks.edit', $event->task_id )}}" class="btn btn-xs btn-warning" data-placement="top" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a href="" data-target="#modal-delete-{{ $event->task_id }}" data-toggle="modal-task" class="btn btn-xs btn-danger" data-placement="top" title="Elimminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                @else <!--Recurrente editar en calendario-->
                                    <a href="{{ route('admin.calendar.edit', $event->id)}}" class="btn btn-xs btn-warning" data-placement="top" title="Editar"><i class="fa fa-calendar" aria-hidden="true"></i></a>
                                    <a href="" data-target="#modal-delete-{{ $event->id }}" data-toggle="modal-event" class="btn btn-xs btn-danger" data-placement="top" title="Elimminar"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                @endif

                                @if (!is_null($event->end_day) && ($event->state==0))
                                <a href="" id="{{$event->id}}" class="btn btn-xs btn-primary aprobEndTask" data-placement="top" title="Aprobar"><i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                </a>
                                @endif
                                @endrole
                            </td>


                        </tr>
                        @include('tasks.modal-task')
                        @include('tasks.modal-event')
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {!! Form::open(['id' =>'form-taskEndAprob']) !!}
    {!! Form::close() !!}
@endsection

@section('script')

    <script type="text/javascript">

        $(document).ready(function () {

            var table = $('#task_table').DataTable({
                "lengthMenu": [[5, 7, 10, 25], [5, 7, 10, 25]],
                "processing": true,
//            "serverSide": false,
//            "ajax":"api/result",
//            "columns":[
//                {data:'first_name'},
//                {data:'second_name'},
//                {data:'last_name'},
//                {data:'sex'},
//                {data:'category'},
//                {data:'circuit'},
//                {data:'place'},
//                {data:'time'},
//            ],
//            select: true
                "language": {
                    "decimal": "",
                    "emptyTable": "No se encontraron datos en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(filtrados de un total _MAX_ registros)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encrontraron coincidencias",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": Activar para ordenar ascendentemente",
                        "sortDescending": ": Activar para ordenar descendentemente"
                    }
                },
                "fnInitComplete": function () {
                    $('#task_table').fadeIn();
                }
            });


            $(function () {
                $(".tip1").tooltip()
            });
        });

        $(".aprobEndTask").click(function(e){
            e.preventDefault();
            var token = document.getElementsByName("_token")[0].value;
            var datos=this.id;
            var route="{{route('user.task.end.aprob')}}";
            $.ajax({
                url: route,
                type: "POST",
                headers: {'X-CSRF-TOKEN': token},
                contentType: 'application/x-www-form-urlencoded',
                data: {datos},
                success: function(json) {
//                    console.log(json);
                    $("#send").html(json.message);
                    $("#msg-send").fadeIn();
                },
                error: function(json){
                    console.log("Error al enviar id");
                }
            });
        });
    </script>
@endsection