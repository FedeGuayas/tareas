<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //para convertir a fechas de carbon desahbilitado xk da problemas con loa eventos en el calendario
//    protected $dates = [
//        'start',
//        'end'
//    ];
    
    protected $fillable = ['task_id','start','end','title',];
    protected $hidden = ['id'];

    public function task(){
        return $this->belongsTo('App\Task');
    }
}
