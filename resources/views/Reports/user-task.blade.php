@extends ('layouts.dashboard')
@section('page_heading','Reportes Usuarios')

@section('section')

    <div class="col-sm-12">

        <div class="row">
            {!! Form::open (['route' => 'admin.tasks.reports.users','method' => 'GET' ])!!}
            <div class='col-sm-2'>
                <div class="form-group">
                    {!! Form::label('start','Desde') !!}
                    <div class='input-group date' id='start_datetimepicker'>
                        {!! Form::text('start',$start,['class'=>'form-control']) !!}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class='col-sm-2'>
                <div class="form-group">
                    {!! Form::label('end','Hasta') !!}
                    <div class='input-group date' id='end_datetimepicker'>
                        {!! Form::text('end',$end,['class'=>'form-control']) !!}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    {!! Form::label('buscar','Buscar') !!}
                    <div class="input-group">
                        {!! Form::select('trabajador',$trabajadores,$trabajador,['placeholder'=>'Seleccione trabajador','class'=>'form-control','id'=>'trabajador']) !!}
                    </div><!-- /input-group -->
                </div>
            </div><!-- /.col-lg-3 -->
            <div class="col-sm-3">
                {!! Form::submit('Buscar',['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}

            <div class="col-sm-3">
                <div class="form-group pull-right">

                    {!! Form::open (['route' => 'admin.tasks.reports.users.excel','method' => 'GET'])!!}
                    <div class="hidden">
                        <div class='col-sm-2'>
                            <div class="form-group">
                                {!! Form::label('start','Desde') !!}
                                <div class='input-group date' id='start_datetimepicker'>
                                    {!! Form::text('start',$start,['class'=>'form-control']) !!}
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                                </div>
                            </div>
                        </div>
                        <div class='col-sm-2'>
                            <div class="form-group">
                                {!! Form::label('end','Hasta') !!}
                                <div class='input-group date' id='end_datetimepicker'>
                                    {!! Form::text('end',$end,['class'=>'form-control']) !!}
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::label('buscar','Buscar') !!}
                                <div class="input-group">
                                    {!! Form::select('trabajador',$trabajadores,$trabajador,['placeholder'=>'Seleccione trabajador','class'=>'form-control','id'=>'trabajador']) !!}
                                </div><!-- /input-group -->
                            </div>
                        </div><!-- /.col-lg-3 -->
                    </div>

                </div>
                {!! Form::submit('Exp-XLS',['class'=>'btn  btn-success pull-right']) !!}
                {!! Form::close() !!}
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">
                <table id="tasks_table" class="table table-striped table-bordered" cellspacing="0" width="100%"
                       data-order='[[ 1, "asc" ]]' style="display: none">
                    <thead>
                    <tr>
                        <th>Area</th>
                        <th>Tareas</th>
                        <th>Cumplidas</th>
                        <th>Sin cumplir</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Area</th>
                        <th>Tareas</th>
                        <th>Cumplidas</th>
                        <th>Sin cumplir</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    {{--@foreach($user as $user)--}}
                    @if(!$user==0)
                        <tr>
                            <td>
                                {{$user->area->area}}
                            </td>
                            <td>
                                @foreach ($tareas as $task)
                                    >> {{ $task->task}}<br>
                                @endforeach
                            </td>
                            <td>{{$cumplidas}}</td>
                            <td>{{$incumplidas}}</td>

                        </tr>
                        {{--@endforeach--}}
                    @endif
                    </tbody>
                </table>
            </div>

        </div>

    </div>

@endsection

@section('script')

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


        $(function () {
            $("#search").click(function () {

                var token = document.getElementsByName("_token")[0].value;
                var start = $("#start").val(); //aaaa-mm-dd
                var end = $("#end").val();
                var trabajador = $("#trabajador option:selected").val();//id del trabajador
                var datos = {
                    start: start,
                    end: end,
                    trabajador: trabajador
                };

                var route = "{{route('admin.tasks.reports.users')}}";

                $.ajax({
                    url: route,
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': token},
                    contentType: 'application/x-www-form-urlencoded',
                    data: {start: start, end: end, trabajador: trabajador},
//                data: datos,
                    success: function (data) {
                        console.log(data)
                        $("#list-user").empty().html(data);
                    },
                    error: function (data) {
                        console.log('data')
                    }
                });
            });

            {{--$("#export-exel").click(function(){--}}
            {{--var token = document.getElementsByName("_token")[0].value;--}}
            {{--var start=$("#start").val();--}}
            {{--var end=$("#end").val( );--}}
            {{--var trabajador = $("#trabajador option:selected").val();--}}
            {{--var datos={--}}
            {{--start:start,--}}
            {{--end:end,--}}
            {{--trabajador:trabajador--}}
            {{--};--}}

            {{--var route= "{{route('admin.tasks.reports.users.excel')}}";--}}
            {{--$.ajax({--}}
            {{--url: route,--}}
            {{--type: "GET",--}}
            {{--headers: {'X-CSRF-TOKEN': token},--}}
            {{--contentType: 'application/x-www-form-urlencoded',--}}
            {{--data: { start:start, end:end, trabajador:trabajador},--}}
            {{--success: function(data) {--}}
            {{--$("#list-user").empty().html(data);--}}
            {{--},--}}
            {{--error: function(data){--}}

            {{--}--}}
            {{--});--}}
            //        });

        });

    </script>
@endsection