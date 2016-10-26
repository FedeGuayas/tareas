@extends('layouts.dashboard')

@section('page_heading','Tareas')
@section('section')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                {!! Form::open(['route'=>'admin.tasks.store', 'method'=>'POST','role'=>'form']) !!}
                {{--//        '', '', '','','end_day','state','area_id','person_id','allDay','color'--}}
                <div class="form-group">
                    <div class="form-group">
                        {!! Form::label('task','Tarea:') !!}
                        {!! Form::text('task',null,['class'=>'form-control','placeholder'=>'Nombre de la tarea','required']) !!}
                        <p class="help-block">Ejemplo: Crear este sistema</p>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('description','Descripción') !!}
                    {!! Form::textarea('description',null,['class'=>'form-control','placeholder'=>'Breve descripción... puede dejarlo vacio','rows'=>'3']) !!}
                </div>

                <div class="container">
                    <div class='col-sm-3'>
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
                    <div class='col-sm-3'>
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


                <div class="col-sm-6">
                <div class="form-group">
                {!! Form::label('area_id','Area:') !!}
                {!! Form::select('area_id',$areas,null,['class'=>'form-control','placeholder'=>'Seleccione area']) !!}
                </div>
                </div>

                <div class="col-sm-6">
                <div class="form-group">
                {!! Form::label('person_id','Trabajador:') !!}
                {!! Form::select('person_id',['placeholder'=>'Seleccione trabajador'],null,['class'=>'form-control']) !!}
                </div>
                </div>



                {{--<div class="col-sm-6">--}}
                    {{--<div class="form-group">--}}
                        {{--{!! Form::label('area_id','Area:') !!}--}}
                        {{--{!! Form::select('area_id',$areas,null,['class'=>'form-control','placeholder'=>'Seleccione el area...','required']) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="col-sm-6">--}}
                    {{--<div class="form-group">--}}
                        {{--{!! Form::label('person_id','Trabajador:') !!}--}}
                        {{--{!! Form::select('person_id',$persons,null,['class'=>'form-control','placeholder'=>'Seleccione el trabajador...','required']) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}


                {!! Form::submit('Crear',['class'=>'btn btn-success','type'=>'button']) !!}

                {!! Form::reset('Limpiar',['class'=>'btn btn-danger']) !!}
                {{--<a href="#" >--}}
                {{--{!! Form::button('Truncate',['class'=>'btn btn-danger']) !!}--}}
                {{--</a>--}}

                {!! Form::close() !!}

            </div>
        </div>
    </div>


@endsection

@section('script')

    {{--Script para select condicional dropdown de personas por areas--}}
    <script src="{{ asset("assets/scripts/dropdown.js") }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(function () {
            $('#start_day_datetimepicker').datetimepicker({
                locale:'es'
            });
            $('#performance_day_datetimepicker').datetimepicker({
                useCurrent: false, //Important! See issue #1075
                locale:'es'

            });
            $("#start_day_datetimepicker").on("dp.change", function (e) {
                $('#performance_day_datetimepicker').data("DateTimePicker").minDate(e.date);

            });
            $("#performance_day_datetimepicker").on("dp.change", function (e) {
                $('#start_day_datetimepicker').data("DateTimePicker").maxDate(e.date);
            });
        });
    </script>


@endsection