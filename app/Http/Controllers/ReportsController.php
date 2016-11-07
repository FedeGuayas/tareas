<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
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

        $tasks = DB::table('tasks as t')
            ->join('users as u', 'u.id', '=', 't.user_id')
            ->join('events as e', 'e.task_id', '=', 't.id')
            ->select('t.task', 't.user_id', 't.start_day', 't.performance_day', 't.end_day', 't.state', 't.repeats',
                't.repeats_freq','t.created_at',
                'e.task_id','e.start','e.start','e.end','e.title','e.created_at',
                'u.first_name','u.last_name','u.phone','u.email','u.activated')
            ->where('start_day','>=',$start)
            ->where('performance_day','<=',$end)
            ->orderBy('t.created_at')
            ->get();


        return view('reports.index-task',compact('tasks','start','end'));
    }



    public function exportTasks(Request $request){


        $start = trim($request->get('start'));
        $end = trim($request->get('end'));


        $tasks = DB::table('tasks as t')
            ->join('users as u', 'u.id', '=', 't.user_id')
            ->join('events as e', 'e.task_id', '=', 't.id')
            ->select('t.task', 't.user_id', 't.start_day', 't.performance_day', 't.end_day', 't.state', 't.repeats',
                't.repeats_freq','t.created_at',
                'e.task_id','e.start','e.start','e.end','e.title','e.created_at',
                'u.first_name','u.last_name','u.phone','u.email','u.activated')
            ->where('start_day','>=',$start)
            ->where('performance_day','<=',$end)
            ->orderBy('t.created_at')
            ->get();



        $taskArray[] = ['Tarea', 'Nombre ', 'Apellidos'];
        foreach ($tasks as $task) {
            $taskArray[] = [
                'Tarea' => $task->task,
            ];
        }

        Excel::create('Tareas Excel', function ($excel) use ($taskArray) {

            $excel->sheet('Tareas', function ($sheet) use ($taskArray) {

                $sheet->fromArray($taskArray);

            });
        })->export('xlsx');

    }
    
    
    
    


}
