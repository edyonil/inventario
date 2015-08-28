<?php namespace JobsCondDev\ModuloUsuario\Repository;

use JobsCondDev\System\Repository\RepositorioAbstract;
use JobsCondDev\ModuloUsuario\Models\Modulo;

/**
 * Repositório responsável pelas operações do submodulo Modulo do gerenciamento de usuarios
 * Class ModuloRepositorio
 * @package Condominio\ModuloUsuario\Repositorios
 */
class ModuloRepositorio extends RepositorioAbstract
{

    /**
     * @var \Condominio\ModuloCondominio\Models\SubCondominio
     */
    protected $modulo;

    /**
     * @var array /campos do banco de dados
     */
    protected $fields = ['name', 'display_name', 'created_by', 'updated_by'];

    /**
     * Injeta Model Modulo
     * @param Modulo $modulo
     */
    public function __construct(Modulo $modulo)
    {

        $this->modulo = $modulo;

        parent::__construct($modulo);
    }

    public function all(){

        return $this->modulo->orderBy('created_at', 'ASC')->paginate(10);

    }

    /**
     * Para ser implementado pelas classes concretas
     * @param array $where
     * @return mixed
     */
    public function getWhere(array $where)
    {
        return $this->modulo->orderBy('created_at', 'ASC')->paginate((int)$where['count']);
    }
}
