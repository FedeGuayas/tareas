@extends('layouts.dashboard')

@section('page_heading','Editar comentario')

@section('section')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                @include('alert.request')
                @include('alert.success')
                {!! Form::model($comment,['route'=>['task.update.comment',$comment->id], 'method'=>'PUT','role'=>'form']) !!}
                <div class="row">
                <div class="form-group">
                    <div class="form-group">
                        {!! Form::label('title','Titulo del comentario:') !!}
                        {!! Form::text('title',null,['class'=>'form-control','placeholder'=>'Titulo']) !!}

                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('body','Comentario') !!}
                    {!! Form::textarea('body',null,['class'=>'form-control','placeholder'=>'Comentario....','rows'=>'3']) !!}
                </div>
                <div class="pull-right">
                    <div class="clearfix"></div>
                    <br>
                    {!! Form::submit('Editar',['class'=>'btn btn-success','type'=>'button']) !!}
                    {!! Form::reset('Cancelar',['class'=>'btn btn-danger']) !!}
                    <a href="{{route('user.profile.tasks')}}" >
                        {!! Form::button('Regresar',['class'=>'btn btn-primary']) !!}
                    </a>
                </div>
            </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>


@endsection








