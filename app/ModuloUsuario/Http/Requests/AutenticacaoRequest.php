<?php namespace JobsCondDev\ModuloUsuario\Http\Requests;

use \JobsCondDev\Http\Requests\Request;

class AutenticacaoRequest extends Request {


    public function authorize()
    {

        return true;
    }

    public function rules()
    {
        return [
            'teste' => ['required', 'numeric', 'size:10'],
            'email' => ['required', 'email'],
        ];
    }

}