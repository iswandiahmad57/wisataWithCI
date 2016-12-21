'use strict';

angular.module('myApp.services7',[])

.factory('wisatatimerange',function($http){
	var services={};

	services.get=function(id=null){

		if(id==null){
			return $http.get('api/wisatarange/wisataranges').success(function(data){});
		}else{
			return $http.get('api/wisatarange/wisatarange?wisatatimerangeID='+id);
		}  		
	}

	services.gets=function(id){
		return $http.get('api/wisatarange/wisataranges?wisataID='+id).success(function(data){});
	}


    services.save = function (data) {

		 return $http.post('api/wisatarange/wisatarange',data).then(function (results) {
        	return results;
    	});
	};


	services.delete=function(id){
		  
		return $http.delete('api/wisatarange/wisatarange?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.edit=function(id,data){
 		 return $http.put('api/wisatarange/wisatarange?wisatatimerangeID='+id,data).then(function (results) {
        	return results;
    	});  	
   }

	return services;

});