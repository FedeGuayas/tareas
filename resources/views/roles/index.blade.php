@extends('layouts.dashboard')

@section('page_heading','Listado Permisos')

@section('section')

    <div class="row">
        <div class="col-lg-8">
            @include('alert.success')
            <h4>Listado de Roles</h4>
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="">
                <a href="{{route('admin.roles.create')}}">
                    {!! Form::button('<i class="fa fa-plus" ></i>',['class'=>'btn waves-effect waves-light']) !!}
                </a>
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Rol</th>
                    <th>Nombre para mostrar</th>
                    <th>Descripción</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($roles as $rol)
                        <tr>
                            <td>{{ $rol->id }}</td>
                            <td>{{ $rol->name }}</td>
                            <td>{{ $rol->display_name }}</td>
                            <td>{{ $rol->description }}</td>
                            <td>
                                <a href="" data-target="#modal-delete-{{ $rol->id }}" data-toggle="modal"
                                   class="btn btn-xs btn-danger tip" data-placement="top" title="Elimminar"><i
                                            class="fa fa-trash" aria-hidden="true"></i>
                                </a>
{{--                                {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'btn btn-xs btn-danger','data-toggle'=>'modal','data-target'=>"modal-delete-$rol->id"]) !!}--}}
                                <a href="{{ route('admin.roles.edit', $rol->id ) }}">
                                    {!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>
                                <a href="{{ route('admin.roles.show', $rol->id ) }}">
                                    {!! Form::button('<i class="fa fa-eye"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
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