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
            'email'                 => 'required|email|max:255|unique:users,email|unique:agencies,email',
            'password'              => 'required|between:6,15|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'agency_name.required'           => 'Nama Agensi harus diisi.',
            'agency_website.url'             => 'Alamat Website Agensi tidak valid.',
            'name.required'                  => 'Nama harus diisi.',
            'email.required'                 => 'Email harus diisi.',
            'email.email'                    => 'Email tidak valid.',
            'email.unique'                   => 'Email ini sudah terdaftar.',
            'password.required'              => 'Password harus diisi.',
            'password.between'               => 'Password baru harus antara 6 - 15 karakter.',
            'password.confirmed'             => 'Konfirmasi password tidak sesuai.',
            'password_confirmation.required' => 'Konfirmasi password harus diisi.',
        ];
    }
}
