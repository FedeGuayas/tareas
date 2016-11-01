@extends('layouts.dashboard')
@section('page_heading','Perfil de Usuario')
@section('section')
           
            <!-- /.row -->
            <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">124</div>
                                    <div>Sin Terminar!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
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
                                    <div class="huge">12</div>
                                    <div>Terminadas!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Ver Detalles</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-lg-offset-2">
                    @section ('pane3_panel_title', 'Editar Perfil')
                    @section ('pane3_panel_body')

                        <div class="list-group">
                            {{--<a href="#" class="list-group-item">--}}
                            {{--<i class="fa fa-comment fa-fw"></i> New Comment--}}
                            {{--<span class="pull-right text-muted small"><em>4 minutes ago</em>--}}
                            {{--</span>--}}
                            {{--</a>--}}
                            <p class="pull-right">
                                <a href="#!" class="btn btn-success">
                                    <i class="fa fa-key fa-fw"></i> Contraseña
                                </a>
                            </p>
                            <p class="pull-right">
                                <a href="#" class="btn btn-success">
                                    <i class="fa fa-image fa-fw"></i> Imagen
                                </a>
                            </p>

                        </div>
                        <!-- /.list-group -->
                        {{--<a href="#" class="btn btn-default btn-block">Ver todas</a>--}}

                                <!-- /.panel-body -->
                    @endsection
                    @include('widgets.panel', array('header'=>true, 'class'=>'success', 'as'=>'pane3'))
                </div>
            </div>
            <!-- /.row -->


            <div class="row">
                <div class="col-lg-8">

                @section ('pane2_panel_title', 'En el tiempo...')
                @section ('pane2_panel_body')
                    
                    <!-- /.panel -->
                    <ul class="timeline">
                        @foreach($tasks as $task )
                            @if (!$task->state)
                                <li class="timeline-inverted">
                                    <div class="timeline-badge success"><i class="fa fa-check"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">{{$task->task}}</h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> {{$task->created_at->diffForHumans()}}</small>
                                            </p>
                                        </div>
                                        <div class="timeline-body">
                                            <p>{{$task->description}}</p>
                                        </div>
                                    </div>
                                </li>
                           @elseif ($task->state)
                                <li >
                                    <div class="timeline-badge warning"><i class="fa fa-minus"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">{{$task->task}}</h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> {{$task->created_at->diffForHumans()}}</small>
                                            </p>
                                        </div>
                                        <div class="timeline-body">
                                            <p>{{$task->description}}</p>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown">
                                                    <i class="fa fa-gear"></i>  <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#">Ver</a>
                                                    </li>
                                                    <li><a href="#">Comentar</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li><a href="#">Terminar</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                        {{ $tasks->render() }}
                    </ul>
                @endsection
                @include('widgets.panel', array('header'=>true, 'as'=>'pane2'))
                </div>

                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    @section ('pane1_panel_title', 'Panel de Notificaciones')
                    @section ('pane1_panel_body')

                        <div class="list-group">
                                {{--<a href="#" class="list-group-item">--}}
                                    {{--<i class="fa fa-comment fa-fw"></i> New Comment--}}
                                    {{--<span class="pull-right text-muted small"><em>4 minutes ago</em>--}}
                                    {{--</span>--}}
                                {{--</a>--}}
                            <a href="#" class="list-group-item">
                                <i class="fa fa-tasks fa-fw"></i> Nueva Tarea
                                <span class="pull-right text-muted small"><em>hace 43 minutos</em>
                                </span>
                            </a>

                        </div>
                            <!-- /.list-group -->
                            <a href="#" class="btn btn-default btn-block">Ver todas</a>

                        <!-- /.panel-body -->
                    @endsection
                    @include('widgets.panel', array('header'=>true, 'as'=>'pane1'))
                </div>

                <!-- /.col-lg-8 -->



            </div><!-- /.row -->
            </div>  <!-- /.col-sm-12 -->

            
@endsection
