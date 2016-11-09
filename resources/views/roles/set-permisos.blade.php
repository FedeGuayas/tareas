@extends('layouts.dashboard')

@section('page_heading', 'Asignar Permisos al '.$rol->display_name)

@section('section')


    <div class="row">
        <div class="col-sm-8 col-lg-offset-1">
            {!! Form::model($rol,['route'=>['admin.roles.setpermisos', $rol->id], 'method'=>'PUT']) !!}
            {{--{!! Form::hidden('rol_id',$rol->id) !!}--}}
            <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                <thead>
                    <th>Id</th>
                    <th>Add/Rem</th>
                    <th>Permisos</th>
                    <th>Descripción</th>
                </thead>
                {{--@foreach($role_permissions as $rp) <p>{{$rp->display_name}}</p> @endforeach--}}
                @foreach ($permisos as $per)
                    <tr>
                        <td>{{ $per->id }}</td>
                        <td>{!! Form::checkbox('permisos[]',$per->id,null,['id'=>$per->id]) !!}
                            {!! Form::label($per->id, $per->name) !!}</td>
                        <td>{{ $per->display_name }}</td>
                        <td>{{ $per->description }}</td>
                    </tr>

                @endforeach
            </table><!--end table-responsive-->
            {!! Form::button('Act<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
            {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
            <a href="{{ route('admin.roles.index') }}"  class="tooltipped" data-position="top" data-delay="50" data-tooltip="Regresar">
                {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
            </a>
            {!! Form::open() !!}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->


@endsection

