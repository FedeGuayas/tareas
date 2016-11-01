@extends('layouts.dashboard')

@section('page_heading','Listado Usuarios')

@section('section')

    <div class="row">
        <div class="col l12 m12 s12">

                {{--<a href="{{route('admin.users.create')}}">--}}
                    {{--{!! Form::button('<i class="fa fa-user-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light','data-position'=>'right', 'data-delay'=>'50', 'data-tooltip'=>'Crear usuario']) !!}--}}
                {{--</a>--}}
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>User</th>
                    <th>Trabajador</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($usuarios as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>@foreach ($user->roles as $role)
                                    {{ $role->display_name }}<br>

                                @endforeach
                            </td>
                            <td>
                                {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$user->id"]) !!}
                                {{--<a href="{{ route('admin.users.edit', $user->id ) }}">--}}
                                    {{--{!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                                {{--</a>--}}
                                {{--<a href="{{ route('admin.users.show', $user->id ) }}">--}}
                                    {{--{!! Form::button('<i class="fa fa-eye"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                                {{--</a>--}}
                                <a href="{{ route('admin.users.roles', $user->id ) }}">
                                    {!! Form::button('<i class="fa fa-key"></i>',['class'=>'btn btn-xs']) !!}
                                </a>
                            </td>
                        </tr>
{{--                        @include ('campamentos.users.modal')--}}
                    @endforeach
                </table><!--end table-responsive-->
            {{--  {{ $usuarios->render() }}--}}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection