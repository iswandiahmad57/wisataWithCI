'use strict';

angular.module('myApp.services23',[])

.factory('insurance',function($http){
	var services={};

	services.get=function(id=null){

		if(id==null){
			return $http.get('api/insurance/insuranceAll').success(function(data){});
		}else{
			return $http.get('api/insurance/insurance?insurancepriceID='+id);
		}  		
	}



   
   services.edit=function(id,data){
 		 return $http.put('api/insurance/insurance?insurancepriceID='+id,data).then(function (results) {
        	return results;
    	});  	
   }


	return services;

});