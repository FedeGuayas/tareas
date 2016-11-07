@extends('layouts.dashboard')

@section('page_heading','Listado Trabajadores')

@section('section')

    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                @include('alert.success')
                <table id="users_table" class="table table-striped table-bordered" cellspacing="0" width="100%"
                       data-order='[[ 1, "asc" ]]' style="display: none">
                    <thead>
                    <tr>
                        {{--<th>id</th>--}}
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Area</th>
                        <th>Tareas</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        {{--<th>id</th>--}}
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Area</th>
                        <th>Tareas</th>
                        <th>Acción</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            {{--<td>{{$area->id}}</td>--}}
                            <td>{{$user->name}}</td>
                            <td>{{$user->getFullName()}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->area['area']}}</td>
                            <td>
                                <a href="#!" class="btn btn-xs bg-info">Total  <span class="badge">{{$user->tasks->count()}}</span></a>

                                @foreach($user->tasks as $task)
                                    @if ($task->repeats==1){{--repetitiva--}}
                                        <a href="#!" class="btn btn-xs bg-primary">Recurrentes <span class="badge">{{$task->events->count()}}</span></a>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id )}}" class="btn btn-xs btn-warning tip" data-placement="top" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <a href="" data-target="#modal-delete-{{ $user->id }}" data-toggle="modal" class="btn btn-xs btn-danger tip"  data-placement="top" title="Elimminar"><i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                                @permission('create-role')
                                <a href="{{ route('admin.users.roles', $user->id )}}" class="btn btn-xs btn-warning tip" data-placement="top" title="Roles"><i class="fa fa-key" aria-hidden="true"></i>
                                </a>
                                @endpermission
                            </td>
                        </tr>
                        @include('users.modal')
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

            var table =  $('#users_table').DataTable({
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
                    $('#users_table').fadeIn();
                }
            });


            $(function () {
                $('.tip').tooltip()
            });

        } );
    </script>
@endsection