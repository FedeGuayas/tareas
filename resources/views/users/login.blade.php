@extends ('layouts.plane')
@section ('body')
<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
            <br /><br /><br />
               @section ('login_panel_title','Please Sign In')
               @section ('login_panel_body')
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
                                {{--<a href="{{ route ('/home') }}" class="btn btn-lg btn-success btn-block">Login</a>--}}
                            {{--</fieldset>--}}
                        {{--</form>--}}

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p>
                                    {{$error}}
                                </p>
                            @endforeach
                        </div>
                    @endif
                    <ul class="list-inline intro-social-buttons">
                        <li>
                            {!! Form::open(['route'=>'user.signin','method'=>'POST','role'=>'form']) !!}
                            <fieldset>
                            <div class="form-group">
                                {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Correo','autofocus']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::password('password',['class'=>'form-control','placeholder'=>'Contraseña']) !!}
                            </div>
                            <div class="form-inline">
                                <div class="form-group">
                                    {!! Form::checkbox('remember',null) !!}
                                    {!! Form::label('remember','Recordarme') !!}
                                </div>
                            </div>
                            {!! Form::button('<i class="fa fa-sign-in fa-fw"></i>Entrar',['class'=>'btn btn-success btn-lg','type'=>'submit']) !!}
                            </fieldset>
                            {!! Form::close() !!}
                        </li>

                    </ul>
                    
                @endsection
                @include('widgets.panel', array('as'=>'backup.login', 'header'=>true))
            </div>
        </div>
    </div>
@stop