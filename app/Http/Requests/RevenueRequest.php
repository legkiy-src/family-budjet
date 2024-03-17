<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RevenueRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'id' => 'integer',
            'account' => 'required|numeric',
            'article' => 'required|numeric',
            'total_sum' => 'required|numeric',
            'description' => 'max:255'
        ];
    }
}
