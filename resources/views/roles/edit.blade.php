@extends('layouts.dashboard')

@section('page_heading', 'Editar Rol')

@section('section')

    <div class="row">
        {!! Form::model($rol,['route'=>['admin.roles.update',$rol->id], 'method'=>'PUT'])  !!}
        {!! Form::open(['route'=>'admin.roles.store', 'method'=>'POST'])  !!}

        <div class="col-lg-10 col-md-8 col-sm-12">
            <div class="form-horizontal">

                <div class="form-group">
                    {!! Form::label('name','Nombre del rol:',['class'=>'control-label col-sm-2']) !!}
                    <div class="col-lg-6">
                        {!! Form::text('name',null,['class'=>'form-control','placeholder'=>' Ejemplo: "administrador", "gestor"']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('display_name','Nombre a mostrar:',['class'=>'control-label col-lg-2']) !!}
                    <div class="col-lg-6">
                        {!! Form::text('display_name',null,['class'=>'form-control','placeholder'=>' Ejemplo: "Gestor de tareas", "Usuario registrado",']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('description','Descripción',['class'=>'control-label col-lg-2']) !!}
                    <div class="col-lg-6">
                        {!! Form::textarea('description',null,['class'=>'form-control','rows'=>'3']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">

                        {!! Form::button('<i class="fa fa-check fa-fw" aria-hidden="true"></i>Editar', ['class'=>'btn btn-success','type' => 'submit']) !!}
                        {!! Form::button('<i class="fa fa-close fa-fw" aria-hidden="true"></i>Cancelar',['class'=>'btn btn-warning','type' => 'reset']) !!}

                    </div>
                </div>
            </div>


        </div>

        {!! Form::close() !!}
    </div>


@endsection