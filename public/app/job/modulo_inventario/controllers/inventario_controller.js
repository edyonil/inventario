(function(){

    'use strict';

    angular.module('JobCondDev.ModuloInventario').controller('InventarioController', InventarioController);

    InventarioController.$inject = ['$scope', '$http', '$inventario', '$mdToast', '$mdDialog', '$routeParams', '$route', '$mdBottomSheet', '$filter', '$cookies'];

    function InventarioController($scope, $http, $inventario, $mdToast, $mdDialog, $routeParams, $route, $mdBottomSheet, $filter, $cookies) {

        var InventarioCtrl = this;

        InventarioCtrl.tipoEquipamento = [
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
            },
            {
                id: 7,
                descricao: 'Kit'
            }
        ];

        InventarioCtrl.sistemaOperacional = ['WINDOWS 7', 'WINDOWS XP', 'WINDOWS 8', 'LINUX', 'MAC OS', 'NÃO SE APLICA'];

        $scope.project = {};

        InventarioCtrl.form = {};

        InventarioCtrl.itens = [];

        InventarioCtrl.init = function() {

            var url = $filter('segmentUrl').segment(2);

            if(url == 'kit') {

                var novaArray = [];

                angular.forEach(InventarioCtrl.tipoEquipamento, function(valor){

                    switch (valor.id){
                        case 1:
                            novaArray.push(valor);
                            break;
                        case 2:
                            novaArray.push(valor);
                            break;
                        case 3:
                            novaArray.push(valor);
                            break;
                        case 4:
                            novaArray.push(valor);
                            break;
                        case 6:
                            novaArray.push(valor);
                            break;
                    }

                });

                InventarioCtrl.tipoEquipamento = novaArray;

            }

            $http.get('setor').success(function(data){
                InventarioCtrl.setor = data;
            });

            $http.get('status').success(function(data){
                InventarioCtrl.status = data;
            });

            $http.get('proprietario').success(function(data){
                InventarioCtrl.proprietario = data;
            });

            if($routeParams.id != undefined) {
                InventarioCtrl.progresso = true;
                $http.get('inventario/index/'+$routeParams.id).success(function (dados) {
                    InventarioCtrl.form = dados;
                    setTimeout(function(){
                        $scope.$apply(function(){
                            InventarioCtrl.progresso = false;
                        });
                    }, 1000)
                });
                
            }
        };

        InventarioCtrl.selected = [];

        InventarioCtrl.all = function() {

            InventarioCtrl.tipoEquipamento.unshift({
                id: 0,
                descricao: 'Todos'
            });

            InventarioCtrl.tipoEquipamento.pop();

            $http.get('proprietario').success(function(data){

                InventarioCtrl.proprietario = data;

                InventarioCtrl.proprietario.unshift({
                    id: 0,
                    nome: 'Todos'
                });
            });

            $http.get('status').success(function(data){
                InventarioCtrl.status = data;
                InventarioCtrl.status.unshift({
                    id: 0,
                    descricao: 'Todos'
                });
            });

            var cookieDados = $cookies.getObject('tabela_search');

            if(angular.isDefined(cookieDados)) {
                InventarioCtrl.query = cookieDados;
            }

            return $inventario.item.get(InventarioCtrl.query, success).$promise;

        };

        InventarioCtrl.query = {
            limit: 5,
            page: 1
        };

        function success(desserts) {
            InventarioCtrl.itens = desserts.data;
            InventarioCtrl.total = desserts.total;
        }

        InventarioCtrl.onChange = function(zera){
            if(zera == true) {
                InventarioCtrl.query.page = 1;
            };

            $('main').animate({
                scrollTop: 0
            }, 600);

            cookieBusca();

            return $inventario.item.get(InventarioCtrl.query, success).$promise;
        };

        function cookieBusca(){
            $cookies.putObject('tabela_search', InventarioCtrl.query);
        }

        InventarioCtrl.salvar = function() {

            var url = $filter('segmentUrl').segment(2);

            InventarioCtrl.progresso = true;
            if($routeParams.id != undefined && url != 'kit') {
                $http.put('inventario/index/'+$routeParams.id, InventarioCtrl.form).success(function(data){
                    $mdToast.show(
                        $mdToast.simple()
                            .content('Registro atualizado com sucesso')
                            .position('top')
                            .hideDelay(2000)
                    );

                    InventarioCtrl.progresso = false;

                }).error(function(data){
                    $mdToast.show(
                        $mdToast.simple()
                            .content(data.erro)
                            .position('top')
                            .hideDelay(2000)
                    );

                    InventarioCtrl.progresso = false;
                });
            }else{

                if(url == 'kit'){
                    InventarioCtrl.form.idKit =  $filter('segmentUrl').segment(3);
                }

                $http.post('inventario', InventarioCtrl.form).success(function(data){
                    $mdToast.show(
                        $mdToast.simple()
                            .content('Registro cadastrado com sucesso')
                            .position('top')
                            .hideDelay(2000)
                    );

                    $route.reload();

                    InventarioCtrl.progresso = false;

                }).error(function(data){
                    $mdToast.show(
                        $mdToast.simple()
                            .content(data.erro)
                            .position('top')
                            .hideDelay(2000)
                    );

                    InventarioCtrl.progresso = false;
                });
            }


        };

        InventarioCtrl.kitDetalhe = function(ev, dadoskit) {
            $mdDialog.show({
                controller: KitDetalhamentoController,
                templateUrl: 'app/job/views/inventario/kit_detalhe.html',
                parent: angular.element(document.body),
                targetEvent: ev,
                locals: {
                    items: dadoskit
                }
            });

        };

        function KitDetalhamentoController($scope, $mdDialog, items) {

            $scope.items = items;

            $scope.hide = function() {
                $mdDialog.hide();
            };
            $scope.cancel = function() {
                $mdDialog.cancel();
            };
        }

    }

})();