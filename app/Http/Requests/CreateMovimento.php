<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMovimento extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data' => 'required|date|before:tomorrow',
            'valor' => 'required|numeric|min:0.01',
            'tipo' => 'required',
            'categoria_id' => 'nullable',
            'descricao' => 'nullable|string|max:255',
        ];
    }
}
