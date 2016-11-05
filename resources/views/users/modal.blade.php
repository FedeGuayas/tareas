<div class="modal fade modal-slide-in-right" aria-hidden="true"
     role="dialog" tabindex="-1" id="modal-delete-{{ $user->id }}">
    {{Form::open(['route'=>['admin.users.destroy',$user->id],'method'=>'DELETE'])}}

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hiden="true">x</span>
                </button>
                <h4 class="modal-title">Eliminar Trabajador</h4>
            </div>
            <div class="modal-body">
                <p>Confirme si desea eliminar al Trabajador</p><em><b>{{$user->getFullName()}}</b></em><br>

                <p class=""><i class="fa fa-exclamation-triangle fa-2x text-danger"></i> Si el Trabajador tiene tareas asignadas estas tambien serán eliminadas</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-danger">Confirmar</button>
            </div>
        </div>
    </div>
    {{Form::Close()}}
</div>