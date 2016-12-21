'use strict';

angular.module('myApp.services20',[])

.factory('countries',function($http){
	var services={};

	services.get=function(id=null){

		if(id==null){
			return $http.get('api/countries/countriesAll').success(function(data){});
		}else{
			return $http.get('api/countries/countries?countryID='+id);
		}  		
	}


    services.save = function (data) {

		 return $http.post('api/countries/countries',data).then(function (results) {
        	return results;
    	});
	};


	services.delete=function(id){
		  
		return $http.delete('api/countries/countries?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.edit=function(id,data){
 		 return $http.put('api/countries/countries?countryID='+id,data).then(function (results) {
        	return results;
    	});  	
   }
	
	return services;

});