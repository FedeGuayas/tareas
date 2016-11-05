@extends ('layouts.dashboard')
@section('page_heading','Editar Categoria de Notificación')

@section('section')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-6">
                @include('alert.request')
                {!! Form::model($notification,['route'=>['admin.notifications.update',$notification->id], 'method'=>'PUT', 'role'=>'form']) !!}
                <div class="form-group">
                    {!! Form::label('name','Nombre de la Notificación') !!}
                    {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'user.follow']) !!}

                </div>
                <div class="form-group">
                    {!! Form::label('text','Contenido de la notificacion') !!}
                    {!! Form::textarea('text',null,['class'=>'form-control','placeholder'=>'Hola {to.name}, {from.name} es tu seguidor ahora....','rows'=>'3']) !!}
                </div>
                {!! Form::submit('Editar',['class'=>'btn btn-success','type'=>'button']) !!}
                {!! Form::reset('Limpiar',['class'=>'btn btn-danger']) !!}

                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection