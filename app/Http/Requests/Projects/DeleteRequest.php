<?php

namespace App\Http\Requests\Projects;

use App\Http\Requests\Request;

class DeleteRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return auth()->user()->can('manage_projects');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'project_id' => 'required'
		];
	}

}
