<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    
    protected $fillable = ['task_id','start','end','title',];
    protected $hidden = ['id'];

    public function task(){
        return $this->belongsTo('App\Task');
    }
}
