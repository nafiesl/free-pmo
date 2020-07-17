<?php

namespace App\Http\Requests\Projects;

use App\Entities\Projects\Project;
use App\Http\Requests\Request;

class UpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $project = Project::findOrFail($this->segment(2));

        return auth()->user()->can('update', $project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'           => 'required|max:50',
            'description'    => 'nullable|max:255',
            'proposal_date'  => 'nullable|date|date_format:Y-m-d',
            'proposal_value' => 'nullable|numeric',
            'start_date'     => 'nullable|date|date_format:Y-m-d',
            'end_date'       => 'nullable|date|date_format:Y-m-d',
            'due_date'       => 'nullable|date|date_format:Y-m-d',
            'project_value'  => 'nullable|numeric',
            'customer_id'    => 'nullable|numeric',
            'status_id'      => 'required|numeric',
        ];
    }
}
