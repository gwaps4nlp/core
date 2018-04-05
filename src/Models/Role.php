<?php

namespace Gwaps4nlp\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public static function getUser(){
        return Role::where('slug','user')->first();
    }

    public static function getAdmin(){
    	return Role::where('slug','admin')->first();
    }

    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany('Gwaps4nlp\Core\Models\User');
    }    
}
