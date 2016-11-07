{!! Form::open (['route' => 'admin.tasks.excel','method' => 'GET'])!!}
        <div class="hidden">
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
            {{--<div class="col-sm-3">--}}
                {{--<div class="form-group">--}}
                    {{--{!! Form::label('buscar','Buscar') !!}--}}
                    {{--<div class="input-group">--}}
                        {{--{!! Form::select('trabajador',$trabajadores,$trabajador,['placeholder'=>'Seleccione trabajador','class'=>'form-control','id'=>'trabajador']) !!}--}}
                     {{--</div><!-- /input-group -->--}}
                {{--</div>--}}
            {{--</div><!-- /.col-lg-3 -->--}}
            {{--<div class="col-sm-3">--}}

            </div>
        </div>
    {!! Form::submit('Exp-XLS',['class'=>'btn  btn-success pull-right']) !!}
{!! Form::close() !!}