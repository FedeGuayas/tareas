@extends ('layouts.dashboard')
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
            <strong id="send"></strong></div>
        <div class="row">
            <div class="col-lg-12">

                <table id="task_table" class="table table-striped table-bordered" cellspacing="0" width="100%"
                       data-order='[[ 0, "asc" ]]' style="display: none">
                    <thead>
                    <tr>
                        {{--<th>id</th>--}}
                        <th>Tarea</th>
                        <th>Trabajador</th>
                        <th>Area</th>
                        <th>Inicio</th>
                        <th>Termino P</th>
                        <th>Termino R</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        {{--<th>id</th>--}}
                        <th>Tarea</th>
                        <th>Trabajador</th>
                        <th>Area</th>
                        <th>Inicio</th>
                        <th>Termino P</th>
                        <th>Termino R</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            {{--<td>{{$area->id}}</td>--}}
                            <td>{{$task->task}}</td>
                            <td>{{$task->user->getFullName()}}</td>
                            <td>
                                @foreach($areas as $area)
                                    {{-- $task->user->area_id //area del usuario--}}
                                    @if ($task->user->area_id==$area->id)
                                        {{$area->area}}<br><br>
                                    @endif
                                @endforeach
                            </td>
                            <td>{{$task->start_day}}</td>
                            <td>{{$task->performance_day}}</td>
                            <td>{{$task->end_day}}</td>
                            <td>
                                @if ($task->state==0)
                                    <span class="label label-warning">Activa</span>

                                @else
                                    @if ($task->end_day > $task->performance_day)
                                        <span class="label label-danger">Terminada</span>
                                    @else
                                        <span class="label label-success">Terminada</span>
                                    @endif

                                @endif
                            </td>

                            <td>
                                @role('supervisor')
                                @if ($task->repeats==0)
                                    <a href="{{ route('admin.tasks.edit', $task )}}" class="btn btn-xs btn-warning" data-placement="top" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                @else
                                    <a href="{{ route('admin.calendar.edit', $task)}}" class="btn btn-xs btn-warning" data-placement="top" title="Editar"><i class="fa fa-calendar" aria-hidden="true"></i>
                                    </a>
                                @endif
                                <a href="" data-target="#modal-delete-{{ $task->id }}" data-toggle="modal" class="btn btn-xs btn-danger" data-placement="top" title="Elimminar"><i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                                    @if (!is_null($task->end_day) && ($task->state==0))
                                        <a href="" id="{{$task->id}}" class="btn btn-xs btn-primary aprobEndTask" data-placement="top" title="Aprobar"><i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                        </a>
                                    @endif
                                @endrole
                            </td>

                        </tr>
                        @include('tasks.modal')
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
                    console.log(json);
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