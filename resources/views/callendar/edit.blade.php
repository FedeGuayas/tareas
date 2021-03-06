@extends ('layouts.dashboard')
@section('page_heading','Tareas')

@section('section')

    <div class="panel panel-danger">
        <!-- Content Header (Page header) -->
        <div class="panel-heading"><h2>Calendario Editable</h2></div>
        <div class="panel-body">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- /.col -->
                    <div class="col-md-9 ">
                        @include('alert.success')
                        <div id="msg-send-error" class="alert alert-danger alert-dismissible" role="alert"
                             style="display: none">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <strong id="send"></strong>
                        </div>
                        <div id="msg-send-success" class="alert alert-success alert-dismissible" role="alert"
                             style="display: none">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <strong id="sendok"></strong>
                        </div>
                        <div class="box box-primary">
                            <div class="box-body no-padding">
                                <!-- THE CALENDAR -->
                                <div id="calendar"></div>
                            </div><!-- /.box-body -->
                        </div> <!-- /. box -->
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
                                    <li class="list-group-item"><h5><i style="color: #46b8da;" class="fa fa-square" aria-hidden="true"></i> En curso</h5></li>
                                    <li class="list-group-item"><h5><i style="color: #5cb85c;" class="fa fa-square" aria-hidden="true"></i> Terminada en Tiempo</h5></li>
                                    <li class="list-group-item"><h5><i style="color: #f0ad4e;" class="fa fa-square" aria-hidden="true"></i> Terminada fuera de término</h5></li>
                                    <li class="list-group-item"><h5><i style="color: #d9534f;" class="fa fa-square" aria-hidden="true"></i> Tareas incumplidas</h5></li>
                                    <li class="list-group-item"><h5><i style="color: #286090;" class="fa fa-square" aria-hidden="true"></i> No iniciada</h5></li>
                                </ul>
                            </div><!-- /.box-body-->
                        </div><!-- /. box-->
                    </div><!-- /.col -->
                </div>
            </section>
        </div>
    </div>
    </div><!-- /.panel-body -->

    {!! Form::open(['id' =>'form-calendario']) !!}
    {!! Form::close() !!}
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

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex: 1070,
                        revert: true, // will cause the event to go back to its
                        revertDuration: 0  //  original position after the drag
                    });

                });
            }

            ini_events($('#external-events div.external-event'));
//
            /* initialize the calendar
             -----------------------------------------------------------------*/
//            //Date for the calendar events (dummy data)
//            var date = new Date();
//            var     d = date.getDate(),
//                    m = date.getMonth(),
//                    y = date.getFullYear();
            //while(reload==false){

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                businessHours: [ // specify an array instead
                    {
                        dow: [1, 2, 3, 4, 5], // Lunes, Martes, Miercoles, Jueves y Viernes
                        start: '09:00', // 9am
                        end: '18:00' // 6pm
                    },
                    {
                        dow: [6, 7], //   Domingo Sabado
                        start: '10:00', // 10am
                        end: '11:00' // 4pm
                    }
                ],
                locale: 'es',

                eventTextColor: '#030414',
                slotDuration: '00:30:00',// (30 minutes) intervalos de tiempo en la vista del dia
                buttonText: {
                    today: 'hoy',
                    month: 'mes',
                    week: 'semana',
                    day: 'dia'
                },
                displayEventEnd: true,

                eventDurationEditable: true,

//                weekends: false, // will hide Saturdays and Sundays

                events: {url: "getEvents"},

                editable: true,//true para permitir editar en el calendario
                droppable: true, // this allows things to be dropped onto the calendar !!!

                //acion al ser arrastrado un evento sobre el calendario
//                drop: function (date, allDay) { // this function is called when something is dropped
                // retrieve the dropped element's stored Event Object
//                    var originalEventObject = $(this).data('eventObject');
                // we need to copy it, so that multiple events don't have a reference to the same object
//                    var copiedEventObject = $.extend({}, originalEventObject);
//                    allDay=true;
                // assign it the date that was reported
//                    copiedEventObject.start = date;
//                    copiedEventObject.allDay = allDay;
//                    copiedEventObject.backgroundColor = $(this).css("background-color");
//                    alert("Dropped on " + date.format());
//                    copiedEventObject.borderColor = $(this).css("border-color");

                // render the event on the calendar
                //$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                // is the "remove after drop" checkbox checked?
//                    if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
//                        $(this).remove();
//                    }
                //Guardamos el evento creado en base de datos
//                    var title=copiedEventObject.title;
//                    var start=copiedEventObject.start.format("YYYY-MM-DD HH:mm");
//                    var back=copiedEventObject.backgroundColor;

//                    crsfToken = document.getElementsByName("_token")[0].value;
//                    $.ajax({
//                        url: 'guardaEventos',//la URI definida en la ruta
//                        data: 'title='+ title+'&start='+ start+'&allday='+allDay+'&background='+back,//parametros pasados en el head al controlador al metodo create
//                        type: "POST",
//                        headers: {
//                            "X-CSRF-TOKEN": crsfToken
//                        },
//                        success: function(events) {
//                            console.log('Evento creado');
//                            $('#calendar').fullCalendar('refetchEvents' );
//                        },
//                        error: function(json){
//                            console.log("Error al crear evento");
//                        }
//                    });
//                },//end drop

                /*funciones*/

                eventAfterRender: function (event, element, view) {
                    var hoy = new Date();

                    if (event.end_day) {//performance_day
                        var end_day =event.end_day;
                    } else {
                        var end_day  = "NULL";
                    }

                    if (event.end) {
                        var end =event.end.format("YYYY-MM-DD HH:mm");
                    } else {
                        var end = "NULL";
                    }

                    var back=event.color;
                    var area=event.area;
                    var resp=event.users;
                    var repeat=event.repeats;
                    var repeat_freq=event.repeats_freq;
                    var start = (event.start.format("YYYY-MM-DD HH:mm"));

                    if ((event.start < hoy && event.end < hoy) && (end_day==='NULL') ) {
                        //Incumplida danger
                        //event.color = "#AEC6CF";
                        element.css('background-color', '#d9534f');
                    }

                    if ((event.start < hoy && event.end < hoy) &&  (Date.parse(end_day)<=Date.parse(end))){
                        //Concluído OK success paso el tiempo y se cumplio
                        //event.color = "#77DD77";
                        element.css('background-color', '#3c763d');
                    }

                    if ((event.start<hoy && event.end>hoy) && (Date.parse(end_day)<Date.parse(end)))  {
                        //terminada en tiempo success
                        element.css('background-color', '#3c763d');
                        //event.color = "#FFB347"; //n curso
                    }  if ((event.start<hoy && event.end>hoy)  ) {
//                        //en curso info
                        element.css('background-color', '#46b8da');
//                        //event.color = "#FFB347";
                    }

                    if ((event.start>hoy && event.end>hoy)) {
                        //No iniciada primary
                        element.css('background-color', '#286090');
                        //event.color = "#FFB347"; //n curso
                    }

                   if ((event.start < hoy && event.end < hoy) && (Date.parse(end_day)>=Date.parse(end))) {
                        //Concluído fuera de termino warning
                        //event.color = "#AEC6CF";
                        element.css('background-color', '#ec971f');
                    }

                },

                //actualiza en la bd al editar en el calendario un evento al cambiar su tamaño, llama al metodo update del controler
                eventResize: function (event, delta, revertFunc) {
                    var start = event.start.format("YYYY-MM-DD HH:MM");
                    var task_id = event.task_id;
                    var id = event.id;
                    var start_day = event.start_day;
                    var performance_day = event.performance_day;

                    if (!event.allDay) {
                        var allDay = false;
                        defaultTimedEventDuration: "00:30:00";
                    } else {
                        var allDay = true;
                        defaultTimedEventDuration: "00:30:00";
                    }

                    var title = event.title;
                    var repeats = event.repeats;

                    //compruebo si el evento tiene fecha de fin, sino da error el hacer resize
                    if (event.end) {
                        var end = event.end.format("YYYY-MM-DD 18:00");
                    } else {
                        var end = "NULL";
                    }
                    var datos = {
                        start: start,
                        task_id: task_id,
                        id: id,
                        end: end,
                        start_day: start_day,
                        performance_day: performance_day,
                        title: title,
                        repeats: repeats,
                        allDay: allDay
                    }
                    crsfToken = document.getElementsByName("_token")[0].value;
                    $.ajax({
                        url: 'actualizaEventos',
                        data: datos,
//                        'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id+'&task_id='+task,
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": crsfToken
                        },
                        success: function (json) {
                            console.log("Actualizado al resize");
                        },
                        error: function (json) {
                            console.log("Error al actualizar resize");
                        }
                    });
                },
                /*actualiza en la bd el evento al arrastarlo y cambiandolo de fecha dentro del calendario*/
                eventDrop: function (event) {
                    if (!event.allDay) {
                        var allDay = false;
                        defaultTimedEventDuration: "00:30:00";
                    } else {
                        var allDay = true;
                        defaultTimedEventDuration: "00:30:00";
                    }

                    var id = event.id; //id del evento
                    var start = event.start.format("YYYY-MM-DD HH:MM:SS");

                    if (event.end) {
                    var end = event.end.format("YYYY-MM-DD HH:MM:SS");
                    } else {
                        var end = "NULL";
                    }

                    var title = event.title;
                    var task_id = event.task_id;
                    var state = event.estado;
                    var end_day = event.end_day;

                    var color = event.color;
                    var task=event.task;//task title
                    var description=event.description;//task
                    var start_day=event.start_day;//task
                    var performance_day=event.performance_day;//task
                    var users=event.users;//task users
                    var repeats = event.repeats; //task
                    var repeats_freq = event.repeats_freq; //task
                    var area = event.area; //task

                    var datos = {
                        start: start,
                        task_id: task_id,
                        id: id,
                        end: end,
                        end_day: end_day,
                        title: title,
                        repeats: repeats,
                        state:state,
                        allDay:allDay,
                        task:task,
                        description:description,
                        start_day:start_day,
                        performance_day:performance_day,
                        users:users,
                        repeats : repeats,
                        repeats_freq:repeats_freq,
                        area:area,
                        color:color
                    }

                    crsfToken = document.getElementsByName("_token")[0].value;
                    $.ajax({
                        url: 'actualizaEventos',
                        data: datos,
//                        'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id+'&task_id='+task,
                        type: "POST",
//                        contentType: 'application/x-www-form-urlencoded',
                        headers: {
                            "X-CSRF-TOKEN": crsfToken
                        },

                        success: function (json) {
                            console.log('Actualizado al arrastrar ');
                            $("#sendok").html("Evento actualizado");
                            $("#msg-send-success").fadeIn();
                        },
                        error: function (json) {
                            console.log("Error al actualizar arrastrado");
                            $("#send").html("Este tipo de evento no puede ser actualizado en el calendario");
                            $("#msg-send-error").fadeIn();
                        }
                    });
                },
                //mostrar informacion del evento en un tooltip al pasar el mouse por encima
                eventMouseover: function (event, jsEvent, view) {

                    if (!event.allDay) {
                        var allDay = false;
                        defaultTimedEventDuration: "00:30:00";
                    } else {
                        var allDay = true;
                        defaultTimedEventDuration: "00:30:00";
                    }

                    var start = (event.start.format("YYYY-MM-DD HH:MM"));
                    var back = event.color;
                    var area = event.area;
                    var resp = event.user_id;
                    var repeat = event.repeats;
                    var repeat_freq = event.repeats_freq;

                    if (event.end) {
                      var end= event.end.format("YYYY-MM-DD HH:MM");
                    } else {
                        var end = "No definido";
                    }

                    if (repeat > 0) {
                        var recurrent = 'SI';
                    } else {
                        var recurrent = 'NO';
                    }
                    if (repeat_freq == 7) {
                        var freq = 'Semanal';
                    } else if (repeat_freq == 30) {
                        var freq = 'Mensual';
                    } else {
                        var freq = '';
                    }

                    var tooltip = '<div class="tooltipevent" style="padding:10px;border-radius: 10px 10px 10px 10px; width:auto;height:auto;color:rgba(251, 246, 250, 0.91);background:' + back + ';position:absolute; placement:top;z-index:10001;">' +
                            '' + '<b><center> ' + event.title + ' </center></b>' +
                            '' + 'Area: ' + area + '<br>' +
                            '' + 'Inicio: ' + start + '<br>' +
                            '' + 'Fin: ' + end + '<br>' +
                            '' + 'Recurrente: ' + recurrent + '<br>' +
                            '' + 'Frecuencia: ' + freq + '<br></div>';
                    $("body").append(tooltip);
                    $(this).mouseover(function (e) {
                        $(this).css('z-index', 10000);
                        $('.tooltipevent').fadeIn('500');
                        $('.tooltipevent').fadeTo('10', 1.9);
                    }).mousemove(function (e) {
                        $('.tooltipevent').css('top', e.pageY - 170);
                        $('.tooltipevent').css('left', e.pageX - 170);
                    });
                },
                //evento al retirar el mouse se cierra el toolpit
                eventMouseout: function (calEvent, jsEvent) {
                    $(this).css('z-index', 8);
                    $('.tooltipevent').remove();
                },
                //evento para eliminar una tarea al dar click sobre ella
                eventClick: function (event, jsEvent, view) {
                    crsfToken = document.getElementsByName("_token")[0].value;
                    var con = confirm("Esta seguro que desea eliminar el evento");

                    if (con) {
                        $.ajax({
                            url: 'eliminaEvento',
                            data: 'id=' + event.id,
                            headers: {
                                "X-CSRF-TOKEN": crsfToken
                            },
                            type: "POST",
                            success: function () {
                                $('#calendar').fullCalendar('removeEvents', event._id);
                                console.log("Evento eliminado");
                            }
                        });
                    } else {
                        console.log("Cancelado");
                    }
                    return false;
                },
                //entra en determinado dia al dar click en el calendario
                dayClick: function (date, jsEvent, view) {
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