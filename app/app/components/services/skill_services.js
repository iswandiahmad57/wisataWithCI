'use strict';

angular.module('myApp.services4',[])

.factory('skill',function($http){
	var services={};

	services.get=function(id=null){

		if(id==null){
			return $http.get('api/skill/skillAll').success(function(data){});
		}else{
			return $http.get('api/skill/skill?skillID='+id);
		}  		
	}


    services.save = function (data) {

		 return $http.post('api/skill/skill',data).then(function (results) {
        	return results;
    	});
	};


	services.delete=function(id){
		  
		return $http.delete('api/skill/skill?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.edit=function(id,data){
 		 return $http.put('api/skill/skill?skillID='+id,data).then(function (results) {
        	return results;
    	});  	
   }
	
	return services;

});