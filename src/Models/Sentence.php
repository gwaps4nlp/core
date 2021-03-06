<?php

namespace Gwaps4nlp\Core\Models;

use Gwaps4nlp\Core\Models\Corpus;
use Gwaps4nlp\Core\Models\Source;
use Illuminate\Database\Eloquent\Model;
use DB;

class Sentence extends Model
{
	protected $fillable = ['corpus_id', 'sentid', 'source_id'];
	protected $visible = ['id', 'content', 'sentid'];

	/**
	 * One to One relation
	 *
	 * @return Illuminate\Database\Eloquent\Relations\hasOne
	 */
	public function corpus()
	{
		return $this->belongsTo('Gwaps4nlp\Core\Models\Corpus');
	}

}
