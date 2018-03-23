<?php

namespace Gwaps4nlp\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Sentence;

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
	  return $this->hasMany('Gwaps4nlp\Models\Sentence')->whereIn('corpus_id', array_merge([$this->id],$this->subcorpora->pluck('id')->toArray()));
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
	 * One to Many relation
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function subcorpora()
	{
	  return $this->belongsToMany('Gwaps4nlp\Models\Corpus','corpus_subcorpus','corpus_id','subcorpus_id');
	}

	/**
	 * One to One relation
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function language()
	{
	  return $this->belongsTo('Gwaps4nlp\Models\Language');
	}

	/**
	 * One to One relation
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function license()
	{
	  return $this->belongsTo('Gwaps4nlp\Models\License');
	}

	/**
	 * One to One relation
	 *
	 * @return Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function source()
	{
	  return $this->hasOne('Gwaps4nlp\Models\Source');
	}

}
