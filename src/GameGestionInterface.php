<?php

namespace Gwaps4nlp;

use Illuminate\Http\Request;

interface GameGestionInterface 
{	
	public function begin(Request $request, $id);

	public function jsonContent(Request $request);

	public function jsonAnswer(Request $request);
		
	public function end();
	
	public function processAnswer();
	
}
