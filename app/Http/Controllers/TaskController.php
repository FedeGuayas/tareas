<?php

namespace App\Http\Controllers;

use App\Event;

use App\Events\TaskCreated;
use App\Events\TaskFinished;
use App\Role;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use App\Area;
use Illuminate\Queue\SerializesModels;
use Session;
use DB;
use Mail;
use Auth;
use Carbon\Carbon;
use App\Http\Requests\TaskStoreRequest;
use Fenos\Notifynder\Facades\Notifynder;
use Illuminate\Support\Collection as Collection;

use App\Http\Requests;
use Zizaco\Entrust\Entrust;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware(['role:supervisor|administrador'],['except'=>['index','userTaskEnd']]);

    }
    
    /**
     * Colores de estado de la tarea
     * "bg-primary"=>#337ab7
     * "bg-success" =>#5cb85c
     * "bg-info" => #5bc0de
     * "bg-warning"=>#f0ad4e
     * "bg-danger"=> #d9534f
     */

    /**
     * muestra tabla con todas las tareas
     * @return mixed
     */
    public function index()
    {
        $events = Event::all();
        $areas=Area::all();

        $events->each(function ($events) {
            $events->task;
        });

        $areas->each(function ($areas)  {
            $areas->events;
        });
        return view('tasks.index', ['events' => $events,'areas' => $areas]);
    }
    
    

    /**
     * Muestra formulario para crear tareas
     * @return string
     */
    public function create()
    {
//        if(Auth::user()->can('create-task')){
            $areas_coll = Area::all();
            $list_areas = $areas_coll->pluck('area', 'id');
            return view('tasks.create', ['areas' => $list_areas]);
//        }else{
//            Session::flash('message_danger','No tiene permisos para crear tareas');
//            return redirect()->back();
//        }
    }


    /**
     * 
     * Almacena la nueva tarea en la bd, notifica al usuario en el sistema y le envia correo
     *
     * @param TaskStoreRequest $request
     * @return mixed
     */
    public function store(TaskStoreRequest $request)
    {

//        hacemos uso de las funciones para verificar el rol del usuario
            if (Auth::user()->hasRole(['supervisor', 'administrador'])) {
                try {
                    DB::beginTransaction();

                    $task = new Task;
                    $task->task = $request->input('task');
                    $task->description = $request->input('description');
                    $task->start_day = $request->input('start_day');
                    $task->performance_day = $request->input('performance_day');
                    $task->end_day = null;
                    $task->state = false;//no terminada
                    $task->color = "#286090";//tarea recien creada
                    $repeats = $request->input('repeats');
                    $weekday = date('N', strtotime($request->input('start_day')));
                    $task->area_id = $request->input('area_id');
                    $task->created_by = $request->user();
                    
                    if (!$repeats) {
                        // El usuario no marcó checkbox tarea no recurrente
                        $task->repeats = 0;
                        $task->repeats_freq = 0;
                        $task->weekday = $weekday;
                        $task->allDay = true; //resize en calendario
                        $task->save();
                        $event = new Event([
                            'title' => $task->task,
                            'start' => $task->start_day,
                            'end' => $task->performance_day,
                            'end_day' => $task->end_day,
                            'state' => $task->state,
                            'allDay' => $task->allDay
                        ]);
                        $event->task()->associate($task);
                        $event->save();

                    } else {
                        // El usuario marcó checkbox tarea recurrente
                        $start_day = $request->input('start_day');
                        $performance_day = $request->input('performance_day');
                        $repeats = $request->input('repeats');
                        $repeats_freq = $request->input('repeat-freq');
                        $task->allDay = true;
//            $until = (365/$repeats_freq);
//            if ($repeats_freq == 1){ //diario
//                $weekday = 0;
//            }
                        if ($repeats_freq == 7) {
                            //convierto el start_day en objeto carbon
                            $inicio = new Carbon($start_day);
                            $fin = new Carbon($performance_day);
                            //le adiciono 1 año y calculo la diferencia de semanas, esto me da las semanas del año
                            $until = $inicio->diffInWeeks($inicio->copy()->addYear());
                            $task->repeats = $repeats;
                            $task->repeats_freq = $repeats_freq;
                            $task->weekday = $weekday;
                            $task->save();
                            $start_week = $inicio;
                            $end_week = $fin;
                            for ($i = 0; $i < $until; $i++) {
                                $event = new Event([
                                    'title' => $task->task,
                                    'start' => $start_week,
                                    'end' => $end_week,
                                    'end_day' => null,
                                    'state' => false,
                                    'allDay' => true
                                ]);
                                $event->task()->associate($task);
                                $event->save();
                                $start_week = $inicio->addWeek();
                                $end_week = $fin->addWeek();
                            }
                        }
                        if ($repeats_freq == 30) {
                            $inicio = new Carbon($start_day);
                            $fin = new Carbon($performance_day);
                            //le adiciono 1 año y calculo la diferencia de meses, esto me da los meses del año
                            $until = $inicio->diffInMonths($inicio->copy()->addYear());

                            $task->repeats = $repeats;
                            $task->repeats_freq = $repeats_freq;
                            $task->weekday = $weekday;
                            $task->save();
                            $start_month = $inicio;
                            $end_month = $fin;

                            for ($i = 0; $i < $until; $i++) {
                                $event = new Event([
                                    'title' => $task->task,
                                    'start' => $start_month,
                                    'end' => $end_month,
                                    'end_day' => null,
                                    'state' => false,
                                    'allDay' => true
                                ]);
                                $event->task()->associate($task);
                                $event->save();
                                $start_month = $inicio->addMonth();
                                $end_month = $fin->addMonth();
                            }
                        }
                    }
                    //Usuarios a los k se les asigno la tarea
                    $usersId = $request->input('user_id');
                    $task->users()->attach($usersId);

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();

                    Session::flash('message_danger', 'Error' . $e->getMessage());
                    return redirect()->route('admin.tasks.create');
                }

            } else {
//            //si el usuario no cumple con los requisitos, retornamos un error 403
                return abort(403);
            }

//        $receiver=User::findOrFail($task->user_id);
        //notificacion del sistema a un usuario
//        \Notifynder::category('task.new')
//        ->from($request->user())
//        ->to($receiver)
//        ->url('/user/tasks')
//        ->extra(['message' => 'Nueva tarea creada'])
//        ->expire(Carbon::now()->addDays(7))//expirara a la semana
//        ->send();

        $receivers=User::findOrFail($usersId);

        //correo de notificacion
        $sender=$request->user();
        event(new TaskCreated($sender,$task,$receivers));


        //notificacion multiple a todos los usuarios de la tarea
        \Notifynder::loop($receivers, function(\Fenos\Notifynder\Builder\Builder $builder, $receiver) use ($sender) {
            $builder->category('task.new')// definir la categoria de notificacion a enviar
            ->from($sender)
                ->to($receiver)
                ->url('/user/tasks')
                ->extra(['message' => 'Nueva tarea asignada'])
                ->expire(Carbon::now()->addDays(7));
        })->send();


        Session::flash('message', 'Tarea creada correctamente');
        return redirect()->route('admin.tasks.index');
    }


    /**
     * Carga formulario para Editar la tarea 
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {

        $task = Task::findOrFail($id);
        $users=$task->users->pluck('full_name','id');
        $areas_coll = Area::all();
        $areas = $areas_coll->pluck('area', 'id');

        return view('tasks.edit', compact('task', 'areas','users'));
    }


    /**
     * 
     * Actualiza la tarea en la bd, solo se actualizan la tareas no recurrentes, las recurrentes es el calendario
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {

        $task = Task::findOrFail($id);

        if(Auth::user()->hasRole(['supervisor','administrador'])){//verificamos los roles
//        if(Auth::user()->hasRole(['supervisor'])){
        try {
            DB::beginTransaction();

            $task->task = $request->input('task');
            $task->description = $request->input('description');
            $task->start_day = $request->input('start_day');
            $task->performance_day = $request->input('performance_day');
//            $task->end_day = null;
//            $task->state = false;//no terminada
//            $task->color = "#286090";//tarea recien creada
//            $repeats = $request->input('repeats');
            $weekday = date('N', strtotime($request->input('start_day')));
            $task->area_id = $request->input('area_id');
            $task->weekday = $weekday;

            $task->update();

            $event=\App\Event::where('task_id',$id)->first();

            $event->start= $request->input('start_day');
            $event->end= $request->input('performance_day');
            $event->title =$request->input('task');

            $event->task()->associate($task);

            $event->update();
            if ($request->input('user_id')){
                $usersId = $request->input('user_id');//Usuarios a los k se les asigno la tarea
                $task->users()->sync($usersId);
            }


            DB::commit();

        }catch (\Exception $e) {
            DB::rollback();

            Session::flash('message_danger','Error'.$e->getMessage());
            return redirect()->route('admin.tasks.edit');
        }

        Session::flash('message', 'Tarea actualizada correctamente');
        return redirect()->route('admin.tasks.index');
        } else{
            Session::flash('message_danger','No tiene permisos para actualizar tareas');
            return redirect()->back();
        }
    }

    /**
     * elimina una tarea de la bd, esto tambien elimina sus eventos relacionados
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        
        $task=Task::findOrFail($id);
        if(Auth::user()->hasRole(['supervisor','administrador'])){
        $task->delete();
        Session::flash('message_danger','Tarea eliminada');
        return redirect()->route('admin.tasks.index');
        }else{
            Session::flash('message_danger','No estas autorizado para eliminar tareas');
            return redirect()->back();
        }
    }


    /**
     * Solicitud de terminio de tarea por parte del usuario por ajax
     * @param Request $request
     * @param $id
     */
    public function userTaskEnd(Request $request){

      $id=$request->get('datos');

        if ($request->ajax()){

            $event=Event::findOrFail($id);
            $event->end_day=Carbon::now();

            $task=$event->task;
            $user_id=$task->created_by;
            
            
            if ($task->repeats==0){
                $task->end_day=$event->end_day;

                $task->update();
            }
            $event->update();


            //$roles=Role::with('users')->where('name', 'supervisor')->get();
            //usuarios con rol de supervisor
           // $receivers = User::whereHas('roles', function($q){
             //   $q->where('name', 'supervisor');
            //})->get();

            $receivers = User::where('id',$user_id)->get();


            //correo de notificacion
            $sender=$request->user();
            event(new TaskFinished($sender,$task,$receivers));

//            //notificacion multiple a todos los supervisores
        \Notifynder::loop($receivers, function(\Fenos\Notifynder\Builder\Builder $builder, $receiver) use ($sender) {
            $builder->category('task.end.sol')// definir la categoria de notificacion a enviar
            ->from($sender)
                ->to($receiver)
                ->url('/admin/tasks')
                ->extra(['message' => 'Solicitud finalizar tarea'])
                ->expire(Carbon::now()->addDays(7));
        })->send();

            return response()->json(["message"=>"Solicitud de termino de tarea enviada"]);
        }
    }


    /**
     * Aprobacion de terminio de tarea por parte del supervisor
     * @param Request $request
     * @param $id
     */
    public function taskEndAprob(Request $request){

        if(Auth::user()->hasRole('supervisor')){
        $id=$request->get('datos');

        if ($request->ajax()){

            $event=Event::findOrFail($id);
            $event->state=1;
            $event->update();

            $task=$event->task;

            if ($task->repeats==0){
                $task->state=1;
                $task->update();
            }

            $users=$task->users;

            $receivers=$users;
            $sender=$request->user();

//            //notificacion del sistema
//            \Notifynder::category('tasks.end.aprob')
//                ->from($sender)
//                ->to($receiver)
//                ->url('/user/tasks')
//                ->extra(['message' => 'Aprobada la finalizacion de la tarea'])
//                ->expire(Carbon::now()->addDays(7))
//                ->send();

            //notificacion multiple a todos los responsables de la tarea
            \Notifynder::loop($receivers, function(\Fenos\Notifynder\Builder\Builder $builder, $receiver) use ($sender) {
                $builder->category('tasks.end.aprob')// definir la categoria de notificacion a enviar
                ->from($sender)
                    ->to($receiver)
                    ->url('/user/tasks')
                    ->extra(['message' => 'Aprobada la finalizacion de la tarea'])
                    ->expire(Carbon::now()->addDays(7));
            })->send();



            return response()->json(["message"=>"Aprobación enviada"]);
        }
        }else{
            return response()->json(["message"=>"No estas autorizado para aprobar finalizacion de tareas"]);
        }
    }

   
    /**
     * Correo de notificacion por email de nueva tarea
     * @param $user
     * @param $pass
     */

    public function sendNewTaskMail($sender,$task,$receivers){

        $correos=[];
        foreach ($receivers as $receiver) {
         $correos[]= [
             'email'=>$receiver->email
         ];
        }
        $array=array_flatten($correos);//convierte el array multidimensional en una dimension

        Mail::send('emails.new_task', ['sender' => $sender,'receivers'=>$receivers,'task'=>$task], function ($message) use ($array){
            $message->from('admin@fedeguayas.com.ec', 'Gestion de Tareas');
            $message->subject('Nueva Tarea asignada');
             $message->to($array);

        });

    }

    /**
     * Correo de notificacion por email de solicitud de fin de tarea por el usuario
     * @param $user
     * @param $pass
     */
    public function sendEndTaskMail($sender,$task,$receivers){

        $correos=[];
        foreach ($receivers as $receiver) {
            $correos[]= [
                'email'=>$receiver->email
            ];
        }
        $array=array_flatten($correos);

        Mail::send('emails.sol_end_task', ['sender' => $sender,'receivers'=>$receivers,'task'=>$task], function ($message) use ($array){
            $message->from('admin@fedeguayas.com.ec', 'Gestion de Tareas');
            $message->subject('Solicitud Finalización de Tarea');
            $message->to($array);
        });

    }
    
    
}
