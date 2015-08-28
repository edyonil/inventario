<?php namespace JobsCondDev\System\Negocio;


interface InterfaceNegocio {

    public function find($id);

    public function all($input = null);

    public function save(array $input);

    public function update(array $input, $id);

    public function delete($id);

    public function getErrors();

}