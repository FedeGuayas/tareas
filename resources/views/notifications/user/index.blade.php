@extends ('layouts.dashboard')
@section('page_heading','Notificaciones')

@section('section')


    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                @include('alert.success')
                <table id="noti_table" class="table table-striped table-bordered" cellspacing="0" width="100%"
                       data-order='[[ 1, "asc" ]]' style="display: none">
                    <thead>
                    <tr>
                        {{--<th>id</th>--}}
                        <th>De</th>
                        <th>Notificación</th>
                        <th>Fecha Notificación</th>
                        <th>Estado</th>
                        <th>Tareas</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        {{--<th>id</th>--}}
                        <th>De</th>
                        <th>Notificación</th>
                        <th>Fecha Notificación</th>
                        <th>Estado</th>
                        <th>Tareas</th>
                        <th>Acción</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($notifications as $notifi)
                        <tr>
                            <td>{{$notifi->from->getFullName()}}</td>
                            <td>{{$notifi->text}}</td>
                            <td>{{$notifi->created_at}}</td>
                            <td>
                                @if ($notifi->read)
                                    <span class="label label-success">Leida</span>
                                @else
                                    <span class="label label-warning">Nueva</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ $notifi->url }}" class="btn btn-xs btn-primary tip" data-placement="top" title="Tarea"><i class="fa fa-tasks" aria-hidden="true"></i>
                                </a>

                            </td>
                            <td>
                                <a href="{{ route('user.notification.destroy',$notifi->id)}}" class="btn btn-xs btn-danger tip" data-placement="top" title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i>
                                </a>

                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script type="text/javascript">

        $(document).ready( function () {

            var table =  $('#noti_table').DataTable({
                "lengthMenu": [[5, 7, 10, 25], [5, 7, 10, 25]],
                "processing": true,
//            "serverSide": false,
//            "ajax":"api/result",
//            "columns":[
//                {data:'first_name'},
//                {data:'second_name'},
//                {data:'last_name'},
//                {data:'sex'},
//                {data:'category'},
//                {data:'circuit'},
//                {data:'place'},
//                {data:'time'},
//            ],
//            select: true
                "language":{
                    "decimal":        "",
                    "emptyTable":     "No se encontraron datos en la tabla",
                    "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered":   "(filtrados de un total _MAX_ registros)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing":     "Procesando...",
                    "search":         "Buscar:",
                    "zeroRecords":    "No se encrontraron coincidencias",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Ultimo",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    },
                    "aria": {
                        "sortAscending":  ": Activar para ordenar ascendentemente",
                        "sortDescending": ": Activar para ordenar descendentemente"
                    }
                },
                "fnInitComplete":function(){
                    $('#noti_table').fadeIn();
                }
            });


            $(function () {
                $('.tip').tooltip()
            });

        } );
    </script>
@endsection