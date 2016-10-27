<?php

namespace App\Http\Controllers;

use App\Person;
use App\Task;
use Illuminate\Http\Request;
use App\Area;
use Session;
use DB;

use App\Http\Requests;

class TaskController extends Controller
{
    /**
     * Colores de estado de la tarea
     * "bg-primary"=>rgb(66,139,202),#428bca
     * "bg-success" => rgb(92,184,92), #5cb85c
     * "bg-info" =>rgb(91,192,222) #5bc0de
     * "bg-warning"=>rgb(255,127,80), #FF7F50
     * "bg-danger"=> rgb(217,83,79), 	#d9534f
     */

    public function index(){

        $tasks=Task::all();

        $tasks->each(function ($tasks) {
             $tasks->person;
            $tasks->area;
        });
        return view('tasks.index',['tasks'=>$tasks]);
    }

    public function create()
    {
        $areas_coll=Area::all();
        $list_areas = $areas_coll->pluck('area', 'id');
        return view('tasks.create',['areas'=>$list_areas]);
    }

    public function store(Request $request){
        $task=new Task;
        $task->task=$request->get('task');
        $task->description=$request->get('description');
        $task->start_day=$request->get('start_day');
        $task->performance_day=$request->get('performance_day');
        $task->performance_day=$request->get('performance_day');
        $task->state=true;
        $task->end_day=null;
        $task->area_id=$request->get('area_id');
        $task->person_id=$request->get('person_id');
        $task->allDay=false;
        $task->color="rgb(92,184,92)";

        $task->save();
        Session::flash('message','Tarea creada correctamente');
        return redirect()->route('admin.tasks.index');

    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        
        $areas_coll = Area::all();
        $list_areas = $areas_coll->pluck('area', 'id');

        $persons_coll = Person::select(DB::raw('CONCAT(first_name, " ", last_name) AS name'), 'id')->where('id',$task->person_id);
        $list_persons = $persons_coll->pluck('name', 'id');
        

       
        return view('tasks.edit',['task'=>$task,'areas'=>$list_areas,'person'=>$list_persons]);

    }



    public function update(Request $request, $id){

        $task=Task::findOrFail($id);
        $task->task=$request->get('task');
        $task->description=$request->get('description');
        $task->start_day=$request->get('start_day');
        $task->performance_day=$request->get('performance_day');
        $task->performance_day=$request->get('performance_day');
//        $task->state=true;
//        $task->end_day=null;
        $task->area_id=$request->get('area_id');
        $task->person_id=$request->get('person_id');
//        $task->allDay=true;
//        $task->color="rgb(92,184,92)";

        $task->update();
        Session::flash('message','Tarea actualizada correctamente');
        return redirect()->route('admin.tasks.index');


    }

    public function delete(){
        
    }


    /**
     * Cargar tareas en el calendario
     */
    public function getTasks(){
        
        $tasks=Task::all();
        
        $tasks->each(function ($tasks) {
            $tasks->person;
            $tasks->area;
        });

        $data=[];
        foreach ($tasks as $task){
            $data[]=[
                'id'=>$task->id,
                'title'=>$task->task,
                'description'=>$task->description,
                'start'=>$task->start_day,
                'end'=>$task->performance_day,
                'end_day'=>$task->end_day,
                'state'=>$task->state,
                'area_id'=>$task->area->area,
                'person_id'=>$task->person->getFullName(),
                'allDay'=>$task->allDay,
                'color'=>$task->color,
                "url"=>"getTasks"."/".$task->id,
            ];
        }

        json_encode($data);
         //convertimos el array principal $data a un objeto Json
        return $data;


//        $data = array(); //declaramos un array principal que va contener los datos
//        $id = Task::all()->pluck('id'); //listo todos los id de los eventos
//        $task = Task::all()->pluck('task');
//        $description = Task::all()->pluck('description');
//        $start_day = Task::all()->pluck('start_day');
//        $performance_day = Task::all()->pluck('performance_day');
//        $end_day= Task::all()->pluck('end_day');
//        $state= Task::all()->pluck('state');
//        $area_id= Task::all()->pluck('area_id');
//        $person_id= Task::all()->pluck('person_id');
//        $allDay= Task::all()->pluck('allDay');
//        $background= Task::all()->pluck('color');
//        $count = count($id); //contamos los ids obtenidos para saber el numero exacto de eventos
//
//        //hacemos un ciclo para anidar los valores obtenidos a nuestro array principal $data
//        for($i=0;$i<$count;$i++){
//            $data[$i] = array(
//                //obligatoriamente "title", "start" y "url" son campos requeridos por el plugin, asi que asignamos a cada uno el valor correspondiente
//                "id"=>$id[$i],
//                "title"=>$task[$i],
//                "description"=>$description[$i],
//                "start"=>$start_day[$i],
//                "performance_day"=>$performance_day[$i],//dia programado para termino
//                "end_day"=>$end_day[$i],//dia real de termino
//                "state"=>$state[$i],
//                "area_id"=>$area_id[$i],
//                "person_id"=>$person_id[$i],
//                "allDay"=>$allDay[$i],
//                "backgroundColor"=>$background[$i],
////               "borderColor"=>$borde[$i],
//
//               "url"=>"getTasks".$id[$i]
//                //en el campo "url" concatenamos el el URL con el id del evento para luego
//                //en el evento onclick de JS hacer referencia a este y usar el método show
//                //para mostrar los datos completos de un evento
//            );
//        }

//        json_encode($data); //convertimos el array principal $data a un objeto Json
//        return $data; //para luego retornarlo y estar listo para consumirlo
    }

    public function show($id){

    }

}
