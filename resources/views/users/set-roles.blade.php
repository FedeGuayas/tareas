@extends('layouts.dashboard')

@section('page_heading', 'Accesos del usuario '.$nombre.'')

@section('section')


    <div class="row">
        <div class="col l12 m12 s12">
            {!! Form::open(['route'=>'admin.users.setroles', 'method'=>'POST']) !!}
            {!! Form::hidden('user_id',$user->id) !!}
            <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                <thead>
                    <th>Id</th>
                    <th>Add/Rem</th>
                    <th>Rol</th>
                    <th>Descripcion</th>
                    <th>Permiso</th>
                </thead>
                @foreach ($roles as $rol)
                    <tr>
                        <td>{{ $rol->id }}</td>
                        <td>{!! Form::checkbox('roles[]',$rol->id,null,['id'=>$rol->id]) !!}
                            {!! Form::label($rol->id, $rol->name) !!}
                        <td>{{ $rol->display_name }}</td>
                        <td>{{ $rol->description }}</td>
                        <td>@foreach($rol->perms as $perm)
                            {{ $perm->display_name }}<br>
                                @endforeach
                        </td>

                    </tr>
                @endforeach
            </table><!--end table-responsive-->
            {!! Form::button('Otorgar<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
            {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
            <a href="{{ route('admin.users.index') }}"  class="tooltipped" data-position="top" data-delay="50" data-tooltip="Regresar">
                {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
            </a>
            {!! Form::open() !!}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->


@endsection

