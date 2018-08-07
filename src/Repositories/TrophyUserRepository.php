<?php

namespace Gwaps4nlp\Core\Repositories;
use Gwaps4nlp\Core\Repositories\BaseRepository;
use Gwaps4nlp\Core\Models\TrophyUser;
use Gwaps4nlp\Core\Models\Trophy;
use App\Repositories\QuestUserRepository;
use DB;


class TrophyUserRepository extends BaseRepository
{
  public function __construct(
    TrophyUser $trophyuser)
  {
    $this->model = $trophyuser;
  }

  public function updateTrophy($user,$trophyid){
    if($this->trophyCreated($user)){
      DB::table('trophy_user')
        ->where('user_id','=',$user->id)
        ->where('trophy_id','=',$trophyid)
        ->increment('score',1 );
      $nextfloor=$this->checkFloor($user,$trophyid);
      $score=DB::table('trophy_user')
        ->where('user_id','=',$user->id)
        ->where('trophy_id','=',$trophyid)
        ->value('score');
      if($score=$nextfloor){
        DB::table('trophy_user')
          ->where('user_id','=',$user->id)
          ->where('trophy_id','=',$trophyid)
          ->increment('actual_floor',1 );
        DB::table('trophy_user')
          ->where('user_id','=',$user->id)
          ->where('trophy_id','=',$trophyid)
          ->update('image',$this->getImage($user,$trophyid));
        floorMax($user,$trophyid);
      }
    }
  }

  public function updateConsecutiveTrophy($user){
    $questuser= App::make('App\Repositories\QuestUserRepository');
    $daybefore=$questuser->getLastDayBefore($user);
    if(!$daybefore){
      $score=DB::table('trophy_user')
        ->where('user_id','=',$user->id)
        ->where('trophy_id','=',1)
        ->update(['score'=>0]);
    }
    else{
      $this->updateTrophy($user,1);
    }
  }

  public function floorMax($user,$trophyid){
        $actualfloor=DB::table('trophy_user')
          ->where('user_id','=',$user->id)
          ->where('trophy_id','=',$trophyid)
          ->value('actual_floor');
        $maxfloor=DB::table('trophy')
          ->where('trophy_id','=',$trophyid)
          ->value('maximum_floor');
        if($actualfloor==$maxfloor){
          $nbrfloormax=DB::table('trophy_user')
            ->where('user_id','=',$user->id)
            ->where('trophy_id','=',$trophyid)
            ->value('number_maximum_floor');
          $score=DB::table('trophy_user')
            ->where('user_id','=',$user->id)
            ->where('trophy_id','=',$trophyid)
            ->update(['actual_floor'=>0,'score'=>0,'number_maximum_floor'=>$nbrfloormax+1,'image'=>'secret.png']);
        }

  }

  public function checkFloor($user,$trophyid){
    $floor=DB::table('floors')
      ->where('trophy_id','=',$trophyid)
      ->where('floor','=',getActualFloor($user,$trophyid)+1)
      ->value('score_to_reach');
    return $floor;
  }

  public function createTrophy($user){
    $trophies=Trophy::get();
    foreach ($trophies as $trophy) { 
      TrophyUser::create([
        'user_id'=>$user->id,
        'trophy_id'=>$trophy->id,
        'score'=>0,
        'actual_floor'=>0,
        'number_maximum_floor'=>0,
        'image'=>'secret.png'
      ]);
    }
  }


    public function getActualFloor($user,$trophyid){
      $actualfloor=DB::table('trophy_user')
        ->where('trophy_id','=',$trophyid)
        ->where('user_id','=',$user->id)
        ->value('actual_floor');
      return $actualfloor;
    }

    public function getTrophyId($user){
      return 'trophy_id';
    }

    public function trophyCreated($user){
      $created=DB::table('trophy_user')
        ->where('user_id','=',$user->id)
        ->get();
      if(count($created)==0) {
        $this->createTrophy($user);
      }
      return True;
    }


    public function getImage($user,$trophyid){
      $actualfloor=$this->getActualFloor($user,$trophyid);
      $image=DB::table('floors')
        ->where('trophy_id','=',$trophyid)
        ->where('floor','=',$actualfloor)
        ->value('image');
      if( !($this->getActualFloor($user,$trophyid)==0)){
        return $image;
      }
      else{
        return 'secret.png';
      }
    }

    public function getScore($user,$trophyid){
      $score=DB::table('trophy_user')
        ->where('user_id','=',$user->id)
        ->where('trophy_id','=',$trophyid)
        ->value('score');
      return $score;
    }


  }
