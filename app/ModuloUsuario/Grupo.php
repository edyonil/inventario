<?php namespace JobsCondDev\ModuloUsuario;

use JobsCondDev\System\Negocio\InterfaceNegocio;
use JobsCondDev\ModuloUsuario\Repository\GrupoRepositorio;

/**
 * Reponsável pelo processamento pesado da gestão de condominio
 * Class Condominio
 * @package Condominio\ModuloCondominio
 */
class Grupo implements InterfaceNegocio
{

    /**
     * @var \Condominio\ModuloUsuario\Repositorios\GrupoRepositorio
     */
    protected $rGrupo;

    /**
     * @var errors string
     */
    protected $errors;


    /**
     * Injeta o repositorio Grupos
     * @param GrupoRepositorio $rGrupo
     */
    public function __construct(GrupoRepositorio $rGrupo)
    {

        $this->rGrupo = $rGrupo;


    }

    /**
     * Retorna um registro
     * @param $id
     * @return bool|\stdClass
     */
    public function find($id)
    {

        try {

            $dados = $this->rGrupo->find($id);

            if($dados == false) {
                throw new \Exception("Registro não encontrado");
            }

            $itens = new \stdClass();

            $itens->id         = $dados->id;
            $itens->nome       = $dados->name;
            $itens->permissoes = (array)$dados->permissions;
            $itens->createdAt  = date('d/m/Y h:i:s', strtotime($dados->created_at));
            $itens->updatedAt  = $dados->updated_at;
            $itens->createdBy  = $dados->created_by;
            $itens->updatedBy  = $dados->updated_by;

            if($dados->updated_at != $dados->created_at) {
                $itens->updatedAt  = date('d/m/Y h:i:s', strtotime($dados->updated_at));
            }else{
                $itens->updatedAt = false;
            }

            return $itens;

        } catch(\Exception $e) {

            if($e instanceof \Cartalyst\Sentry\Groups\GroupNotFoundException){
                $this->errors = "Grupo não encontrado";

            }else{
                $this->errors = $e->getMessage();
            };

            return false;
        }

    }

    /**
     * Retorna todos os registros
     * Pode ser usado para retorna todos os registros a partir de condições especificas seta pela $input
     * @param null $input
     * @return mixed
     */
    public function all($input = NULL)
    {

        try{

            $dados = $this->rGrupo->getWhere($input);


            if($dados == false){
                throw new \Exception("Não foi encontrado registro");
            }

            $grupos = new \stdClass();
            $grupos->itens = [];

            foreach($dados as $key => $dado) {

                $grupos->itens[$key] = [
                    'id'         => $dado->id,
                    'nome'       => $dado->name,
                    'createdAt'  => date('d/m/Y h:i:s', strtotime($dado->created_at)),
                    'createdBy'  => $dado->created_by,
                    'updatedBy'  => $dado->updated_by,
                ];

                if($dado->updated_at != $dado->created_at) {
                    $grupos->itens[$key]['updatedAt']  = date('d/m/Y h:i:s', strtotime($dado->updated_at));
                }else{
                    $grupos->itens[$key]['updatedAt'] = false;
                }

            }

            $grupos->total = $dados->total();

            return $grupos;

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

            $dados = [
                'name'        => $input['nome'],
                'permissions' => [],
                'created_by'  => \Sentry::getUser()->id,
            ];

            if(count($input['permissoes']) && isset($input['permissoes'])){

                for($i=0; $i<count($input['permissoes']); $i++){
                    $dados['permissions'][$input['permissoes'][$i]] = 1;
                }

            }

            $this->rGrupo->save($dados);

            return true;

        }
        catch (\Cartalyst\Sentry\Groups\NameRequiredException $e)
        {
            $this->errors = 'Nome do grupo obrigatório';
            return false;
        }
        catch (\Cartalyst\Sentry\Groups\GroupExistsException $e)
        {
            $this->errors = 'Grupo já existe';
            return false;
        }

    }

    /**
     * Atualizar o Registro
     *
     * @param array $input
     * @param $id
     * @return bool
     */
    public function update(array $input, $id)
    {
        try
        {

            $dados = [
                'id'            => $id,
                'name'          => $input['nome'],
                'permissions'   => [],
                'updated_by'    => \Sentry::getUser()->id,
            ];

            if(count($input['permissoes']) && isset($input['permissoes'])){

                for($i=0; $i<count($input['permissoes']); $i++){
                    $dados['permissions'][$input['permissoes'][$i]] = 1;
                }

            }


            if(!$this->rGrupo->update($dados)){

                $this->errors = "Não foi possível salvar o registro";

                return false;

            };

            return true;

        }
        catch (\Cartalyst\Sentry\Groups\NameRequiredException $e)
        {
            $this->errors = "Nome é obrigatório";
            return false;
        }
        catch (\Cartalyst\Sentry\Groups\GroupExistsException $e)
        {
            $this->errors = "Grupo já existe";
            return false;
        }
        catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
            $this->errors = 'Grupo não encontrado';
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
        try
        {

            // Find the group using the group id
            if($this->rGrupo->delete($id))
            {
                return true;
            }

            $this->errors = "Não foi possível excluir o registro";

            return false;
        }
        catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
            $this->errors = "Grupo não encontrado";

            return false;
        }
        catch(\Exception $e)
        {
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
}


