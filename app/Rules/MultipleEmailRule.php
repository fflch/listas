<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MultipleEmailRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        /* Esse campo não é obrigatório */
        if(empty(trim($value))) return true;

        $emails = explode(',',$value);
        foreach($emails as $email){
            if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
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
        return 'Emails inválidos';
    }
}
