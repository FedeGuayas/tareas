<?php

namespace App\Http\Controllers;

use App\Fullcalendarevento;
use Illuminate\Http\Request;

use App\Http\Requests;

class CalendarController extends Controller
{

    public function index()
    {
        $data = array(); //declaramos un array principal que va contener los datos
        $id = Fullcalendarevento::all()->pluck('id'); //listamos todos los id de los eventos
        $titulo = Fullcalendarevento::all()->pluck('titulo'); //lo mismo para lugar y fecha
        $fechaIni = Fullcalendarevento::all()->pluck('fechaIni');
        $fechaFin = Fullcalendarevento::all()->pluck('fechaFin');
        $allDay = Fullcalendarevento::all()->pluck('todoeldia');
        $background = Fullcalendarevento::all()->pluck('color');
        $count = count($id); //contamos los ids obtenidos para saber el numero exacto de eventos

        //hacemos un ciclo para anidar los valores obtenidos a nuestro array principal $data
        for($i=0;$i<$count;$i++){
            $data[$i] = array(
                "title"=>$titulo[$i], //obligatoriamente "title", "start" y "url" son campos requeridos
                "start"=>$fechaIni[$i], //por el plugin asi que asignamos a cada uno el valor correspondiente
                "end"=>$fechaFin[$i],
                "allDay"=>$allDay[$i],
                "backgroundColor"=>$background[$i],
//                "borderColor"=>$borde[$i],
                "id"=>$id[$i]
                //"url"=>"cargaEventos".$id[$i]
                //en el campo "url" concatenamos el el URL con el id del evento para luego
                //en el evento onclick de JS hacer referencia a este y usar el método show
                //para mostrar los datos completos de un evento
            );
        }

        json_encode($data); //convertimos el array principal $data a un objeto Json
        return $data; //para luego retornarlo y estar listo para consumirlo
    }




    public function create(){


        //Valores recibidos via ajax

            $title = $_POST['title'];//title
            $start = $_POST['start'];////&start
            $back = $_POST['background'];//&background

            //Insertando evento a base de datos
            $evento=new Fullcalendarevento;
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

        $evento=Fullcalendarevento::findOrFail($id);
        if($end=='NULL'){
            $evento->fechaFin='NULL'; //NULL sin comillas es para postgres
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

        Fullcalendarevento::destroy($id);
    }
}
