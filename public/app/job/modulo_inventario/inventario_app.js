(function(){

    'use strict';

    angular.module('JobCondDev.ModuloInventario', ['ngRoute'])

        .config(['$routeProvider','$analyticsProvider', function($routeProvider, $analyticsProvider){

            $routeProvider.when('/inventario', {
                templateUrl: 'app/job/views/inventario/index.html',
                controller: 'InventarioController',
                controllerAs: 'InventarioCtrl',
                title: "Lista de inventário"
            }).when('/inventario/form',{
                templateUrl: 'app/job/views/inventario/form.html',
                controller: 'InventarioController',
                controllerAs: 'InventarioCtrl',
                title: "Cadastro de Inventário"
            }).when('/inventario/form/:id',{
                templateUrl: 'app/job/views/inventario/form.html',
                controller: 'InventarioController',
                controllerAs: 'InventarioCtrl',
                title: "Editar item do inventário"
            }).when('/inventario/kit/:id',{
                templateUrl: 'app/job/views/kit/lista.html',
                controller: 'KitDetalhamentoController',
                controllerAs: 'DetalhamentoCtrl',
                title: "Detalhe do kit"
            });

        }]);

})();