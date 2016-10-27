@extends ('layouts.dashboard')
@section('page_heading','Listado de Tareas')

@section('section')
    <div class="col-sm-12 col-lg-6">
        <div class="row">
            <a href="{{ route('admin.tasks.create' )}}" class="btn btn-success tip pull-left" data-placement="right"
               title="Nueva"><i class="fa fa-tasks" aria-hidden="true"></i>
                Nueva</a>
        </div>
        <div class="col-sm-12 col-lg-6">
            @include('alert.success')
        </div>
    </div>



    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-12">

                <table id="task_table" class="table table-striped table-bordered" cellspacing="0" width="100%"
                       data-order='[[ 0, "asc" ]]' style="display: none">
                    <thead>
                    <tr>
                        {{--<th>id</th>--}}
                        <th>Tarea</th>
                        <th>Area</th>
                        <th>Trabajador</th>
                        <th>Dia Inicio</th>
                        <th>Dia Termino</th>
                        <th>Fin Ejecución</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        {{--<th>id</th>--}}
                        <th>Tarea</th>
                        <th>Area</th>
                        <th>Trabajador</th>
                        <th>Dia Inicio</th>
                        <th>Dia Termino</th>
                        <th>Fin Ejecución</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            {{--<td>{{$area->id}}</td>--}}
                            <td>{{$task->task}}</td>
                            <td>{{$task->area->area}}</td>
                            <td>{{$task->person->getFullName()}}</td>
                            <td>{{$task->start_day}}</td>
                            <td>{{$task->performance_day}}</td>
                            <td>{{$task->end_day}}</td>
                            <td>
                                @if ($task->state==1)
                                    <span class="label label-success">Act</span>

                                @else
                                    <p>Terminada</p>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.tasks.edit', $task->id )}}" class="btn btn-xs btn-warning tip1"
                                   data-placement="top" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <a href="" data-target="#modal-delete-{{ $task->id }}" data-toggle="modal"
                                   class="btn btn-xs btn-danger tip" data-placement="top" title="Elimminar"><i
                                            class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                        @include('tasks.modal')
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