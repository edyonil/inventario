(function(){

    'use strict';

    angular.module('JobCondDev.ModuloRelatorio').controller('RelatorioController', RelatorioController);

    RelatorioController.$inject = ['$scope', '$http', '$resource'];

    function RelatorioController($scope, $http, $resource) {

        var RelatorioCtrl = this;

        RelatorioCtrl.query = {};

        RelatorioCtrl.tipoEquipamento = [
            {
                id: 0,
                descricao: 'Todos'
            },
            {
                id: 1,
                descricao: 'Gabinete'
            },
            {
                id: 2,
                descricao: 'Monitor'
            },
            {
                id: 3,
                descricao: 'Teclado'
            },
            {
                id: 4,
                descricao: 'Mouse'
            },
            {
                id: 5,
                descricao: 'Impressora'
            },
            {
                id: 6,
                descricao: 'Estabilizador'
            },
            {
                id: 8,
                descricao: 'Notebook'
            }
        ];

        RelatorioCtrl.sistemaOperacional = ['WINDOWS 7', 'WINDOWS XP', 'WINDOWS 8', 'LINUX', 'MAC OS', 'NÃO SE APLICA'];



        RelatorioCtrl.init = function() {

            $http.get('status').success(function(data){
                RelatorioCtrl.status = data;
                RelatorioCtrl.status.unshift({
                    id: 0,
                    descricao: 'Todos'
                });
            });

            $http.get('proprietario').success(function(data){
                RelatorioCtrl.proprietario = data;
                RelatorioCtrl.proprietario.unshift({
                    id: 0,
                    nome: 'Todos'
                });
            });

        };

        RelatorioCtrl.gerar = function(){

            RelatorioCtrl.progresso = true;

            var req = {
                method: 'GET',
                url: '/relatorio-enviar',
                data: RelatorioCtrl.query
            };

            var link = $resource('relatorio-enviar');


            link.get(RelatorioCtrl.query).$promise.then(function(data){

                window.open("/relatorio/"+data.link);

            })

        }

    }

})();