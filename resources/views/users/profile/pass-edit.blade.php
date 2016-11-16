@extends ('layouts.dashboard')
@section('page_heading','Cambiar Contraseña')

@section('section')
    <div class="col-sm-12">
        <div class="row">
            {!! Form::model($user,['route'=>['user.password.update',$user], 'method'=>'PUT','role'=>'form']) !!}
            <div class="col-lg-4 col-md-6 col-sm-12 col-lg-offset-1">
                @include('alert.success')
                @include('alert.request')
                <div class="form-group">
                    {!! form::label('password','Contraseña anterior:*') !!}
                    {!! Form::password('password',['class'=>'form-control', 'placeholder'=>'******']) !!}
                </div>
                <div class="form-group">
                    {!! form::label('password_new','Nueva contraseña:') !!}
                    {!! Form::password('password_new',['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! form::label('password_new','Confirmar contraseña:') !!}
                    {!! Form::password('password_new_confirmation',['class'=>'form-control']) !!}
                </div>
                <div class="form-group pull-right">
                    <div class="clerafix"></div>
                    {!! Form::submit('Actualizar',['class'=>'btn btn-warning','type'=>'button']) !!}
                    {!! Form::reset('Cancelar',['class'=>'btn btn-success']) !!}
                    <a href="{{route('user.profile')}}">
                        {!! Form::button('Regresar',['class'=>'btn btn-primary']) !!}
                    </a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection