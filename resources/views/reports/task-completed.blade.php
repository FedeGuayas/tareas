@extends ('layouts.dashboard')
@section('style')
    <link rel="stylesheet" href="{{ asset("plugins/choosenjs/chosen.min.css") }}" />
@endsection
@section('page_heading','Tareas Terminadas')

@section('section')

    <div class="col-sm-12">

        <div class="row">
            {{--Filtrar busqueda--}}
            {!! Form::open (['route' => 'admin.reports.getCompleted','method' => 'GET' ])!!}
            <div class='col-sm-3'>
                <div class="form-group">
                    {!! Form::label('start','Desde *') !!}
                    <div class='input-group date' id='start_datetimepicker'>
                        {!! Form::text('start',$start,['class'=>'form-control']) !!}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class='col-sm-3'>
                <div class="form-group">
                    {!! Form::label('end','Hasta *') !!}
                    <div class='input-group date' id='end_datetimepicker'>
                        {!! Form::text('end',$end,['class'=>'form-control']) !!}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    {!! Form::label('buscar','Areas *') !!}
                    <div class="input-group">
                        {!! Form::select('areas_id[]',$areas,$areasID,['class'=>'form-control chosen-area','id'=>'areas_id', 'multiple'=>'multiple','data-placeholder'=>'Seleccione areas']) !!}
                    </div><!-- /input-group -->
                </div>
            </div><!-- /.col-lg-3 -->

            {{--<div class="clearfix"></div>--}}
            <div class="col-sm-2">
                {!! Form::submit('Filtrar',['class'=>'btn btn-primary']) !!}
            </div>
            {!!form::close()!!}

            {{--FIN Filtrar busqueda--}}

            {{--Boton Exportar--}}
            <div class="col-sm-2">
                <div class="form-group pull-right">
                    {!! Form::open (['route' => 'admin.reports.exportCompleted','method' => 'GET'])!!}
                    <div class="hidden">
                        {!! Form::text('start',$start,['class'=>'form-control']) !!}
                        {!! Form::text('end',$end,['class'=>'form-control']) !!}
                        {!! Form::select('areas_id[]',$areas,$areasID,['class'=>'form-control chosen-area','id'=>'areas_id', 'multiple'=>'multiple',]) !!}
                    </div>
                    {!! Form::submit('Exp-XLS',['class'=>'btn  btn-success pull-right']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            {{--END Exportar--}}

        </div>
            <div class="row">

                <div class="col-lg-12">
                    <table id="tasks_table" class="table table-striped table-bordered" cellspacing="0" width="100%"
                           data-order='[[ 3, "asc" ]]' style="display: none">
                        <thead>
                        <tr>
                            <th>Tarea</th>
                            <th>Trabajador</th>
                            <th>Area</th>
                            <th>Inicio</th>
                            <th>Termino P</th>
                            <th>Termino R</th>
                            <th>Estado</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Tarea</th>
                            <th>Trabajador</th>
                            <th>Area</th>
                            <th>Inicio</th>
                            <th>Termino P</th>
                            <th>Termino R</th>
                            <th>Estado</th>

                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td>{{$task->task}}</td>
                                <td>
                                    @foreach($task->users as $user )
                                        {{$user->getFullNameAttribute()}}<br>
                                    @endforeach
                                </td>
                                <td>
                                    {{--$task->user->area_id //area del usuario--}}
                                    {{$task->area->area}}
                                </td>
                                <td>{{$task->start_day}}</td>
                                <td>{{$task->performance_day}}</td>
                                <td>{{$task->end_day}}</td>
                                <td>Terminada</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>


        </div>



@endsection

@section('script')

    <script src="{{ asset("plugins/choosenjs/chosen.jquery.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("plugins/choosenjs/chosen.proto.min.js") }}" type="text/javascript"></script>
    <script type="text/javascript">

        $(function () {
            $('#start_datetimepicker').datetimepicker({
                showClear: true,
                showClose: true,
                locale: 'es',
                format: 'YYYY-MM-DD'

            });
            $('#end_datetimepicker').datetimepicker({
                useCurrent: false,
                showClear: true,
                showClose: true,
                locale: 'es',
                format: 'YYYY-MM-DD'

            });
            $("#start_datetimepicker").on("dp.change", function (e) {
                $('#end_datetimepicker').data("DateTimePicker").minDate(e.date);

            });
            $("#end_datetimepicker").on("dp.change", function (e) {
                $('#start_datetimepicker').data("DateTimePicker").maxDate(e.date);
            });
        });

        var table = $('#tasks_table').DataTable({
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
                $('#tasks_table').fadeIn();
            }
        });

        $(".chosen-area").chosen({
//            disable_search_threshold: 10,
            no_results_text: "No encontrado!",
            width: "200px",
            placeholder_text_multiple: "Seleccione areas",
            search_contains:true
        });


    </script>
@endsection