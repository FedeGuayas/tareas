<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
	<meta charset="utf-8"/>
	<title>Control de Tareas</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>
	{{--Calendar--}}
	<link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('bower_components/bootstrap-calendar/css/calendar.css')}}">

	{{--<link rel="stylesheet" href="{{asset('plugins/bootstrap/dist/css/bootstrap.min.css')}}">--}}
	{{--<link rel="stylesheet" href="{{asset('plugins/fontawesome/css/font-awesome.css')}}">--}}

{{--	<link rel="stylesheet" href="{{ asset("plugins/datatables/media/css/jquery.dataTables.min.css") }}" />--}}
	{{--<link rel="stylesheet" href="{{ asset("plugins/datatables/media/css/dataTables.bootstrap.css") }}" />--}}
	{{--<link rel="stylesheet" href="{{ asset("assets/stylesheets/styles.css") }}" />--}}
	@yield('style')
</head>
<body>
	@yield('body')

	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	{{--<script src="{{ asset("plugins/Chart.js/Chart.js") }}" type="text/javascript"></script>--}}


	{{--<script src="{{ asset("plugins/datatables/media/js/jquery.dataTables.min.js") }}" type="text/javascript"></script>--}}
	{{--<script src="{{ asset("plugins/datatables/media/js/dataTables.bootstrap.min.js") }}" type="text/javascript"></script>--}}

	{{--Calendar--}}
	<script type="text/javascript" src="{{asset('bower_components/jquery/dist/jquery.js')}}"></script>
	<script type="text/javascript" src="{{asset('bower_components/bootstrap/dist/js/bootstrap.js')}}"></script>
	<script type="text/javascript" src="{{asset('bower_components/moment/moment.js')}}"></script>
	<script type="text/javascript" src="{{asset('bower_components/underscore/underscore-min.js')}}"></script>
	<script type="text/javascript" src="{{asset('bower_components/bootstrap-calendar/js/calendar.js')}}"></script>

	@yield('script')
</body>
</html>