<?php namespace JobsCondDev\ModuloInventario\Http\Controllers;

use Illuminate\Routing\Controller;
use JobsCondDev\ModuloInventario\ModuloInventario;
use JobsCondDev\ModuloInventario\Models\InventarioModel;
use JobsCondDev\ModuloInventario\Models\SetorModel;
use Illuminate\Http\Request;


class InventarioController extends Controller
{
    protected $inventario;
    
    public function __construct(ModuloInventario $inventario)
    {
        $this->inventario = $inventario;
    }
    
    public function getIndex(Request $request,$id = null)
    {

        //InventarioModel::where('id', '!=', 1)->delete();
        $query = $request->all();

        if($id != null) {
            $dados = $this->inventario->find($id);

        }else{

            $dados = $this->inventario->all($query);
        }

        
        return response()->json($dados);

    }

    public function postIndex(Request $request)
    {

        $input = $request->all();

        $registro = $this->inventario->save($input);

        if($registro) {

            return response()->json($registro);

        }

        return response()->json(['erro' => $this->inventario->getErrors()], 500);

    }
    public function putIndex(Request $request, $id)
    {

        $input = $request->all();

        $registro = $this->inventario->update($input, $id);

        if($registro) {

            return response()->json($registro);

        }

        return response()->json(['erro' => $this->inventario->getErrors()]);

    }

    public function deleteIndex($id)
    {

        $registro = $this->inventario->delete($id);

        if($registro) {

            return response()->json($registro);

        }

        return response()->json($this->inventario->getErrors(), 400);

    }
    
}