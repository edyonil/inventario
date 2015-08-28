<?php namespace JobsCondDev\ModuloUsuario\Http\Controllers;

use JobsCondDev\ModuloUsuario\Grupo;
use Illuminate\Routing\Controller;

/**
 * Controllador padrão do pacote para acesso ao Módulo do Condomínio
 * Deve apenas implementar o restFull
 *
 * Class CondominioController
 * @package Condominio\ModuloCondominio\Controllers
 * @author Ediaimo Borges <edyonil@gmail.com>
 *
 * getRegistro() - Todos os registros
 * getRegistro($id) - Um registro
 * postRegistro() - Criar um registro
 * putRegistro($id) - Atualizar um registro
 * deleteRegistro($id) - Remove um registro
 *
 * Obs.: Temporario -> Os nomes dos métodos serão alterado para o RestFull quando for implementado o angular
 */
class GrupoController extends Controller
{

    /**
     * Negócio Condominio
     * @var \JobsCondDev\ModuloUsuario\Grupo
     */
    protected $grupo;


    /**
     * Método construtor que injeta o negocio Grupo
     * @param Grupo $grupo
     */
    public function __construct(Grupo $grupo)
    {

        $this->middleware('auth');

        $this->grupo = $grupo;

    }

    /**
     * Obtem condominios ou um condominio
     * Deve ser substituido pelo nome Registro, passando a ser @getRegistro/@getRegistro($id)
     * @param null $id
     * @return mixed
     */
    public function getIndex($id = null)
    {
        //É um ou mais registro

        //É um ou mais registro
        $input['count'] = \Input::get('count');

        if($id == null) {
            $dados = $this->grupo->all($input);
        } else{
            $dados = $this->grupo->find($id);
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
            'msg'    => $this->grupo->getErrors()
        ];

        return \Response::json($json);
    }

    /**
     * Cadastrar condominio
     * Deve ser substituido pelo Verbo POST passando a ser postIndex
     * @return mixed
     */
    public function postIndex()
    {
        $input = \Input::all();

        if($this->grupo->save($input)){

            $json = [
                'status' => true,
                'msg'    => "Registro cadastrado com sucesso"
            ];

            return \Response::json($json);

        }

        $json = [
            'status' => false,
            'msg'    => $this->grupo->getErrors()
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

        if($this->grupo->update($input, $id)){

            $json = [
                'status' => true,
                'msg'    => "Registro atualizado com sucesso"
            ];

            return \Response::json($json);

        }

        $json = [
            'status' => false,
            'msg'    => $this->grupo->getErrors()
        ];

        return \Response::json($json);
    }


    /**
     * Remove condomonio
     * Deve ser substituido pelo verbo DELETE passando a ser deleteRegistro
     * @param $id
     * @return mixed
     */
    public function deleteIndex($id)
    {

        if($this->grupo->delete($id)) {


            $json = [
                'status' => true,
                'msg'    => "Registro removido com sucesso"
            ];

            return \Response::json($json);

        }

        $json = [
            'status' => false,
            'msg'    => $this->grupo->getErrors()
        ];

        return \Response::json($json);

    }

}