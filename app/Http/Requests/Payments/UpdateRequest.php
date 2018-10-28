<?php

namespace App\Http\Requests\Payments;

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
        return auth()->user()->can('manage_payments');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date'         => 'required|date|date_format:Y-m-d',
            'in_out'       => 'required|numeric',
            'amount'       => 'required',
            'project_id'   => 'required|numeric',
            'type_id'      => 'required|numeric',
            'partner_type' => 'nullable|string',
            'partner_id'   => 'required|numeric',
            'description'  => 'required|max:255',
        ];
    }
}
