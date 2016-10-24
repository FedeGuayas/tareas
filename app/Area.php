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
        'area', 'description'
    ];

    public function task(){
        return $this->hasMany('App\Task');
    }

    public function persons(){
        return $this->hasMany('App\Task');
    }
    
}
