<?php namespace JobsCondDev\ModuloUsuario\Repository;

use Cartalyst\Sentry\Sentry;
use JobsCondDev\ModuloUsuario\Models\Grupo;
use JobsCondDev\System\Repository\RepositorioAbstract;

/**
 * Repositório responsável pelas operações do submodulo de gerenciamento de usuarios
 * Esse componente utiliza o Sentry
 * Class CondominioRepositorio
 * @package Condominio\ModuloUsuario\Repositorios
 */
class GrupoRepositorio extends RepositorioAbstract
{

    protected $grupos;

    public function __construct(Grupo $model)
    {

        $this->grupos = $model;
        parent::__construct($model);
    }

    /**
     * @var array Campos do banco de dados
     */
    protected $fields = ['name','permissions','created_by','updated_by', 'deleted_by'];

    /**
     * Não está sendo utilizado no momento
     * @param array $where
     * @return mixed|void
     */
    public function getWhere(array $where)
    {
        return $this->grupos->orderBy('created_at', 'DESC')->paginate((int)$where['count']);
    }

    public function find($id)
    {

        return \Sentry::findGroupById($id);

    }

    public function all(){

        return \Sentry::findAllGroups();

    }

    public function save(array $input)
    {

        return \Sentry::createGroup($input);

    }

    public function update(array $input)
    {
        // Find the group using the group id
        $group = \Sentry::findGroupById($input['id']);

        // Update the group details
        $group->name = $input['name'];

        $dados = [];

        foreach($group->permissions as $key => $groups){
            if(!array_key_exists($key, $input['permissions'])){
                $dados[$key] = 0;
            }
        }

        $dados = array_merge($input['permissions'], $dados);

        $group->permissions = $dados;

        // Update the group
        return $group->save();

    }

    public function delete($id)
    {
        $group = $this->find($id);

        // Delete the group
        if(!$group->delete()) {
            throw new \Exception("Não foi possível excluir o registro");
        }

        return true;
    }






}