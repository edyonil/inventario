<?php namespace JobsCondDev\ModuloUsuario;

use JobsCondDev\ModuloUsuario\Service\ValidacaoUsuario;
use JobsCondDev\ModuloUsuario\Repository\UsuarioRepositorio;
use JobsCondDev\System\Negocio\InterfaceNegocio;

/**
 * Reponsável pelo processamento pesado da gestão de unidade
 * Class Unidade
 * @package Condominio\ModuloCondominio
 */
class Usuario implements InterfaceNegocio
{

	/**
	 * @var UsuarioRepositorio
	 */
	protected $rUsuario;

	/**
	 * @var $errors String
	 */
	protected $errors;


	public function __construct(UsuarioRepositorio $rUsuario)
	{

		$this->rUsuario = $rUsuario;

	}

	public function find($id)
	{

		try {

			$dados = $this->rUsuario->find($id);

			$itens = new \stdClass();

			$itens->id 			 = $dados->id;
			$itens->email 		 = $dados->email;
			$itens->ultimoNome   = $dados->last_name;
			$itens->primeiroNome = $dados->first_name;
			$itens->cpf          = $dados->cpf;
			$itens->rg           = $dados->rg;
			$itens->cep          = $dados->cep;
			$itens->endereco     = $dados->endereco;
			$itens->complemento  = $dados->complemento;
			$itens->bairro       = $dados->bairro;
			$itens->estado       = $dados->estado;
			$itens->municipio    = $dados->municipio;
			$itens->telefones    = $dados['telefones'];
			$itens->status 		 = $dados->activated;
			$itens->createdAt 	 = date('d/m/Y H:i:s', strtotime($dados->created_at));
			$itens->updatedAt 	 = $dados->updated_at;
			$itens->createdBy 	 = $dados->created_by;
			$itens->updatedBy 	 = $dados->updated_by;
			$itens->grupos		 = $this->tratarGrupos($dados->getGroups());

			$itens->ultimoLogin = ($dados->last_login) ? date('d/m/Y H:i:s', strtotime($dados->last_login)) : 'Esse usuário nunca acessou o sistema';

			if ($dados->updated_at != $dados->created_at) {
				$itens->updatedAt = date('d/m/Y H:i:s', strtotime($dados->updated_at));
			} else {
				$itens->updatedAt = false;
			}

			return $itens;

		} catch (\Exception $e) {

			$this->errors = $e->getMessage();

			return false;
		}

	}

	/**
	 * @param null $input
	 * @return bool|\stdClass
	 */
	public function all($input = null)
	{
		try {

			if(!isset($input['count'])) {

				$input['count'] = 10;

			}

			$usuarios = $this->rUsuario->getWhere($input);

			$dados = new \stdClass();
			$dados->itens = [];

			foreach ($usuarios as $key => $usuario) {

				$dados->itens[$key] = [
					'id'        	=> $usuario->id,
					'email' 		=> $usuario->email,
					'primeiroNome' 	=> $usuario->first_name,
					'ultimoNome' 	=> $usuario->last_name,
					'nome'			=> $usuario->first_name .' '. $usuario->last_name,
					'status'		=> $usuario->activated,
					'grupos'		=> $this->tratarGrupos($usuario->getGroups()),
					'createdAt' 	=> date('d/m/Y H:i:s', strtotime($usuario->created_at)),
					'createdBy' 	=> $usuario->created_by,
					'updatedBy' 	=> $usuario->updated_by,
					'ultimoLogin'   => ($usuario->last_login) ? date('d/m/Y H:i:s', strtotime($usuario->last_login)) : 'Esse usuário nunca acessou o sistema'
				];

				if ($usuario->updated_at != $usuario->created_at) {
					$dados->itens[$key]['updatedAt'] = date('d/m/Y H:i:s', strtotime($usuario->updated_at));
				} else {
					$dados->itens[$key]['updatedAt'] = false;
				}

			}

			return $dados;

		} catch (\Exception $e) {

			$this->errors = $e->getMessage();

			return false;

		}

	}

	public function save(array $input)
	{
		try {

			$this->validacao($input);

			// Create the user
			$dados = [
				'email'         => $input['email'],
				'first_name'    => $input['primeiroNome'],
				'last_name'     => $input['ultimoNome'],
				'cpf'           => $input['cpf'],
				'rg'            => $input['rg'],
				'cep'           => $input['cep'],
				'endereco'      => $input['endereco'],
				'complemento'   => $input['complemento'],
				'bairro'        => $input['bairro'],
				'estado'        => $input['estado'],
				'municipio'     => $input['municipio'],
				'password'      => $input['senha'],
				'telefones'     => $input['telefones'],
				'activated'     => $input['status'],
				'created_by'    => \Sentry::getUser()->id,
				'permissions'   => [],
				'groups'	    => (isset($input['grupos'])) ? $input['grupos'] : []
			];

			if(isset($input['permissoes']) && count($input['permissoes'])){

				for($i=0; $i<count($input['permissoes']); $i++){
					$dados['permissions'][$input['permissoes'][$i]] = 1;
				}

			}

			return $this->rUsuario->save($dados);


		} catch (\Exception $e) {

			$this->errors = $e->getMessage();

			return false;

		}

	}

	public function update(array $input, $id)
	{
		try {

			$this->validacao($input);
			// Create the user
			$dados = [
				'id'		 => $id,
				'email'         => $input['email'],
				'first_name'    => $input['primeiroNome'],
				'last_name'     => $input['ultimoNome'],
				'cpf'           => $input['cpf'],
				'rg'            => $input['rg'],
				'cep'           => $input['cep'],
				'endereco'      => $input['endereco'],
				'complemento'   => $input['complemento'],
				'bairro'        => $input['bairro'],
				'estado'        => $input['estado'],
				'municipio'     => $input['municipio'],
				'telefones'     => $input['telefones'],
				'activated'     => $input['status'],
				'updated_by' => \Sentry::getUser()->id,
				'permissions'   => [],
				'groups'	    => (isset($input['grupos'])) ? $input['grupos'] : []
			];

			if (isset($input['senha'])) {
				$dados['password'] = $input['senha'];
			}

			if(isset($input['permissoes']) && count($input['permissoes']) ){

				for($i=0; $i<count($input['permissoes']); $i++){
					$dados['permissions'][$input['permissoes'][$i]] = 1;
				}

			}

			return $this->rUsuario->update($dados);

		} catch (\Exception $e) {

			$this->errors = $e->getMessage();

			return false;

		}
	}

	public function delete($id)
	{
		try {

			$input = [
				'id'         => $id,
				'deleted_by' => \Sentry::getUser()->id,
			];

			$delete = $this->rUsuario->delete($input);

			if (!$delete) {
				throw new \Exception("Não foi possível remover o registro");
			}

			return true;

		} catch (\Exception $e) {

			$this->errors = $e->getMessage();

			return false;

		}
	}

	/**
	 * retorna os erros do sistema
	 * @return errors
	 */
	public function getErrors()
	{
		return $this->errors;

	}

	/**
	 * Validação para os registro de forma mas simples
	 * @param array $input
	 * @return bool
	 * @throws \Exception
	 */
	protected function validacao(array $input)
	{
		$validacaoUsuario = new ValidacaoUsuario();

		$validacaoUsuario->with($input);

		if (!$validacaoUsuario->passes()) {

			throw new \Exception($validacaoUsuario->errors()->first());

		}

		return true;
	}

	protected function tratarGrupos($grupos)
	{

		if(!is_object($grupos)) {
			throw new \Exception("A variavel {$grupos} não é um objeto. Tipo passado: " . gettype($grupos));
		}

		$grupoArray = [];

		foreach($grupos as $grupo){

			array_push($grupoArray, ['nome' => $grupo->name, 'id' => $grupo->id]);
		}

		return $grupoArray;
	}
}


