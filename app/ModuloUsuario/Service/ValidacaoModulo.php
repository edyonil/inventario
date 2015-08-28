<?php namespace JobsCondDev\ModuloUsuario\Service;

use JobsCondDev\System\Validacao\ValidatorAbstract;

class ValidacaoModulo extends ValidatorAbstract
{

    protected $rules = [
        'nome'        => ['required'],
        'displayNome' => ['required']
    ];

    protected $message = [
        'required' => 'Campo obrigatório',
    ];

    public function __construct(){

        $validacao = \App::make('validator');

        parent::__construct($validacao);
    }

}