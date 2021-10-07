<?php

namespace sig\Http\Requests\User;

use sig\Http\Requests\Request;

class UserCreateRequest extends Request
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
            'name'=>'required|max:100|regex: /^[a-zA-Z0-9áéíóúñÑ,\s\-\_\.]*$/ ',
            'email' => 'required|email|max:255|unique:users',
            'usuario'=>'required|max:100|unique:users|regex: /^[a-zA-Z0-9áéíóúñÑ,\s\-\_\.]*$/ ',
            'password' => 'required|confirmed|min:6',
            'perfil'=>'required|not_in:0',                                   
        ];
    }
   
}
