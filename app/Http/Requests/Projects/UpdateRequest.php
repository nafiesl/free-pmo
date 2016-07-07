<?php

namespace App\Http\Requests\Projects;

use App\Http\Requests\Request;

class UpdateRequest extends Request {

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
			'name' => 'required|max:50',
			'description' => 'max:255',
			'proposal_date' => 'date|date_format:Y-m-d',
			'proposal_value' => 'numeric',
			'start_date' => 'date|date_format:Y-m-d',
			'end_date' => 'date|date_format:Y-m-d',
			'project_value' => 'numeric',
			'customer_id' => 'numeric',
		];
	}

}
