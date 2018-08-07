<?php

namespace Gwaps4nlp\Core\Models;

use Illuminate\Database\Eloquent\Model;

class TrophyUser extends Model
{
    //
  protected $table= 'trophy_user';
  protected $fillable = ['user_id','trophy_id', 'score', 'actual_floor','number_maximum_floor','image'];
}
