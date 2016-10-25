<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'persons';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name','phone','email','area_id',
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
}

