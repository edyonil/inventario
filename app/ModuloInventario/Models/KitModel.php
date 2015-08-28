<?php namespace JobsCondDev\ModuloInventario\Models;

use Jenssegers\Mongodb\Model;

class KitModel extends Model{

    protected $table = 'kit';

    public function inventario()
    {
        return $this->hasMany('JobsCondDev\ModuloInventario\Models\InventarioModel', 'kit_model_id');
    }


    public function setor()
    {
        return $this->belongsTo('JobsCondDev\ModuloInventario\Models\SetorModel', 'setor_model_id');
    }
}