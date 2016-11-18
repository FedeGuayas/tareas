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

        });

        $data = [];
        foreach ($events as $event) {
            $data[] = [
                'id' => $event->id,
                'task' => $event->task->task,
                'description' => $event->task->description,
                'start_day' => $event->task->start_day,
                'performance_day' => $event->task->performance_day,
                'end_day' => $event->task->end_day,
                'state' => $event->task->state,
                'user_id' => $event->task->user->getFullNameAttribute(),
                'allDay' => $event->task->allDay,
                'color' => $event->task->color,
                'weekday' => $event->task->weekday,
                'repeats'=>$event->task->repeats,
                'repeats_freq'=>$event->task->repeats_freq,
                'area'=>$event->task->user->area->area,
                'task_id'=>$event->task_id,
                'title'=>$event->title,
                'start'=>$event->start,
                'end'=>$event->end,
                "url" => "getEvents" . "/" . $event->id,
            ];
        }

        json_encode($data);
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Musestra la tarea en detalle.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
                $start_event = $request->get('start');//ok
                $start_day = $request->get('start_day');//ok
                $task_id = $request->get('task_id');//ok
                $end = $request->get('end');//ok
                $performance_day = $request->get('performance_day');//ok
                $title = $request->get('title');//ok
                $repeats = $request->get('repeats');//ok
//        $id = $_POST['id'];
//        $title = $_POST['title'];
//        $start = $_POST['start'];
//        $end = $_POST['end'];
//        $task_id = $_POST['task_id'];

                $event = Event::findOrFail($event_id);
                if($end=="NULL"){
                $event->end="NULL"; //NULL sin comillas es para postgres
                }else{
                    $event->end=$end;
                }

                if ($repeats == 0) { //tarea unica sin evento recurrente

                    $task = Task::findOrFail($task_id);

                    $task->start_day = $start_day;
                    $task->performance_day =$performance_day;

                    $task->update();
                    $event->start = $start_event;
                    $event->end = $end;
                    $event->updated_at = Carbon::now();
                    $event->update();

                } else {//evento recurrente

                    $event->start = $start_event;
                    $event->task_id = $task_id;
                    $event->title = $title;
                    $event->end = $end;
                    $event->update();
                }

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

    public function downloadFile(Request $request, $file)
    {
        $pathtoFile = public_path().'/files/events/'.$file;
        return response()->download($pathtoFile);

    }


}
