<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
   protected $fillable=[
       'user_id','event_id','title','body'
];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function event()
    {
        return $this->belongsTo('App\Task');
    }

}
