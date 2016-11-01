@extends('layouts.dashboard')

@section('page_heading','Listado Roles')

@section('section')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Listado de Roles</h4>
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="">
                <a href="{{route('admin.roles.create')}}">
                    {!! Form::button('<i class="fa fa-plus fa-fw"></i>Crear',['class'=>'btn btn-success']) !!}
                </a>
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Rol</th>
                    <th>Descripción</th>
                    <th>Permisos</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($roles as $rol)
                        <tr>
                            <td>{{ $rol->id }}</td>
                            <td>{{ $rol->display_name }}</td>
                            <td>{{ $rol->description }}</td>
                            <td>
                                @foreach($rol->perms as $per)
                                    {{ $per->display_name }}<br>
                                @endforeach
                            </td>

                            <td>
                                {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'btn btn-xs btn-danger','data-target'=>"modal-delete-$rol->id"])!!}
                                <a href="{{ route('admin.roles.edit', $rol->id ) }}">
                                    {!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn btn-xs btn-primary']) !!}
                                </a>
                                <a href="{{ route('admin.roles.show', $rol->id ) }}">
                                    {!! Form::button('<i class="fa fa-eye fa-fw"></i>',['class'=>'btn btn-xs btn-info']) !!}
                                </a>
                                <a href="{{ route('admin.roles.permisos',$rol->id  ) }}">
                                    {!! Form::button('<i class="fa fa-key fa-fw"></i>',['class'=>'btn btn-xs btn-success']) !!}
                                </a>

                            </td>
                        </tr>
                        @include ('roles.modal')
                    @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection