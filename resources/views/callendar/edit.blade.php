@extends ('layouts.dashboard')
@section('page_heading','Tareas')

@section('section')

    <div class="panel panel-success">
        <!-- Content Header (Page header) -->
        <div class="panel-heading"><h2>Calendario Editable</h2></div>
        <div class="panel-body">
            <!-- Main content -->
            <section class="content">
                <div class="row">

                    <!-- /.col -->
                    <div class="col-md-9 col-lg-offset-2">
                        @include('alert.success')
                        <div id="msg-send-error" class="alert alert-danger alert-dismissible" role="alert" style="display: none">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong id="send"></strong>
                        </div>
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
    </div><!-- /.panel -->
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

                eventDurationEditable:true,

//                weekends: false, // will hide Saturdays and Sundays

                events: { url:"getEvents"},

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

                //actualiza en la bd al editar en el calendario un evento al cambiar su tamaño, llama al metodo update del controler
                eventResize: function(event, delta, revertFunc) {
                    var start = event.start.format("YYYY-MM-DD HH:MM");//inicio del evento = task sino es repetitivo
                    var task_id=event.task_id; //task_id identifica a la tarea si no es repetitivo
                    var id=event.id; //id del evento
//                    var end=event.end; //fin evento = al performances_day si no es repetitivo
                    var  start_day=event.start_day; //inicio de tarea= inicio de evento  sino es repetitivo
                    var  performance_day=event.performance_day; //fin de tarea
                    if(!event.allDay){
                        var allDay = false;
                        defaultTimedEventDuration: "00:30:00";
                    }else {
                        var allDay = true;
                        defaultTimedEventDuration: "00:30:00";
                    }

                    var title=event.title; //igual al titulo de la tarea task
                    var repeats=event.repeats; //para saber si es evento recurrente


                    //compruebo si el evento tiene fecha de fin
                    if(event.end){
                        var end = event.end.format("YYYY-MM-DD HH:MM");
                    }else{var end="NULL";
                    }
                    var datos={start:start, task_id:task_id,  id:id , end:end, strat_day:start_day, performance_day:performance_day, title:title, repeats:repeats ,allDay:allDay}
                    crsfToken = document.getElementsByName("_token")[0].value;
                    $.ajax({
                        url: 'actualizaEventos',
                        data:datos,
//                        'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id+'&task_id='+task,
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": crsfToken
                        },
                        success: function(json) {
                            console.log("Actualizado al resize");
                        },
                        error: function(json){
                            console.log("Error al actualizar resize");
                        }
                    });
                },
                /*actualiza en la bd el evento al arrastarlo y cambiandolo de fecha dentro del calendario*/
                eventDrop: function(event, delta) {
                    var start = event.start.format("YYYY-MM-DD HH:MM");//inicio del evento = task sino es repetitivo
                    var task_id=event.task_id; //task_id identifica a la tarea si no es repetitivo
                    var id=event.id; //id del evento
//                    var end=event.end; //fin evento = al performances_day si no es repetitivo
                    var  start_day=event.start_day; //inicio de tarea= inicio de evento  sino es repetitivo
                    var  performance_day=event.performance_day; //fin de tarea
                    var allDay = event.allDay;
                    var title=event.title; //igual al titulo de la tarea task
                    var repeats=event.repeats; //para saber si es evento recurrente

                    if(event.end){
                        var end = event.end.format("YYYY-MM-DD HH:MM");
                    }else{var end="NULL";
                    }
                    var datos={start:start, task_id:task_id,  id:id , end:end, strat_day:start_day, performance_day:performance_day, title:title, repeats:repeats}

//
                    crsfToken = document.getElementsByName("_token")[0].value;
                    $.ajax({
                        url: 'actualizaEventos',
                        data: datos,
//                        'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id+'&task_id='+task,
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": crsfToken
                        },
                        success: function(json) {
                            console.log('Actualizado al arrastrar ');
                        },
                        error: function(json){
//                            console.log("Error al actualizar arrastrado");
                            $("#send").html(json.message);
                            $("#msg-send-error").fadeIn();
                        }
                    });
                },
                //mostrar informacion del evento en un tooltip al pasar el mouse por encima
                eventMouseover: function( event, jsEvent, view ) {
                    var start = (event.start.format("YYYY-MM-DD HH:mm"));
                    var back=event.color;
                    var area=event.area;
                    var resp=event.user_id;
                    var repeat=event.repeats;
                    var repeat_freq=event.repeats_freq;

                    if(event.end){
                        var end = event.end.format("YYYY-MM-DD HH:mm");
                    }else{var end="No definido";
                    }

                    if (repeat>0){ var recurrent='SI'; }else{var recurrent='NO'; }
                    if (repeat_freq==7){var freq='Semanal';}else if (repeat_freq==30){var freq='Mensual';} else {var freq='';}
//                    if(event.allDay){
//                        var allDay = "Si";
//                    }else{var allDay="No";
//                    }
                    var tooltip = '<div class="tooltipevent" style="padding:10px;border-radius: 10px 10px 10px 10px; width:auto;height:auto;color:#030414;background:'+back+';position:absolute; placement:top;z-index:10001;">' +
                            ''+'<b><center> '+ event.title +' </center></b>'+
                            ''+ 'Area: '+area+'<br>' +
                            ''+ 'Inicio: '+start+'<br>' +
                            ''+ 'Fin: '+ end +'<br>' +
                            ''+ 'Recurrente: '+ recurrent +'<br>' +
                            ''+ 'Frecuencia: '+ freq +'<br>' +
                            ''+'Responsable: '+'<b>'+resp+'</b></div>';
                    $("body").append(tooltip);
                    $(this).mouseover(function(e) {
                        $(this).css('z-index', 10000);
                        $('.tooltipevent').fadeIn('500');
                        $('.tooltipevent').fadeTo('10', 1.9);
                    }).mousemove(function(e) {
                        $('.tooltipevent').css('top', e.pageY -170);
                        $('.tooltipevent').css('left', e.pageX -170);
                    });
                },
                //evento al retirar el mouse se cierra el toolpit
                eventMouseout: function(calEvent, jsEvent) {
                    $(this).css('z-index', 8);
                    $('.tooltipevent').remove();
                },
                //evento para eliminar una tarea al dar click sobre ella
                eventClick: function (event, jsEvent, view) {
                    crsfToken = document.getElementsByName("_token")[0].value;
                    var con=confirm("Esta seguro que desea eliminar el evento");
                    if(con){
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
                    }else{
                        console.log("Cancelado");
                    }
                    return false;
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

            /* AGREGANDO EVENTOS AL PANEL  izquierdo del calendario*/
            var currColor = "#3c8dbc"; //Red by default
            //Color chooser button
            var colorChooser = $("#color-chooser-btn");
            $("#color-chooser > li > a").click(function (e) {
                e.preventDefault();
                //Save color
                currColor = $(this).css("color");
                //Add color effect to button
                $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
            });
            $("#add-new-event").click(function (e) {
                e.preventDefault();
                //Get value and make sure it is not null
                var val = $("#new-event").val();
                if (val.length == 0) {
                    return;
                }

                //Create events
                var event = $("<div />");
                event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
                event.html(val);
                $('#external-events').prepend(event);

                //Add draggable funtionality
                ini_events(event);

                //Remove event from text input
                $("#new-event").val("");
            });
        });
    </script>
@endsection
@endsection