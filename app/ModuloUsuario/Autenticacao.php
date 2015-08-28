<?php namespace JobsCondDev\ModuloUsuario;

class Autenticacao
{

	protected $errors;

	public function logar($usuario, $senha, $lembrar = null)
	{
		try
		{
			// Login credentials
			$credentials = array(
				'email'    => $usuario,
				'password' => $senha,
			);

			// Authenticate the user
			$user = \Sentry::authenticate($credentials, false);

			$dados = [
				'dados'  => $user,
				'permissoes' => $user->getMergedPermissions(),
				'grupos' => $user->getGroups()
			];

			setcookie('dadosUser', json_encode($dados));

			return ($user) ? $user : false;
		}
		catch (\Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			$this->errors = 'Email é obrigatório';
		}
		catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			$this->errors = 'Senha obrigatória';
		}
		catch (\Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
			$this->errors = 'Login ou senha inválido';
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			$this->errors = 'Login ou senha inválido';
		}
		catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
			$this->errors = 'Esse usuário está inativo no sistema';
		}

		// The following is only required if the throttling is enabled
		catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
			$this->errors = 'Usuário suspenso';
		}
		catch (\Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
			$this->errors = 'Usuário banido';
		}
	}

	public function getErrors(){

		return $this->errors;

	}

}