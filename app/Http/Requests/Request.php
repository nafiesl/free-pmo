<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * {@inheritdoc}
     */
    protected function failedValidation(Validator $validator)
    {
        flash()->error('Mohon periksa kembali form isian Anda.');
        parent::failedValidation($validator);
    }
}
