<?php namespace JobsCondDev\ModuloUsuario\Models;

class Grupo extends \Jenssegers\Mongodb\Model {

    protected $table = 'groups';

    protected $fillable = [
        'name',
        'permissions',
    ];

    protected $softDelete = true;

}
