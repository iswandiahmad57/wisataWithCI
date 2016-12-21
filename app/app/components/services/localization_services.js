'use strict';

angular.module('myApp.services21',[])

.factory('localization',function($http){
	var services={};
	services.getCountries=function(id=null){


		return $http.get('api/countries/countriesAll').success(function(data){});
			
	}

	services.getBahasa=function(id=null){

	
		return $http.get('api/bahasa/bahasaAll').success(function(data){});
	}


	services.get=function(id=null){

		if(id==null){
			return $http.get('api/localization/localizationAll').success(function(data){});
		}else{
			return $http.get('api/localization/localization?localizationID='+id);
		}  		
	}


    services.save = function (data) {

		 return $http.post('api/localization/localization',data).then(function (results) {
        	return results;
    	});
	};


	services.delete=function(id){
		  
		return $http.delete('api/localization/localization?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.edit=function(id,data){
 		 return $http.put('api/localization/localization?localizationID='+id,data).then(function (results) {
        	return results;
    	});  	
   }
	
	return services;

});