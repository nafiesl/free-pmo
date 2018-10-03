<?php

namespace App\Http\Requests\Accounts;

use App\Http\Requests\Request;

class RegisterRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'agency_name'           => 'required|max:255',
            'agency_website'        => 'nullable|url|max:255',
            'name'                  => 'required|max:255',
            'email'                 => 'required|email|max:255|unique:users,email',
            'password'              => 'required|between:6,15|confirmed',
            'password_confirmation' => 'required',
        ];
    }
}
