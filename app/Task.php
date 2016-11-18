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

    //para convertir a fechas de carbon
    protected $dates = [
        'start_day',
        'performance_day',
        'end_day'
    ];
    

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
        'task', 'description', 'start_day','performance_day','end_day','state','allDay','color','weekday','repeats','repeats_freq','file','area_id'

    ];

    protected $hidden = [
        'id'
    ];

    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function area(){
        return $this->belongsTo('App\Area');
    }

    public function events(){
        return $this->hasMany('App\Event');
    }
    
   
}
