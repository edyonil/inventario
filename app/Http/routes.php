<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('cadastro-inventario', function(){
    return "ola Mundo";
});


/*Route::get('limpar-base', function(){

    \JobsCondDev\ModuloInventario\Models\KitModel::where('id', '!=', 1)->delete();
    \JobsCondDev\ModuloInventario\Models\InventarioModel::where('id', '!=', 1)->delete();

    return "Apagou!!!";

});*/