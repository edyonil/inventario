<?php namespace JobsCondDev\ModuloInventario\Models;

use Jenssegers\Mongodb\Model;
/**
 *
 * @author ediaimoborges
 *        
 */
class SetorModel extends Model
{
    
    protected $table = 'setor';
    
    public function inventario() 
    {   
        
        return $this->hasMany('JobsCondDev\ModuloInventario\Models\InventarioModel');
        
        
    }
    
    
}