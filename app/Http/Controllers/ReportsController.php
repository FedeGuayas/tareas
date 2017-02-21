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


            $data[] = ['Trabajador ', 'Tarea', 'Estado', 'Inicio Planificado', 'Fin Planificado', 'Fin Real', 'Cumplida', 'Incumplida'];

            foreach ($tareas as $task) {
                if ($task->state == 0) {
                    $estado = 'Activa';
                } else {
                    $estado = 'Terminada';
                }
                $data[] = [
                    'trabajador' => $user->getFullNameAttribute(),
                    'tarea' => $task->task,
                    'estado' => $estado,
                    'inicio' => $task->start_day,
                    'fin_p' => $task->performance_day,
                    'fin_r' => $task->end_day,
                    'cumplidas' => $cumplidas,
                    'incumplidas' => $incumplidas,
                ];

            }
            Excel::create('Reporte', function ($excel) use ($data) {

                $excel->sheet('Inscripciones', function ($sheet) use ($data) {

                    $sheet->fromArray($data, null, 'A1', false, false);
                });
            })->export('xlsx');

            return view('reports.user-task', compact('trabajadores', 'trabajador', 'end', 'start', 'user', 'cumplidas', 'incumplidas', 'tareas'));
        } else {
            Session::flash('message', 'No existen datos para exportar');
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
        $areas = [] + Area::lists('area', 'id')->all();
        $area = trim($request->get('area'));

        $tasks = Task::with('users', 'area', 'events')
            ->where('start_day', '>=', $start)
            ->where('performance_day', '<=', $end)
            ->where('area_id', $area)
            ->orderBy('created_at')
            ->get();

//        $tasks->each(function ($tasks) {
//            $tasks->users;
//            $tasks->area;
//        });

        return view('reports.index-task', compact('tasks', 'start', 'end', 'areas', 'area'));
    }

    /**
     * Exportar todas las tareas para Informe Excell
     * @param Request $request
     */

    public function exportTasks(Request $request)
    {

        $start = trim($request->get('start'));
        $end = trim($request->get('end'));
//        $areas = [] + Area::lists('area', 'id')->all();
        $area = trim($request->get('area'));

        $tasks = Task::with('users', 'area', 'events')
            ->where('start_day', '>=', $start)
            ->where('performance_day', '<=', $end)
            ->where('area_id',$area )

            ->orderBy('created_at')
            ->get();

        $taskArray[] = ['Tarea', 'Trabajadores', 'Inicio Tarea', 'Fin Planificado', 'Fin Real', 'Estado', 'Descripción', 'Comentarios'];

        $encabezado = [
            'start' => $start,
            'end' => $end
        ];
        $tareArea=Area::select('area')->where('id',$area)->first();

        foreach ($tasks as $task) {
            if ($task->state == 0) {
                $estado = 'Activa';
            } else {
                $estado = 'Terminada';
            }

            //Los trabajadores asignados a la tarea
            $works = [];
                foreach ($task->users as $user) {//el usaurio de la tarea
                    array_push($works, $user->getFullNameAttribute());//voy agregando los usuarios a un array
                }
            $trabajadores=implode(" \\ ",$works);//convierto el array en una cadena separada por \

            //comentarios realizados por los trabajdores de la tarea
            $comentario = [];
            foreach($task->events as $event ) {
                foreach ($event->comments as $coment) {
                    array_push($comentario,$coment->body);
                }
            }
            $comentarios=implode(" \\ ",$comentario);

                $taskArray[] = [
                    'tarea' => $task->task,
                    'trabajador' => $trabajadores,
                    'inicio' => $task->start_day,
                    'fin_p' => $task->performance_day,
                    'fin_r' => $task->end_day,
                    'estado' => $estado,
                    'descripcion' => $task->description,
                    'comentario' => $comentarios,

                ];

            }


        Excel::create('Tareas_Excel - ' . Carbon::now() . '', function ($excel) use ($taskArray, $encabezado,$tareArea) {//crear excel pasando array al closure

            $excel->sheet('Tareas', function ($sheet) use ($taskArray, $encabezado,$tareArea) {//crear la hoja pasando array al closure

                //merge cells
//                $sheet->mergeCells('B1:C1');

//                $sheet->setMergeColumn(array(
//                    'columns' => array('A','B','C','D'),
//                    'rows' => array(
//                        array(1,2),
//                        array(12,16),
//                    )
//                ));
                $inicio = $encabezado['start'];
                $fin = $encabezado['end'];

                $sheet->row(1, ["GESTION DE TAREAS", "Area: ".$tareArea->area ,"Periodo: " . $inicio . ' / ' . $fin,]);
                $sheet->cells('A1:E1', function ($cells) {
//                   $cells->setBackground('#B2B2B2');
                    $cells->setFontWeight('bold');
                    //alineacion horizontal
                    $cells->setAlignment('center');
                    // alineacion vertical
                    $cells->setValignment('center');
                    // tipo de letra
                    $cells->setFontFamily('Arial');
                    // tamaño de letra
                    $cells->setFontSize(14);
                    // bordes (top, right, bottom, left)
//                    $cells->setBorder('solid', 'solid', 'solid', 'solid');
                });

                //manipular rango de celdas (encabezado)
                $sheet->cells('A2:I2', function ($cells) {
//                   $cells->setBackground('#B2B2B2');
                    $cells->setFontWeight('bold');
                    //alineacion horizontal
                    $cells->setAlignment('left');
                    // alineacion vertical
                    $cells->setValignment('center');
                    // tipo de letra
                    $cells->setFontFamily('Arial');
                    // tamaño de letra
                    $cells->setFontSize(12);
                    // bordes (top, right, bottom, left)
//                    $cells->setBorder('solid', 'solid', 'solid', 'solid');
                });

                // Set all margins
//                $sheet->setPageMargin(0.25);
                // Set top, right, bottom, left margins
                $sheet->setPageMargin(array(
                    0.25, 0.30, 0.25, 0.30
                ));

                // Set font with ->setStyle()`
                $sheet->setStyle([
                    // Font family
                    $sheet->setFontFamily('Arial'),
                    // Font size
                    $sheet->setFontSize(12),
                    // Font bold
                    $sheet->setFontBold(false),
                    // Sets all borders
                    $sheet->setAllBorders('thin'),
                ]);

                // freeze fila
                $sheet->setFreeze('A3');



                //crear la hoja a partir del array
                //5to parametro false pasa como encabesado de la primera fila los nombres de las columnas
                $sheet->fromArray($taskArray, null, 'A2', false, false);

            });
        })->export('xlsx');

    }


}
