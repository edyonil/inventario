<?php namespace JobsCondDev\ModuloInventario\Models;

use Jenssegers\Mongodb\Model;
/**
 *
 * @author ediaimoborges
 *        
 */
class ProprietarioModel extends Model
{

    protected $table = 'proprietario';
    
    public function inventario()
    {   
        
        return $this->hasMany('JobsCondDev\ModuloInventario\Models\InventarioModel');
        
    }

}