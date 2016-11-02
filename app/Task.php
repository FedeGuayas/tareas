<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';
    

    /**
     * @start_day Dia de asignacion de la tarea
     * @performance_day Fecha en que se debe terminar 
     * @end_day Fecha real en que se cumplio
     * @color Color del estado de la tarea, succes en termina, warning proxima a termino, danger pasada de termino    
     * @allDay Si la tarea ocupa el dia completo
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task', 'description', 'start_day','performance_day','end_day','state','user_id','allDay','color','weekday','repeats','repeats_freq'

    ];

    protected $hidden = [
        'id'
    ];

    public function user(){
        return $this->belongsTo('App\Person');
    }

    public function events(){
        return $this->hasMany('App\Event');
    }

    
}
