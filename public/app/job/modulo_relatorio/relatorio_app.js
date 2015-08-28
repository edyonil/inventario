(function(){

    'use strict';

    angular.module('JobCondDev.ModuloRelatorio', ['ngRoute'])

        .config(['$routeProvider', function($routeProvider){

            $routeProvider.when('/relatorio', {
                templateUrl: 'app/job/views/relatorio/index.html',
                controller: 'RelatorioController',
                controllerAs: 'RelatorioCtrl',
                title: "Relatório"
            });

        }]);

})();