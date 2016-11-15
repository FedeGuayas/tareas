@extends('layouts.plane')

@section('body')
 <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url ('/') }}">Control de Tareas. V1.0</a>
            </div>
            <!-- /.navbar-header -->

            <!--MEN MENSAJES DROPDOWN-->
            <ul class="nav navbar-top-links navbar-right">



               <!--MENU DROPDOWN TAREAS-->
                {{--<li class="dropdown">--}}
                    {{--<a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
                        {{--<i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu dropdown-tasks">--}}
                        {{--<li>--}}
                            {{--<a href="#">--}}
                                {{--<div>--}}
                                    {{--<p>--}}
                                        {{--<strong>Trea 1</strong>--}}
                                        {{--<span class="pull-right text-muted">40%</span>--}}
                                    {{--</p>--}}

                                        {{--<div>--}}
                                        {{--@include('widgets.progress', array('animated'=> true, 'class'=>'success', 'value'=>'40'))--}}
                                            {{--<span class="sr-only">40%</span>--}}
                                        {{--</div>--}}

                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="divider"></li>--}}
                        {{--<li>--}}
                            {{--<a href="#">--}}
                                {{--<div>--}}
                                    {{--<p>--}}
                                        {{--<strong>Tarea 2</strong>--}}
                                        {{--<span class="pull-right text-muted">20%</span>--}}
                                    {{--</p>--}}

                                        {{--<div>--}}
                                        {{--@include('widgets.progress', array('animated'=> true, 'class'=>'info', 'value'=>'20'))--}}
                                            {{--<span class="sr-only">20% </span>--}}
                                        {{--</div>--}}

                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="divider"></li>--}}
                        {{--<li>--}}
                            {{--<a href="#">--}}
                                {{--<div>--}}
                                    {{--<p>--}}
                                        {{--<strong>Tarea 3</strong>--}}
                                        {{--<span class="pull-right text-muted">60%</span>--}}
                                    {{--</p>--}}

                                        {{--<div>--}}
                                        {{--@include('widgets.progress', array('animated'=> true, 'class'=>'warning', 'value'=>'60'))--}}
                                            {{--<span class="sr-only">60%</span>--}}
                                        {{--</div>--}}

                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="divider"></li>--}}
                        {{--<li>--}}
                            {{--<a href="#">--}}
                                {{--<div>--}}
                                    {{--<p>--}}
                                        {{--<strong>Tarea 4</strong>--}}
                                        {{--<span class="pull-right text-muted">80%</span>--}}
                                    {{--</p>--}}

                                        {{--<div>--}}
                                        {{--@include('widgets.progress', array('animated'=> true,'class'=>'danger', 'value'=>'80'))--}}
                                            {{--<span class="sr-only">80% </span>--}}
                                        {{--</div>--}}

                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="divider"></li>--}}
                        {{--<li>--}}
                            {{--<a class="text-center" href="#">--}}
                                {{--<strong>Ver Todas las Tareas</strong>--}}
                                {{--<i class="fa fa-angle-right"></i>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                    {{--<!-- /.dropdown-tasks -->--}}
                {{--</li>--}}
                <!-- /.dropdown -->



                <!--MENU DROPDOWN ALERTAS-->
                {{--<li class="dropdown">--}}
                    {{--<a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
                        {{--<i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu dropdown-alerts">--}}
                        {{--@foreach(Auth::user()->$notifications as $notification)--}}
                        {{--<li>--}}
                            {{--<a href="#">--}}
                                {{--<div>--}}
                                    {{--<i class="fa fa-tasks fa-fw"></i>--}}
                                    {{--{{$notification->name}}--}}
                                    {{--<span class="pull-right text-muted small">--}}
{{--                                        {{ $notification->created_at->diffForHumans() }}--}}
                                    {{--</span>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--@endforeach--}}
                        {{--<li class="divider"></li>--}}

                        {{--<li>--}}
                            {{--<a class="text-center" href="#">--}}
                                {{--<strong>Ver Todas</strong>--}}
                                {{--<i class="fa fa-angle-right"></i>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                    {{--<!-- /.dropdown-alerts -->--}}
                {{--</li>--}}
                <!-- /.dropdown -->



                <!--MENU DROPDOWN DE USUARIOS-->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> {{Auth::user()->name}} <i class="fa fa-caret-down"></i>

                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ route ('user.profile')}}"><i class="fa fa-user fa-fw"></i>Perfil</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out fa-fw"></i>Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->


            <!--BARRA LATERAL-->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li {{ (Request::is('home') ? 'class="active"' : '') }}>
                            <a href="{{ url ('/home') }}"><i class="fa fa-home fa-fw"></i> Home</a>
                        </li>
                        {{--<li {{ (Request::is('*charts') ? 'class="active"' : '') }}>--}}
                            {{--<a href="#!"><i class="fa fa-bar-chart-o fa-fw"></i> Gráficas</a>--}}
                            {{--<ul class="nav nav-second-level">--}}
                                {{--<li>--}}
                                    {{--<a href="#!">Grafica tipo 1</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="#!">Grafica tipo 2</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="#!">Grafica tipo 3</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                            {{--<!-- /.nav-second-level -->--}}
                        {{--</li>--}}
                        {{--<li {{ (Request::is('*tables') ? 'class="active"' : '') }}>--}}
                            {{--<a href="{{ url ('tables') }}"><i class="fa fa-table fa-fw"></i> Tablas</a>--}}
                        {{--</li>--}}
                        {{--<li {{ (Request::is('*forms') ? 'class="active"' : '') }}>--}}
                            {{--<a href="{{ url ('forms') }}"><i class="fa fa-edit fa-fw"></i> Forms</a>--}}
                        {{--</li>--}}
                        {{--@role('supervisor','administrador')--}}
                        @if (Auth::user()->hasRole(['supervisor', 'administrador']))
                        <li >
                            <a href="#"><i class="fa fa-files-o" aria-hidden="true"></i> Reportes<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('admin.tasks.reports.users')}}">Tareas por trabajadores</a>
                                </li>
                                <li>
                                    <a href="{{route('admin.reports.index')}}">Informe Excel</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                            <li>
                            <a href="#"><i class="fa fa-cogs" aria-hidden="true"></i> Gestión<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#!">Areas <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <!-- visible solo para el autorizado a crear area-->
                                            @permission('create-area')
                                            <a href="{{route('admin.areas.create')}}">Nueva</a>
                                            @endpermission
                                        </li>
                                        <li>
                                            <a href="{{route('admin.areas.index')}}">Todas</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>

                                <li>
                                    <a href="#"><i class="fa fa-users" aria-hidden="true"></i> Trabajadores <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <!-- visible solo para el autorizado a crear usuarios-->
                                            @permission('create-user')
                                            <a href="{{route('admin.users.create')}}">Nuevo</a>
                                            @endpermission
                                        </li>
                                        <li>
                                            <a href="{{route('admin.users.index')}}">Todos</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-tasks" aria-hidden="true"></i> Tareas<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="{{route('admin.tasks.create')}}">Nueva</a>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.tasks.index')}}">Todas</a>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.calendar.edit')}}"><i class="fa fa-calendar fa-fw"></i> Calendario</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        @endif
                        @role('administrador')
                        <li>
                            <a href="#"><i class="fa fa-lock fa-fw" aria-hidden="true"></i> Administración<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('admin.users.index')}}"><i class="fa fa-user-secret fa-fw" aria-hidden="true"></i> Accesos Usuarios <span class="fa arrow"></span></a>
                                    <!-- /.nav-third-level -->
                                </li>

                                <li>

                                    <a href="#"><i class="fa fa-key fa-fw" aria-hidden="true"></i>Admin<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="{{route('admin.roles.index')}}">Roles</a>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.permissions.index')}}">Permisos</a>
                                        </li>
                                        <li>
                                            <a href="{{route('admin.notifications.index')}}">Notificaciones</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->

                                </li>

                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        @endrole
                        {{--<li {{ (Request::is('*documentation') ? 'class="active"' : '') }}>--}}
                            {{--<a href="{{ url ('documentation') }}"><i class="fa fa-file-word-o fa-fw"></i> Documentation</a>--}}
                        {{--</li>--}}
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!--CONTENIDO DE LA PAGINA-->
        <div id="page-wrapper">
			 <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">@yield('page_heading')</h2>
                </div><!-- /.col-lg-12 -->
             </div>  <!-- /.row -->
			<div class="row">
				@yield('section')
            </div><!-- /.row -->
        </div> <!-- /#page-wrapper -->
    </div>
@stop

