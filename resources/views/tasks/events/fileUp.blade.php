@extends('layouts.dashboard')

@section('page_heading','Adjuntar archivos o comentarios a: '.$event->title)

@section('section')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                @include('alert.request')
                @include('alert.success')
                {!! Form::open(['route'=>'user.task.postFileUpload', 'method'=>'POST','role'=>'form', 'files'=>true]) !!}
                {!! Form::hidden('event_id',$event->id) !!}
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

                <div class="row">
                    <div class='col-sm-6'>
                        <div class="form-group">
                            {!! Form::label('file','Archivos') !!}
                            <span class="btn btn-default btn-file">
                            {!! Form::file('file[]',['multiple'=>'multiple']) !!}
                             </span>
                        </div>
                    </div>
                </div>


                <div class="pull-right">
                    <div class="clearfix"></div>
                    <br>
                    {!! Form::submit('Salvar',['class'=>'btn btn-success','type'=>'button']) !!}
                    {!! Form::reset('Limpiar',['class'=>'btn btn-danger']) !!}
                    <a href="javascript:history.go(-1)">
                        {!! Form::button('Regresar',['class'=>'btn btn-primary']) !!}
                    </a>
                </div>
            </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>


@endsection








