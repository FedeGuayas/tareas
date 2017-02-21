{!! Form::open (['route' => 'admin.tasks.excel','method' => 'GET'])!!}
        <div class="hidden">
            <div class='input-group date' id='start_datetimepicker'>
                {!! Form::text('start',$start,['class'=>'form-control']) !!}
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>

            <div class='input-group date' id='end_datetimepicker'>
                {!! Form::text('end',$end,['class'=>'form-control']) !!}
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>

            <div class="input-group">
                {!! Form::select('area',$areas,$area,['placeholder'=>'Seleccione area','class'=>'form-control','id'=>'area']) !!}
            </div><!-- /input-group -->
        </div>
    {!! Form::submit('Exp-XLS',['class'=>'btn  btn-success pull-right']) !!}
{!! Form::close() !!}