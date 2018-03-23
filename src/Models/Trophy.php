<?php

namespace Gwaps4nlp\Models;

use Illuminate\Database\Eloquent\Model;

class Trophy extends Model
{
	protected $fillable = ['slug', 'name', 'key', 'required_value', 'description', 'points', 'is_secret', 'created_at', 'updated_at'];
}
