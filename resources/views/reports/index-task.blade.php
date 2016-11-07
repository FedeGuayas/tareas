@extends ('layouts.dashboard')
@section('page_heading','Reportes Tareas')

@section('section')

    <div class="col-sm-12">

        <div class="row">
            @include('reports.task-search')
            <div class="col-sm-3">
                <div class="form-group pull-right">
{{--                    {!! Form::label('export','Exportar') !!}--}}

                        @include('reports.export-tasks')
                        {{--<a href="{{route('admin.tasks.reports.users.excel')}}"  class="btn btn-success" title="exportar"><i class="fa fa-file-excel-o" aria-hidden="true"></i>--}}
                        {{--</a>--}}

                </div>
            </div>
            <div class="row">

                <div class="col-lg-12">
                    <table id="tasks_table" class="table table-striped table-bordered" cellspacing="0" width="100%"
                           data-order='[[ 1, "asc" ]]' style="display: none">
                        <thead>
                        <tr>
                            {{--<th>id</th>--}}
                            <th>Area</th>
                            <th>Trabajador</th>
                            <th>Tareas</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha termino</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            {{--<th>id</th>--}}
                            <th>Area</th>
                            <th>Trabajador</th>
                            <th>Tareas</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha termino</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td>area</td>
                                <td>{{$task->user_id}}</td>
                                <td>{{$task->task}}</td>
                                <td>{{$task->start_day}}</td>
                                <td>{{$task->performance_day}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>


        </div>


    </div>
@endsection

@section('script')

    <script type="text/javascript">
        $(function () {
            $('#start_datetimepicker').datetimepicker({
                showClear:true,
                showClose:true,
                locale:'es',
                format:'YYYY-MM-DD'

            });
            $('#end_datetimepicker').datetimepicker({
                useCurrent: false,
                showClear:true,
                showClose:true,
                locale:'es',
                format:'YYYY-MM-DD'

            });
            $("#start_datetimepicker").on("dp.change", function (e) {
                $('#end_datetimepicker').data("DateTimePicker").minDate(e.date);

            });
            $("#end_datetimepicker").on("dp.change", function (e) {
                $('#start_datetimepicker').data("DateTimePicker").maxDate(e.date);
            });
        });

        var table =  $('#tasks_table').DataTable({
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
            "language":{
                "decimal":        "",
                "emptyTable":     "No se encontraron datos en la tabla",
                "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                "infoFiltered":   "(filtrados de un total _MAX_ registros)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Mostrar _MENU_ registros",
                "loadingRecords": "Cargando...",
                "processing":     "Procesando...",
                "search":         "Buscar:",
                "zeroRecords":    "No se encrontraron coincidencias",
                "paginate": {
                    "first":      "Primero",
                    "last":       "Ultimo",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                },
                "aria": {
                    "sortAscending":  ": Activar para ordenar ascendentemente",
                    "sortDescending": ": Activar para ordenar descendentemente"
                }
            },
            "fnInitComplete":function(){
                $('#tasks_table').fadeIn();
            }
        });




    </script>
@endsection