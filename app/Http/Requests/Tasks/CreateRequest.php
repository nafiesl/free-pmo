<?php

namespace App\Http\Requests\Tasks;

use App\Entities\Projects\Task;
use App\Http\Requests\Request;

class CreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create', new Task());
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
            'description' => 'nullable|max:255',
            'progress'    => 'required|numeric|max:100',
        ];
    }
}
