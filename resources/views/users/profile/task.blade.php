@extends ('layouts.dashboard')
@section('page_heading','Tareas')

@section('section')

    <div class="col-sm-12">
        @include('alert.success')
        <div class="row">
            <div class="col-lg-12">

                <table id="task_table" class="table table-striped table-bordered" cellspacing="0" width="100%"
                       data-order='[[ 0, "asc" ]]' style="display: none">
                    <thead>
                    <tr>
                        {{--<th>id</th>--}}
                        <th>Tarea</th>
                        <th>Inicio</th>
                        <th>Fecha Termino</th>
                        <th>Fecha Cumplida</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        {{--<th>id</th>--}}
                        <th>Tarea</th>
                        <th>Inicio</th>
                        <th>Fecha Termino</th>
                        <th>Fecha Cumplida</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            {{--<td>{{$area->id}}</td>--}}
                            <td>
                                @if ($task->repeats==1)
                                    {{$task->title}}<br>
                                @else
                                    {{$task->task}}<br>
                                @endif
                            </td>
                            <td>{{$task->start}}</td>
                            <td>{{$task->performance_day}}</td>
                            <td>{{$task->end_day}}</td>
                            <td>
                                @if ($task->state==0)
                                    <span class="label label-warning">Activa</span>
                                @else
                                    <span class="label label-success">Terminada</span>
                                @endif
                            </td>
                            <td>
                                @if ($task->state==0)
                                    <a href="" data-target="#modal-coment-{{ $task->id }}" data-toggle="modal" class="btn btn-xs btn-primary" data-placement="top" title="Terminada"><i class="fa fa-hand-o-left" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @include('users.profile.end_tasks')
                    @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>
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
    </script>
@endsection