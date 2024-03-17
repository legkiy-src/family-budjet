<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'id' => 'integer',
            'name' => 'required|max:255',
            'balance' => 'required|numeric',
            'currency' => 'required|numeric',
            'description' => 'max:255'
        ];
    }
}
