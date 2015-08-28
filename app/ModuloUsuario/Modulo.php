<?php namespace JobsCondDev\ModuloUsuario;


use JobsCondDev\ModuloUsuario\Service\ValidacaoModulo;
use JobsCondDev\System\Negocio\InterfaceNegocio;
use JobsCondDev\ModuloUsuario\Repository\ModuloRepositorio;

/**
 * Reponsável pelo processamento pesado da gestão de condominio
 * Class Condominio
 * @package Condominio\ModuloCondominio
 */
class Modulo implements InterfaceNegocio
{

    /**
     * @var Repositorios\ModuloRepositorio
     */
    protected $rModulo;

    /**
     * @var errors string
     */
    protected $errors;


    /**
     * Injeta ModuloRepositorio
     * @param ModuloRepositorio $rModulo
     */
    public function __construct(ModuloRepositorio $rModulo)
    {

        $this->rModulo = $rModulo;


    }

    /**
     * Retorna um registro
     * @param $id
     * @return bool|\stdClass
     */
    public function find($id)
    {

        try {

            $dados = $this->rModulo->find($id);

            if($dados == false) {
                throw new \Exception("Registro não encontrado");
            }

            $itens = new \stdClass();

            $itens->id           = $dados->id;
            $itens->nome         = $dados->name;
            $itens->displayNome  = $dados->display_name;
            $itens->createdAt    = date('d-m-Y h:i:s', strtotime($dados->created_at));
            $itens->updatedAt    = date('d-m-Y h:i:s', strtotime($dados->updated_at));
            $itens->updatedAt    = $dados->updated_at;
            $itens->createdBy    = $dados->created_by;
            $itens->updatedBy    = $dados->updated_by;

            return $itens;

        } catch(\Exception $e) {

            $this->errors = $e->getMessage();
            return false;
        }

    }

    /**
     * Retorna todos os registros
     * Pode ser usado para retornar todos os registros a partir de condições especificas setadas pela $input
     * Nesse caso está sendo utilizado para obter os subcondominios passando como paramentro o ID do Condominio
     * @param null $input
     * @return mixed
     */
    public function all($input = null)
    {
        try{

            $dados = $this->rModulo->getWhere($input);

            if($dados == false){
                throw new \Exception("Não foi encontrado registro");
            }

            $modulos = new \stdClass();
            $modulos->itens = [];

            foreach($dados as $key => $dado) {

                $modulos->itens[$key] = [
                    'id'           => $dado->id,
                    'nome'         => $dado->name,
                    'displayNome'  => $dado->display_name,
                    'createdAt'    => date('d/m/Y H:i:s', strtotime($dado->created_at)),
                    'createdBy'    => $dado->created_by,
                    'updatedBy'    => $dado->updated_by,
                ];

                if($dado->updated_at != $dado->created_at) {
                    $modulos->itens[$key]['updatedAt']  = date('d/m/Y h:i:s', strtotime($dado->updated_at));
                }else{
                    $modulos->itens[$key]['updatedAt'] = false;
                }

            }

            //dd($dados);
            $modulos->total = $dados->total();

            return $modulos;

        } catch (\Exception $e){

            $this->errors = $e->getMessage();
			return false;

        }

    }

    /**
     * Salva um registro
     * @param array $input
     * @return bool
     */
    public function save(array $input)
    {

        try{

            $this->validacao($input);

            $dados = [
                'name'          => $input['nome'],
                'display_name'  => $input['displayNome'],
                'created_by'    => \Sentry::getUser()->id
            ];

            $resultado = $this->rModulo->saveOrUpdate($dados);

            if(!$resultado){

                throw new \Exception('Não foi possível salvar o registro');

            }
            return true;

        }catch (\Exception $e){

            if($e->getCode() == 23000) {

                $this->errors = "Já existe um modulo com esse mesmo nome";
                return false;

            }

            $this->errors = $e->getMessage();

            return false;

        }

    }

    /**
     * Atualiza o registro
     * @param array $input
     * @param $id
     * @return bool
     */
    public function update(array $input, $id)
    {
        try{

            $this->validacao($input);

            $dados = [
                'name'           => $input['nome'],
                'display_name'   => $input['displayNome'],
                'id'             => $id,
                'updated_by'     => \Sentry::getUser()->id
            ];

            $resultado = $this->rModulo->saveOrUpdate($dados);

            if(!$resultado){

                throw new \Exception('Não foi possível salvar o registro');

            }

            return true;

        }catch (\Exception $e){

            if($e->getCode() == 23000) {

                $this->errors = "Já existe um modulo com esse mesmo nome";
                return false;

            }

            $this->errors = $e->getMessage();

            return false;

        }
    }

    /**
     * Delete um registro do sistema utilizando o método SoftDeleting
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        try {

            $input = [
                'id'         => $id,
                'deleted_by' => \Sentry::getUser()->id,
            ];

            $delete = $this->rModulo->delete($input);

            if(!$delete) {
                throw new \Exception("Não foi possível remover o registro");
            }

            return true;

        }catch (\Exception $e) {

            if($e->getCode() == 23000) {

                $this->errors = "Esse registro não pode ser removido. Deve haver permissões para esse modulo";
                return false;

            }

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
        $validacaoModulo = new ValidacaoModulo();

        $validacaoModulo->with($input);

        if(!$validacaoModulo->passes()) {

            throw new \Exception($validacaoModulo->errors()->first());

        }

        return true;
    }
}


