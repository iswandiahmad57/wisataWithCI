'use strict';

angular.module('myApp.services22',[])

.factory('transport',function($http){
	var services={};

	services.get=function(id=null){

		if(id==null){
			return $http.get('api/transport/transportAll').success(function(data){});
		}else{
			return $http.get('api/transport/transport?transportcategoryID='+id);
		}  		
	}


    services.save = function (data) {

		 return $http.post('api/transport/transport',data).then(function (results) {
        	return results;
    	});
	};


	services.delete=function(id){
		  
		return $http.delete('api/transport/transport?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.edit=function(id,data){
 		 return $http.put('api/transport/transport?transportcategoryID='+id,data).then(function (results) {
        	return results;
    	});  	
   }
	services.getGambar=function(id){
		return $http.get('api/transport/timelineGambar?transportcategoryID='+id);
	}
   //get wisata translated
	services.getTranslated=function(id=null){

			return $http.get('api/transport/translatedAll?transportcategoryID='+id).success(function(data){});
 		
	}

	services.getTranslatedItem=function(id){

		return $http.get('api/transport/translated?transportcategoriestranslatedID='+id);
		
	}
    services.saveTranslate = function (data) {

		 return $http.post('api/transport/transportTranslated',data).then(function (results) {
        	return results;
    	});
	};
	services.deleteTranslated=function(id){
		  
		return $http.delete('api/transport/transportTranslated?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.editTranslated=function(id,data){
 		 return $http.put('api/transport/transportTranslated?transportcategoriestranslatedID='+id,data).then(function (results) {
        	return results;
    	});  	
   }

	return services;

});