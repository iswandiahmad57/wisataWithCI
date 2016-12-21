'use strict';

angular.module('myApp.services6',[])

.factory('advertiser',function($http){
	var services={};

	services.get=function(id=null){

		if(id==null){
			return $http.get('api/advertisers/advertisersAll').success(function(data){});
		}else{
			return $http.get('api/advertisers/advertisers?advertiserID='+id);
		}  		
	}


    services.save = function (data) {

		 return $http.post('api/advertisers/advertisers',data).then(function (results) {
        	return results;
    	});
	};


	services.delete=function(id){
		  
		return $http.delete('api/advertisers/advertisers?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.edit=function(id,data){
 		 return $http.put('api/advertisers/advertisers?advertiserID='+id,data).then(function (results) {
        	return results;
    	});  	
   }
	
	return services;

});