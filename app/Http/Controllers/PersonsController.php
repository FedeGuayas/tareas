<?php

namespace App\Http\Controllers;

use App\Area;
use App\Person;
use Illuminate\Http\Request;

use App\Http\Requests;

use Session;

class PersonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $persons=Person::all();
        return view('persons.index',['persons'=>$persons]);
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
        return view('persons.create',['areas'=>$listado]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $person=new Person();
        $area_id=$request->input('area_id');
        $area=Area::findOrFail($area_id);

        $person->first_name=$request->input('first_name');
        $person->last_name=$request->input('last_name');
        $person->phone=$request->input('phone');
        $person->email=$request->input('email');
        //Agrega el id del area a la persona y lo salva, por las relaciones
        $area->persons()->save($person);

         Session::flash('message','Trabajador agregado correctamente');
         return redirect()->route('admin.persons.index');
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
        $person=Person::findOrFail($id);
        $areas_coll=Area::all();
        $listado = $areas_coll->pluck('area', 'id');
        $listado->all();

        return view('persons.edit',['person'=>$person,'areas'=>$listado]);
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
        $person=Person::findOrFail($id);
        $area_id=$request->input('area_id');
        $area=Area::findOrFail($area_id);
        $person->first_name=$request->input('first_name');
        $person->last_name=$request->input('last_name');
        $person->phone=$request->input('phone');
        $person->email=$request->input('email');

        $person->area()->associate($area);
        $person->update();

        Session::flash('message','Trabajador actualizado correctamente');
        return redirect()->route('admin.persons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $person=Person::findOrFail($id);
        $person->delete();
        Session::flash('message','Se elimino el trabajador '.  $person->getFullName());
        return redirect()->route('admin.persons.index');
    }
}
