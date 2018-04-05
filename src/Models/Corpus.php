<?php

namespace Gwaps4nlp\Core\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Gwaps4nlp\Core\Models\Sentence;

class Corpus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'corpuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','description','source_id','language_id','license_id','playable','title','url_source','url_info_license'];  
     
    protected $visible = ['id','name'];
	
	/**
	 * One to Many relation
	 *
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function sentences()
	{
	  return $this->hasMany('Gwaps4nlp\Core\Models\Sentence')->whereIn('corpus_id', array_merge([$this->id],$this->subcorpora->pluck('id')->toArray()));
	}	

	/**
	 * One to Many relation
	 *
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function all_sentences()
	{
	  return Sentence::whereIn('corpus_id', array_merge([$this->id],$this->subcorpora->pluck('id')->toArray()));;
	}

	/**
	 * One to One relation
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function language()
	{
	  return $this->belongsTo('Gwaps4nlp\Core\Models\Language');
	}

	/**
	 * One to One relation
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function license()
	{
	  return $this->belongsTo('Gwaps4nlp\Core\Models\License');
	}

	/**
	 * One to One relation
	 *
	 * @return Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function source()
	{
	  return $this->hasOne('Gwaps4nlp\Core\Models\Source');
	}

}
