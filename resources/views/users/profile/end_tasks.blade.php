<div class="modal fade modal-slide-in-right" aria-hidden="true"
     role="dialog" tabindex="-1" id="modal-coment-{{ $event->id }}">

    {{Form::open(['route'=>['user.task.end',$event->id],'method'=>'POST'])}}

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hiden="true">x</span>
                </button>
                <h4 class="modal-title">Dar por terminada: {{$event->title}}</h4>
            </div>
            <div class="modal-body">
                <p>Confirme si desea notificar el termino de su tarea. Esta accion enviará una notificación para que un responsable de por cumplida la misma</p></em>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

                    <button type="submit" class="btn btn-primary " >Confirmar</button>

            </div>
        </div>
    </div>

    {{Form::Close()}}
</div>