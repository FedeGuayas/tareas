<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    
    protected $table = 'persons';
    
    public $timestamps = false;
 
    protected $fillable = [
        'first_name', 'last_name','phone','area_id','user_id'
    ];

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function area()
    {
        return $this->belongsTo('App\Area');
    }
    
    public function getFullName(){
        return $this->first_name.' '.$this->last_name;
    }

    //para acceder a las personas en el dropdown sin necesidad de instanciarlas
    public static function persons($id){
        return Person::where('area_id',$id)->get();
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}

