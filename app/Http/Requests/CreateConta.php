<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateConta extends FormRequest
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
            'nome' => ['required', 'string', 'max:20',Rule::unique('contas')->where(function ($query){
                return $query->where('user_id', Auth::user()->id);
            })],
            'saldo_abertura' => 'required|numeric',
            'descricao'=>'nullable|string',
        ];
        
    }
}
