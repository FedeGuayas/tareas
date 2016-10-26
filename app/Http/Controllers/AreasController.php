<?php

namespace App\Http\Controllers;

use App\Area;
use App\Person;
use Illuminate\Http\Request;

use App\Http\Requests;

use Session;

class AreasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $areas=Area::all();
        foreach ($areas as $area ){
           $area->persons();
        }
        return view('areas.index',['areas'=>$areas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('areas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $area=new Area();
        $area->area=$request->input('area');
        $area->description=$request->input('description');
        $area->save();

        Session::flash('message','Se creo el área correctamente');
        return redirect()->route('admin.areas.index');
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
        $area=Area::findOrFail($id);
        return view('areas.edit',['area'=>$area]);
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
        $area=Area::findOrFail($id);
        $area->update($request->all());
        Session::flash('message','Se editó el área correctamente');
        return redirect()->route('admin.areas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $area=Area::findOrFail($id);
        $flag=$area->persons;
        if (count($flag)>0){
            Session::flash('message_danger','El area '.$area->area.' tiene trabajadores, eliminelos o cambielos de area');
            return redirect()->back();
        }else{
            $area->delete();
            Session::flash('message','Se elimino el área '.  $area->area);
        }
        return redirect()->route('admin.areas.index');
    }

    public function getPersons(Request $request,$id){
        if ($request->ajax()){
            $persons=Person::persons($id);
            return response()->json($persons);
        }
    }

}
