<?php

namespace App\Http\Controllers;

use App\Area;
use App\Comments;
use App\Event;
use App\File;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','getDataModal']]);
        $this->middleware(['role:supervisor|administrador'],['only'=>['update','destroy']]);

    }


    /**
     * Cargo todos los datos en un json para mostrarlos en el calendario por Ajax
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();

        $events->each(function ($events)  {
            $events->task;
           $events->task->users;
        });

        $data = [];
        foreach ($events as $event) {
            $data[] = [
                'id' => $event->id,
                'start'=>$event->start,
                'end'=>$event->end,
                'title'=>$event->title,
                'task_id'=>$event->task_id,
                'estado' => $event->state,
                'end_day' => $event->end_day,
                'allDay' => $event->allDay,

                'task' => $event->task->task,
                'description' => $event->task->description,
                'start_day' => $event->task->start_day,
                'performance_day' => $event->task->performance_day,

                'users' => $event->task->users,
                'color' => $event->task->color,
                'weekday' => $event->task->weekday,
                'repeats'=>$event->task->repeats,
                'repeats_freq'=>$event->task->repeats_freq,
                'area'=>$event->task->area->area,

//                "url" => "getEvents" . "/" . $event->id,
            ];
        }

        json_encode($data);
        return $data;
    }


    /**
     * Cargo todos los datos para el usuario logueado en un json para mostrarlos en el calendario  home por Ajax
     *
     * @return \Illuminate\Http\Response
     */
    public function userEvents()
    {
        $user=Auth::user();

        $events=\App\Event::
        join('task_user as t','t.task_id','=','e.task_id',' as e')
            ->join('users as u','u.id','=','t.user_id')
            ->select('e.id','e.task_id','e.start','e.end','e.title','e.end_day','e.state','e.created_at','e.updated_at','t.user_id','t.task_id','u.area_id','u.first_name','u.last_name','u.phone','u.email')
            ->where('t.user_id',$user->id)
            ->get();

        $events->each(function ($events) {
            $events->tasks;

        });

//dd($events);

        $data = [];
        foreach ($events as $event) {

            $data[] = [
                'id' => $event->id,
                'start'=>$event->start,
                'end'=>$event->end,
                'title'=>$event->title,
                'task_id'=>$event->task_id,
                'estado' => $event->state,
                'end_day' => $event->end_day,
                'allDay' => $event->allDay,
//                tasks
//                'task' => $event->task->task,
//                'description' => $event->description,
//                'start_day' => $event->start_day,
//                'performance_day' => $event->performance_day,
//                'users' => $event->task->user,
//                'color' => $event->color,
//                'weekday' => $event->weekday,
//                'repeats'=>$event->repeats,
//                'repeats_freq'=>$event->repeats_freq,
//                'area'=>$event->task->area->area,

//                "url" => "getEvents" . "/" . $event->id,
            ];
        }

       json_encode($data);

        return $data;
    }
    
    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('callendar.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        if ($request->ajax()) {


            if (Auth::user()->can('edit-task')) {

                $event_id = $request->get('id');//ok
                $start = $request->get('start');//ok
                $task_id = $request->get('task_id');//ok
                $end = $request->get('end');//ok
                $end_day = $request->get('end_day');//ok
                $title = $request->get('title');//ok
                $repeats = $request->get('repeats');//ok
                $state = $request->get('state');//ok
                $allDay= $request->get('allDay');//ok

//        $id = $_POST['id'];
//        $title = $_POST['title'];
//        $start = $_POST['start'];
//        $end = $_POST['end'];
//        $task_id = $_POST['task_id'];

                $event = Event::findOrFail($event_id);

                if($end=="NULL"){
                $event->end="NULL"; //Para Postgres se pone NULL sin comillas por compatibilidad
                }else{
                    $event->end=$end;
                }

                $task = Task::findOrFail($task_id);
                $task->start_day =$start;
                $task->end_day = $end;
//                 $task->performance_day =$end_day;
                $weekday = date('N', strtotime($start));
                $task->weekday=$weekday;
                $task->update();

                $event->start = $start;
                $event->end = $end;
                $event->allDay = $allDay;
                $event->updated_at = Carbon::now();
                $event->update();

            }else{
                Session::flash('message_danger','No tien permisos para realizar esta acción');
                return redirect()->back();
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if (Auth::user()->can('delete-task')) {
            
            $id = $_POST['id'];
            $event = Event::findOrFail($id);
            $task=$event->task;

            if ($task->repeats==0){
                $task->delete();
            }

            if ($task->repeats==1 && count($task->events)==1){
                $task->delete();
            }

            $event->delete();
//        return redirect()->route('admin.calendar.edit');
            return response()->json(["message"=>"Se elimino el evento"]);
        }else{
            return response()->json(["message"=>"No estas autorizado eliminar tareas"]);
        }
//
    }
//        

    /**
     * Cargar datos del trabajador en la ventana modal en el calendario por ajax
     */
    public function getDataModal()
    {
        $id = $_POST['id'];

        $event = Event::find($id);

        $task_id=$event->task_id;
        $task=Task::find($task_id);
//        $user_id=$task->user;

        $user = $event->task->user;//responsable de la tarea
        $asignadas = $user->tasks->count();//cantidad de tareas asignadas a este trabajador

        $terminadas = Task::where('user_id', $user->id)
            ->where('state', true)->count();
        $pendientes = $asignadas - $terminadas;//tareas pendientes
        $cumplimiento = round((($terminadas * 100) / $asignadas), 2);//%de tareas cumplidas

        $data[] = [
            'asignadas' => $asignadas,
            'terminadas' => $terminadas,
            'pendientes' => $pendientes,
            'cumplimiento' => $cumplimiento
        ];

        json_encode($data);
        return $data;
    }

    /**
     * Mostrar vista para cargar archivos a la tarea.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getFileUpload($id)
    {
        $event=\App\Event::findOrFail($id);
        return view('tasks.events.fileUp',compact('event'));
    }

    /**
     * Guarda comentarios y archivos para el evento
     * @param Request $request
     * @return mixed
     */
    public function postFileUpload(Request $request)
    {
        $user=$request->user();

        $event=$request->input('event_id');


        if ($request->input('body')){
            $comment=new Comments;
            $comment->title=$request->input('title');
            $comment->body=$request->input('body');
            $comment->user()->associate($user);
            $comment->event()->associate($event);
            $comment->save();
        }

        $files = Input::file('file');
        $file_count = count($files);
        // contador de archivos a subir
        $uploadcount = 0;
        if ($request->hasFile('file')) {
            foreach($files as $file) {
                $archivo=new File();
                $name = 'requerimiento_' . time() . '.' . $file->getClientOriginalExtension();
                $path = public_path() . '/files/events/';//ruta donde se guardara
                $upload_success = $file->move($path, $name);//lo copio a $path con el nombre $name
                $archivo->name = $name;//ahora se guarda  en el atributo foto_ced la imagen
                $archivo->event()->associate($event);
                $archivo->save();
                $uploadcount ++;
            }

            if($uploadcount == $file_count){
                Session::flash('message', 'Subida de archivos satisfactoria');
                return redirect()->route('user.profile.tasks');
            }
            else {
                Session::flash('message_danger','Error en la subida de archivos');
                return redirect()->back();
            }
        }
        return redirect()->route('user.profile.tasks');
    }


    /**
     * descargar los archivos adjuntos
     * @param Request $request
     * @param $file
     * @return mixed
     */
    public function downloadFile(Request $request, $file)
    {
        $pathtoFile = public_path().'/files/events/'.$file;
        return response()->download($pathtoFile);
    }


   


}
