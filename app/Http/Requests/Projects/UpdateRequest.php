<?php

namespace App\Http\Requests\Projects;

use App\Entities\Projects\Project;
use App\Http\Requests\Request;

class UpdateRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		$project = Project::findOrFail($this->segment(2));
		return auth()->user()->can('manage_project', $project);
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
