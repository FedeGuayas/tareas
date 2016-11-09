<?php

namespace App;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    /**
     * name — unico en permission, permisos asignados a un rol. Ejemplo: "create-post", "edit-user", "post-payment", "mailing-list-subscribe".
     * display_name — ejemplo "Create Posts", "Edit Users", "Post Payments", "Subscribe to mailing list".
     * description — Descripcion del Permission.
     *
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
