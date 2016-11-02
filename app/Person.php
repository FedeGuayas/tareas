<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    
    protected $table = 'persons';
    
    public $timestamps = false;
 
    protected $fillable = [
        'first_name', 'last_name','phone','area_id','user_id'
    ];

   
}

