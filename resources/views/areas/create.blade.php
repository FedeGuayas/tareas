@extends ('layouts.dashboard')
@section('page_heading','Crear Area')

@section('section')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-6">
                {!! Form::open(['route'=>'admin.areas.store', 'method'=>'POST','role'=>'form']) !!}


                    <div class="form-group">
                        {!! Form::label('area','Nombre del Area') !!}
                        {!! Form::text('area',null,['class'=>'form-control','placeholder'=>'Area...']) !!}
                        <p class="help-block">Ejemplo: Crear este sistema</p>

                    </div>
                    <div class="form-group">
                        {!! Form::label('description','Descripción') !!}
                        {!! Form::textarea('description',null,['class'=>'form-control','placeholder'=>'Descripción... puede dejarlo vacio','rows'=>'3']) !!}
                    </div>

                    {!! Form::submit('Crear!',['class'=>'btn btn-primary']) !!}
                    {!! Form::reset('Limpias!',['class'=>'btn btn-danger']) !!}
                    {{--<button type="reset" class="btn btn-danger">Limpiar</button>--}}

                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection