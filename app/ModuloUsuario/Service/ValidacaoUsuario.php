<?php namespace JobsCondDev\ModuloUsuario\Service;
/**
 * Created by PhpStorm.
 * User: Danilo
 * Date: 11/09/14
 * Time: 19:27
 */

use JobsCondDev\System\Validacao\ValidatorAbstract;

class ValidacaoUsuario extends ValidatorAbstract
{

    protected $rules = [
        'email'        => ['required', 'email'],
        'primeiroNome' => ['required'],
        'ultimoNome'   => ['required'],
        'senha' 	   => ['sometimes','required'],
        'repitaSenha'  => ['sometimes','required', 'same:senha']
    ];

    protected $message = [
        'required' => 'Campo Obrigatório',
		'email'	   => 'Formato de email inválido',
		'same'	   => 'O campo Repita a senha deve ser igual ao campo senha'
    ];

    public function __construct() {

        $validacao = \App::make('validator');

        parent::__construct($validacao);
    }

}