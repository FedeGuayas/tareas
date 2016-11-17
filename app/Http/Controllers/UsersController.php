<?php

namespace App\Http\Controllers;

use App\Area;
use App\Task;
use Illuminate\Support\Facades\Event;
use App\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use App\Events\UserCreated;
use DB;
use App\User;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Collection as Collection;


class UsersController extends Controller
{
    public function __construct()
    {
        Carbon::setLocale('es');
    }
    /**
     * Obtener listado de todos los usuarios , el area k pertenece y sus tareas asignadas
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::where('activated',true)->get();
        $events =\App\Event::all();
        $tasks =Task::all();
        $tasks->each(function ($tasks) {
            $tasks->user;
            $tasks->events;
            $tasks->area;
        });
        $events->each(function ($events) {
           $events->task;
        });

        $users->each(function ($users) {
            $users->area;
            $users->tasks;
        });
        return view('users.index',compact('users','events','tasks'));
    }

    /**
     * Mostrar el formulario de crear usuarios(trabajadores)
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas_coll=Area::all();
        $listado = $areas_coll->pluck('area', 'id');
        return view('users.create',['areas'=>$listado]);
    }

    /**
     * Crear el nuevo trabajador y enviarle correo de activacion de cuenta
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $user=new User();
            $user->email=$request->input('email');
            $pass=str_random(6);
            $user->password=$pass;
            $user->activated=false;
            $user->name=$request->input('first_name');
            $user->first_name=$request->input('first_name');
            $user->last_name=$request->input('last_name');
            $user->phone=$request->input('phone');
            $area_id=$request->input('area_id');
            $area=Area::findOrFail($area_id);

//            $user->area()->associate($area);
            $area->users()->save($user);//Agrega el id del area al user y lo salva, por las relaciones
            $role=Role::where('name','empleado')->first();//le asigno el roll de empleado por defecto
            $user->attachRole($role);
            Event::fire(new UserCreated($user,$pass));
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('message_danger','ERROR!! '.$e->getMessage());
        }

        Session::flash('message','Trabajador creado, se le ha enviado correo de activación de cuenta');
        return redirect()->route('admin.users.index');
    }

   
    /**
     * Muestra el Formulario para editar al trabajador
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::findOrFail($id);
        $areas_coll=Area::all();
        $listado = $areas_coll->pluck('area', 'id');
        return view('users.edit',['user'=>$user,'areas'=>$listado]);
    }

    /**
     * Actualizar los datos del trabajador.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);
        $user->email=$request->input('email');
        $user->name=$request->input('first_name');
        $user->first_name=$request->input('first_name');
        $user->last_name=$request->input('last_name');
        $user->phone=$request->input('phone');
        $area_id=$request->input('area_id');
        $area=Area::findOrFail($area_id);
        $user->area()->associate($area);
        $user->update();//Agrega el id del area al user y lo salva, por las relaciones

        return redirect()->route('admin.users.index')->with('message','Trabajador editado correctamente');
    }


    /**
     * Elimina un trabajador, y todas sus notificaciones de la bd.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::findOrFail($id);
        $notifications=$user->getNotifications();
        $notifications->each(function($notification){
            $notification->delete();
        });
        $flag=$user->delete();
        if ($flag){
            return redirect()->route('admin.users.index')->with('message_danger', 'El usuario '.$user->getFullName().' ha sido eliminado');
        }else{
            return redirect()->route('admin.users.index')->with('message_danger', 'Ah ocurrido un error');
        }

    }


//    public function getSignin(){
//        return view('users.login');
//    }
//
//    public function postSignin(Request $request){
//        
//        if (Auth::attempt(['email'=>$request->input('email'),'password'=>$request->input('password')])){
//            //redirecciono a la pagina k intentaba entrar sino al perfil
//            return redirect()->intended('user/profile');
//        }
//        
//        return redirect()->route('user.signin')->withInput();
//    }


    /**
     * Muestra el perfil del usuario con sus notificaciones, sus tareas  
     * @param Request $request
     * @return mixed
     */

    public function getProfile(Request $request){

        $dt=Carbon::now();
        $user=$request->user();

        $notifications = $user->getNotifications(10, 'desc');
//        $tasks=Task::where('user_id',$user->id)->paginate(5);
//        $total=$user->tasks->count();//total de tareas
//        $tasksOn=$user->tasks->where('state',0)->count();//tareas pendientes
//        $tasksOff=$total-$tasksOn;//tareas terminadas

        $inicioMes=$dt->firstOfMonth()->toDateString();
        $finMes=$dt->lastOfMonth()->toDateString();

        //eventos del mes
        $events=\App\Event::
        join('tasks as t','t.id','=','e.task_id',' as e')
            ->join('users as u','u.id','=','t.user_id')
            ->where([
                ['start', '>=',  $inicioMes],
                ['start', '<=', $finMes]
            ])
            ->where('t.user_id',$user->id)
            ->get();

        //todos los eventos del usuario paginados para la linea del tiempo
        $eventsAll=\App\Event::
        join('tasks as t','t.id','=','e.task_id',' as e')
            ->join('users as u','u.id','=','t.user_id')
            ->where('t.user_id',$user->id)
            ->paginate(5);

        //para contarlos
        $eventsCount=\App\Event::
        join('tasks as t','t.id','=','e.task_id',' as e')
            ->join('users as u','u.id','=','t.user_id')
            ->where('t.user_id',$user->id)
            ->get();

        $total=$eventsCount->count();
        $tasksOn=$eventsCount->where('state',0)->count();//tareas pendientes
        $tasksOff=$total-$tasksOn;//tareas terminadas
       
//        $eventsAllArray=[];
//        foreach ($eventsAll as $event){
//            $eventsAllArray[]=[
//                'total'=>$event-$total,
//            ];
//
//        }
//        dd($user->notifications()->byRead(1)->get());
        
        return view('users.profile.profile',compact('user','tasksOn','tasksOff','notifications','events','eventsAll'));
    }


    /**
     * Cargar el form para editar la contraseña del usuario
     * @param Request $request
     * @return mixed
     */
    public function getPasswordEdit(Request $request){

        $user=$request->user();
        
        return view('users.profile.pass-edit',['user'=>$user]);
    }

    /**
     * Cambio de contraseña de usuario
     *
     * @param ChangePasswordRequest $request
     * @param User $user
     * @return mixed
     */
    public function postPassword(ChangePasswordRequest $request,User $user){

        $new_pass=$request->password_new;
        $user->password = $new_pass;
        $user->update();
        return redirect()->route('user.profile')->with('message','Contraseña Actualizada');
    }


    /**
     * Obtener los eventos del usuario en el mes actual para mostrarlo en la tabla de tareas del usuario
     * 
     * @param Request $request
     * @return mixed
     */
    public function  userTasks(Request $request){
        $user=$request->user();
        $dt=Carbon::now();
        $ano=$dt->year;
        $mes=$dt->month;

        $inicioMes=$dt->firstOfMonth()->toDateString();
        $finMes=$dt->lastOfMonth()->toDateString();

        //eventos del mes
        $tasks=\App\Event::
            join('tasks as t','t.id','=','e.task_id',' as e')
            ->join('users as u','u.id','=','t.user_id')
            ->where([
                ['start', '>=',  $inicioMes],
                ['start', '<=', $finMes]
            ])
            ->where('t.user_id',$user->id)
            ->get();
//dd($tasks);
//        $tasks=$user->tasks;
//        $tasks->each(function($tasks){
//            $tasks->events;
//        });
        
        return view('users.profile.task',compact('tasks','user'));
    }



    /**
     * Cargar vista para otorgar roles
     * @param $id
     * @return mixed
     */
    public  function roles($id)
    {
        $user=User::findOrFail($id);
//        dd($user);
        $nombre=$user->first_name.' '.$user->last_name ;
//        $roles= [''=>'Seleccione roles'] + Role::lists('display_name', 'id')->all();
        $roles=Role::all();
        return view('users.access.set-roles',compact('user','roles','nombre'));
    }

    /**
     * Addiconar o kitar los roles del usuario.
     *
     * $id de usuario
     *
     */
    public  function setRoles(Request $request, $id)
    {
        $user=User::findOrFail($id);
        $roles=$request->get('roles');

        if ($roles) {
            $user->roles()->sync($roles);

        } else {
            // El usuario no marcó checkbox
//            $user->detachRole($roles);
        }
        return redirect()->route('admin.users.index');
    }
    
}
