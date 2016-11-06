<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Fenos\Notifynder\Traits\Notifable as NotifableTrait;

class User extends Authenticatable
{
    use NotifableTrait; //trai para notificaciones
    /**
     * Este trait habilita las relaciones del modelo User con el modelo Role, adicionando los siguientes metodos
     * roles(), hasRole($name), can($permission), and ability($roles, $permissions, $options)
     */
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','email','activated','area_id','first_name','last_name','phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

   //    //setear el password, ya no es necesario encriptar pass en controlador
    public function setPasswordAttribute($value){
        if (!empty ($value)) {
            $this->attributes['password'] =bcrypt($value);
        }
    }

    //para acceder a las personas en el dropdown sin necesidad de instanciarlas
    public static function users($id){
        return User::where('area_id',$id)->get();
    }

    public function getFullName(){
        return $this->first_name.' '.$this->last_name;
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function area()
    {
        return $this->belongsTo('App\Area');
    }

//    public function notifications()
//    {
//        return $this->belongsToMany('App\Notification');
//    }

    public function comments(){
        return $this->hasMany('App\Coments');
    }
    
}
