<?php

namespace App\Http\Requests;

use App\Categoria;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

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
            'imagem_doc' => 'mimes:jpeg,jpg,png',
        ];
    }

    public function ValidateCategory(){
        $record = $this->validator->validated();
        $cat = Categoria::find($record['categoria_id']);
        if($cat->tipo != $record['tipo']){
            $this->validator->errors()->add('tipo', 'Categoria do tipo de despesa é diferente da categoria');

            throw (new ValidationException($this->validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }
    }
}
