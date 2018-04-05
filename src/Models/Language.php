<?php

namespace Gwaps4nlp\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Language extends Model
{
	protected $fillable = ['slug'];

	public static function getIdBySlug($slug)
	{
		return Cache::rememberForever('id-'.$slug, function() use ($slug) {
			$language = self::select('id')->where('slug','=',$slug)->first();
			return $language->id;
		});
	}
}
