<?php namespace JobsCondDev\ModuloInventario\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use JobsCondDev\ModuloInventario\Relatorio;


class RelatorioController extends Controller
{
    protected $relatorio;
    
    public function __construct(Relatorio $relatorio)
    {
        $this->relatorio = $relatorio;
    }
    
    public function getIndex(Request $request)
    {
        $itens = $this->relatorio->consultarRelatorio($request);

        return response()->view('relatorio/default', compact('itens'));

    }
}