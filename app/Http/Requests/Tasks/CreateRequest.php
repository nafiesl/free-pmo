<?php

namespace App\Http\Requests\Tasks;

use App\Http\Requests\Request;
use App\Entities\Projects\Task;

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
        $rules = [
            'name'     => 'required|max:60',
            'progress' => 'required|numeric|max:100',
        ];

        //Allow for flexibility instead of optionless hard-coded value for "description". This is
        //achieved using environmental variable.
        //A value of zero (0) will mean "no limit"

        $charLenTaskDescription = intval(env('DESCRIPTION_CHAR_LEN', 255));
        if ($charLenTaskDescription > 0) {
            $rules['description'] = "max:$charLenTaskDescription";
        }

        return $rules;
    }
}
