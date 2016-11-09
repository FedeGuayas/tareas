<?php

namespace App;

use Zizaco\Entrust\EntrustRole;


class Role extends EntrustRole
{
    /**
     * The attributes that are mass assignable.
     * name — Unico, ejemplo: "admin", "propietario", "empleado".
     * display_name — ejemplo: "Usuario Administrador", "Propietario de La Tarea", "Empleado de la Empresa".
     * description — A more detailed explanation of what the Role does. Also optional.
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'description',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
    
   
}
