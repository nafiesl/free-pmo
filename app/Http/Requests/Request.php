<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

abstract class Request extends FormRequest
{
    /**
     * {@inheritdoc}
     */
    protected function failedValidation(Validator $validator)
    {
        flash(__('validation.flash_message'), 'danger');
        parent::failedValidation($validator);
    }
}
