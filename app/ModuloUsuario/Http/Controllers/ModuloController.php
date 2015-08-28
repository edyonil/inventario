<?php namespace JobsCondDev\ModuloUsuario\Http\Controllers;

use JobsCondDev\ModuloUsuario\Modulo;
use Illuminate\Routing\Controller;

/**
 * SubController padrão do pacote para acesso ao SubCondominio
 * Deve apenas implementar o restFull
 *
 * Class SubCondominioController
 * @package Condominio\ModuloCondominio\Controllers
 * @author Ediaimo Borges <edyonil@gmail.com>
 *
 *
 * Obs.: Temporario -> Os nomes dos métodos serão alterado para o RestFull quando for implementado o angular
 */
class ModuloController extends Controller
{

    /**
     * Negócio Condominio
     * @var \Condominio\ModuloCondominio\Condominio
     */
    protected $modulo;


	/**
	 * @param Modulo $modulo
	 */
	public function __construct(Modulo $modulo)
    {
        $this->modulo = $modulo;
    }

    /**
     * Retorna os Subcondominios cadastrados
     * @param null $idCondominio
     * @param null $id
     * @return mixed
     */
    public function getIndex($idModulo = null)
    {

        /*$credentials = array(
            'email'    => 'john.doe@example.com',
            'password' => 'test',
        );

        // Authenticate the user
        $user = \Sentry::authenticate($credentials, false);*/

        //É um ou mais registro
        $input['count'] = \Input::get('count');

        if($idModulo == null) {
            $dados = $this->modulo->all($input);
        } else{
            $dados = $this->modulo->find($idModulo);
        }

        if($dados) {

            $json = [
                'status' => true,
                'dados' => $dados
            ];

            return \Response::json($json);
        }

        $json = [
            'status' => false,
            'msg'    => $this->modulo->getErrors()
        ];

        return \Response::json($json);

    }
    /**
     * Cadastra um SubCondominio
     * @return mixed
     */
    public function postIndex()
    {
        $input = \Input::all();

        if($this->modulo->save($input)){

            $json = [
                'status' => true,
                'msg'    => "Registro cadastrado com sucesso"
            ];

            return \Response::json($json);

        }

        $json = [
            'status' => false,
            'msg'    => $this->modulo->getErrors()
        ];

        return \Response::json($json);

    }

    /**
     * Atualizar condominio
     * Deve ser substituido pelo Verbo PUT passando a ser putRegistro
     * @param $id
     * @return mixed
     */
    public function putIndex($id)
    {

        $input = \Input::all();

        if($this->modulo->update($input, $id)){

            $json = [
                'status' => true,
                'msg'    => "Registro atualizado com sucesso"
            ];

            return \Response::json($json);

        }

        $json = [
            'status' => false,
            'msg'    => $this->modulo->getErrors()
        ];

        return \Response::json($json);
    }


    /**
     * Remove condomonio
     * @param $id
     * @return mixed
     */
    public function deleteIndex($id)
    {

        if($this->modulo->delete($id)) {

            $json = [
                'status' => true,
                'msg'    => "Registro removido com sucesso"
            ];

            return \Response::json($json);

        }

        $json = [
            'status' => false,
            'msg'    => $this->modulo->getErrors()
        ];

        return \Response::json($json);

    }
}