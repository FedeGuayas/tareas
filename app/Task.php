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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task', 'description', 'start_day','performance_day','end_day','state','area_id','person_id'
    ];

    public function person(){
        return $this->belongsTo('App\Person');
    }

    public function area(){
        return $this->belongsTo('App\Area');
    }
    
}
