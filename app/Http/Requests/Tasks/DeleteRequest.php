<?php

namespace App\Http\Requests\Tasks;

use App\Entities\Projects\Feature;
use App\Http\Requests\Request;

class DeleteRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		$feature = Feature::findOrFail($this->get('feature_id'));
		return auth()->user()->can('manage_feature', $feature);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'task_id' => 'required',
			'feature_id' => 'required',
		];
	}

}
