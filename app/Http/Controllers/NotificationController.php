<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use Fenos\Notifynder\Models\NotificationCategory;
use Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:administrador'],['except'=>['getIndex','getRead']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $notifications=NotificationCategory::all();


        return view('notifications.index',['notifications'=>$notifications]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notifications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $name=$request->input('name');
        $text=$request->input('text');
        $category = NotificationCategory::create([
            'name' => $name,//'user.follow', // we recommend lowercase and dot seperated names
            'text' => $text,//'Hola {to.name}, {from.name} es tu seguidor ahora dile algo extra "{extra.message}".',
        ]);

        $category->save();

        Session::flash('message','Se creo la categoria para notificacion correctamente');
        return redirect()->route('admin.notifications.index');
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
        $notification=NotificationCategory::findOrFail($id);
        return view('notifications.edit',['notification'=>$notification]);
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
        $notification=NotificationCategory::findOrFail($id);
        $notification->update($request->all());

        Session::flash('message','Se editó la categoria de notificacion correctamente');
        return redirect()->route('admin.notifications.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification=NotificationCategory::findOrFail($id);
        $notification->delete();
        Session::flash('message','Se elimino la notificacion');

        return redirect()->route('admin.notifications.index');
    }
    
    
    
    /**
     * Ver todas las notificaciones del usuario
     */

    public function getIndex(){

        $user = Auth::user();
        //todas las notificaciones que no han expirado, y ordenadas por estado de si se han leido o no lectura
        $notifications = $user->getNotificationRelation()//->where('category_id', 2) por categoria
            ->where(function($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>=', Carbon::now());
            })->orderBy('read', 'asc')->get();

        //eliminar las notificaciones expiradas de la bd
        $notifications->each(function($notification){
           if ($notification->expires_at <= Carbon::now()){
               $notification->delete();
           }
        });

        return view('notifications.user.index',compact('user', 'notifications'));
    }

    /** El usuario va a la url y marca la notificacion como leida
     * @param Notification $notification
     * @return mixed
     */
    public function getRead(Notification $notification)
    {
        $notification::where('id',$notification->getKey())
            ->update(['read' => 1]);
//        $notification->read();
        if(empty($notification->url)) {
            return redirect()->back();
        }
        return redirect()->to($notification->url);
    }

    /**
     * Test
     */
    public function notiAsxderdd(){

        $user = Auth::user();
        $notifications = $user->getNotifications(null, 'asc'); // all notifactions asc ordered by created_at
        $notifications = $user->getNotifications(10); // 10 notifactions desc ordered by created_at
        $notifications = $user->getNotifications(10, 'asc'); // 10 notifactions asc ordered by created_at
        $notifications = $user->getNotificationRelation() // get all notifications in category 2 that are not expired and order by read status
        ->where('category_id', 2)
            ->where(function($query) {
                $query
                    ->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', Carbon::now());
            })
            ->orderBy('read', 'asc')
            ->get();
    }
    
    
    
    

}
