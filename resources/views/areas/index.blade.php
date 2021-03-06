@extends ('layouts.dashboard')
@section('title','Areas')
@section('page_heading','Listado de las áreas')

@section('section')
    <div class="col-sm-12 col-lg-6">
        <div class="row">
            <a href="{{ route('admin.areas.create' )}}" class="btn btn-success tip pull-left" data-placement="right"
               title="Nueva"><i class="fa fa-building-o" aria-hidden="true"></i>
                Nueva</a>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                @include('alert.success')
                <table id="area_table" class="table table-striped table-bordered" cellspacing="0" width="100%"
                       data-order='[[ 0, "asc" ]]' style="display: none">
                    <thead>
                        <tr>
                            <th>Area</th>
                            <th>Trabajadores</th>
                            <th>Tareas</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Area</th>
                        <th>Trabajadores</th>
                        <th>Tareas</th>
                        <th>Acción</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($areas as $area)
                        <tr>
                            <td>{{$area->area}}</td>
                            <td>
                                @foreach($area->users as $user)
                                    {{$user->getFullNameAttribute()}}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach($area->tasks as $task)
                                    {{$task->task}}<br>
                                @endforeach
                            </td>
                            <td>
                                {{--@permission('edit-area')--}}
                                <a href="{{ route('admin.areas.edit', $area->id )}}" class="btn btn-xs btn-warning tip" data-toggle="tooltip" data-placement="top"  title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                {{--@endpermission--}}
                                {{--@permission('delete-area')--}}
                                <a href="" data-target="#modal-delete-{{ $area->id }}" data-toggle="modal" class="btn btn-xs btn-danger tip"  data-placement="top" title="Elimminar"><i class="fa fa-trash" aria-hidden="true"></i>
                                </a>


                                {{--@endpermission--}}
                            </td>
                        </tr>
                        @include('areas.modal')
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

            var table =  $('#area_table').DataTable({
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
                    $('#area_table').fadeIn();
                }
            });



        } );

        $(function () {
            $('.tip').tooltip()
        });

    </script>
@endsection