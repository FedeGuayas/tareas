@extends('layouts.dashboard')

@section('page_heading', 'Asignar Permisos al '.$rol->display_name)

@section('section')


    <div class="row">
        <div class="col l12 m12 s12">
            {!! Form::open(['route'=>'admin.roles.setpermisos', 'method'=>'POST']) !!}
            {!! Form::hidden('rol_id',$rol->id) !!}
            <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                <thead>
                    {{--<th>Id</th>--}}
                    <th>Add/Rem</th>
                    <th>Permisos</th>
                    <th>Descripcion</th>

                </thead>
                @foreach ($permisos as $per)
                    <tr>
                        {{--<td>{{ $per->id }}</td>--}}
                        <td>{!! Form::checkbox('permisos[]',$per->id,false,['id'=>$per->id]) !!}
                            {!! Form::label($per->id, $per->name) !!}
                        <td>{{ $per->display_name }}</td>
                        <td>{{ $per->description }}</td>
                    </tr>
                @endforeach
            </table><!--end table-responsive-->
            {!! Form::button('Otorgar<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
            {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
            <a href="{{ route('admin.roles.index') }}"  class="tooltipped" data-position="top" data-delay="50" data-tooltip="Regresar">
                {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
            </a>
            {!! Form::open() !!}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->


@endsection

