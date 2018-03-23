<?php

namespace Gwaps4nlp;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrophyCreateRequest;
use App\Models\Trophy;
use Illuminate\Http\Request;

class TrophyController extends Controller
{
    /**
     * Show a listing of the trophies.
     *
     * @return Illuminate\Http\Response
     */
    public function getIndex()
    {
		$trophies = Trophy::orderBy('key')->orderBy('required_value')->get();
        return view('gwaps4nlp-core::trophy.index',compact('trophies'));
    }   

    /**
     * Show a form to edit a trophy.
     *
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function getEdit(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
        ]);
        $trophy = Trophy::findOrFail($request->id);
        return view('gwaps4nlp-core::trophy.edit',compact('trophy'));
    }

    /**
     * Update a trophy.
     *
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function postEdit(TrophyCreateRequest $request)
    {
        $this->validate($request, [
            'id' => 'required|integer'
        ]);

        $trophy = Trophy::findOrFail($request->id)->update($request->all());
        return $this->getIndex();
    }

    /**
     * Display a form to create a new trophy.
     *
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function getCreate(Request $request)
    {
        return view('gwaps4nlp-core::trophy.create');
    } 

    /**
     * Create a trophy.
     *
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function postCreate(TrophyCreateRequest $request)
    {
        $this->validate($request, [
            'slug' => 'required|unique:trophies,slug'
        ]);
        Trophy::create($request->all());        

        return $this->getIndex();
    }

}