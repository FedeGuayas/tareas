@extends ('layouts.dashboard')
@section('page_heading','Sus tareas del mes, '.$user->getFullNameAttribute().' ')

@section('section')

    <div class="col-sm-12">
        @include('alert.success')
        @include('alert.request')
        <div id="msg-send" class="alert alert-success alert-dismissible" role="alert" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong id="send"></strong>
        </div>
        <div class="row">
            <div class="col-lg-12">

                <table id="task_table" class="table table-striped table-bordered" cellspacing="0" width="100%"
                       data-order='[[ 1, "asc" ]]' style="display: none">
                    <thead>
                    <tr>
                        {{--<th>id</th>--}}
                        <th>Tarea</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Termino Planificada</th>
                        <th>Fecha Termino Real</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        {{--<th>id</th>--}}
                        <th>Tarea</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Termino Planificada</th>
                        <th>Fecha Termino Real</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>{{$event->title}}</td>
                            <td>{{$event->start}}</td>
                            <td>{{$event->end}}</td>
                            <td>{{$event->end_day}}</td>
                            <td>
                                @if ($event->state==0)
                                    <span class="label label-warning">Pendiente</span>
                                @else
                                    <span class="label label-success">Terminada</span>
                                @endif
                            </td>
                            <td>
                                @if ($event->state==0)
                                    {{--</a>--}}
                                    {{--<a href="" data-target="#modal-coment-{{ $task->id }}" data-toggle="modal" class="btn btn-xs btn-primary" data-placement="top" title="Terminada"><i class="fa fa-hand-o-left" aria-hidden="true"></i>--}}
                                    {{--</a>--}}
                                    <a href="#!" id="{{$event->id}}" class="solEndTask btn btn-xs btn-primary" data-placement="top" title="Terminar"><i class="fa fa-hand-o-left" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        {{--@include('users.profile.end_tasks')--}}
                    @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>

    {!! Form::open(['id' =>'form-solEndTask']) !!}
    {!! Form::close() !!}
@endsection


@section('script')
    <script>
        $(document).ready(function () {
        $(".solEndTask").click(function(){
            var token = document.getElementsByName("_token")[0].value;
            var datos=this.id;
            var route="{{route('user.task.end')}}";
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
        });
    </script>
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



    </script>
@endsection