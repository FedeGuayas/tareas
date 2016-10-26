<?php

namespace App\Http\Controllers;

use App\Person;
use App\Task;
use Illuminate\Http\Request;
use App\Area;
use Session;

use App\Http\Requests;

class TaskController extends Controller
{


    public function index(){

        return ("ok");
    }

    public function create()
    {
        $areas_coll=Area::all();
        $list_areas = $areas_coll->pluck('area', 'id');
//        $persons_coll=Person::all();
//        $list_persons = $persons_coll->pluck('first_name','id');
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
        $task->allDay=true;
        $task->color="rgb(92,184,92)";
// "bg-primary"=>rgb(66,139,202),#428bca
//"bg-success" => rgb(92,184,92), #5cb85c
//"bg-info" =>rgb(91,192,222) #5bc0de
//"bg-warning"=>rgb(255,127,80), #FF7F50
//"bg-danger"=> rgb(217,83,79), 	#d9534f

        $task->save();
        Session::flash('message','Tarea creada correctamente');
        return redirect()->route('admin.tasks.index');

    }

    public function update(){
        
    }

    public function delete(){
        
    }
    

}
