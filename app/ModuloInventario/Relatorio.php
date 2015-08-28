<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 10/08/15
 * Time: 22:06
 */

namespace JobsCondDev\ModuloInventario;


use JobsCondDev\ModuloInventario\Models\InventarioModel;

class Relatorio {

    protected $tipoEquipamento = [
        [
            'id' => 0,
            'descricao' => 'Todos os equipamentos'
        ],
        [
            'id' => 1,
            'descricao' => 'Gabinetes'
        ],
        [
            'id' => 2,
            'descricao' => 'Monitores'
        ],
        [
            'id' => 3,
            'descricao' => 'Teclados'
        ],
        [
            'id' => 4,
            'descricao' => 'Mouses'
        ],
        [
            'id' => 5,
            'descricao' => 'Impressoras'
        ],
        [
            'id' => 6,
            'descricao' => 'Estabilizadores'
        ],
        [
            'id' => 7,
            'descricao' => 'Kits'
        ],
        [
            'id' => 8,
            'descricao' => 'Notebooks'
        ]
    ];

    protected $fields = [
            'proprietario'    => ['Propriétario', 'proprietarioNome'],
            'status_model_id' => ['Status', 'statusNome'],
            'tipo_equipamento'
    ];


    public function consultarRelatorio($request)
    {
        $item = new InventarioModel();

        $input = $request->all();

        if(isset($input['tipoEquipamento']) && $input['tipoEquipamento'] != 0) {
            $item = $item->where('tipo_equipamento', '=', (int)$input['tipoEquipamento']);
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

        if(isset($input['agruparPor'])) {
            $item = $item->orderBy($input['agruparPor']);
        }

        $item = $item->get();

        $array = [];

        $mudou = false;
        $contador = 0;

        foreach($item as $key => $i) {

            if(isset($input['agruparPor'])) {

                if($mudou == false) {

                    $contador += 1;

                    $temp = $this->fields[$input['agruparPor']][1];

                    $array[$contador] = [
                        'agrupador' => $this->fields[$input['agruparPor']][0]
                    ];

                    if($input['agruparPor'] === 'proprietario') {
                        $array[$contador]['nome'] = $i->proprietarioRelacao->nome;
                    }

                    $contador = $contador+1;

                    $mudou = true;

                }else{
                    $contador += 1;
                }
            }else{
                $contador = $key;
            }

            $array[$contador] = [
                'id'                        => $i->_id,
                'sequencia'                 => $key+1,
                'patrimonio'                => (isset($i->patrimonio) && !empty($i->patrimonio)) ? $i->patrimonio : null,
                'numeroSerie'               => $i->numero_serie,
                'proprietario'              => $i->proprietario,
                'proprietarioNome'          => (isset($i->proprietario)) ? $i->proprietarioRelacao->nome : null,
                'statusNome'                => (isset($i->status_model_id)) ? $i->status->descricao : null,
                'sistemaOperacional'        => (isset($i->sistema_operacional)) ? $i->sistema_operacional : null,
                'nomeComputador'            => (isset($i->nome_computador)) ? $i->nome_computador : null,
                'tipoEquipamento'           => (isset($i->tipo_equipamento)) ? $i->tipo_equipamento : null,
                'tipoEquipamentoNome'       => self::tratarNome($i->tipo_equipamento),
                'kit'                       => $i->kit_model_id,
                'setor'                     => (isset($i->kit_model_id)) ? $i->kit->setor->sigla : null,
                'createdAt'                 => date('d/m/Y', strtotime($i->created_at))
            ];



            if($key+1 < count($item)){

                if(isset($input['agruparPor'])){

                    if($i->$input['agruparPor'] != $item[$key+1]->$input['agruparPor']) {

                        $mudou = false;
                    }
                }


            }

        }

        $colspan = 5;

        if(isset($input['tipoEquipamento'])) {
            if($input['tipoEquipamento'] == 1 || $input['tipoEquipamento'] == 8) {
                $colspan = 7;
            }

            if($input['tipoEquipamento'] != 3 && $input['tipoEquipamento'] != 4 && $input['tipoEquipamento'] != 6 ) {
                $colspan = $colspan + 1;
            }

        }


        $configuracao = [
            'totalRegistro' => count($item),
            'tipoRelatorio' => (isset($input['tipoEquipamento'])) ? self::tratarNome($input['tipoEquipamento']) : "Todos os equipamentos",
            'colspan'       => $colspan

        ];

        return ['registros' => $array, 'configuracao' => $configuracao];

    }

    protected function tratarNome($id) {
        $count = count($this->tipoEquipamento);

        for($i=0; $i<$count; $i++){

            if($this->tipoEquipamento[$i]['id'] == $id){
                return $this->tipoEquipamento[$i]['descricao'];
            }

        };
    }

}