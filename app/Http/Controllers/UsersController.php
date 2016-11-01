<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Session;
use App\User;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios=User::all();
        $usuarios->each(function ($usuarios) {
            $usuarios->person;
        });
//        dd($usuarios);
        return view('users.index',['usuarios'=>$usuarios]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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


    public function getProfile(){
        return view('users.profile');
    }


    public  function roles($id)
    {
        $user=User::findOrFail($id);
        $nombre=$user->person->first_name.' '.$user->person->last_name ;
//        $roles= [''=>'Seleccione roles'] + Role::lists('display_name', 'id')->all();
        $roles=Role::all();
        return view('users.set-roles',compact('user','roles','nombre'));
    }

    /**
     * Addiconar o kitar los roles del usuario.
     *
     * $id de usuario
     *
     */
    public  function setRoles(Request $request)
    {
        $user_id=$request->get('user_id');
        $user=User::findOrFail($user_id);
        $roles=$request->get('roles');

        if ($roles) {
            // El usuario marcó checkbox
            foreach ($roles as $rol){
                $user->attachRole($rol);
            }

        } else {
            // El usuario no marcó checkbox
            $user->detachRole($roles);
        }
        return redirect()->route('admin.users.index');
    }
    

}
