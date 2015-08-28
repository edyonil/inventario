<?php namespace JobsCondDev\System\Repository;

/**
 * Interface responsável por definir quais métodos são acessiveis publicamente
 * Interface InterfaceRepositorio
 * @package Condominio\System\Repositorio
 */
interface InterfaceRepositorio {

    /**
     * Retorna todos os registros
     */
    public function all();

    /**
     * Retorna que apenas um registro
     * @var $id int
     */
    public function find($id);

    /**
     * Salva um registro
     * @param array $input
     * @return mixed
     */
    public function save(array $input);

    /**
     * Atualizar um registro
     * @param array $input
     * @return mixed
     */
    public function update(array $input);

    /**
     * Remove um registro
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Obtem um ou mais registro de acordo com o critério
     * @param array $where
     * @return mixed
     */
    public function getWhere(array $where);

}