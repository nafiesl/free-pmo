<?php

namespace App\Http\Requests\Projects;

use App\Http\Requests\Request;
use App\Entities\Projects\Project;

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
        $rules = [
            'name'           => 'required|max:50',
            'proposal_date'  => 'nullable|date|date_format:Y-m-d',
            'proposal_value' => 'nullable|numeric',
            'start_date'     => 'nullable|date|date_format:Y-m-d',
            'end_date'       => 'nullable|date|date_format:Y-m-d',
            'due_date'       => 'nullable|date|date_format:Y-m-d',
            'project_value'  => 'nullable|numeric',
            'customer_id'    => 'nullable|numeric',
            'status_id'      => 'required|numeric',
        ];

        //Allow for flexibility instead of optionless hard-coded value for "description". This is
        //achieved using environmental variable.
        //A value of zero (0) will mean "no limit"

        $char_len_project_description = intval(env('CHAR_LEN_PROJECT_DESCRIPTION', 255));
        if ($char_len_project_description > 0) {
            $rules['description'] = "max:$char_len_project_description";
        }

        return $rules;
    }
}
