'use strict';

// Declare app level module which depends on views, and components
angular.module('myApp', [
  'ngRoute',

  'myApp.wisata',
  'myApp.services',
  'angular-input-stars'
]).
config(['$locationProvider', '$routeProvider' ,function($locationProvider, $routeProvider) {
  $locationProvider.hashPrefix('!');

  $routeProvider.otherwise({redirectTo: '/index'});

}]).directive('backButton', ['$window', function($window) {
        return {
            restrict: 'A',
            link: function (scope, elem, attrs) {
                elem.bind('click', function () {
                    $window.history.back();
                });
            }
        };
    }]).directive('forwardButton', ['$window', function($window) {
        return {
            restrict: 'A',
            link: function (scope, elem, attrs) {
                elem.bind('click', function () {
                    $window.history.forward();
                });
            }
        };
    }]);
    // .run(['$rootScope','ngProgressFactory','$location','$window',function($rootScope,ngProgressFactory,$location,$window){
            
       
    //         var progressbar=ngProgressFactory.createInstance();
    //         progressbar.setColor('#26b99a');
    //         progressbar.setHeight('5px');
    //         $rootScope.$on('$routeChangeStart', function(){
    //            progressbar.start();
    //         });

    //         $rootScope.$on('$routeChangeSuccess', function(){
    //           progressbar.complete();
    //         });

    // }]);