<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserPost extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'NIF' => 'nullable|numeric|digits:9',
            'telefone' => 'nullable|regex:/^[0-9 +\s]+$/',
            'foto' => 'mimes:jpeg,jpg,png',
        ];
    }
}
