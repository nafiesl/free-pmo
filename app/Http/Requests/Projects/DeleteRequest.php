<?php

namespace App\Http\Requests\Projects;

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
            'project_id' => 'required',
        ];
    }

}
