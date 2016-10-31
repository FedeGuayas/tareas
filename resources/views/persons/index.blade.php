@extends ('layouts.dashboard')
@section('page_heading','Listado de trabajadores')

@section('section')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-1">
                @include('alert.success')
                <table id="persons_table" class="table table-striped table-bordered" cellspacing="0" width="100%"
                       data-order='[[ 1, "asc" ]]' style="display: none">
                    <thead>
                    <tr>
                        {{--<th>id</th>--}}
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Area</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        {{--<th>id</th>--}}
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Area</th>
                        <th>Acción</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($persons as $person)
                        <tr>
                            {{--<td>{{$area->id}}</td>--}}
                            <td>{{$person->getFullName()}}</td>
                            <td>{{$person->phone}}</td>
                            <td>{{$person->user->email}}</td>
                            <td>{{$person->area->area}}</td>
                            <td>
                                <a href="{{ route('admin.persons.edit', $person->id )}}" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <a href="" data-target="#modal-delete-{{ $person->id }}" data-toggle="modal" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Elimminar"><i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                        @include('persons.modal')
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

            var table =  $('#persons_table').DataTable({
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
                    $('#persons_table').fadeIn();
                }
            });


            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });

        } );
    </script>
@endsection