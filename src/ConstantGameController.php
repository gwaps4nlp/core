<?php

namespace Gwaps4nlp;

use App\Http\Controllers\Controller;
use Gwaps4nlp\Models\ConstantGame;
use Illuminate\Http\Request;
use Cache;

class ConstantGameController extends Controller
{
	/**
     * Create a new ConstantGameController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
     /**
     * Show a listing of the constants of the game.
     *     
     * @return Illuminate\Http\Response
     */
    public function getIndex()
    {
		$constants = ConstantGame::all();
        return view('gwaps4nlp-core::constant-game.index',compact('constants'));
    }    
     /**
     * Show a form to edit a constant.
     *
     * @param  Illuminate\Http\Request $request     
     * @return Illuminate\Http\Response
     */
    public function getEdit(ConstantGame $constant)
    {
        return view('gwaps4nlp-core::constant-game.edit',compact('constant'));
    }    
     /**
     * Update a constant.
     *
     * @param  Illuminate\Http\Request $request 
     * @return Illuminate\Http\Response
     */
    public function postEdit(ConstantGame $constant, Request $request)
    {
		$this->validate($request, [
			'value' => 'required|max:50',
			'description' => 'required|max:200',
		]);
		$constant->value=$request->value;
		$constant->description=$request->description;
		$constant->save();
		ConstantGame::forget($constant->key);
        return $this->getIndex();
    }

}