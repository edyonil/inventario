<?php namespace JobsCondDev\ModuloUsuario\Repository;

/**
 * Created by PhpStorm.
 * User: Danilo
 * Date: 11/09/14
 * Time: 19:05
 */

use JobsCondDev\System\Repository\RepositorioAbstract;
use JobsCondDev\ModuloUsuario\Models\User;

/**
 * responsavel pelo gerenciamento do modulo de unidade.
 * Class UndidadeRepositorio
 * @package Condominio\ModuloCondominio\Repositorios
 */
class UsuarioRepositorio extends RepositorioAbstract
{

	/**
	 * @var \Condominio\ModuloCondominio\Models\Usuario
	 */
	protected $usuario;

	/**
	 * @var array campos a serem utilizados na tabela no banco
	 */
	protected $fildes = ['username', 'email', 'password'];

	/**
	 * metodo construtor do objeto
	 */
	public function __construct(User $usuario)
	{

		$this->usuario = $usuario;
		parent::__construct($usuario);
	}


	public function all()
	{
		return $this->usuario->all();
	}

	public function find($id)
	{
		try
		{
			// Find the user using the user id
			return \Sentry::findUserById($id);
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			throw new \Exception("Usuário não encontrado");

			return false;
		}

	}

	public function save(array $input)
	{

		try {
			// Create the user

			$grupo = $this->gruposExceptions($input);

			unset($input['groups']);

			$user = \Sentry::createUser($input);

			if ($grupo != false) {

				if (is_array($grupo)) {

					for ($i = 0; $i < count($grupo); $i++) {

						$adminGroup = \Sentry::findGroupById($grupo[$i]);

						$user->addGroup($adminGroup);

					}

				} else {

					$adminGroup = \Sentry::findGroupById($grupo);

					$user->addGroup($adminGroup);

				}

			}

			return $user;

		} catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {

			throw new \Exception('Campo Login obrigatório');


		} catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e) {

			throw new \Exception('Campo password é obrigatório');


		} catch (\Cartalyst\Sentry\Users\UserExistsException $e) {

			throw new \Exception('Já existe um usuário com esse email');


		} catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e) {

			throw new \Exception('Grupo não encontrado');


		}

	}

	public function update(array $input)
	{

		try {
			$grupo = $this->gruposExceptions($input);

			// Find the user using the user id
			$user = \Sentry::findUserById($input['id']);

			$grupos = $user->getGroups();

			// Update the user details
			$user->email = $input['email'];

			if(isset($input['password'])) {
				$user->password = $input['password'];
			};

			$user->activated = $input['activated'];
			$user->first_name = $input['first_name'];
			$user->last_name = $input['last_name'];
			$user->cpf = $input['cpf'];
			$user->rg = $input['rg'];
			$user->cep = $input['cep'];
			$user->endereco = $input['endereco'];
			$user->complemento = $input['complemento'];
			$user->bairro = $input['bairro'];
			$user->estado = $input['estado'];
			$user->municipio = $input['municipio'];
			$user->telefones = $input['telefones'];
			$user->updated_by = $input['updated_by'];

			// Update the user
			if ($user->save()) {
				if ($grupo != false) {

					if (is_array($grupo)) {

						$gruposRemover = $this->gruposParaRemover($grupo, $grupos);

						for ($i = 0; $i < count($grupo); $i++) {

							$adminGroup = \Sentry::findGroupById($grupo[$i]);

							$user->addGroup($adminGroup);

						}

						if ($gruposRemover) {

							if (is_array($gruposRemover)) {

								for ($i = 0; $i < count($gruposRemover); $i++) {

									$adminGroup = \Sentry::findGroupById($gruposRemover[$i]);

									$user->removeGroup($adminGroup);

								}

							} else {

								$adminGroup = \Sentry::findGroupById($gruposRemover);

								$user->removeGroup($adminGroup);
							}

						}

					} else {

						$adminGroup = \Sentry::findGroupById($grupo);

						$user->addGroup($adminGroup);

					}

				} else {

					if ($grupos) {

						foreach ($grupos as $grupo) {

							$adminGroup = \Sentry::findGroupById($grupo->id);

							$user->removeGroup($adminGroup);
						}

					}

				}

				return $user;
			}

			throw new \Exception("Não foi possível salvar o registro");


		} catch (\Cartalyst\Sentry\Users\UserExistsException $e) {

			throw new \Exception("Já existe um usuário com esse email");

		} catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {

			throw new \Exception("Usuário não encontrado");

		} catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e) {

			throw new \Exception('Grupo não encontrado');
		}
	}


	public function delete($input)
	{

		try {
			// Find the user using the user id
			$user = \Sentry::findUserById($input['id']);

			$user->delete();

			return true;

		} catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {

			throw new \Exception("Usuário não encontrado");

		}
	}


	protected function gruposExceptions($array)
	{
		if (isset($array['groups'])) {

			return $array['groups'];

		}

		return false;

	}

	protected function gruposParaRemover($array, $userGroups)
	{

		if (!is_array($array)) {
			throw new \Exception('A variavel $array não é uma array. Tipo passado: ' . gettype($array));
		}

		if (!is_object($userGroups)) {
			throw new \Exception('A variavel $userGroups não é um objeto. Tipo passado: ' . gettype($userGroups));
		}

		$gruposRemover = [];

		foreach ($userGroups as $grupo) {

			if (!in_array($grupo->id, $array)) {

				array_push($gruposRemover, $grupo->id);

			}

		}

		return (count($gruposRemover)) ? $gruposRemover : false;

	}

	public function getWhere(array $where)
	{
		return $this->usuario
					->orderBy('created_at', 'DESC')->paginate($where['count']);
	}

}