<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        if ($request){
        $permisos=Permission::all();
//        }

        return view('permissions.index', compact('permisos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permiso=new Permission;
        $permiso->name=$request->get('name');
        $permiso->display_name=$request->get('display_name');
        $permiso->description=$request->get('description');
        $permiso->save();

        Session::flash('message', 'Permiso creado correctamente');
        return redirect()->route('admin.permissions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $per=Permission::findOrFail($id);
        return view('permissions.show',compact('per'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permiso=Permission::findOrFail($id);
        return view('permissions.edit',compact('permiso'));
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
        $permiso=Permission::findOrFail($id);
        $permiso->update($request->all());

        Session::flash('message','Permiso actualizado');
        return redirect()->route('admin.permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permiso=Permission::findOrFail($id);
        $permiso->delete;

        Session::flash('message','Permiso eliminado');
        return redirect()->route('admin.permissions.index');
    }
}
