<?php namespace JobsCondDev\ModuloInventario\Models;

use Jenssegers\Mongodb\Model;

class InventarioModel extends Model{

    protected $table = 'inventario';

    protected $fillable = ['setor_model_id', 'sistema_operacional', 'usuario', 'numero_serie', 'nome_computador'];
    
    public function setor() 
    {
        
        return $this->belongsTo('JobsCondDev\ModuloInventario\Models\SetorModel', 'setor_model_id');
        
    }

    public function proprietarioRelacao()
    {
        return $this->belongsTo('JobsCondDev\ModuloInventario\Models\ProprietarioModel', 'proprietario');
    }
    
    public function setorUnico()
    {
        return $this->embedsOne('JobsCondDev\ModuloInventario\Models\SetorModel', 'setor_model_id');
    }

    public function kit()
    {
        return $this->belongsTo('JobsCondDev\ModuloInventario\Models\KitModel', 'kit_model_id');
    }

    public function status()
    {
        return $this->belongsTo('JobsCondDev\ModuloInventario\Models\StatusModel', 'status_model_id');
    }
    
    
    
    
}