<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MultipleEmailRule;
use Illuminate\Validation\Rule;

class ConsultaRequest extends FormRequest
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
            'nome' => ['required'],
            'replicado_query' => ['required','not_regex:[;]'],
        ];
        if ($this->method() == 'PATCH' || $this->method() == 'PUT'){
            array_push($rules['nome'], 'unique:consultas,nome,' .$this->consulta->id);
            array_push($rules['replicado_query'], 'unique:consultas,replicado_query,' .$this->consulta->id);
        }
        else{
            array_push($rules['nome'], 'unique:consultas');
            array_push($rules['replicado_query'], 'unique:consultas');
        }
        return $rules;
    }
}
