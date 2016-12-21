'use strict';

// Declare app level module which depends on views, and components
angular.module('myApp', [
  'ngRoute',
  'ngResource',
  'angular-ladda',
  'myApp.services',
  'myApp.services5',

  
  'myApp.wisata',
  'myApp.wisata_translated',

  'textAngular',
  'myApp.dokumen_factory',
  'datatables',
  'ng-sweet-alert',
  'angularFileUpload',
  'ngProgress'

]).
config(['$locationProvider', '$routeProvider' ,function($locationProvider, $routeProvider) {
  $locationProvider.hashPrefix('!');

  $routeProvider.otherwise({redirectTo: '/wisata'});

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