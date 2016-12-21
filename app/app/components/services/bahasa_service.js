'use strict';

angular.module('myApp.services3',[])

.factory('bahasa',function($http){
	var services={};

	services.get=function(id=null){

		if(id==null){
			return $http.get('api/bahasa/bahasaAll').success(function(data){});
		}else{
			return $http.get('api/bahasa/bahasa?languageID='+id);
		}  		
	}


    services.save = function (data) {

		 return $http.post('api/bahasa/bahasa',data).then(function (results) {
        	return results;
    	});
	};


	services.delete=function(id){
		  
		return $http.delete('api/bahasa/bahasa?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.edit=function(id,data){
 		 return $http.put('api/bahasa/bahasa?languageID='+id,data).then(function (results) {
        	return results;
    	});  	
   }

   services.getAvalibleLanguage=function(id=null){
		if(id==null){
			return $http.get('api/bahasa/avalible').success(function(data){});
		}else{
			return $http.get('api/bahasa/avalible?availablelanguageID='+id);
		}   	
   }

  
	services.delete=function(id){
		  
		return $http.delete('api/bahasa/avalible?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
    services.saveAvalibleLanguage = function (data) {

		 return $http.post('api/bahasa/avalible',data).then(function (results) {
        	return results;
    	});
	};	
	return services;

});