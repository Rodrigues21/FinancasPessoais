<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Conta;

class EditarConta implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $conta_id;

    public function __construct($conta_id)
    {
        $this->conta_id=$conta_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $contas = Conta::where('user_id', Auth::user()->id)->get();

        foreach ($contas as $conta){
            if ($conta->nome === $value   ){
                if($conta->id == $this->conta_id)
                    return true;
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O nome indicado já está a ser utilizado';
    }
}
