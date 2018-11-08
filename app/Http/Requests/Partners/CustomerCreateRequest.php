<?php

namespace App\Http\Requests\Partners;

use App\Entities\Partners\Customer;
use Illuminate\Foundation\Http\FormRequest;

class CustomerCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', new Customer);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => 'required|max:60',
            'email'   => 'nullable|email|unique:customers,email',
            'phone'   => 'nullable|max:255',
            'pic'     => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'website' => 'nullable|url|max:255',
            'notes'   => 'nullable|max:255',
        ];
    }
}
