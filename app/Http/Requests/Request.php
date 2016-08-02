<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * {@inheritdoc}
     */
    protected function formatErrors(Validator $validator)
    {
        flash()->error('Mohon periksa kembali form isian Anda.');
        return $validator->getMessageBag()->toArray();
    }
}
