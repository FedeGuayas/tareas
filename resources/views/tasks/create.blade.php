@extends('layouts.dashboard')

@section('style')
    <link rel="stylesheet" href="{{ asset("plugins/choosenjs/chosen.min.css") }}" />
@endsection

@section('page_heading','Crear Tarea')


@section('section')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                @include('alert.request')
                @include('alert.success')
                {!! Form::open(['route'=>'admin.tasks.store', 'method'=>'POST','role'=>'form', 'id'=>'add-event-form']) !!}
                <div class="form-group">
                    <div class="form-group">
                        {!! Form::label('task','Tarea:') !!}
                        {!! Form::text('task',null,['class'=>'form-control','placeholder'=>'Nombre de la tarea','required']) !!}
                        <p class="help-block">Ejemplo: Crear manual de usuario</p>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('description','Descripción') !!}
                    {!! Form::textarea('description',null,['class'=>'form-control','placeholder'=>'Breve descripción... puede dejarlo vacio','rows'=>'3']) !!}
                </div>

                <div class="row">
                    <div class='col-sm-6'>
                        <div class="form-group">
                            {!! Form::label('start_day','Dia inicio') !!}
                            <div class='input-group date' id='start_day_datetimepicker'>
                                {!! Form::text('start_day',null,['class'=>'form-control','required']) !!}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-6'>
                        <div class="form-group">
                            {!! Form::label('performance_day','Dia de termino') !!}
                            <div class='input-group date' id='performance_day_datetimepicker'>
                                {!! Form::text('performance_day',null,['class'=>'form-control','required']) !!}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-inline">
                        <div class="checkbox col-lg-4">
                            <label>
                                <input type="checkbox" name="repeats" id="repeats" value="1"> Tarea recurrente
                            </label>
                        </div>
                        <div id="repeat-options col-lg-4" >
                            {{--<label class="radio-inline">--}}
                                {{--<input type="radio" value="1" name="repeat-freq" id="1" align="bottom" disabled> diario--}}
                            {{--</label>--}}
                            <label class="radio-inline">
                                <input type="radio" value="7" name="repeat-freq" align="bottom" disabled> semanal
                            </label>
                            <label class="radio-inline">
                                <input type="radio" value="30" name="repeat-freq" align="bottom" disabled> mensual
                            </label>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('area_id','Area:') !!}
                            {!! Form::select('area_id',$areas,null,['class'=>'form-control','placeholder'=>'Seleccione area']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('user_id','Trabajador:') !!}
                            {{--<select data-placeholder="Seleccione trabajador..." style="width:350px;" multiple class="chosen-select" id="user_id"></select>--}}
                            {!! Form::select('user_id[]',['placelholder'=>'Seleccione trabajadores'],null,['class'=>'form-control chosen-trabajador','id'=>'user_id', 'multiple'=>'multiple']) !!}
                        </div>
                    </div>
                </div>


<div class="pull-right">
    <div class="clearfix"></div>
    <br>
    {!! Form::submit('Crear',['class'=>'btn btn-success','type'=>'button']) !!}
    {!! Form::reset('Limpiar',['class'=>'btn btn-danger']) !!}
    <a href="{{route('admin.tasks.index')}}" >
        {!! Form::button('Regresar',['class'=>'btn btn-primary']) !!}
    </a>
</div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>


@endsection

@section('script')

    {{--Script para select condicional dropdown de personas por areas--}}

    <script src="{{ asset("assets/scripts/dropdown.js") }}" type="text/javascript"></script>
    <script src="{{ asset("plugins/choosenjs/chosen.jquery.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset("plugins/choosenjs/chosen.proto.min.js") }}" type="text/javascript"></script>


    <script type="text/javascript">
        $(function () {
            $('#start_day_datetimepicker').datetimepicker({
                daysOfWeekDisabled: [0, 6],
                showClear:true,
                showClose:true,
                minDate: moment(),
//                disabledTimeIntervals:[],
//                enabledHours: [9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                locale:'es',
                format:'YYYY-MM-DD 09:00:00'


            });
            $('#performance_day_datetimepicker').datetimepicker({
                daysOfWeekDisabled: [0, 6],
                showClear:true,
                showClose:true,
                useCurrent: false, //Important! See issue #1075
//                enabledHours: [9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
                locale:'es',
                format:'YYYY-MM-DD 18:00:00'

            });
            $("#start_day_datetimepicker").on("dp.change", function (e) {
                $('#performance_day_datetimepicker').data("DateTimePicker").minDate(e.date);

            });
            $("#performance_day_datetimepicker").on("dp.change", function (e) {
                $('#start_day_datetimepicker').data("DateTimePicker").maxDate(e.date);
            });


            $("#repeats").on('click',function(){
                if($("#repeats").prop("checked")){
                    $("input[type=radio][name=repeat-freq]").prop("disabled", false);
                }else{
                    $("input[type=radio][name=repeat-freq]").prop("disabled",true);
                    $("input[type=radio][name=repeat-freq]").prop("checked",false);
                }

            });

        });

        $(".chosen-trabajador").chosen({
//            disable_search_threshold: 10,
            no_results_text: "No encontrado!",
            width: "95%",
            placeholder_text_multiple: "Seleccione trabajadores",
            search_contains:true
        });

    </script>


@endsection