<?php namespace JobsCondDev\ModuloInventario;

use JobsCondDev\ModuloInventario\Models\InventarioModel;
use JobsCondDev\System\Negocio\InterfaceNegocio;
use JobsCondDev\ModuloInventario\Models\KitModel;

/**
 * @author ediaimoborges
 *
 */
class Kit implements InterfaceNegocio{
 /* (non-PHPdoc)
     * @see \JobsCondDev\System\Negocio\InterfaceNegocio::all()
     */

    protected $errors;

    protected $tipoEquipamento = [
        [
            'id' => 1,
            'descricao' => 'Gabinete'
        ],
        [
            'id' => 2,
            'descricao' => 'Monitor'
        ],
        [
            'id' => 3,
            'descricao' => 'Teclado'
        ],
        [
            'id' => 4,
            'descricao' => 'Mouse'
        ],
        [
            'id' => 5,
            'descricao' => 'Impressora'
        ],
        [
            'id' => 6,
            'descricao' => 'Estabilizador'
        ],
        [
            'id' => 7,
            'descricao' => 'Kit'
        ],
        [
            'id' => 8,
            'descricao' => 'Notebook'
        ]
    ];

    public function all($input = null)
    {
        /*if($input == null) {
            $limit = 5;
        }else{
            $limit = (int)$input;
        }

        $item = InventarioModel::orderBy('created_at', 'DESC')->paginate($limit);

        $count = $item->total();

        $array = [];
        foreach($item as $i) {

            $array[] = [
                'id'                        => $i->_id,
                'patrimonio'                => (isset($i->patrimonio)) ? $i->patrimonio : null,
                'numeroSerie'               => $i->numero_serie,
                'proprietario'              => $i->proprietario,
                'proprietarioNome'          => (isset($i->proprietario)) ? $i->proprietarioRelacao : null,
                'sistemaOperacional'        => (isset($i->sistema_operacional)) ? $i->sistema_operacional : null,
                'nomeComputador'            => (isset($i->nome_computador)) ? $i->nome_computador : null,
                'tipoEquipamento'           => (isset($i->tipo_equipamento)) ? $i->tipo_equipamento : null,
                'tipoEquipamentoNome'       => self::tratarNome($i->tipo_equipamento),
                'usuario'                   => (isset($i->usuario)) ? $i->usuario : null,
                'setor'                     => (isset($i->setor_model_id)) ?$i->setor_model_id  : null,
                'setorSigla'                => (isset($i->setor_model_id)) ?$i->setor : null,
                'kit'                       => $i->kit_model_id,
                'createdAt'                 => date('d/m/Y', strtotime($i->created_at))
            ];

        }

        return ['data' => $array, 'total' => $count];*/
        
    }

 /* (non-PHPdoc)
     * @see \JobsCondDev\System\Negocio\InterfaceNegocio::delete()
     */
    public function delete($id)
    {
        $model = new InventarioModel;

        $item = $model->find($id);

        if(!$item->delete()){
            return false;
        };

        return true;
        
    }

 /* (non-PHPdoc)
     * @see \JobsCondDev\System\Negocio\InterfaceNegocio::find()
     */
    public function find($id)
    {

        try{

            $kit = KitModel::find($id);

            if(!$kit) {
                throw new \Exception('Kit não encontrado!');
            }

            $itensKit = $kit->inventario()->orderBy('tipo_equipamento')->get();

            foreach($itensKit as $i){

                $dados[] = [

                    'id'                        => $i->_id,
                    'patrimonio'                => (isset($i->patrimonio) && !empty($i->patrimonio)) ? $i->patrimonio : null,
                    'numeroSerie'               => $i->numero_serie,
                    'proprietario'              => $i->proprietario,
                    'proprietarioNome'          => (isset($i->proprietario)) ? $i->proprietarioRelacao : null,
                    'sistemaOperacional'        => (isset($i->sistema_operacional)) ? $i->sistema_operacional : null,
                    'nomeComputador'            => (isset($i->nome_computador)) ? $i->nome_computador : null,
                    'tipoEquipamento'           => (isset($i->tipo_equipamento)) ? $i->tipo_equipamento : null,
                    'tipoEquipamentoNome'       => self::tratarNome($i->tipo_equipamento),
                    'usuario'                   => (isset($kit->usuario)) ? $kit->usuario : null,
                    'setor'                     => (isset($kit->setor_model_id)) ?$kit->setor_model_id  : null,
                    'setorSigla'                => (isset($kit->setor_model_id)) ?$kit->setor : null,
                    'createdAt'                 => date('d/m/Y', strtotime($i->created_at))
                ];
            }

            return $dados;

        }catch (\Exception $e) {
            $this->errors = $e->getMessage();
            return false;
        }

    }

    /* (non-PHPdoc)
     * @see \JobsCondDev\System\Negocio\InterfaceNegocio::getErrors()
     */
    public function getErrors()
    {
        return $this->errors;
        
    }

    /* (non-PHPdoc)
     * @see \JobsCondDev\System\Negocio\InterfaceNegocio::save()
     */
    public function save(array $input)
    {
        try{

            $equipamento = InventarioModel::find($input['id']);

            if($equipamento->tipo_equipamento != 2) {

                if(self::verificarItemKit($equipamento->tipo_equipamento, $input['idKit'])){
                    throw new \Exception("Já existe um ". self::tratarNome($equipamento->tipo_equipamento) . " nesse kit");
                };

            }

            $equipamento->kit_model_id = $input['idKit'];
            $equipamento->status_model_id = '55ad767ebffebcc3078b4568';

            $equipamento->save();

            return $equipamento;

        } catch (\Exception $e) {

            $this->errors = $e->getMessage();

            return false;

        }
    }

 /* (non-PHPdoc)
     * @see \JobsCondDev\System\Negocio\InterfaceNegocio::update()
     */
    public function update(array $input, $id)
    {
        return false;
    }

    protected function tratarNome($id) {

        $count = count($this->tipoEquipamento);

        for($i=0; $i<$count; $i++){

           if($this->tipoEquipamento[$i]['id'] == $id){
               return $this->tipoEquipamento[$i]['descricao'];
           }

       };
    }

    protected function verificarItemKit($tipoEquipamento, $idDoKit) {

        $kit = InventarioModel::where('tipo_equipamento', '=', (int)$tipoEquipamento)
            ->where('kit_model_id', '=', $idDoKit)
            ->first();

        if($kit) {
            return true;
        }

        return false;

    }


}
