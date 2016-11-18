<?php

namespace App\Http\Controllers;

use App\Area;
use App\Events\UserCreated;
use App\Person;
use App\User;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Requests\PersonStoreRequest;
use Event;


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
        
        $persons=Person::
            join('users as u','u.id','=','user_id')
            ->where('activated',true)
            ->get();
        

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
    public function store(PersonStoreRequest $request)
    {
        Session::forget('message_danger');
        try {
            DB::beginTransaction();

            $user=new User();
            $user->email=$request->input('email');
            $pass=str_random(6);
            $user->password=$pass;
            $user->activated=false;
            $user->name=$request->input('first_name');
            $user->save();
            Event::fire(new UserCreated($user,$pass));
        
            $person=new Person();
            $person->user()->associate($user);
            $area_id=$request->input('area_id');
            $area=Area::findOrFail($area_id);
            $person->first_name=$request->input('first_name');
            $person->last_name=$request->input('last_name');
            $person->phone=$request->input('phone');

            //Agrega el id del area a la persona y lo salva, por las relaciones
            $area->persons()->save($person);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();

            Session::flash('message_danger','Error'.$e->getMessage());
            return redirect()->route('admin.persons.create');
        }

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
        $user=$person->user()->delete();


//        $person->delete();
        Session::flash('message','Se elimino el trabajador '.  $person->getFullNameAttribute());
        return redirect()->route('admin.persons.index');
    }
    
}
