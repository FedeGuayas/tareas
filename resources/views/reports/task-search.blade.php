{!! Form::open (['route' => 'admin.reports.index','method' => 'GET' ])!!}
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

<div class="col-sm-2">
    <div class="form-group">
        {!! Form::label('buscar','Buscar') !!}
        <div class="input-group">
            {!! Form::select('areas_id[]',$areas,$areasID,['class'=>'form-control chosen-area','id'=>'areas_id', 'multiple'=>'multiple','data-placeholder'=>'Seleccione areas']) !!}

            {{--{!! Form::select('area',$areas,$area,['placeholder'=>'Seleccione area','class'=>'form-control','id'=>'area']) !!}--}}
        </div><!-- /input-group -->
    </div>
</div><!-- /.col-lg-3 -->

{{--<div class="clearfix"></div>--}}
<div class="col-sm-2">
{!! Form::submit('Buscar',['class'=>'btn btn-primary']) !!}
</div>
{{--<div class="col-sm-3">--}}

{{--</div><!-- /.col-lg-3 -->--}}

{{--<div class="col-sm-3">--}}
    {{--<div class="form-group">--}}
        {{--{!! Form::label('buscar','Buscar') !!}--}}
        {{--<div class="input-group">--}}
            {{--{!! Form::select('trabajador',$trabajadores,$trabajador,['placeholder'=>'Seleccione trabajador','class'=>'form-control','id'=>'trabajador']) !!}--}}
                    {{--<span class="input-group-btn">--}}
                        {{--<a href=""  class="btn btn-primary" title="Buscar"><i class="fa fa-search" aria-hidden="true"></i>--}}
                            {{--{!! Form::submit('Buscar',['class'=>'btn btn-primary']) !!}--}}
                        {{--</a>--}}
                    {{--</span>--}}
        {{--</div><!-- /input-group -->--}}
    {{--</div>--}}
{{--</div><!-- /.col-lg-3 -->--}}
{!!form::close()!!}
