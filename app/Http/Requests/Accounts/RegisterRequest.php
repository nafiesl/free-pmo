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
            'name' => 'required',
            'username' => 'required|alpha_num',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|between:6,15|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'username.required' => 'Username harus diisi.',
            'username.alpha_num' => 'Username harus berupa huruf dan angka.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.between' => 'Password baru harus antara 6 - 15 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password_confirmation.required' => 'Konfirmasi password harus diisi.',
        ];
    }
}
