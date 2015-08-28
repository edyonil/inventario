<?php  namespace JobsCondDev\ModuloUsuario\Models;
/**
 * Created by PhpStorm.
 * User: Danilo
 * Date: 05/09/14
 * Time: 13:37
 */

class Modulo extends \Jenssegers\Mongodb\Model {

    protected $fillable = [
        'name',
        'display_name',
        'created_by'
    ];

}
