<?php

namespace Gwaps4nlp;

use Gwaps4nlp\Models\ConstantGame;
use Gwaps4nlp\Models\Corpus;
use Gwaps4nlp\Models\Source;
use Gwaps4nlp\GameGestionInterface;
use Gwaps4nlp\Exceptions\GameException;
use Illuminate\Http\Request;
use Response, View, App, Auth;

class GameController extends Controller
{

    protected $game;

    /**
     * Instantiate a new GameController instance.
     *
     * @return void
     */
    public function __construct()
    {
		$this->game = App::make('Gwaps4nlp\GameGestionInterface');
    }

    /**
     * Begin a new game
     *
     * @param  App\Repositories\CorpusRepository $corpuses
     * @param  Illuminate\Http\Request $request
     * @param  string $mode
     * @param  int $relation_id
     * @return Illuminate\Http\Response
     */
    public function begin(Request $request, $mode, $relation_id)
    {

        $this->game->begin($request, $relation_id);
        if($this->game->request->ajax())
            return Response::json(array(
                'html' => View::make('partials.'.$this->game->mode.'.container',['game'=>$this->game])->render()
                ));
        else
            return view('front.game.container',['game'=>$this->game]);
    }
    
    /**
     * Send the content of the game in JSON format
     *
     * @return Illuminate\Http\Response
     */
    public function jsonContent(Request $request)
    {
        return $this->game->jsonContent($request);

    }

    /**
     * Receive and process the answer of the player.
     *
     * @return Illuminate\Http\Response
     */
    public function answer(Request $request)
    {
        return $this->game->jsonAnswer($request);

    }
	
}
