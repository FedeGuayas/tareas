<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TaskController extends Controller
{


    public function index()
    {
//        $data = array(); //declaramos un array principal que va contener los datos
//        $id = TaskController::all()->lists('id'); //listamos todos los id de los eventos
//        $task = TaskController::all()->lists('task'); //lo mismo para lugar y fecha
//        $description = TaskController::all()->lists('description');
//        $start_day = TaskController::all()->lists('start_day');
//        $performance_day = TaskController::all()->lists('performance_day');
//        $end_day = TaskController::all()->lists('end_day');
//        $state = TaskController::all()->lists('state');
//        $area_id = TaskController::all()->lists('area_id');
//        $person_id = TaskController::all()->lists('person_id');
////        $background = TaskController::all()->lists('color');
//        $count = count($id); //contamos los ids obtenidos para saber el numero exacto de eventos

        //hacemos un ciclo para anidar los valores obtenidos a nuestro array principal $data
//        for($i=0;$i<$count;$i++){
//            $data[$i] = array(
//                "task"=>$task[$i], //obligatoriamente "title", "start" y "url" son campos requeridos
//                "description"=>$description[$i],
//                "start_day"=>$start_day[$i], //por el plugin asi que asignamos a cada uno el valor correspondiente
//                "performance_day"=>$performance_day[$i],
//                "end_day"=>$end_day[$i],
//                "state"=>$state[$i],
//                "area_id"=>$area_id[$i],
//                "person_id"=>$person_id[$i],
////                "allDay"=>$allDay[$i],
////                "backgroundColor"=>$background[$i],
////                "borderColor"=>$borde[$i],
//                "id"=>$id[$i],
//                "url"=>"cargaTask".$id[$i]
//                //en el campo "url" concatenamos el el URL con el id del evento para luego
//                //en el evento onclick de JS hacer referencia a este y usar el método show
//                //para mostrar los datos completos de un evento
//            );
//        }

//        json_encode($data); //convertimos el array principal $data a un objeto Json
//        return $data; //para luego retornarlo y estar listo para consumirlo
    }

    public function create(){
        //Valores recibidos via ajax
        $title = $_POST['title'];
        $start = $_POST['start'];
        $back = $_POST['background'];

        //Insertando evento a base de datos
        $evento=new CalendarioEvento;
        $evento->fechaIni=$start;
        //$evento->fechaFin=$end;
        $evento->todoeldia=true;
        $evento->color=$back;
        $evento->titulo=$title;

        $evento->save();
    }

    public function update(){
        //Valores recibidos via ajax
        $id = $_POST['id'];
        $title = $_POST['title'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $allDay = $_POST['allday'];
        $back = $_POST['background'];

        $evento=CalendarioEvento::find($id);
        if($end=='NULL'){
            $evento->fechaFin=NULL;
        }else{
            $evento->fechaFin=$end;
        }
        $evento->fechaIni=$start;
        $evento->todoeldia=$allDay;
        $evento->color=$back;
        $evento->titulo=$title;
        //$evento->fechaFin=$end;

        $evento->save();
    }

    public function delete(){
        //Valor id recibidos via ajax
        $id = $_POST['id'];

        CalendarioEvento::destroy($id);
    }

}
