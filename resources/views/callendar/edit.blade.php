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
                    <div class="col-md-3">
                        {{--Tareas externas--}}
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h4 class="box-title">Otros eventos</h4>
                            </div>
                            <div class="box-body">
                                <!-- the events -->
                                <div id="external-events">
                                    <div class="external-event bg-success">Tarea 1</div>
                                    <div class="external-event bg-warning">Tarea 2</div>
                                    <div class="external-event bg-primary">Tarea 3</div>
                                    <div class="external-event bg-danger">Tarea 4</div>
                                    <div class="external-event bg-info">Tarea 5</div>
                                    <div class="checkbox">
                                        <label for="drop-remove">
                                            <input type="checkbox" id="drop-remove">
                                            Eliminar al asignar
                                        </label>
                                    </div>
                                </div>
                            </div><!-- /.box-body-->
                        </div><!-- /. box-->
                        {{--/.Tareas externas--}}
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Crear tarea</h3>
                            </div>
                            <div class="box-body">

                                <div class="btn-group" style="width: 100%; margin-bottom: 10px;">

                                    <button type="button" class="btn btn-primary">Color estado</button>
                                    <button type="button" id="color-chooser-btn" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span></button>
                                    <ul class="fc-color-picker dropdown-menu" id="color-chooser">
                                        <li><a class="label-success" href="#"><i class="fa fa-arrow-circle-o-right"></i></a></li>
                                        <li><a class="label-info" href="#"><i class="fa fa-arrow-circle-o-right"></i></a></li>
                                        <li><a class="label-warning" href="#"><i class="fa fa-arrow-circle-o-right"></i></a></li>
                                        <li><a class="label-danger" href="#"><i class="fa fa-arrow-circle-o-right"></i></a></li>
                                        <li><a class="label-primary" href="#"><i class="fa fa-arrow-circle-o-right"></i></a></li>
                                        {{--<li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>--}}
                                        {{--<li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>--}}
                                        {{--<li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>--}}
                                        {{--<li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>--}}
                                        {{--<li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>--}}
                                        {{--<li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>--}}
                                        {{--<li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>--}}
                                        {{--<li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>--}}
                                        {{--<li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>--}}
                                        {{--<li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>--}}
                                        {{--<li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>--}}
                                        {{--<li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>--}}
                                        {{--<li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>--}}
                                    </ul>
                                </div>
                                <!-- /btn-group -->
                                <div class="input-group">
                                    <input id="new-event" type="text" class="form-control" placeholder="Titulo de evento">

                                    <div class="input-group-btn">
                                        <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Agregar</button>
                                    </div>
                                    <!-- /btn-group -->
                                </div><br/><br/>
                                <!-- /input-group -->
                                {!! Form::open(['id' =>'form-calendario']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
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

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex: 1070,
                        revert: true, // will cause the event to go back to its
                        revertDuration: 0  //  original position after the drag
                    });

                });
            }

            ini_events($('#external-events div.external-event'));

            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date();
            var     d = date.getDate(),
                    m = date.getMonth(),
                    y = date.getFullYear();
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

//                weekends: false, // will hide Saturdays and Sundays

                events: { url:"getTasks"},

                editable: false,//true para permitir editar en el calendario
                droppable: true, // this allows things to be dropped onto the calendar !!!

                //acion al ser arrastrado un evento sobre el calendario
                drop: function (date, allDay) { // this function is called when something is dropped
                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');
                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);
                    allDay=true;
                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;
                    copiedEventObject.backgroundColor = $(this).css("background-color");
//                    alert("Dropped on " + date.format());
//                    copiedEventObject.borderColor = $(this).css("border-color");

                    // render the event on the calendar
                    //$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                    //Guardamos el evento creado en base de datos
//                    var title=copiedEventObject.title;
//                    var start=copiedEventObject.start.format("YYYY-MM-DD HH:mm");
//                    var back=copiedEventObject.backgroundColor;

                    crsfToken = document.getElementsByName("_token")[0].value;
                    $.ajax({
                        url: 'guardaEventos',//la URI definida en la ruta
                        data: 'title='+ title+'&start='+ start+'&allday='+allDay+'&background='+back,//parametros pasados en el head al controlador al metodo create
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": crsfToken
                        },
                        success: function(events) {
                            console.log('Evento creado');
                            $('#calendar').fullCalendar('refetchEvents' );
                        },
                        error: function(json){
                            console.log("Error al crear evento");
                        }
                    });
                },//end drop

                /*funciones*/

                //actualiza en la bd al editar en el calendario un evento al cambiar su tamaño, llama al metodo update del controler
                eventResize: function(event) {
                    var start = event.start.format("YYYY-MM-DD HH:mm");
                    var back=event.backgroundColor;
                    var allDay=event.allDay;

                    //compruebo si el evento tiene fecha de fin
                    if(event.end){
                        var end = event.end.format("YYYY-MM-DD HH:mm");//le doy la fecha
                    }else{var end="NULL"; //sino valor nulo para enviar algo al controlador y poder guaradarlo en la bd
                    }
                    crsfToken = document.getElementsByName("_token")[0].value;
                    $.ajax({
                        url: '/actualizaEventos',
                        data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id+'&background='+back+'&allday='+allDay,
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": crsfToken
                        },
                        success: function(json) {
                            console.log("Updated Successfully");
                        },
                        error: function(json){
                            console.log("Error al actualizar evento");
                        }
                    });
                },
                /*actualiza en la bd el evento al arrastarlo y cambiandolo de fecha dentro del calendario*/
                eventDrop: function(event, delta) {
                    var start = event.start.format("YYYY-MM-DD HH:mm");
                    if(event.end){
                        var end = event.end.format("YYYY-MM-DD HH:mm");
                    }else{var end="NULL";
                    }
                    var back=event.backgroundColor;
                    var allDay=event.allDay;
                    crsfToken = document.getElementsByName("_token")[0].value;

                    $.ajax({
                        url: 'actualizaEventos',
                        data: 'title='+ event.title+'&start='+ start +'&end='+ end+'&id='+ event.id+'&background='+back+'&allday='+allDay ,
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": crsfToken
                        },
                        success: function(json) {
                            console.log("Updated Successfully eventdrop");
                        },
                        error: function(json){
                            console.log("Error al actualizar eventdrop");
                        }
                    });
                },
                //mostrar informacion del evento en un tooltip al pasar el mouse por encima
                eventMouseover: function( event, jsEvent, view ) {
                    var start = (event.start.format("HH:mm"));
                    var back=event.backgroundColor;
                    if(event.end){
                        var end = event.end.format("HH:mm");
                    }else{var end="No definido";
                    }
                    if(event.allDay){
                        var allDay = "Si";
                    }else{var allDay="No";
                    }
                    var tooltip = '<div class="tooltipevent" style="width:200px;height:100px;color:#030414;background:'+back+';position:absolute;z-index:10001;">'+'<center>'+ event.title +'</center>'+'Todo el dia: '+allDay+'<br>'+ 'Inicio: '+start+'<br>'+ 'Fin: '+ end +'</div>';
                    $("body").append(tooltip);
                    $(this).mouseover(function(e) {
                        $(this).css('z-index', 10000);
                        $('.tooltipevent').fadeIn('500');
                        $('.tooltipevent').fadeTo('10', 1.9);
                    }).mousemove(function(e) {
                        $('.tooltipevent').css('top', e.pageY + 10);
                        $('.tooltipevent').css('left', e.pageX + 20);
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