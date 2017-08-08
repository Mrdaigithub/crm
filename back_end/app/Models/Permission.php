<?php namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $hidden = ['depth' ,'parentid','created_at', 'updated_at'];
}