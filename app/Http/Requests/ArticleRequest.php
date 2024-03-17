<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'id' => 'integer',
            'operationType' => 'required|numeric',
            'name' => 'required|max:255',
            'description' => 'max:255'
        ];
    }
}
