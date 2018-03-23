<?php

namespace Gwaps4nlp\Models;

use Illuminate\Database\Eloquent\Model;
use Cache,App;

class ConstantGame extends Model
{
	protected $fillable = ['key','value','description'];
	
	public static function get($key){
		try {
			return Cache::rememberForever(App::environment().'-'.$key, function() use ($key) {
				return parent::select('value')->where('key','=',$key)->first()->value;
			});
		} catch (Exception $Ex){
			return parent::select('value')->where('key','=',$key)->first()->value;
		}
	}

	public static function set($key, $value){
        $constant = ConstantGame::where('key',$key)->first();
        $constant->value=$value;
        $constant->save();
        ConstantGame::forget($constant->key);
	}

	public static function forget($key){

		Cache::forget(App::environment().'-'.$key);

	}
}
