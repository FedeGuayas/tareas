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
use Session;


class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:supervisor|administrador']);
    }

    /**
     *  Reporte de tareas  por trabajadores
     * @param Request $request
     * @return mixed
     */
    public function indexUsersTask(Request $request)
    {

        $trabajadores = [] + User::select(DB::raw('CONCAT(first_name, " ", last_name) AS usuario'), 'id')->lists('usuario', 'id')->all();

        $trabajador = trim($request->get('trabajador'));
        $start = trim($request->get('start'));
        $end = trim($request->get('end'));

        if ($trabajador) {
            $user = User::with('area', 'tasks')->where('id', $trabajador)->first();

            $tareas = $user->tasks()
                ->where('start_day', '>=', $start)
                ->where('performance_day', '<=', $end)->get();

            $cumplidas = $tareas
                ->where('state', 1)->count();

            $incumplidas = $tareas
                ->where('state', 0)->count();
        } else {
            $user = 0;
        }
//dd($tareas);
        return view('reports.user-task', compact('trabajadores', 'trabajador', 'end', 'start', 'user', 'cumplidas', 'incumplidas', 'tareas'));
    }


    /**
     * Exportar reporte de tareas del usuario a excel
     * @param Request $request
     * @return mixed
     */
    public function exportUsersTask(Request $request)
    {

        $trabajadores = [] + User::select(DB::raw('CONCAT(first_name, " ", last_name) AS usuario'), 'id')->lists('usuario', 'id')->all();

        $trabajador = trim($request->get('trabajador'));
        $start = trim($request->get('start'));
        $end = trim($request->get('end'));

        if ($trabajador) {
            $user = User::with('area', 'tasks')->where('id', $trabajador)->first();

            $tareas = $user->tasks()
                ->where('start_day', '>=', $start)
                ->where('performance_day', '<=', $end)->get();

            $cumplidas = $tareas
                ->where('state', 1)->count();

            $incumplidas = $tareas
                ->where('state', 0)->count();


        $data[] = ['Trabajador ', 'Tarea','Estado', 'Inicio Planificado','Fin Planificado','Fin Real','Cumplida','Incumplida'];

        foreach ($tareas as $task) {
            if ($task->state == 0) {
                $estado = 'Activa';
            } else {
                $estado = 'Terminada';
            }
            $data[] = [
                'trabajador' => $user->getFullNameAttribute(),
                'tarea' => $task->task,
                'estado'=>$estado,
                'inicio' => $task->start_day,
                'fin_p' => $task->performance_day,
                'fin_r' => $task->end_day,
                'cumplidas' => $cumplidas,
                'incumplidas' => $incumplidas,
            ];

        }
        Excel::create('Reporte', function ($excel) use ($data) {

            $excel->sheet('Inscripciones', function ($sheet) use ($data) {

                $sheet->fromArray($data);

            });
        })->export('xlsx');

        return view('reports.user-task', compact('trabajadores', 'trabajador', 'end', 'start', 'user', 'cumplidas', 'incumplidas', 'tareas'));
        } else {
            Session::flash('message','No existen datos para exportar');
            return redirect()->route('admin.tasks.reports.users');
        }
    }


    /**
     * Listado de todas las tareas para Informe Excell
     * @param Request $request
     */
    public function indexTasks(Request $request)
    {

        $start = trim($request->get('start'));
        $end = trim($request->get('end'));

        $tasks = Task::with('users', 'area')
            ->where('start_day', '>=', $start)
            ->where('performance_day', '<=', $end)
            ->orderBy('created_at')
            ->get();

//        $tasks->each(function ($tasks) {
//            $tasks->users;
//            $tasks->area;
//        });

        return view('reports.index-task', compact('tasks', 'start', 'end'));
    }


    public function exportTasks(Request $request)
    {

        $start = trim($request->get('start'));
        $end = trim($request->get('end'));

        $tasks = Task::with('users', 'area')
            ->where('start_day', '>=', $start)
            ->where('performance_day', '<=', $end)
            ->orderBy('created_at')
            ->get();

        $taskArray[] = ['Tarea', 'Trabajador', 'Area', 'Inicio Tarea', 'Fin Planificado', 'Fin Real', 'Estado', 'Descripción'];

        foreach ($tasks as $task) {
            if ($task->state == 0) {
                $estado = 'Activa';
            } else {
                $estado = 'Terminada';
            }

            foreach ($task->users as $user) {
                $trabajador = $user->getFullNameAttribute();
            }

            $taskArray[] = [
                'tarea' => $task->task,
                'trabajador' => $trabajador,
                'area' => $task->area->area,
                'inicio' => $task->start_day,
                'fin_p' => $task->performance_day,
                'fin_r' => $task->end_day,
                'estado' => $estado,
                'descripcion' => $task->description,
            ];
        }

        Excel::create('Tareas_Excel - ' . Carbon::now() . '', function ($excel) use ($taskArray) {

            $excel->sheet('Tareas', function ($sheet) use ($taskArray) {


                $sheet->cells('A1:H1', function ($cells) {
//                   $cells->setBackground('#B2B2B2');
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                    $cells->setBorder('solid', 'solid', 'solid', 'solid');
                });

                $sheet->fromArray($taskArray, null, 'A1', false, false);

            });
        })->export('xlsx');

    }


}
