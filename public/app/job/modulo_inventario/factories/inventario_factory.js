(function(){

    angular.module('JobCondDev.ModuloInventario').factory('$inventario', ['$resource', function ($resource) {

        'use strict';

        return {
            item: $resource('inventario')
        };
    }]);

})()