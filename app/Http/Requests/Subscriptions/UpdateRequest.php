<?php

namespace App\Http\Requests\Subscriptions;

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
            'domain_name'      => 'required|max:60|unique:subscriptions,domain_name,'.$this->segment(2),
            'epp_code'         => 'max:60',
            'domain_price'     => 'required|numeric',
            'hosting_capacity' => 'max:60',
            'hosting_price'    => 'required_with:hosting_capacity|numeric',
            'start_date'       => 'required|date|date_format:Y-m-d',
            'due_date'         => 'required|date|date_format:Y-m-d',
            'project_id'       => 'required|numeric',
            'vendor_id'        => 'required|numeric',
            'remark'           => 'max:255',
        ];
    }

}
