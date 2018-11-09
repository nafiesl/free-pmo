<?php

namespace App\Http\Requests\Partners;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->route('customer'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $customer = $this->route('customer');

        return [
            'name'      => 'required|max:60',
            'email'     => 'nullable|email|unique:customers,email,'.$customer->id,
            'phone'     => 'nullable|max:255',
            'pic'       => 'nullable|max:255',
            'address'   => 'nullable|max:255',
            'website'   => 'nullable|url|max:255',
            'notes'     => 'nullable|max:255',
            'is_active' => 'required|boolean',
        ];
    }
}
