@extends ('layouts.plane')
@section ('body')
<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
            <br /><br /><br />
               {{--@section ('login_panel_title','Please Sign In')--}}
               {{--@section ('login_panel_body')--}}
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Acceder al sistema</h3>
                        @include('alert.success')
                        {{--Para la act por email--}}
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('warning'))
                            <div class="alert alert-warning">
                                {{ session('warning') }}
                            </div>
                        @endif
                        {{--end act x email--}}

                    </div>
                    <div class="panel-body">
                        {!! Form::open(['url'=>'/login','method'=>'POST','role'=>'form']) !!}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Correo','autofocus']) !!}
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                {!! Form::password('password',['class'=>'form-control','placeholder'=>'Contraseña']) !!}
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-inline">
                                <div class="form-group">
                                    {!! Form::checkbox('remember',null) !!}
                                    {!! Form::label('remember','Recordarme') !!}
                                </div>
                            </div>
                    </div>
                    <div class="panel-footer">


                        {!! Form::button('<i class="fa fa-sign-in fa-fw"></i>Entrar',['class'=>'btn btn-primary pull-left','type'=>'submit']) !!}
                        {!! Form::close() !!}
                        <a class="btn btn-link pull-right" href="{{ url('/password/reset') }}">Olvide mi contraseña</a><br>
                        <div class="clearfix"></div>
                    </div>

                </div>
        </div>
    </div>
</div>
@endsection