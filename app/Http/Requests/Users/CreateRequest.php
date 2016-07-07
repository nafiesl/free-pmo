<?php

namespace App\Http\Requests\Users;

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
        return $this->user()->can('manage_users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'required|min:5',
            'username'              => 'required|alpha_dash|min:4|unique:users,username',
            'email'                 => 'required|email|unique:users,email',
            'role'                  => 'required|array',
            'password'              => 'between:6,15|confirmed',
            'password_confirmation' => 'required_with:password',
        ];
    }
}
