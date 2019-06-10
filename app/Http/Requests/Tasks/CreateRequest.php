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

        $rules = [
            'name'     => 'required|max:60',
            'progress' => 'required|numeric|max:100',
        ];

        //Allow for flexibility instead of optionless hard-coded value for "description". This is
        //achieved using environmental variable.
        //A value of zero (0) will mean "no limit"

        $char_len_task_description = intval(env("CHAR_LEN_TASK_DESCRIPTION", 255));
        if ($char_len_task_description > 0) {
            $rules["description"] = "max:$char_len_task_description";
        }

        return $rules;
    }
}
