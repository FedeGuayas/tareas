@extends('layouts.plane')

<!-- Main Content -->
@section('body')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-2"><br><br><br>
            <div class="panel panel-warning">
                <div class="panel-heading">Restablecer Contraseña</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Su E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-lg-offset-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-envelope"></i> Link reestablecer contraseña
                                </button>

    <a href="{{url('login')}}">
        {!! Form::button('<i class="fa fa-undo fa-fw"></i>Login',['class'=>'btn btn-primary pull-right']) !!}
    </a>
                                <div class="clearfix"></div>


                            </div>



                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection