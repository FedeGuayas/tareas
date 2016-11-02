<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $fillable = [
        'title','description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function users(){
        return $this->belongsToMany('app\User');
    }
}
