<?php

namespace App\Http\Controllers;

use App\Area;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;


class ReportsController extends Controller
{

    public function index_users(Request $request){

        $trabajadores=[] + User::select(DB::raw('CONCAT(first_name, " ", last_name) AS usuario'), 'id')->lists('usuario','id')->all();


        $trabajador= trim($request->get('trabajador'));
        $start = trim($request->get('start'));
        $end = trim($request->get('end'));

        return view('reports.user-task',compact('trabajadores','trabajador','end','start'));
    }


    /**
     * Cargar el resultado de la busqeudad en un vista
     * @param Request $request
     * @return mixed
     */
    public function getUsersTask(Request $request){

        if ($request->ajax()){

            $trabajadores=[] + User::select(DB::raw('CONCAT(first_name, " ", last_name) AS usuario'), 'id')->lists('usuario','id')->all();

            $trabajador= trim($request->get('trabajador'));
            $start = trim($request->get('start'));
            $end = trim($request->get('end'));

            $user=User::where('id',$trabajador)->first();

            $tareas= Task::where('user_id', $user['id'])
                ->where('start_day','>=',$start)
                ->where('performance_day','<=',$end)
                ->get();

            $cumplidas= Task::where('user_id', $user['id'])
                ->where('start_day','>=',$start)
                ->where('performance_day','<=',$end)
                ->where('state','=','1')->count();
            $incumplidas= Task::where('user_id', $user['id'])
                ->where('start_day','>=',$start)
                ->where('performance_day','<=',$end)
                ->where('state','=','0')->count();

            $data[] = [
                'trabajadores' => $trabajadores,
                'trabajador' => $trabajador,
                'end' => $end,
                'start' => $start,
                'user' => $user,
                'cumplidas' => $cumplidas,
                'incumplidas' => $incumplidas,
                'tareas' => $tareas,
            ];
            //            return response()->json($data);

        }

//        $desde = trim($request->get('start'));
//        $hasta = trim($request->get('end'));
//        $query= trim($request->get('trabajador'));
//        $users = DB::table('users as u')
//            ->join('tasks as t', 't.user_id', '=', 'u.id')
//            ->join('events as e', 'e.task_id', '=', 't.id')
//            ->join('areas as a', 'a.id', '=', 'u.area_id')
//            ->select('u.first_name', 'u.last_name','u.phone', 'u.email','u.activated',
//                't.task', 't.start_day','t.performance_day','t.end_day','t.state',
//                'a.area','e.start','e.end')
//            ->where('u.activated', 1)
//            ->where('u.first_name', 'LIKE','%'.$query.'%')
//            ->orderBy('')
//            ->get();

//dd($user->id);
////       $cuadreArray = array();
//        foreach ($cuadre as $c) {
//            $cuadreArray[] = [
//                'nombre' => $c->nombre,
//                'cantidad' => Inscripcion::where('user_id', $c->uid)->where('fecha_insc', 'LIKE', '%' . $fecha . '%')->count(),
//                'valor' => Inscripcion::where('user_id', $c->uid)->where('fecha_insc', 'LIKE', '%' . $fecha . '%')->sum('costo'),
//            ];
//        }
//    }
        return view('reports.listUserTask',compact('trabajadores','trabajador','end','start','user','cumplidas','incumplidas','tareas'));
    }


    /**
     * Exportar reporte del usuario a excel
     */

    public function exportUsersTask(Request $request){

//        if ($request->ajax()){

            $trabajadores=[] + User::select(DB::raw('CONCAT(first_name, " ", last_name) AS usuario'), 'id')->lists('usuario','id')->all();

            $trabajador= trim($request->get('trabajador'));
            $start = trim($request->get('start'));
            $end = trim($request->get('end'));
dd($trabajador);
            $user=User::where('id',$trabajador)->first();

            $tareas= Task::where('user_id', $user['id'])
                ->where('start_day','>=',$start)
                ->where('performance_day','<=',$end)
                ->get();

            $cumplidas= Task::where('user_id', $user['id'])
                ->where('start_day','>=',$start)
                ->where('performance_day','<=',$end)
                ->where('state','=','1')->count();
            $incumplidas= Task::where('user_id', $user['id'])
                ->where('start_day','>=',$start)
                ->where('performance_day','<=',$end)
                ->where('state','=','0')->count();

//            dd($trabajador);

        $data[] = ['Trabajador ', 'Fecha Inicio T', 'Fecha Termino T', ];

        foreach ($tareas as $task) {

            $data[] = [
                'trabajadores' => $trabajadores,
                'trabajador' => $trabajador,
                'end' => $end,
                'start' => $start,
                'user' => $user,
                'cumplidas' => $cumplidas,
                'incumplidas' => $incumplidas,
                'tareas' => $tareas,
            ];

        }
            Excel::create('Reporte', function ($excel) use ($data) {

                $excel->sheet('Inscripciones', function ($sheet) use ($data) {

                    $sheet->fromArray($data);

                });
            })->export('xlsx');
//        }

        return view('reports.user-task',compact('trabajadores','trabajador','end','start','user','cumplidas','incumplidas','tareas'));
    }


    /**
     * Listado de todas las tareas
     * @param Request $request
     */
    public function indexTasks(Request $request){

        $start = trim($request->get('start'));
        $end = trim($request->get('end'));

        $tasks = Task::
        where('start_day','>=',$start)
            ->where('performance_day','<=',$end)
            ->orderBy('created_at')
            ->get();;
        
        $areas=Area::all();

        $tasks->each(function ($tasks) {
            $tasks->user;
        });

        $areas->each(function ($areas)  {
            $areas->tasks;
        });

//        return view('tasks.index', ['tasks' => $tasks,'areas' => $areas]);
      
         

//        $tasks = DB::table('tasks as t')
//            ->join('users as u', 'u.id', '=', 't.user_id')
//            ->join('events as e', 'e.task_id', '=', 't.id')
//            ->select('t.task', 't.user_id', 't.start_day', 't.performance_day', 't.end_day', 't.state', 't.repeats',
//                't.repeats_freq','t.created_at',
//                'e.task_id','e.start','e.start','e.end','e.title','e.created_at',
//                'u.first_name','u.last_name','u.phone','u.email','u.activated')
//            ->where('start_day','>=',$start)
//            ->where('performance_day','<=',$end)
//            ->orderBy('t.created_at')
//            ->get();


        return view('reports.index-task',compact('tasks','start','end','areas'));
    }



    public function exportTasks(Request $request){


        $start = trim($request->get('start'));
        $end = trim($request->get('end'));

        $tasks = Task::
            where('start_day','>=',$start)
            ->where('performance_day','<=',$end)
            ->orderBy('task')
            ->get();;

        $areas=Area::all();

        $tasks->each(function ($tasks) {
            $tasks->user;
        });

        $areas->each(function ($areas)  {
            $areas->tasks;
        });

        $taskArray[] = ['Trabajador','Area','Tarea', 'Inicio Tarea','Fin Planificado','Fin Real','Estado','Descripción'];

        foreach ($tasks as $task) {
            if($task->state==0){
                $estado='Activa';
            }  else{
                $estado='Terminada';}
            
            $taskArray[] = [
                'trabajador' => $task->user->getFullName(),
                'area'=> $task->user->area->area,
                'tarea'=>   $task->task,
                'inicio'=>$task->start_day,
                'fin_p'=>$task->performance_day,
                'fin_r'=>$task->end_day,
                'estado'=> $estado,
                'descripcion'=>$task->description,
            ];
        }

        Excel::create('Tareas_Excel - '.Carbon::now().'', function ($excel) use ($taskArray) {



            $excel->sheet('Tareas', function ($sheet) use ($taskArray) {

//                $sheet->setBorder('thin');
                $sheet->setBorder('A1:H1', 'thin');

                $sheet->cells('A1:H1', function($cells){
//                   $cells->setBackground('#B2B2B2');
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                    $cells->setBorder('solid', 'solid', 'solid', 'solid');
                });

                $sheet->fromArray($taskArray,null,'A1',false,false);

            });
        })->export('xlsx');

    }
    
    



}
