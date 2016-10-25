@extends ('layouts.dashboard')
@section('page_heading','Crear Trabajador')

@section('section')
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                {!! Form::open(['route'=>'admin.persons.store', 'method'=>'POST','role'=>'form']) !!}

                <div class="form-group">
                    <div class="form-inline">
                        <div class="form-group">
                            <div class="form-group">
                                {!! Form::label('first_name','Nombre:') !!}
                                {!! Form::text('first_name',null,['class'=>'form-control','placeholder'=>'Nombres','required']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                {{--{!! Form::label('last_name','Apellidos:') !!}--}}
                                {!! Form::text('last_name',null,['class'=>'form-control','placeholder'=>'Apellidos','required']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-inline">
                        <div class="form-group">
                            {!! Form::label('phone','Teléfono:') !!}
                            {!! Form::text('phone',null,['class'=>'form-control','placeholder'=>'Teléfono']) !!}
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon" id="email-add">@</span>
                            {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'correo@ejemplo.com','aria-describedby'=>'email-add']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-inline">
                        {!! Form::label('area_id','Area:') !!}
                        {!! Form::select('area_id',$areas,null,['class'=>'form-control','placeholder'=>'Seleccione el area...','required']) !!}
                    </div>
                </div>


                {!! Form::submit('Crear',['class'=>'btn btn-success','type'=>'button']) !!}

                {!! Form::reset('Limpiar',['class'=>'btn btn-danger']) !!}
                {{--<a href="#" >--}}
                {{--{!! Form::button('Truncate',['class'=>'btn btn-danger']) !!}--}}
                {{--</a>--}}

                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection