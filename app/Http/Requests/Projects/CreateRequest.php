<?php

namespace App\Http\Requests\Projects;

use App\Entities\Projects\Project;
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
        return auth()->user()->can('create', new Project());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'           => 'required|max:50',
            'proposal_date'  => 'nullable|date|date_format:Y-m-d',
            'proposal_value' => 'nullable|numeric',
            'customer_id'    => 'nullable|numeric',
            'customer_name'  => 'nullable|required_without:customer_id|max:60',
            'customer_email' => 'nullable|required_without:customer_id|email|unique:users,email',
            'description'    => 'nullable|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'customer_name.required_without'  => __('validation.project.customer_name.required_without'),
            'customer_email.required_without' => __('validation.project.customer_email.required_without'),
        ];
    }
}
