(function(){

    'use strict';

    angular.module('JobCondDev.ModuloInventario').controller('LocalizarItemController', LocalizarItemController);


    LocalizarItemController.$inject = ['$scope', '$mdBottomSheet', '$http', '$inventario', '$routeParams', '$mdToast'];


    function LocalizarItemController($scope, $mdBottomSheet, $http, $inventario, $routeParams, $mdToast) {

        var LocalizarCtrl = this;

        LocalizarCtrl.form = {};

        LocalizarCtrl.form.id = null;
        LocalizarCtrl.ativo = false;
        LocalizarCtrl.reload = false;
        LocalizarCtrl.id = $routeParams.id;

        LocalizarCtrl.fecharItem = function() {
            $mdBottomSheet.hide(LocalizarCtrl.reload);
        };

        function success(desserts) {
            LocalizarCtrl.itens = desserts.data;
            LocalizarCtrl.total = desserts.total;
            LocalizarCtrl.nenhumRegistro = LocalizarCtrl.itens.length == 0;
            LocalizarCtrl.ativo = true;
            LocalizarCtrl.progresso = false;
        }

        LocalizarCtrl.buscar = function() {

            var data = {
                numeroSerie: LocalizarCtrl.numeroSerie
            };

            LocalizarCtrl.progresso = true;

            LocalizarCtrl.form.id = null;

            LocalizarCtrl.ativo = true;

            return $inventario.item.get(data, success).$promise

        };

        LocalizarCtrl.transferir = function() {

            var data = {
                idKit: $routeParams.id,
                id: LocalizarCtrl.form.id
            };

            $http.post('/kit', data).success(function(){
                LocalizarCtrl.itens = [];
                LocalizarCtrl.numeroSerie = "";
                LocalizarCtrl.form.id = null;
                LocalizarCtrl.reload = true;
                $mdToast.show(
                    $mdToast.simple()
                        .content('Item adicionado com sucesso')
                        .position('top')
                        .hideDelay(2000)
                );
            }).error(function(data){
                $mdToast.show(
                    $mdToast.simple()
                        .content(data.erro)
                        .position('top')
                        .hideDelay(2000)
                );
            });

        }
    }

})();