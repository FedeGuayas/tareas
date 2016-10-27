@extends ('layouts.dashboard')
@section('page_heading','Tareas')

@section('section')

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
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div><!-- /.panel-body -->
        {!! Form::open(['id' =>'form-calendario']) !!}
        {!! Form::close() !!}
    </div><!-- /.panel -->

@section('script')
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
                    {
                        dow: [ 6,7], //   Domingo Sabado
                        start: '10:00', // 10am
                        end: '11:00' // 4pm
                    }
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
                displayEventEnd:true,

//                weekends: false, // will hide Saturdays and Sundays

                events: { url:"getTasks"},

                editable: false,//true para permitir editar en el calendario

                /*funciones*/

                //mostrar informacion del evento en un tooltip al pasar el mouse por encima
                eventMouseover: function( event, jsEvent, view ) {
                    var start = (event.start.format("YYYY-MM-DD HH:mm"));
                    var back=event.color;
                    var area=event.area_id;
                    var borderColor=event.color;
                    var resp=event.person_id;

                    if(event.end){
                        var end = event.end.format("YYYY-MM-DD HH:mm");
                    }else{var end="No definido";
                    }

                    var tooltip = '<div class="tooltipevent" style="border: #030414 2px solid;padding:10px;border-radius: 10px 10px 10px 10px; width:auto;height:auto;color:#030414;background:'+back+';position:absolute; placement:top;z-index:10001;">' +
                            ''+'<b><center> '+ event.title +' </center></b>'+
                            ''+ 'Inicio: '+start+'<br>' +
                            ''+ 'Fin: '+ end +'<br>' +
                            ''+'Area: '+area+'' +'<br>'+
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
                //evento para eliminar una tarea al dar click sobre ella
                eventClick: function (event, jsEvent, view) {

                event.url.show;


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
@endsection
@endsection