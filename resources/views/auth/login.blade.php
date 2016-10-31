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
                    {!! Form::open(['url'=>'/login','method'=>'POST','role'=>'form']) !!}
                    <div class="panel-body">
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

                        {!! Form::button('<i class="fa fa-sign-in fa-fw"></i>Entrar',['class'=>'btn btn-success pull-right','type'=>'submit']) !!}
                        <div class="clearfix"></div>
                    </div>
                    {!! Form::close() !!}
                </div>








                    {{--<form role="form">--}}
                        {{--<fieldset>--}}
                            {{--<div class="form-group">--}}
                                {{--<input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<input class="form-control" placeholder="Password" name="password" type="password" value="">--}}
                            {{--</div>--}}
                            {{--<div class="checkbox">--}}
                                {{--<label>--}}
                                    {{--<input name="remember" type="checkbox" value="Remember Me">Remember Me--}}
                                {{--</label>--}}
                            {{--</div>--}}
                            {{--<!-- Change this to a button or input when using this as a form -->--}}
                            {{--<a href="{{ url ('') }}" class="btn btn-lg btn-success btn-block">Login</a>--}}
                        {{--</fieldset>--}}
                    {{--</form>--}}

                    

                {{--@include('widgets.panel', array('as'=>'backup.login', 'header'=>true))--}}
            </div>
        </div>
    </div>
@endsection