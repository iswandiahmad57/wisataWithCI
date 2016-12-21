'use strict';

angular.module('myApp.services',[])

.factory('Produk',function($http){
	var services={};

	services.get=function(id=null){

		if(id==null){
			return $http.get('api/produk/produks').success(function(data){});
		}else{
			return $http.get('api/produk/produk?productID='+id);
		}  		
	}


    services.save = function (data) {

		 return $http.post('api/produk/produk',data).then(function (results) {
        	return results;
    	});
	};


	services.delete=function(id){
		  
		return $http.delete('api/produk/produk?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.edit=function(id,data){
 		 return $http.put('api/produk/produk?productID='+id,data).then(function (results) {
        	return results;
    	});  	
   }
   //get wisata translated
	services.getTranslated=function(id=null){

		if(id==null){
			return $http.get('api/producttranslated/producttranslatedAll').success(function(data){});
		}else{
			return $http.get('api/producttranslated/producttranslated?producttranslatedID='+id);
		}  		
	}

	services.getTranslateds=function(id=null){

		
			return $http.get('api/producttranslated/producttranslatedAll?productID='+id).success(function(data){});
		 		
	}
    services.saveTranslated = function (data) {

		 return $http.post('api/producttranslated/producttranslated',data).then(function (results) {
        	return results;
    	});
	};

	services.deleteTranslated=function(id){
		  
		return $http.delete('api/producttranslated/producttranslated?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.editTranslated=function(data){
 		 return $http.put('api/producttranslated/producttranslated',data).then(function (results) {
        	return results;
    	});  	
   }	
	return services;

});