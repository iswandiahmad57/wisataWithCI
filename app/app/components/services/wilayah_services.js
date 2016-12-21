'use strict';

angular.module('myApp.services2',[])

.factory('wilayah',function($http){
	var services={};

	services.get=function(id=null){

		if(id==null){
			return $http.get('api/wilayah/wilayahAll').success(function(data){});
		}else{
			return $http.get('api/wilayah/wilayah?wilayahID='+id);
		}  		
	}


    services.save = function (data) {

		 return $http.post('api/wilayah/wilayah',data).then(function (results) {
        	return results;
    	});
	};


	services.delete=function(id){
		  
		return $http.delete('api/wilayah/wilayah?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.edit=function(id,data){
 		 return $http.put('api/wilayah/wilayah?productID='+id,data).then(function (results) {
        	return results;
    	});  	
   }
	
	return services;

});