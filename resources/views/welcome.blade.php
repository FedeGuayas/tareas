<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gestion de Tareas</title>


    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/landing/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('assets/landing/css/landing-page.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{asset('assets/landing/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">


    {{--FullCalendar--}}
    <link rel='stylesheet' href="{{asset('plugins/fullcalendar/fullcalendar.css')}}" />



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="{{asset('assets/landing/js/jquery.js')}}"></script>
    <link href="{{asset('assets/stylesheets/go-top.css')}}" rel="stylesheet">

    <script type="text/javascript">
        $(document).ready(function(){

//            $('.go-top').on('click','.go-top',function(){
//                $('.go-top').addClass('disabled');
//                alert('ok');
                //                    $('html, body').animate({ scrollTop: 0 }, 600);
                //                    return false;
//            });

            $(window).scroll(function(){
                if ($(this).scrollTop() > 250) {
                    $('.go-top').slideDown(300);
                    $('.go-top').on('click','.go-top',function(){
                        $('html, body').animate({ scrollTop: 0 }, 600);
                                            return false;
                    });

                } else {
                    $('.go-top').slideUp(300);
                }
            });



        });


    </script>

</head>

<body>
<!-- BackToTop Button -->
<a href="#" class="go-top" title="Scroll to Top" style="display: none"><span></span></a>

<!-- Header -->
<div class="intro-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-6">
                <div class="intro-message">
                    <h1>Gestion de Tareas</h1>
                    <h3>Planifica tu tiempo</h3>

                    <hr class="intro-divider">

                    <ul class="list-inline intro-social-buttons">
                        <li>
                            <a href="#callendar" class="btn btn-info btn-lg"><i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span class="network-name">Calendario</span>
                            </a>
                            @if (Auth::guest())
                            <a href="{{url('login')}}" class="btn btn-primary btn-lg"><i class="fa fa-sign-in fa-fw" aria-hidden="true"></i> <span class="network-name"> Entrar</span>
                            </a>
                            @else
                                <a href="{{url('/home')}}" class="btn btn-success btn-lg"><i class="fa fa-home fa-fw" aria-hidden="true"></i> <span class="network-name"> Home</span>
                                </a>
                            @endif


                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container -->
</div><!-- /.intro-header-->

<a  name="callendar"></a>
<div class="callendar">

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary">
                    <!-- Content Header (Page header) -->
                    <div class="panel-heading"><h2>Calendario</h2></div>
                    <div class="panel-body">
                        <!-- Main content -->
                        <section class="content">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="box box-primary">
                                        <div class="box-body no-padding">
                                            <!-- THE CALENDAR -->
                                            <div id="calendar"></div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /. box -->
                                </div>
                                <!-- /.col 9-->

                                {{--LEYENDA--}}
                                <div class="col-md-3">
                                    <div class="box box-solid">
                                        <div class="box-header with-border"><br><br><br>
                                            <h4 class="box-title">Leyenda</h4>
                                        </div>
                                        <div class="box-body">
                                            <ul class="list-group">
                                                <li class="list-group-item"><h4><i style="color: #337ab7;" class="fa fa-square" aria-hidden="true"></i> Tareas asignada</h4></li>
                                                <li class="list-group-item"><h4><i style="color: #5cb85c;" class="fa fa-square" aria-hidden="true"></i> Tareas terminadas</h4></li>
                                                <li class="list-group-item"><h4><i style="color: #f0ad4e;" class="fa fa-square" aria-hidden="true"></i> Próximas a vencer</h4></li>
                                                <li class="list-group-item"><h4><i style="color: #d9534f;" class="fa fa-square" aria-hidden="true"></i> Tareas incumplidas</h4></li>
                                            </ul>
                                        </div><!-- /.box-body-->
                                    </div><!-- /. box-->
                                </div>
                            </div><!-- /.row -->
                        </section><!-- /.content -->
                    </div><!-- /.panel-body -->
                    {!! Form::open(['id' =>'form-calendario']) !!}
                    {!! Form::close() !!}
                </div><!-- /.panel -->
            </div>
        </div>
    </div>    <!-- /.container -->
</div><!-- /.callendar -section -->


{{--modal info--}}
@include('callendar.modalInfo')





<!-- Bootstrap Core JavaScript -->
<script src="{{asset('assets/landing/js/bootstrap.min.js')}}"></script>


<script src="{{asset('plugins/fullcalendar/lib/jquery-ui.min.js')}}"></script>
<script src="{{asset('plugins/fullcalendar/lib/moment.min.js')}}"></script>
<script src="{{asset('plugins/fullcalendar/fullcalendar.js')}}"></script>
<script src="{{asset('plugins/fullcalendar/locale/es.js')}}"></script>




<script>


    $(function () {


        /* initialize the external events
         -----------------------------------------------------------------*/
        function ini_events(ele) {
            ele.each(function () {
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                };

                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject);

            });
        }

//            ini_events($('#external-events div.external-event'));

        /* initialize the calendar
         -----------------------------------------------------------------*/


        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            businessHours: [ // specify an array instead
                {
                    dow: [ 1,2,3,4,5], // Lunes, Martes, Miercoles, Jueves y Viernes
                    start: '09:00', // 9am
                    end: '18:00' // 6pm
                },
//                    {
//                        dow: [6,7 ], //   Domingo Sabado
//                        start: '10:00', // 10am
//                        end: '11:00' // 4pm
//                    }
            ],
            locale:'es',

            eventTextColor:'#030414',
            slotDuration:'00:30:00',// (30 minutes) intervalos de tiempo en la vista del dia
            buttonText: {
                today: 'hoy',
                month: 'mes',
                week: 'semana',
                day: 'dia'
            },
//                displayEventEnd:true,

//                weekends: false, // will hide Saturdays and Sundays

            events: {
                url:"getTasks"
            },

            editable: false,//true para permitir editar en el calendario

            /*funciones*/

            //mostrar informacion del evento en un tooltip al pasar el mouse por encima
            eventMouseover: function( event, jsEvent, view ) {
                var start = (event.start.format("YYYY-MM-DD HH:mm"));
                var back=event.color;
                var area=event.area_id;
                var resp=event.person_id;

                if(event.end){
                    var end = event.end.format("YYYY-MM-DD HH:mm");
                }else{var end="No definido";
                }

                var tooltip = '<div class="tooltipevent" style="padding:10px;border-radius: 10px 10px 10px 10px; width:auto;height:auto;color:#030414;background:'+back+';position:absolute; placement:top;z-index:10001;">' +
                        ''+'<b><center> '+ event.title +' </center></b>'+
                        ''+ 'Area '+area+'<br>' +
                        ''+ 'Inicio: '+start+'<br>' +
                        ''+ 'Fin: '+ end +'<br>' +
                        ''+'Responsable: '+'<b>'+resp+'</b></div>';
                $("body").append(tooltip);
                $(this).mouseover(function(e) {
                    $(this).css('z-index', 10000);
                    $('.tooltipevent').fadeIn('500');
                    $('.tooltipevent').fadeTo('10', 1.9);
                }).mousemove(function(e) {
                    $('.tooltipevent').css('top', e.pageY - 150);
                    $('.tooltipevent').css('left', e.pageX -160);
                });
            },
            //evento al retirar el mouse se cierra el toolpit
            eventMouseout: function(calEvent, jsEvent) {
                $(this).css('z-index', 8);
                $('.tooltipevent').remove();
            },
            //evento para cargar en una modal los datos de la tarea
            eventClick: function (event, jsEvent, view) {
                var start = (event.start.format("YYYY-MM-DD HH:mm"));
                var back=event.color;
                var area=event.area_id;
                var resp=event.person_id;

                if(event.end){
                    var end = event.end.format("YYYY-MM-DD HH:mm");
                }else{var end="No definido";
                }
                //limpio los datos de la tabla de la ventana modal
                $("#asignadas").empty();
                $("#terminadas").empty();
                $("#pendientes").empty();
                $("#cumplimiento").empty();
//                    $('#terminadas ').html('<h3 id="terminadas"><span class="label label-success"></span></h3>');
//                    //set the values and open the modal
                $('#modalTitle').html(event.title);
                $('#area_id').val(area);
                $('#start').val(start);
                $('#end').val(end);
                $('#person_id').val(resp);

                $("#modalInfo").modal()
                crsfToken = document.getElementsByName("_token")[0].value;
                $.ajax({
                    url: 'getDataModal',
                    dataType: 'json',
                    data: 'id=' + event.id,
                    headers: {
                        "X-CSRF-TOKEN": crsfToken
                    },
                    type: "POST",
                    success: function (data) {
//
//                            console.log(data.asignada);//no funciona asi
                        var asignadas=data[0].asignadas,
                                terminadas=data[0].terminadas,
                                pendientes=data[0].pendientes,
                                cumplimiento=data[0].cumplimiento;
                        $("#asignadas").text(asignadas);
                        $("#terminadas").text(terminadas);
                        $("#pendientes").text(pendientes);
                        $("#cumplimiento").text(cumplimiento);


                    },
                    error: function(json){
                        console.log("Error en conexion");
                    }
                });
//
                return false;
//
            },
            //entra en determinado dia al dar click en el calendario

            dayClick: function(date, jsEvent, view) {
                if (view.name === "month") {
                    $('#calendar').fullCalendar('gotoDate', date);
                    $('#calendar').fullCalendar('changeView', 'agendaDay');
                }
            }
            /*end funciones*/
        });

    });


</script>

</body>

</html>
