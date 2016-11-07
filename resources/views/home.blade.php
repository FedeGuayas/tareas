@extends('layouts.dashboard')
@section('page_heading','Administración de Tareas')
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
                </div>
                <!-- /.row -->
            </section>

            <!-- /.content -->
        </div><!-- /.panel-body -->

    </div><!-- /.panel -->
    @include('callendar.modalInfo')
    {!! Form::open(['id' =>'form-calendario']) !!}
    {!! Form::close() !!}
@endsection

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
                    }
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
                displayEventEnd:true,

//                weekends: false, // will hide Saturdays and Sundays

                events: {
                    url:"getEvents"
                },

                editable: false,//true para permitir editar en el calendario

                /*funciones*/

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
                    }else{
                        var end="No definido";
                    }

                    if (repeat>0){ var recurrent='SI'; }else{var recurrent='NO'; }
                    if (repeat_freq==7){var freq='Semanal';}else if (repeat_freq==30){var freq='Mensual';} else {var freq='';}



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
                        $('.tooltipevent').css('top', e.pageY - 170);
                        $('.tooltipevent').css('left', e.pageX -170);
                    });
                },
                //evento al retirar el mouse se cierra el toolpit
                eventMouseout: function(calEvent, jsEvent) {
                    $(this).css('z-index', 8);
                    $('.tooltipevent').remove();
                },
                //evento para mostrar info en ventana modal
                eventClick: function (event, jsEvent, view) {

                    var start = (event.start.format("YYYY-MM-DD HH:mm"));
                    var back=event.color;
                    var area=event.area;
                    var resp=event.user_id;

                    if(event.end){
                        var end = event.end.format("YYYY-MM-DD HH:mm");
                    }else{var end="No definido";
                    }

                    //limpio los datos de la tabla
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
//                            console.log(data.asignada);//no funciona asi
                            console.log(data);
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

        });
    </script>

@endsection




