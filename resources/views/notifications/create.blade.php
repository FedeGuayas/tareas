@extends ('layouts.dashboard')
@section('page_heading','Crear Categoria de Notificación')

@section('section')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-6">
                {!! Form::open(['route'=>'admin.notifications.store', 'method'=>'POST','role'=>'form']) !!}
                    <div class="form-group">
                        {!! Form::label('name','Nombre de la Notificación') !!}
                        {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'user.follow']) !!}

                    </div>
                    <div class="form-group">
                        {!! Form::label('text','Contenido de la notificacion') !!}
                        {!! Form::textarea('text',null,['class'=>'form-control','placeholder'=>'Hola {to.name}, {from.name} es tu seguidor ahora....','rows'=>'3']) !!}
                    </div>
                    {!! Form::submit('Crear',['class'=>'btn btn-success','type'=>'button']) !!}
                    {!! Form::reset('Limpiar',['class'=>'btn btn-warning']) !!}
                <a href="{{route('admin.notifications.index')}}" >
                {!! Form::button('Regresar',['class'=>'btn btn-primary']) !!}
                </a>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection