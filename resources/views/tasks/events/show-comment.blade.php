@extends ('layouts.dashboard')
@section('title','Tareas')
@section('page_heading','Comentarios para, '.$event->title)

@section('section')

    <div class="col-sm-12">
        @include('alert.success')
        <div class="row">
            <div class="col-lg-12">

                <table id="comment_table" class="table table-striped table-bordered" cellspacing="0" width="100%" data-order='[[ 0, "asc"]]' style="display: none">
                    <thead>
                        <tr>
                            <th>Titulo</th>
                            <th>Comentario</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Titulo</th>
                            <th>Comentario</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @foreach($event->comments as $comment)
                        <tr>
                            <td>
                                {{$comment->title}}
                            </td>
                            <td>
                                {{$comment->body}}
                            </td>
                            <td>
                                {{$comment->user->getFullNameAttribute()}}
                            </td>
                            <td>
                                <a href="{{route('task.edit.comment',$comment->id)}}" class="btn btn-xs btn-warning" data-placement="top" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="#!" data-target="#modal-delete-{{ $comment->id }}" data-toggle="modal" class="btn btn-xs btn-danger tip"  data-placement="top" title="Elimminar"><i class="fa fa-trash" aria-hidden="true"></i>
                                </a>

                            </td>
                        </tr>
                        @include('tasks.events.modal-delete')
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script type="text/javascript">

        $(document).ready(function () {

            var table = $('#comment_table').DataTable({
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
                "language": {
                    "decimal": "",
                    "emptyTable": "No se encontraron datos en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(filtrados de un total _MAX_ registros)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encrontraron coincidencias",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": Activar para ordenar ascendentemente",
                        "sortDescending": ": Activar para ordenar descendentemente"
                    }
                },
                "fnInitComplete": function () {
                    $('#comment_table').fadeIn();
                }
            });

        });
    </script>
@endsection