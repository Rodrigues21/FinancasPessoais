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
}
