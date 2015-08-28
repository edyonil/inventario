<?php namespace JobsCondDev\ModuloUsuario\Http\Controllers;


use JobsCondDev\ModuloUsuario\Usuario;
use Illuminate\Routing\Controller;

/**
 * Class UnidadeController
 * @package Condominio\ModuloCondominio\Controllers
 * @autor Danilo Merçon
 *
 * getRegistro() - Dados para teste
 * getIndex() - tras um ou varios registros
 * postIndex() - Criar um registro
 * putIndex($id) - Atualizar um registro
 * deleteIndex($id) - Remove um registro
 *
 */
class UsuarioController extends Controller
{
    /**
     * @var \Condominio\ModuloUsuario\Usuario
     */
    protected $usuario;

    /**
     * @param Usuario $usuario
     */
    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * obtem uma unidade ou varias unidades
     * @param null $idSubCondominio
     * @param null $id
     * @return mixed
     */
    public function getIndex($id = null)
    {
        if($id == null) {
            $dados = $this->usuario->all();
        } else{
            $dados = $this->usuario->find($id);
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
            'msg'    => $this->usuario->getErrors()
        ];

        return \Response::json($json);
    }

    /**
     * cadastra uma unidade
     * @return mixed
     *
     * aletrando postIndex para getCadastrar para realizar os testes
     *
     */
    public function postIndex()
    {
        $input = \Input::all();

        if($this->usuario->save($input)){

            $json = [
                'status' => true,
                'msg'    => "Registro cadastrado com sucesso"
            ];

            return \Response::json($json);

        }

        $json = [
            'status' => false,
            'msg'    => $this->usuario->getErrors()
        ];

        return \Response::json($json);

    }

    /**
     * atualiza rum registro
     * @param $id
     * @return mixed
     */
    public function putIndex($id)
    {

        $input = \Input::all();

        if($this->usuario->update($input, $id)){

            $json = [
                'status' => true,
                'msg'    => "Registro atualizado com sucesso"
            ];

            return \Response::json($json);

        }

        $json = [
            'status' => false,
            'msg'    => $this->usuario->getErrors()
        ];

        return \Response::json($json);
    }

    /**
     * deleta umm registro
     * @param $id
     * @return mixed
     */
    public function deleteIndex($id)
    {

        if($this->usuario->delete($id)) {


            $json = [
                'status' => true,
                'msg'    => "Registro removido com sucesso"
            ];

            return \Response::json($json);

        }

        $json = [
            'status' => false,
            'msg'    => $this->usuario->getErrors()
        ];

        return \Response::json($json);

    }

}