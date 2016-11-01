<?php

namespace App\Http\Controllers;

use App\Person;
use App\Task;
use Illuminate\Http\Request;
use App\Area;
use Illuminate\Queue\SerializesModels;
use Session;
use DB;
use Auth;

use App\Http\Requests;

class TaskController extends Controller
{
    
    /**
     * Colores de estado de la tarea
     * "bg-primary"=>#337ab7
     * "bg-success" =>#5cb85c
     * "bg-info" => #5bc0de
     * "bg-warning"=>#f0ad4e
     * "bg-danger"=> #d9534f
     */

    /*muestra tabla con todas las tareas*/
    public function index()
    {

        $tasks = Task::all();

        $tasks->each(function ($tasks) {
            $tasks->person;
            $tasks->area;
        });
        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function create()
    {
        if(Auth::check()){
            $areas_coll = Area::all();
            $list_areas = $areas_coll->pluck('area', 'id');
            return view('tasks.create', ['areas' => $list_areas]);
        }else{
            return "Inicie sesión para poder crear Tareas";
        }
    }

    public function store(Request $request)
    {
        //hacemos uso de las funciones para verificar el rol del usuario
        if(Auth::user()->hasRole('administrador')) {
            
            $task = new Task;
            $task->task = $request->get('task');
            $task->description = $request->get('description');
            $task->start_day = $request->get('start_day');
            $task->performance_day = $request->get('performance_day');
            $task->performance_day = $request->get('performance_day');
            $task->state = true;
            $task->end_day = null;
            $task->area_id = $request->get('area_id');
            $task->person_id = $request->get('person_id');
            $task->allDay = false;
            $task->color = "#337ab7";

            $task->save();
            Session::flash('message', 'Tarea creada correctamente');
            return redirect()->route('admin.tasks.index');
        }else{
            //si el usuario no cumple con los requisitos, retornamos un error 403
            return abort(403);
        }
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);

        $areas_coll = Area::all();
        $list_areas = $areas_coll->pluck('area', 'id');

        $persons_coll = Person::select(DB::raw('CONCAT(first_name, " ", last_name) AS name'), 'id')->where('id', $task->person_id);
        $list_persons = $persons_coll->pluck('name', 'id');


        return view('tasks.edit', ['task' => $task, 'areas' => $list_areas, 'person' => $list_persons]);

    }

    public function update(Request $request, $id)
    {

        $task = Task::findOrFail($id);
        if(Auth::user()->hasRole(['administrador','gestor'])){//verificamos los roles

        $task->task = $request->get('task');
        $task->description = $request->get('description');
        $task->start_day = $request->get('start_day');
        $task->performance_day = $request->get('performance_day');
        $task->performance_day = $request->get('performance_day');
//        $task->state=true;
//        $task->end_day=null;
        $task->area_id = $request->get('area_id');
        $task->person_id = $request->get('person_id');
//        $task->allDay=true;
//        $task->color="rgb(92,184,92)";

        $task->update();
        Session::flash('message', 'Tarea actualizada correctamente');
        return redirect()->route('admin.tasks.index');
        } else{
            return "usted no tiene permisos para actualizar esta tarea";
        }

    }

    public function delete()
    {

    }

    public function show($id)
    {

    }


    /**
     * Cargar tareas en el calendario por ajax
     */
    public function getTasks()
    {

        $tasks = Task::all();

        $tasks->each(function ($tasks) {
            $tasks->person;
            $tasks->area;
        });

        $data = [];
        foreach ($tasks as $task) {
            $data[] = [
                'id' => $task->id,
                'title' => $task->task,
                'description' => $task->description,
                'start' => $task->start_day,
                'end' => $task->performance_day,
                'end_day' => $task->end_day,
                'state' => $task->state,
                'area_id' => $task->area->area,
                'person_id' => $task->person->getFullName(),
                'allDay' => $task->allDay,
                'color' => $task->color,
                "url" => "getTasks" . "/" . $task->id,
            ];
        }

        json_encode($data);
        return $data;

    }


    /**
     * Cargar datos del trabajador en la ventana modal en el calendario por ajax
     */
    public function getDataModal()
    {
        $id = $_POST['id'];

        $task = Task::findOrFail($id);
        $person = $task->person;//responsable de la tarea
        $asignadas = $person->tasks->count();//cantidad de tareas asignadas a este trabajador
        $terminadas = Task::where('person_id', $person->id)
            ->where('state', false)->count();
        $pendientes = $asignadas - $terminadas;//tareas pendientes
        $cumplimiento = round((($terminadas * 100) / $asignadas), 2);//%de tareas cumplidas

        $data[] = [
            'asignadas' => $asignadas,
            'terminadas' => $terminadas,
            'pendientes' => $pendientes,
            'cumplimiento' => $cumplimiento
        ];


        return response()->json($data);
    }
}
