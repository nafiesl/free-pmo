<?php

namespace App\Http\Requests\Tasks;

use App\Entities\Projects\Task;
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
        $task = Task::findOrFail($this->segment(2));

        return auth()->user()->can('update', $task);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|max:60',
            'description' => 'max:255',
            'progress'    => 'numeric|max:100',
            'route_name'  => 'max:255',
        ];
    }
}
