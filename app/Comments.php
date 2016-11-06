<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
   protected $fillable=[
       'user_id','task_id','comment'
];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function task()
    {
        return $this->belongsTo('App\Task');
    }

}