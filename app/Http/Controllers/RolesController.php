<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;

class RolesController extends Controller
{

    public function index(Request $request)
    {

//        if ($request){
        $roles=Role::all();
//        }
        
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rol=new Role();
        $rol->name=$request->get('name');
        $rol->display_name=$request->get('display_name');
        $rol->description=$request->get('description');
        $rol->save();

        Session::flash('message', 'Rol creado correctamente');
        return redirect()->route('admin.roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rol=Role::find($id);
        return view('roles.show',compact('rol'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rol=Role::find($id);
        return view('roles.edit',compact('rol'));
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
        $rol=Role::find($id);
        $rol->update($request->all());

        Session::flash('message','Rol actualizado');
        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rol=Role::find($id);
        
        $rol->delete;

        Session::flash('message','Rol eliminado');
        return redirect()->route('admin.roles.index');
    }


    public  function permisos($id)
    {
        $rol=Role::find($id);

//        $roles= [''=>'Seleccione roles'] + Role::lists('display_name', 'id')->all();
        $permisos=Permission::all();

        return view('roles.set-permisos',compact('rol','permisos'));
    }

    public  function setPermisos(Request $request)
    {

        $rol_id=$request->get('rol_id');
        $rol=Role::find($rol_id);
        $permisos_id=$request->get('permisos');

        if ($permisos_id) {
            // El usuario marcó checkbox
            foreach ($permisos_id as $per_id) {
                $permiso=Permission::find($per_id);
                $rol->attachPermission($permiso);
            }

        }
        else{

            $rol->detachPermission($permisos_id);

        }
        return redirect()->route('admin.roles.index');
    }

}