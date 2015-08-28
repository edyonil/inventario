(function(){
	'use strict';

	angular.module('JobCondDev', [
		'ngRoute',
		'ngAnimate',
		'ngMessages',
		'ngResource',
		'ngCookies',
		'angulartics.piwik',
		'ngMaterial',
		'md.data.table',
		'JobCondDev.ModuloInventario',
		'JobCondDev.ModuloRelatorio'
	])
	.config(['$routeProvider', '$mdThemingProvider','$analyticsProvider', function($routeProvider, $mdThemingProvider, $analyticsProvider){
		$routeProvider.otherwise({redirectTo: '/inventario'});

			$mdThemingProvider.theme('docs-dark', 'default')
				.primaryPalette('yellow')
				.dark();
	}]).run(['$rootScope','$route', function($rootScope, $route){

			$rootScope.$on("$routeChangeSuccess", function(currentRoute, previousRoute){
				//Change page title, based on Route information
				$rootScope.title = $route.current.title;
			});

		}]);

})();
