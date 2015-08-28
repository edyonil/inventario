<?php namespace Condominio\ModuloCondominio\Servicos;

use Condominio\System\Validacao\ValidatorAbstract;
use Illuminate\Support\Facades\App;

class ValidacaoCondominio extends ValidatorAbstract
{

    protected $rules = [
        'nome'       => ['required'],
        'endereco'   => ['required'],
        'bairro'     => ['required'],
        'numero'     => ['required'],
        'cep'        => ['required'],
    ];

    protected $message = [
        'required' => 'Campo obrigatório',
    ];

    public function __construct(){

        $validacao = App::make('validator');

        parent::__construct($validacao);
    }

}