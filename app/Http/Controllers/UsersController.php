<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Support\Facades\Event;
use App\Role;
use App\Task;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::where('activated',true)->get();
        $users->each(function ($users) {
            $users->area;
            $users->tasks;
        });
        

        return view('users.index',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
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
     * Store a newly created resource in storage.
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

            Event::fire(new UserCreated($user,$pass));
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('message_danger','ERROR!! '.$e->getMessage());
        }

        Session::flash('message','Trabajador agregado correctamente');
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Miestra el Formulario para editar akl trabajador
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
     * Muestra el perfil general del usuario
     * @param Request $request
     * @return mixed
     */

    public function getProfile(Request $request){
        
        
        $user=$request->user();

        $notifications = $user->getNotifications(10, 'asc');
        $tasks=Task::where('user_id',$user->id)->paginate(5);
        $total=$user->tasks->count();//total de tareas
        $tasksOn=$user->tasks->where('state',0)->count();//tareas activas
        $tasksOff=$total-$tasksOn;//tareas inacctivas


//        dd($user->notifications()->byRead(1)->get());
        return view('users.profile.profile',compact('user','tasks','tasksOn','tasksOff','notifications'));
    }


    /**
     * cargar el form para editar la contraseña del usuario
     * @param Request $request
     * @return mixed
     */
    public function getProfileEdit(Request $request){

        $user=$request->user();
        
        return view('users.profile.pass-edit',['user'=>$user]);
    }

    /**
     * Cambio de contraseña de usuario
     * @param ChangePasswordRequest $request
     * @param User $user
     * @return mixed
     */
    public function postProfile(ChangePasswordRequest $request,User $user){

        $new_pass=$request->password_new;
        $user->password = $new_pass;
        $user->update();
        return redirect()->route('user.profile')->with('message','Contraseña Actualizada');
    }

    public function  userTasks(Request $request){
        $user=$request->user();
        $tasks=$user->tasks;

        return view('users.profile.task',compact('tasks'));
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
