<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\OldPassRule;

class UpdatePass extends FormRequest
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
            'old_password'=>['required',new OldPassRule],
            'password'=>'required|confirmed|min:3|different:old_password',
            'password_confirmation'=>'required|same:password',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'old_password' => 'This password doesn´t match with your old password!',
        ];
    }
}
