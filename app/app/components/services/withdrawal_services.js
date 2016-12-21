'use strict';

angular.module('myApp.services19',[])

.factory('withdrawal',function($http){
	var services={};

	services.get=function(id){


			return $http.get('api/guides/withdrawal?withdrawalCode='+id).success(function(results){});
		
	}
   
   services.edit=function(id){
 		 return $http.put('api/guides/withdrawal?withdrawalID='+id).then(function (results) {
        	return results;
    	});  	
   }
	
	return services;

});