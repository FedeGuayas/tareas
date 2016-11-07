@extends ('layouts.dashboard')
@section('page_heading','Reportes Usuarios')

@section('section')

    <div class="col-sm-12">

        <div class="row">
            {!! Form::open (['id'=>'formSearch'])!!}
            <div class='col-sm-3'>
                <div class="form-group">
                    {!! Form::label('start','Desde') !!}
                    <div class='input-group date' id='start_datetimepicker'>
                        {!! Form::text('start',$start,['class'=>'form-control']) !!}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class='col-sm-3'>
                <div class="form-group">
                    {!! Form::label('end','Hasta') !!}
                    <div class='input-group date' id='end_datetimepicker'>
                        {!! Form::text('end',$end,['class'=>'form-control']) !!}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('buscar','Buscar') !!}
                <div class="input-group">
                    {!! Form::select('trabajador',$trabajadores,$trabajador,['placeholder'=>'Seleccione trabajador','class'=>'form-control','id'=>'trabajador']) !!}
                    <span class="input-group-btn">
                        <a href="#!" id="search" class="btn btn-primary" title="Buscar"><i class="fa fa-search" aria-hidden="true"></i>
                        </a>
                    </span>
                </div><!-- /input-group -->
                    </div>
            </div><!-- /.col-lg-3 -->
            <div class="col-sm-3">
                <div class="form-group pull-right">
{{--                    {!! Form::label('export','Exportar') !!}--}}
                    <div >

                        {{--<a href="{{route('admin.tasks.reports.users.excel')}}"  class="btn btn-success" title="exportar"><i class="fa fa-file-excel-o" aria-hidden="true"></i>--}}
                        {{--</a>--}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div id="list-user"></div>
            </div>

            {!! Form::close() !!}
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

        $(function () {
        $("#search").click(function(){

            var token = document.getElementsByName("_token")[0].value;
            var start=$("#start").val();
            var end=$("#end").val( );
            var trabajador = $("#trabajador option:selected").val();
            var datos={
                start:start,
                end:end,
                trabajador:trabajador
            };
            var route= "{{route('admin.tasks.reports.users')}}";
            $.ajax({
                url: route,
                type: "POST",
                headers: {'X-CSRF-TOKEN': token},
                contentType: 'application/x-www-form-urlencoded',
                data: { start:start, end:end, trabajador:trabajador},
                success: function(data) {
                    $("#list-user").empty().html(data);
                },
                error: function(data){

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