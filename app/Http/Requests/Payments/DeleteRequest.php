<?php

namespace App\Http\Requests\Masters;

use App\Http\Requests\Request;

class DeleteRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return auth()->user()->can('manage_masters');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'master_id' => 'required'
		];
	}

}
