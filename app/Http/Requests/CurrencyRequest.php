<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'id' => 'integer',
            'name' => 'required|max:20',
            'symbol' => 'required|max:20',
        ];
    }
}
