@extends('layouts.dashboard')
@section('title','Perfil')
@section('page_heading','Perfil de Usuario')
@section('section')
           
            <!-- /.row -->
            <div class="col-sm-12">
            <div class="row">

                @include('alert.success')
                @include('alert.request')
                <div id="msg-send" class="alert alert-success alert-dismissible" role="alert" style="display: none">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong id="send"></strong>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$tasksOn}}</div>
                                    <div>Pendientes!</div>
                                </div>
                            </div>
                        </div>
                        {{--<a href="{{route('user.profile.tasks')}}">--}}
                            {{--<div class="panel-footer">--}}
                                {{--<span class="pull-left">Ver Detalles</span>--}}
                                {{--<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>--}}
                                {{--<div class="clearfix"></div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$tasksOff}}</div>
                                    <div>Terminadas!</div>
                                </div>
                            </div>
                        </div>
{{--                        <a href="{{route('user.profile.tasks')}}">--}}
                            {{--<div class="panel-footer">--}}
                                {{--<span class="pull-left">Ver Detalles</span>--}}
                                {{--<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>--}}
                                {{--<div class="clearfix"></div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{count($events)}}</div>
                                    <div>Mes actual!</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('user.profile.tasks')}}">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Mes actual!</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>


                <div class="col-lg-3 col-md-6 pull-right">
                    <a href="{{route('user.password.edit')}}">
                        {!! Form::button('<i class="fa fa-key fa-fw" aria-hidden="true"></i>Cambiar Contraseña', ['class'=>'btn btn-lg btn-primary']) !!}
                    </a>
                </div>
            </div> <!-- /.row -->

            <div class="row">
                <div class="col-lg-8">

                @section ('pane2_panel_title', 'En el tiempo...')
                @section ('pane2_panel_body')
                    
                    <!-- /.panel -->
                    <ul class="timeline">
                        @foreach($eventsAll as $event )
                            @if ($event->state==1)
                                <li class="timeline-inverted">
                                    <div class="timeline-badge success"><i class="fa fa-check"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">{{$event->title}}</h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> {{$event->created_at->diffForHumans()}}</small>
                                            </p>
                                        </div>
                                        <div class="timeline-body">
                                            <p>{{$event->description}}</p>
                                        </div>
                                    </div>
                                </li>
                           @else
                                <li >
                                    <div class="timeline-badge warning"><i class="fa fa-minus"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">{{$event->title}}</h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> {{$event->created_at->diffForHumans()}}</small>
                                            </p>
                                        </div>
                                        <div class="timeline-body">
                                            <p>{{$event->description}}</p>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
                                                    <i class="fa fa-gear"></i>  <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#">Comentar</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    @if (is_null($event->end_day) )
                                                    <li><a href="#!" class="solEndTask" id="{{$event->task_id}}">Terminar</a>
                                                    </li>
                                                        @else
                                                        <li><a href="#!" class="bg-success">Solicitud enviada</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                            {{ $eventsAll->render() }}
                    </ul>
                @endsection
                @include('widgets.panel', array('header'=>true, 'as'=>'pane2'))
                </div>

                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    @section ('pane1_panel_title', '<i class="fa fa-bell fa-fw"></i> Panel de Notificaciones')
                    @section ('pane1_panel_body')


                        <div class="list-group">
                                {{--<a href="#" class="list-group-item">--}}
                                    {{--<i class="fa fa-comment fa-fw"></i> New Comment--}}
                                    {{--<span class="pull-right text-muted small"><em>4 minutes ago</em>--}}
                                    {{--</span>--}}
                                {{--</a>--}}
                            @foreach($notifications as $notification)
                                @if(!$notification->read)
                            <a href="{{route('user.notifications.read',$notification)}}" class="list-group-item">
                                <i class="fa fa-exclamation-circle fa-fw"></i>
                                    {{$notification->text}}
                                <span class="pull-right text-muted small"><em><i class="fa fa-clock-o">
                                </i> {{ $notification->created_at->diffForHumans() }}</em>
                                </span>
                            </a>
                                @endif
                            @endforeach
                        </div>
                            <!-- /.list-group -->
                            <a href="{{route('user.notifications.all')}}" class="btn btn-default btn-block">Ver todas</a>

                        <!-- /.panel-body -->

                    @endsection
                    @include('widgets.panel', array('header'=>true, 'as'=>'pane1', 'class'=>'danger'))
                </div>
                <!-- /.col-lg-8 -->
            </div><!-- /.row -->
            </div>  <!-- /.col-sm-12 -->

{!! Form::open(['id' =>'form-solEndTask']) !!}
{!! Form::close() !!}
@endsection

@section('script')

    <script>

        $(".solEndTask").click(function(){
            var token = document.getElementsByName("_token")[0].value;
            var datos=this.id;
            var route="{{route('user.task.end')}}";
            $.ajax({
                url: route,
                type: "POST",
                headers: {'X-CSRF-TOKEN': token},
                contentType: 'application/x-www-form-urlencoded',
                data: {datos},
                success: function(json) {
                    console.log(json);
                    $("#send").html(json.message);
                    $("#msg-send").fadeIn();
                },
                error: function(json){
                    console.log("Error al enviar id");
                }
            });
        });

//        function solEndTask(tak){
//            $('meta[name=_token]').attr('content')

//        }

    </script>

@endsection
