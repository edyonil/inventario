(function(){

    'use strict';

    angular.module('JobCondDev.ModuloInventario').controller('KitDetalhamentoController', KitDetalhamentoController);


    KitDetalhamentoController.$inject = ['$scope', '$mdDialog', '$routeParams', '$mdToast', '$http', '$route', '$mdBottomSheet'];


    function KitDetalhamentoController($scope, $mdDialog, $routeParams, $mdToast, $http, $route, $mdBottomSheet) {

        var DetalhamentoCtrl = this;

        var id = $routeParams.id;

        $scope.hide = function() {
            $mdDialog.hide();
        };
        $scope.cancel = function() {
            $mdDialog.cancel();
        };
        $scope.answer = function(answer) {
            $mdDialog.hide(answer);
        };

        DetalhamentoCtrl.find = function() {

            $http.get('/kit/index/'+id).success(function(data){
                DetalhamentoCtrl.kit = data;
            }).error(function(data){

                $mdToast.show(
                    $mdToast.simple()
                        .content(data)
                        .position('top')
                        .hideDelay(2000)
                );

                DetalhamentoCtrl.progresso = false;
            })
        };

        DetalhamentoCtrl.removerItem = function(ev, item){

            var confirm = $mdDialog.confirm()
                .parent(angular.element(document.body))
                .content('Tem certeza que deseja remover o item ' + item.tipoEquipamentoNome + ', número de série ' + item.numeroSerie + ' do kit?')
                .ariaLabel('Fechar')
                .ok('Sim')
                .cancel('Não remover')
                .targetEvent(ev);

            $mdDialog.show(confirm).then(function() {

                $http.delete('inventario/index/'+item.id).success(function(data){
                    $mdToast.show(
                        $mdToast.simple()
                            .content('Item removido do kit')
                            .position('top')
                            .hideDelay(2000)
                    );

                    $route.reload();

                }).error(function(data){
                    $mdToast.show(
                        $mdToast.simple()
                            .content(data)
                            .position('top')
                            .hideDelay(2000)
                    );

                });
            });
        };

        DetalhamentoCtrl.exibirForm = function($event) {

            $mdBottomSheet.show({
                templateUrl: 'app/job/views/inventario/adicionar_kit.html',
                controller: 'LocalizarItemController',
                targetEvent: $event
            }).then(function(reload){
                if(reload) {
                    $route.reload();
                }
            });
        };
    }

})();