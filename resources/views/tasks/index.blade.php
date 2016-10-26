@extends ('layouts.dashboard')
@section('page_heading','Listado de las áreas')

@section('section')
@include('alert.success')
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">12</div>
                        <div>Nueva tarea</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">Ver detalles</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
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


            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });

        } );
    </script>
@endsection