<?php

namespace Gwaps4nlp\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'label', 'image'];

}
