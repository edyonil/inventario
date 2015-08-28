<?php

use JobsCondDev\ModuloInventario\Models\SetorModel;
use JobsCondDev\ModuloInventario\Models\ProprietarioModel;
use JobsCondDev\ModuloInventario\Models\StatusModel;
use Illuminate\Http\Request;

Route::controller('inventario', '\JobsCondDev\ModuloInventario\Http\Controllers\InventarioController');
Route::controller('kit', '\JobsCondDev\ModuloInventario\Http\Controllers\kitController');
Route::controller('relatorio', '\JobsCondDev\ModuloInventario\Http\Controllers\RelatorioController');


Route::get('relatorio-enviar', function(Request $request){

    $url = $request->url();

    $urlTwo = $request->fullUrl();


    return response()->json(['link' => str_replace($url, "", $urlTwo)]);

});
Route::get('setor', function(){
   
    $model = new SetorModel();
    
    return $model->all();
    
});

Route::get('proprietario', function(){

    return ProprietarioModel::all();

});

Route::get('status', function(){

    /*StatusModel::where('_id', '!=', 1)->delete();*/

    /*$array = [
        [
            'alias'     => 'em_estoque',
            'descricao' => 'Em Estoque'
        ],
        [
            'alias'     => 'operacional',
            'descricao' => 'Operacional'
        ],
        [
            'alias'     => 'em_manutencao',
            'descricao' => 'Em Manutenção'
        ],
        [
            'alias'     => 'backup',
            'descricao' => 'Backup'
        ],
        [
            'alias'     => 'com_defeito',
            'descricao' => 'Com Defeito'
        ],
        [
            'alias'     => 'para_devolucao',
            'descricao' => 'Para Devolução'
        ],
        [
            'alias'     => 'devolvido',
            'descricao' => 'Devolvido'
        ]
    ];

    foreach($array as $a) {

        $model = new StatusModel();
        $model->alias       = $a['alias'];
        $model->descricao   = $a['descricao'];
        $model->save();

    }*/

    return StatusModel::all();
});

