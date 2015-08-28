<?php namespace JobsCondDev\ModuloInventario;

use Illuminate\Database\Eloquent\Collection;
use JobsCondDev\System\Negocio\InterfaceNegocio;
use JobsCondDev\ModuloInventario\Models\InventarioModel;
use JobsCondDev\ModuloInventario\Models\KitModel;

/**
 * @author ediaimoborges
 *
 */
class ModuloInventario implements InterfaceNegocio{

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
        $item = new InventarioModel();

        if(isset($input['tipoEquipamento']) && $input['tipoEquipamento'] != 0) {
            $item = $item->where('tipo_equipamento', '=', (int)$input['tipoEquipamento'])->orWhere('tipo_equipamento', '=', $input['tipoEquipamento']);
        }

        if(isset($input['numeroSerie']) || !empty($input['numeroSerie'])) {
            $item = $item->where('numero_serie', 'like', "%". strtoupper($input['numeroSerie']) ."%");
        }

        if(isset($input['patrimonio']) || !empty($input['patrimonio'])) {
            $item = $item->where('patrimonio', 'like', "%". strtoupper($input['patrimonio']) ."%");
        }

        if(isset($input['proprietario']) && $input['proprietario'] != 0) {
            $item = $item->where('proprietario', '=', $input['proprietario']);
        }

        if(isset($input['nomeComputador']) && !empty($input['nomeComputador'])) {
            $item = $item->where('nome_computador', 'like', '%'. strtoupper($input['nomeComputador']) .'%');
        }
        if(isset($input['status']) && $input['status'] != 0) {
            $item = $item->where('status_model_id', '=', $input['status']);
        }

        $item = $item->orderBy('created_at', 'DESC');

        if(isset($input['limit'])) {
            $item = $item->paginate((int)$input['limit']);
            $count = $item->total();
        }else{
            $item = $item->get();
            $count = count($item);
        }

        $array = [];
        foreach($item as $i) {

            $array[] = [
                'id'                        => $i->_id,
                'patrimonio'                => (isset($i->patrimonio) && !empty($i->patrimonio)) ? $i->patrimonio : null,
                'numeroSerie'               => $i->numero_serie,
                'proprietario'              => $i->proprietario,
                'proprietarioNome'          => (isset($i->proprietario)) ? $i->proprietarioRelacao : null,
                'status'                    => $i->status_model_id,
                'statusNome'                => (isset($i->status_model_id)) ? $i->status : null,
                'sistemaOperacional'        => (isset($i->sistema_operacional)) ? $i->sistema_operacional : null,
                'nomeComputador'            => (isset($i->nome_computador)) ? $i->nome_computador : null,
                'tipoEquipamento'           => (isset($i->tipo_equipamento)) ? $i->tipo_equipamento : null,
                'tipoEquipamentoNome'       => self::tratarNome($i->tipo_equipamento),
                'kit'                       => $i->kit_model_id,
                'dadoskit'                  => (isset($i->kit_model_id)) ? self::tratarRelacao($i->kit->inventario()->orderBy('tipo_equipamento')->get()) : null,
                'createdAt'                 => date('d/m/Y', strtotime($i->created_at))
            ];

        }

        return ['data' => $array, 'total' => $count];
        
    }

 /* (non-PHPdoc)
     * @see \JobsCondDev\System\Negocio\InterfaceNegocio::delete()
     */
    public function delete($id)
    {
        $model = new InventarioModel;

        $item = $model->find($id);

        $item->kit_model_id = null;

        $item->status_model_id = '55ad767ebffebcc3078b4567';

        if(!$item->save()){
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

            $item = InventarioModel::find($id);

            if(!$item) {
                throw new \Exception("Registro não encontrato");
            }

            $object = new \stdClass();

            $object->id = $id;
            $object->patrimonio                = (isset($item->patrimonio) && !empty($item->patrimonio)) ? $item->patrimonio : null;
            $object->numeroSerie               = $item->numero_serie;
            $object->status                    = $item->status_model_id;
            $object->proprietario              = $item->proprietario;
            $object->proprietarioNome          = (isset($item->proprietario)) ? $item->proprietarioRelacao : null;
            $object->sistemaOperacional        = (isset($item->sistema_operacional)) ? $item->sistema_operacional : null;
            $object->nomeComputador            = (isset($item->nome_computador)) ? $item->nome_computador : null;
            $object->tipoEquipamento           = (isset($item->tipo_equipamento)) ? (int)$item->tipo_equipamento : null;
            $object->tipoEquipamentoNome       = self::tratarNome($item->tipo_equipamento);
            $object->usuario                   = (isset($item->usuario)) ? $item->usuario : null;
            $object->setor                     = (isset($item->setor_model_id)) ? $item->setor_model_id : null;
            $object->kit                       = $item->kit_model_id;
            $object->dadoskit                  = (isset($item->kit_model_id)) ? self::tratarRelacao($item->kit->inventario()->orderBy('tipo_equipamento')->get()) : null;
            $object->createdAt                 = date('d/m/Y', strtotime($item->created_at));

            return $object;

        }catch (\Exception $e){

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

            self::validarInput($input);

            $model = new InventarioModel;

            $model->numero_serie     = strtoupper($input['numeroSerie']);
            $model->proprietario     = $input['proprietario'];
            $model->status_model_id  = $input['status'];


            if(isset($input['patrimonio']) || !empty($input['patrimonio'])) {
                $model->patrimonio = strtoupper($input['patrimonio']);
            }

            if($input['tipoEquipamento'] == 1 || $input['tipoEquipamento'] == 7 || $input['tipoEquipamento'] == 8) {
                $model->sistema_operacional  = strtoupper($input['sistemaOperacional']);
                $model->nome_computador       = strtoupper($input['nomeComputador']);
            }

            if($input['tipoEquipamento'] == 7) {

                self::validarInput([
                    'tipoEquipamento' => 1,
                    'numero_serie' => $input['numeroSerie'],
                    'nome_computador' => $input['nomeComputador']
                ]);

                self::validarInput([
                    'tipoEquipamento' => 2,
                    'numero_serie' => $input['numeroSerieMonitor'],
                ]);

                self::validarInput([
                    'tipoEquipamento' => 3,
                    'numero_serie' => $input['numeroSerieTeclado'],
                ]);

                self::validarInput([
                    'tipoEquipamento' => 4,
                    'numero_serie' => $input['numeroSerieMouse'],
                ]);

                self::validarInput([
                    'tipoEquipamento' => 6,
                    'numero_serie' => $input['numeroSerieEstabilizador'],
                ]);

                $kit = new KitModel;

                $kit->usuario         = strtoupper($input['usuario']);
                $kit->setor_model_id  = $input['setor'];

                $kit->save();

                //Cadastro do equipamento
                $model->tipo_equipamento = 1;

                $kit->inventario()->save($model);


                //Cadastro de monitor
                $model = new InventarioModel();
                $model->tipo_equipamento   = 2;
                $model->patrimonio         = (isset($input['patrimonioMonitor'])) ? strtoupper($input['patrimonioMonitor']) : null;
                $model->numero_serie       = strtoupper($input['numeroSerieMonitor']);
                $model->proprietario       = $input['proprietarioMonitor'];
                $model->status_model_id    = $input['status'];
                $kit->inventario()->save($model);

                //Cadastro de teclado
                $model = new InventarioModel();
                $model->tipo_equipamento   = 3;
                $model->numero_serie       = strtoupper($input['numeroSerieTeclado']);
                $model->proprietario       = $input['proprietarioTeclado'];
                $model->status_model_id    = $input['status'];
                $kit->inventario()->save($model);

                //Cadastro de mouse
                $model = new InventarioModel();
                $model->tipo_equipamento   = 4;
                $model->numero_serie       = strtoupper($input['numeroSerieMouse']);
                $model->proprietario       = $input['proprietarioMouse'];
                $model->status_model_id    = $input['status'];
                $kit->inventario()->save($model);

                //Cadastro de estabilizador
                $model = new InventarioModel();
                $model->tipo_equipamento   = 6;
                $model->numero_serie       = strtoupper($input['numeroSerieEstabilizador']);
                $model->proprietario       = $input['proprietarioEstabilizador'];
                $model->status_model_id    = $input['status'];
                $kit->inventario()->save($model);

            }else{

                $model->tipo_equipamento = (int)$input['tipoEquipamento'];

                if($input['tipoEquipamento'] == 8) {

                    $model->usuario         = isset($input['usuario']) ? strtoupper($input['usuario']) : null;
                    $model->setor_model_id  = isset($input['setor']) ? $input['setor'] : null;

                }

                $model->save();
            }

            return $model;

        }catch (\Exception $e) {

            $this->errors = $e->getMessage();
            return false;
        }
        
    }

    /* (non-PHPdoc)
     * @see \JobsCondDev\System\Negocio\InterfaceNegocio::update()
     */
    public function update(array $input, $id)
    {

        try{

            $item = new InventarioModel;

            $model = $item->find($id);

            self::validarInput($input, $model);

            if(!$model) {
                throw new \Exception("Registro não encontrado!");
            }

            $model->tipo_equipamento = (int)$input['tipoEquipamento'];
            $model->numero_serie     = strtoupper($input['numeroSerie']);
            $model->proprietario     = $input['proprietario'];
            $model->status_model_id  = $input['status'];

            if(isset($input['patrimonio']) || !empty($input['patrimonio'])) {

                $model->patrimonio = strtoupper($input['patrimonio']);

            }else{
                $model->patrimonio = null;
            }

            if($input['tipoEquipamento'] == 1 || $input['tipoEquipamento'] == 7 || $input['tipoEquipamento'] == 8) {
                $model->sistema_operacional = strtoupper($input['sistemaOperacional']);
                $model->nome_computador = strtoupper($input['nomeComputador']);
            }

            if($input['tipoEquipamento'] == 8) {

                $model->usuario         = isset($input['usuario']) ? strtoupper($input['usuario']) : null;
                $model->setor_model_id  = isset($input['setor']) ? $input['setor'] : null;

            }

            $model->save();

            return $model;

        }catch (\Exception $e) {

            $this->errors = $e->getMessage();
            return false;

        }
    }

    protected function tratarNome($id) {
        $count = count($this->tipoEquipamento);

        for($i=0; $i<$count; $i++){

           if($this->tipoEquipamento[$i]['id'] == $id){
               return $this->tipoEquipamento[$i]['descricao'];
           }

       };
    }

    protected function tratarRelacao(Collection $array){

        $dados = [];

        foreach($array as $i){
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
                'usuario'                   => (isset($i->kit->usuario)) ? $i->kit->usuario : null,
                'setor'                     => (isset($i->kit_model_id)) ? $i->kit->setor_model_id  : null,
                'setorSigla'                => (isset($i->kit_model_id)) ? $i->kit->setor : null,
                'createdAt'                 => date('d/m/Y', strtotime($i->created_at))
            ];
        }

        return $dados;
    }


    protected function validarInput($input, $registro = null)
    {

        $model = new InventarioModel;

        //Faço a consulta com o número se série
        if(isset($input['numeroSerie'])){

            $dados = $model->where('numero_serie', '=', $input['numeroSerie'])->where('tipo_equipamento', '=', (int)$input['tipoEquipamento'])->first();

            //Existe esse numero de serie cadastrado no banco?
            if($dados){
                //Esta no modo de edicao?
                if($registro != null){

                    //É o mesmo registro?
                    if($registro->_id != $dados->_id) {
                        throw new \Exception('Já existe um '. self::tratarNome($input['tipoEquipamento']) .' cadastrado com o número de série ' . $input['numeroSerie']);
                    }

                }else{//Não estou em modo de edição
                    throw new \Exception('Já existe um '. self::tratarNome($input['tipoEquipamento']) .' cadastrado com o número de série ' . $input['numeroSerie']);
                }

            }
        }

        if(isset($input['nomeComputador'])) {

            $dados = $model->where('nome_computador', '=', strtoupper($input['nomeComputador']))->where('tipo_equipamento', '=', (int)$input['tipoEquipamento'])->first();

            //Existe esse nome de computador cadastrado no banco?
            if($dados){
                //Esta no modo de edicao?
                if($registro != null){

                    //É o mesmo registro?
                    if($registro->_id != $dados->_id) {
                        throw new \Exception('Já existe um '. self::tratarNome($input['tipoEquipamento']) .' cadastrado com o nome ' . $input['nomeComputador']);
                    }

                }else{//Não estou em modo de edição
                    throw new \Exception('Já existe um '. self::tratarNome($input['tipoEquipamento']) .' cadastrado com o nome  ' . $input['nomeComputador']);
                }

            }
        }

        return true;
    }
}
