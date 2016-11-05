@extends ('layouts.dashboard')
@section('page_heading','Editar Trabajador')

@section('section')
    <div class="col-sm-12">
        <div class="row">

                {!! Form::model($user,['route'=>['admin.users.update',$user->id], 'method'=>'PUT','role'=>'form']) !!}

                <div class="col-lg-6 col-md-6 col-sm-12 col-lg-offset-1">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="form-inline">
                                {!! Form::label('first_name','Nombre:') !!}
                                {!! Form::text('first_name',null,['class'=>'form-control','placeholder'=>'Nombres','required']) !!}
                                {!! Form::text('last_name',null,['class'=>'form-control','placeholder'=>'Apellidos','required']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-inline">
                                <div class="form-group">
                                    {!! Form::label('phone','Teléfono:') !!}
                                    {!! Form::text('phone',null,['class'=>'form-control','placeholder'=>'Teléfono']) !!}
                                    <div class="input-group">
                                        <span class="input-group-addon" id="email-add">@</span>
                                        {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'correo@ejemplo.com','aria-describedby'=>'email-add']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-inline">
                                {!! Form::label('area_id','Area:') !!}
                                {!! Form::select('area_id',$areas,$user->area_id,['class'=>'form-control','placeholder'=>'Seleccione el area...','required']) !!}
                            </div>
                        </div>
                        <div class="form-group pull-right">
                            <div class="clerafix"></div>
                            {!! Form::submit('Editar',['class'=>'btn btn-warning','type'=>'button']) !!}
                            {!! Form::reset('Cancelar',['class'=>'btn btn-success']) !!}
                            <a href="{{route('admin.users.index')}}">
                                {!! Form::button('Regresar',['class'=>'btn btn-primary']) !!}
                            </a>

                        </div>
                    </div>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection