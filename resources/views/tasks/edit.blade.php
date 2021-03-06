@extends('layouts.dashboard')

@section('page_heading','Editar Tarea')
@section('section')

    <div class="col-sm-12">
        <div class="row">
            @include('alert.success')
            @include('alert.request')
            <div class="col-sm-6">
                {!! Form::model($task,['route'=>['admin.tasks.update',$task], 'method'=>'PUT','role'=>'form']) !!}
                <div class="form-group">
                    <div class="form-group">
                        {!! Form::label('task','Tarea:') !!}
                        {!! Form::text('task',null,['class'=>'form-control','placeholder'=>'Nombre de la tarea','required']) !!}
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
                                <input type="checkbox" name="repeats" id="repeats" value="1" disabled> Tarea recurrente
                            </label>
                        </div>
                        <div id="repeat-options col-lg-4" >
                            {{--<label class="radio-inline">--}}
                            {{--<input type="radio" value="1" name="repeat-freq" id="1" align="bottom" disabled> diario--}}
                            {{--</label>--}}
                            <label class="radio-inline">
                                <input type="radio" value="7" name="repeat-freq" align="bottom" disabled> semana
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
                            {!! Form::select('area_id',$areas,null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('user_id','Trabajador:') !!}
{{--                            {!! Form::select('user_id',[$task->user_id=>$task->user->getFullNameAttribute()],null,['class'=>'form-control']) !!}--}}
{{--                            {!! Form::select('user_id[]',[$task->users=>$task->user->getFullNameAttribute()],null,['class'=>'form-control chosen-trabajador','id'=>'user_id', 'multiple'=>'multiple']) !!}--}}
                            {!! Form::select('user_id[]',$users,null,['class'=>'form-control chosen-trabajador','id'=>'user_id', 'multiple'=>'multiple']) !!}
                        </div>
                    </div>
                </div>


                <div class="pull-right">
                    <div class="clearfix"></div>
                    <br>
                    {!! Form::submit('Editar',['class'=>'btn btn-success','type'=>'button']) !!}
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
    {{--<script src="{{ asset("assets/scripts/dropdown.js") }}" type="text/javascript"></script>--}}

    <script type="text/javascript">
        $(function () {
            $('#start_day_datetimepicker').datetimepicker({
                daysOfWeekDisabled: [0, 6],
                showClear:true,
                showClose:true,
                useCurrent: false,
                locale:'es',
                format:'YYYY-MM-DD 09:00:00'

            });
            $('#performance_day_datetimepicker').datetimepicker({
                daysOfWeekDisabled: [0, 6],
                showClear:true,
                showClose:true,
                useCurrent: false, //Important! See issue #1075
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

        $("#area_id").change(function(event){
            $.get("/users/"+event.target.value+"",function(response,state){
                // console.log(response);
                $("#user_id").empty();
                for (i=0; i<response.length; i++){
                    $("#user_id").append("<option value='"+response[i].id+"'>"+response[i].first_name+' ' +response[i].last_name+"</option>");
                }
                $("#user_id").trigger("chosen:updated");//estas dos lineas son solo para actualizar el choosen js
                $("#user_id").trigger("liszt:updated");
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