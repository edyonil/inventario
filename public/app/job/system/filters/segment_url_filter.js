'use strict';

/**
 * Filtro para trabalhar com URL
 * O filtro trabalha em cima do Objeto $location, transformando
 * a url em array.
 *
 * Usa-se como referência a "/" da url
 * A primeira posição da url deve ser removida, pois é vazia sempre
 */

(function(){

    angular.module('JobCondDev').filter('segmentUrl', segmentUrl);

    segmentUrl.$inject = ['$location'];

    function segmentUrl($location) {

        var url = new Object();

        //url.location = $location.path().split("/");

        /**
         * Obtem o segmento desejado
         * É necessário passar qual posição do segemento deseja receber a string
         *
         * @param segment Posicão do segmento que deseja-se obter
         * @returns {*}
         */
        url.segment = function(segment){

            var data = $location.path().split("/");

            if(data[segment]) { return data[segment]; }

            return false;

        };


        /**
         * Informa o total de segmentos desejados
         *
         * @returns {number}
         */
        url.totalSegment = function(){
            var data = $location.path().split("/");
            var i = 1;
            angular.forEach(data, function(value){
                if(value.length) { i++; }
            });
            return i;
        };


        /**
         * Substituir parte especifica da url por outra desejada
         * Nesse caso devemos passar o substituto da url e sua posição na url
         * usando como referência a "/"
         *
         * @param subsituto
         * @param posicao
         * @returns {string}
         */
        url.substituirUrl = function(subsituto, posicao){

            var data = $location.path().split("/");

            var ulrNova = "/";

            for(var i=1; i<data.length;i++) {
                if(i == posicao) {
                    ulrNova = ulrNova + subsituto + '/';
                } else {
                    ulrNova = ulrNova + data[i] + '/';
                }
            }
            return ulrNova;

        };

        /**
         * Obtejo url com seus métodos e atributos
         */
        return url;
    }

})();