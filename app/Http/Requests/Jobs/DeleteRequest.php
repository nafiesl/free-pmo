<?php

namespace App\Http\Requests\Jobs;

use App\Entities\Projects\Project;
use App\Http\Requests\Request;

class DeleteRequest extends Request
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
        return [
            'job_id'     => 'required',
            'project_id' => 'required',
        ];
    }
}
