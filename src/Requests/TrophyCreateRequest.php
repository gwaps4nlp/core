<?php 

namespace Gwaps4nlp\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrophyCreateRequest extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => 'required|max:50',
			'key' => 'required|max:50',
			'required_value' => 'required|integer',
			'points' => 'required|integer',
			'description' => 'required|max:50',
			'is_secret' => 'required|boolean',
		];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
	    return true;
	}

}