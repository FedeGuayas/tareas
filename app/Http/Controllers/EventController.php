<?php

namespace App\Http\Controllers;

use App\Area;
use App\Event;
use App\Task;
use Illuminate\Http\Request;

use App\Http\Requests;

class EventController extends Controller
{
    /**
     * Cragos todos los datos en un json para mostrarlos en el calendario por Ajax
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
//                'task' => $tevent->task->task,
                'description' => $event->task->description,
//                'start_day' => $event->task->start_day,
//                'performance_day' => $event->task->performance_day,
                'end_day' => $event->task->end_day,
                'state' => $event->task->state,
                'user_id' => $event->task->user->getFullName(),
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
     * Display the specified resource.
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
    public function update()
    {

        $id = $_POST['id'];
        $title = $_POST['title'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $task_id = $_POST['task_id'];

        $event=Event::findOrFail($id);
//        if($end=='NULL'){
//            $evento->fechaFin='NULL'; //NULL sin comillas es para postgres
//        }else{
//            $evento->fechaFin=$end;
//        }
        $task = Task::findOrFail($task_id);

        if ($task->repeats==0){

            $task->start_day=$start;
            $task->performnace_day=$end;
            $task->update();
            $event->start =$start;
            $event->end=$end;
            $event->task()->associate($task);
            $event->update();

        }else {

            $event->start=$start;
            $event->task_id=$task_id;
            $event->title=$title;
            $event->end=$end;
            $event->update();
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
        $id = $_POST['id'];
        $event=Event::findOrFail($id);
        $event->delete();
        return redirect()->route('admin.calendar.edit');
    }

    /**
     * Cargar datos del trabajador en la ventana modal en el calendario por ajax
     */
    public function getDataModal()
    {
        $id = $_POST['id'];

        $event = Event::findOrFail($id);

        $task_id=$event->task_id;
        $task=Task::findOrFail($task_id);
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




}
