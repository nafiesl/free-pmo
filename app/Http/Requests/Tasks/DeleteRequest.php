<?php

namespace App\Http\Requests\Tasks;

use App\Entities\Projects\Task;
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
        $task = Task::findOrFail($this->segment(2));

        return auth()->user()->can('delete', $task);
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
            'job_id'  => 'required',
        ];
    }
}
