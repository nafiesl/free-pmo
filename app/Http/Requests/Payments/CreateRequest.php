<?php

namespace App\Http\Requests\Payments;

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
        return auth()->user()->can('manage_payments');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'date'        => 'required|date|date_format:Y-m-d',
            'in_out'      => 'required|numeric',
            'amount'      => 'required',
            'project_id'  => 'required|numeric',
            'type_id'     => 'required|numeric',
            'partner_id'  => 'required|numeric',
            'description' => 'required|max:255',
        ];

        if ($this->get('in_out') == 0) {
            $rules['partner_id'] = 'required|numeric|exists:vendors,id';
        } else {
            $rules['partner_id'] = 'required|numeric|exists:customers,id';
        }

        return $rules;
    }
}
