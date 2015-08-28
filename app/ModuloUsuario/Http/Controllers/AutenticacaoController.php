<?php namespace JobsCondDev\ModuloUsuario\http\Controllers;

use Illuminate\Routing\Controller;
use JobsCondDev\ModuloUsuario\Autenticacao;

class AutenticacaoController extends Controller
{


	public function getIndex()
	{
		$input = \Input::all();

		return \View::make('index');
	}

	public function postIndex()
	{

		$dados = \Input::all();

		$usuario = new Autenticacao();

		$logado = $usuario->logar($dados['email'], $dados['password']);

		if($logado){
			return \Redirect::to('/');
		}

		\Session::flash('erro', $usuario->getErrors());

		return \Redirect::to('login');


	}

	public function getSair()
	{
		\Sentry::logout();

		return \Redirect::to('login');
	}


	public function getDadosUsuario()
	{

		$user = \Sentry::getUser();

		$dados = [
			'dados'  => $user,
			'permissoes' => $user->getMergedPermissions(),
			'grupos' => $user->getGroups()
		];



		return \Response::json($dados);

	}


}