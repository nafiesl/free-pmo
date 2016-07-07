<?php

namespace App\Http\Requests\Accounts;

use App\Http\Requests\Request;

class ChangePasswordRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required',
            'password' => 'required|between:6,15|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'Password lama harus diisi.',
            'password.required' => 'Password baru harus diisi.',
            'password.between' => 'Password baru harus antara 6 - 15 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
            'password_confirmation.required' => 'Konfirmasi password baru harus diisi.',
        ];
    }
}
