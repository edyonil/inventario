<?php namespace JobsCondDev\ModuloInventario\Http\Controllers;

use Illuminate\Routing\Controller;
use JobsCondDev\ModuloInventario\ModuloInventario;
use JobsCondDev\ModuloInventario\Kit;
use Illuminate\Http\Request;


class KitController extends Controller
{
    protected $kit;
    
    public function __construct(Kit $kit)
    {
        $this->kit = $kit;
    }
    
    public function getIndex(Request $request, $id = null)
    {


        //InventarioModel::where('id', '!=', 1)->delete();

        //$limit = $request->input('limit');

        if($id != null){

            $itens = $this->kit->find($id);
        }else{
            $itens = $this->kit->all($request);
        }

        if($itens) {
            return response()->json($itens);
        }

        return response()->json($itens->getErrors(), 400);

    }

    public function postIndex(Request $request)
    {

        $input = $request->all();

        $registro = $this->kit->save($input);

        if($registro) {

            return response()->json($registro);

        }

        return response()->json(['erro' => $this->kit->getErrors()], 400);

    }
    
}