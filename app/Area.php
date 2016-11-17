<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'areas';
        
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'area', 'description'
    ];

    //accedo a las tareas a traves del usuario
    public function tasks(){
        return $this->hasMany('App\Task');
    }

    //accedo a los eventos a traves de las tareas
    public function events(){
        return $this->hasManyThrough('App\Event','App\Task');
    }
    

    public function users(){
        return $this->hasMany('App\User');
    }
    
}
