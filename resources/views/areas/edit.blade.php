@extends ('layouts.dashboard')
@section('page_heading','Editar Area')

@section('section')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-6">
                @include('alert.request')
                {!! Form::model($area,['route'=>['admin.areas.update',$area->id], 'method'=>'PUT', 'role'=>'form']) !!}
                <div class="form-group">
                    {!! Form::label('area','Nombre del Area') !!}
                    {!! Form::text('area',null,['class'=>'form-control','placeholder'=>'Area...']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('description','Descripción') !!}
                    {!! Form::textarea('description',null,['class'=>'form-control','placeholder'=>'Descripción... puede dejarlo vacio','rows'=>'3']) !!}
                </div>
                {!! Form::submit('Actualizar',['class'=>'btn btn-success','type'=>'button']) !!}
                {!! Form::reset('Cancelar',['class'=>'btn btn-danger']) !!}
                <a href="{{route('admin.areas.index')}}" >
                    {!! Form::button('Regresar',['class'=>'btn btn-primary']) !!}
                </a>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection