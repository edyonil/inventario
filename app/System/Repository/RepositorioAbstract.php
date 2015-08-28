<?php namespace JobsCondDev\System\Repository;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RepositorioAbstract
 * @package Polo\Repositorios
 */
abstract class RepositorioAbstract implements InterfaceRepositorio
{

    /**
     * Model do pacote
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Campos do banco para associação aos atributos
     * @var array
     */
    protected $fields = array();

    /**
     * Injetando model
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Retorna um registro
     * @param int $id
     * @return bool|\Illuminate\Database\Eloquent\Collection|Model|static
     */
    public function find($id)
    {

        $itens = $this->model->find($id);

        return ($itens == null) ? false : $itens;
    }

    /**
     * Retorna todos os registros
     * @return bool|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        $itens =  $this->model->all();

        return (count($itens)) ? $itens : false;
    }

    /**
     * Salva o registro
     * @param array $input
     * @return bool|mixed
     */
    public function save(array $input)
    {
        for($i = 0; $i < count($this->fields); $i++) {

            $dados = $this->fields[$i];

            if(isset($input[$this->fields[$i]])){
                $this->model->$dados = $input[$this->fields[$i]];
            }

        };

        return $this->model->save();

    }

    /**
     * Método que implementa a atualização do registro automatico
     * @param array $input
     * @return bool
     * @throws \Exception
     */
    public function update(array $input)
    {

        $this->model = $this->model->find($input['id']);

        if($this->model == null) {
            throw new \Exception('Registro não foi encontrado');
        }

        for($i = 0; $i < count($this->fields); $i++) {

            $dados = $this->fields[$i];

            if(isset($input[$this->fields[$i]])){

                $this->model->$dados = $input[$this->fields[$i]];

            }

        };

        return $this->model->save();
    }

    /**
     * Aplica o softDeleting e atualiza quem está removendo o registro
     * @param $input
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function delete($input)
    {

        if($input['id'] == null || empty($input['id']) || !isset($input['id']) ) {
            throw new \Exception('ID não encontrado');
        }

        $registro = $this->model->find($input['id']);

        if($registro == null) {
            throw new \Exception('Registro não encontrado para ser removido');
        };

        //$registro->deleted_by = $input['deleted_by'];

        //$registro->deleted_at = date('Y-m-d h:i:s');

        //$registro->save();

        return $registro->delete();
    }

    /**
     * Para ser implementado pelas classes concretas
     * @param array $where
     * @return mixed
     */
    public abstract function getWhere(array $where);


    /**
     * Salva ou atualiza o registro
     * @param array $input
     * @return bool
     * @throws \Exception
     */
    public function saveOrUpdate(array $input)
    {

        if(isset($input['id'])) {
            $this->model = $this->model->find($input['id']);

            if($this->model == null) {
                throw new \Exception('Registro não foi encontrado');
            }

        } else {
           $this->model =  new $this->model;
        }

        for($i = 0; $i < count($this->fields); $i++) {

            $dados = $this->fields[$i];

            if(isset($input[$this->fields[$i]])){
                $this->model->$dados = $input[$this->fields[$i]];
            }

        };

        return $this->model->save();

    }

}
