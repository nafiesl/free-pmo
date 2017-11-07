<?php

namespace App\Http\Requests\Subscriptions;

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
        return auth()->user()->can('manage_subscriptions');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:60',
            'price' => 'required|numeric',
            'start_date' => 'required|date|date_format:Y-m-d',
            'due_date' => 'required|date|date_format:Y-m-d',
            'project_id' => 'required|numeric|exists:projects,id',
            'vendor_id' => 'required|numeric|exists:vendors,id',
            'type_id' => 'required|numeric',
            'remark' => 'max:255',
        ];
    }

}
