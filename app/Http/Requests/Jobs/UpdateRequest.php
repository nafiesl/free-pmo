<?php

namespace App\Http\Requests\Jobs;

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
        $project = Project::findOrFail($this->get('project_id'));

        return auth()->user()->can('manage_jobs', $project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'      => 'required|max:60',
            'price'     => 'required|numeric',
            'worker_id' => 'required|numeric',
            'type_id'   => 'required|numeric',
        ];

        //Allow for flexibility instead of optionless hard-coded value for "description". This is
        //achieved using environmental variable.
        //A value of zero (0) will mean "no limit"

        $char_len_job_description = intval(env('CHAR_LEN_JOB_DESCRIPTION', 255));
        if ($char_len_job_description > 0) {
            $rules['description'] = "max:$char_len_job_description";
        }

        return $rules;
    }
}
