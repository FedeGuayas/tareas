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

	<link rel="stylesheet" href="{{ asset("plugins/metisMenu/dist/metisMenu.css") }}" />
	<link rel="stylesheet" href="{{asset('plugins/bootstrap/dist/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugins/fontawesome/css/font-awesome.css')}}">


{{--	<link rel="stylesheet" href="{{ asset("plugins/datatables/media/css/jquery.dataTables.min.css") }}" />--}}

	<link rel="stylesheet" href="{{ asset("assets/stylesheets/styles.css") }}" />
	<link rel="stylesheet" href="{{ asset("plugins/datatables/media/css/dataTables.bootstrap.css") }}" />
	{{--FullCalendar--}}
	<link rel='stylesheet' href="{{asset('plugins/fullcalendar/fullcalendar.css')}}" />

	{{--Boostrap DateTimePicker--}}
	<link rel="stylesheet" href="{{ asset("plugins/bDateTimePicker/css/bootstrap-datetimepicker.css") }}" />

	@yield('style')
</head>

<body>

	@yield('body')

</body>



<script src="{{ asset('assets/scripts/frontend.js') }}" type="text/javascript"></script>

{{--FullCalendar--}}
{{--<script src="{{asset('plugins/fullcalendar/lib/jquery.min.js')}}"></script>--}}
<script src="{{asset('plugins/fullcalendar/lib/jquery-ui.min.js')}}"></script>
<script src="{{asset('plugins/fullcalendar/lib/moment.min.js')}}"></script>
<script src="{{asset('plugins/fullcalendar/fullcalendar.js')}}"></script>
<script src="{{asset('plugins/fullcalendar/locale/es.js')}}"></script>



{{--<script src="{{ asset("plugins/datatables/media/js/jquery.js") }}" type="text/javascript"></script>--}}
<script src="{{ asset("plugins/datatables/media/js/jquery.dataTables.js") }}" type="text/javascript"></script>
<script src="{{ asset("plugins/datatables/media/js/jquery.dataTables.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("plugins/datatables/media/js/dataTables.bootstrap.min.js") }}" type="text/javascript"></script>

<script src="{{ asset("plugins/Chart.js/Chart.js") }}" type="text/javascript"></script>

{{--Boostrap DateTimePicker--}}
<script src="{{ asset("plugins/moment/min/moment-with-locales.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("plugins/bDateTimePicker/js/bootstrap-datetimepicker.min.js") }}" type="text/javascript"></script>

{{--<script src="{{asset('plugins/bootstrap/dist/js/bootstrap.js')}}"></script>--}}




@yield('script')

</html>