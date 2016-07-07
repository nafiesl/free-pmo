<?php

namespace App\Http\Requests\Accounts;

use App\Http\Requests\Request;

class UpdateProfileRequest extends Request
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
            'name' => 'required|max:60'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'name.max' => 'Nama maksimal 60 karakter.',
        ];
    }
}
