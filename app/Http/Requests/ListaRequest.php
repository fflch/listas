<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MultipleEmailRule;

class ListaRequest extends FormRequest
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
        $rules = [
            'description'     => 'required',
            'emails_allowed' => [new MultipleEmailRule],
            'emails_adicionais' => [new MultipleEmailRule],
            'url_mailman' => 'required',
            'pass' => 'required',
            'name' => ['required']
        ];
        if ($this->method() == 'PATCH' || $this->method() == 'PUT'){
            array_push($rules['name'], 'unique:listas,name,' .$this->lista->id);
        }
        else{
            array_push($rules['name'], 'unique:listas');
        }
        return $rules;
    }
}
