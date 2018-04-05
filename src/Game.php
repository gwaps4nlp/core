<?php

namespace Gwaps4nlp\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Gwaps4nlp\Core\Models\Trophy;
use Gwaps4nlp\Core\Models\Bonus;

use Response, View, DB, Auth;

abstract class Game extends Model
{
	public $turn;

	public $nb_turns;

	protected $in_progress;

	public $html;

	public $type_gain = 'points';
	
	public $request;
	
	public function __construct(Request $request){
	
		$this->request=$request;
	}

	public function loadSession(Request $request){
		
		$this->request=$request;
		$this->user = Auth::user();
		$this->setVisible($this->visible);
		$this->set('mode',$this->mode);
		if($this->request->hasSession()) {
			foreach($this->fillable as $attribute){
				if($request->session()->has("{$this->mode}.{$attribute}")){
					$this->set($attribute, $request->session()->get("{$this->mode}.$attribute"));
				}
			}
		}
	}
	
	public function incrementTurn(){
		$this->increment('turn');
	}
	
	public function set($attr, $value){
		if(is_array($value)){
			$values = $value;
			$value=[];
			foreach($values as $object){

				if(is_object($object))
				$value[]= $object->toArray();
			else 
				$value[]= $object;
			}
		}
		if($this->request->hasSession()) {
			$this->request->session()->put("{$this->mode}.{$attr}",$value);
		}
		$this->setAttribute($attr,$value);
		$this->$attr=$value;		
	}
	
	public function get($attr){
		return $this->$attr;
	}

	public function pushAttr($attr, $value){
		$this->request->session()->push("{$this->mode}.{$attr}",$value);
		if(!is_array($this->$attr)) $this->$attr = array();
		$this->$attr=array_merge($this->$attr,array($value));
		$this->setAttribute($attr,$this->$attr);
	}
	
	public function increment($attr, $value=1, array $extra=array()){
		$this->$attr+=$value;
		$this->request->session()->put("{$this->mode}.{$attr}",$this->$attr);
	}

	public function jsonContent(Request $request){
		$this->loadSession($request);
        if($this->isOver()){
            $this->end();
            $this->set('html',View::make("partials.{$this->mode}.end",['game'=>$this])->render());
        } else {
        	$this->loadContent();
        }
        return Response::json($this);
	}

	public function isInProgress(){
		return $this->in_progress;
	}
	
	public function isOver(){
		return ($this->turn>=$this->nb_turns);
	}

	public function checkBonus($condition){
		if($bonus = Bonus::where('condition','=',$condition)->first()){
			$this->user->bonuses()->save($bonus);
			$this->set('bonus', $bonus->name);
			$this->pushAttr('bonuses', $bonus);
		}
	}

	public function checkTrophy($type_trophy, $number){
		$user_id = $this->user->id;
		if($trophy = Trophy::where('key','=',$type_trophy)
			->where('required_value','<=',$number)->whereNotExists(
				function($query) use($user_id) {
					$query->select(DB::raw(1))
                      ->from('trophy_user')
                      ->whereRaw('trophies.id = trophy_user.trophy_id')
                      ->where('trophy_user.user_id','=',$user_id);
				})
			->first()){
			$this->user->trophies()->save($trophy);
			$this->set('trophy', $trophy->name);
			$this->pushAttr('trophies', $trophy);
			$this->checkBonus($trophy->slug);
		}

	}

}
