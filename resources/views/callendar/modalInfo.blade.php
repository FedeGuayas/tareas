<div id="modalInfo" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <h4 id="modalTitle" class="modal-title"></h4>
            </div>
            <div id="modalBody" class="modal-body">

                <div class="row">
                    <div class="form-horizontal">
                        <div class="form-group">
                            {!! Form::label('area_id','Area',['class'=>'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('area_id',null,['class'=>'form-control', 'disabled']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('start','Fecha Inicio',['class'=>'col-sm-3 control-label']) !!}
                            <div class="col-sm-4">
                                {!! Form::text('start',null,['class'=>'form-control', 'disabled']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('end','Fecha Fin',['class'=>'col-sm-3 control-label']) !!}
                            <div class="col-sm-4">
                                {!! Form::text('end',null,['class'=>'form-control', 'disabled']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('person_id','Responsable',['class'=>'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('person_id',null,['class'=>'form-control', 'disabled']) !!}
                            </div>
                        </div>
                    </div>
                </div>

               {{--<div class="divider"></div>--}}
                <table id="modal_table" class="table table-bordered" cellspacing="0" width="100%"
                       data-order='[[ 1, "asc" ]]'>
                    <thead class="info">
                    <tr>
                        {{--<th>id</th>--}}
                        <th>Tareas asignadas:</th>
                        <th>Terminadas</th>
                        <th>Pendientes</th>
                        <th>% Cumplimiento</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                           {{--<td>{{$area->id}}</td>--}}
                            <td class="text-center"><h4 ><span class="label label-primary" id="asignadas"></span></h4></td>
                            <td class="text-center"><h4 ><span class="label label-success" id="terminadas"></span></h4></td>
                            <td class="text-center"><h4 ><span class="label label-danger" id="pendientes"></span></h4></td>
                            <td class="text-center"><h4 ><span class="label label-warning" id="cumplimiento"></span></h4></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer bg-success">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                {{--<button class="btn btn-primary"><a id="eventUrl" target="_blank">Event Page</a></button>--}}
            </div>
        </div>
    </div>
</div>