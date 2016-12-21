'use strict';

angular.module('myApp.services1',[])

.factory('Posting',function($http){
	var services={};

	services.get=function(id=null){

		if(id==null){
			return $http.get('api/posting/timelineAll').success(function(data){});
		}else{
			return $http.get('api/posting/timeline?timelineID='+id);
		}  		
	}


    services.save = function (data) {

		 return $http.post('api/posting/timeline',data).then(function (results) {
        	return results;
    	});
	};

	services.getGambar=function(id){
		return $http.get('api/posting/timelineGambar?timelineID='+id);
	}
	services.delete=function(id){
		  
		return $http.delete('api/posting/timeline?timelineID='+id);
	}
   
   services.edit=function(id,data){
 		 return $http.put('api/posting/timeline?timelineID='+id,data).then(function (results) {
        	return results;
    	});  	
   }
   //get wisata translated
	services.getTranslated=function(id=null){

		if(id==null){
			return $http.get('api/timelinetranslated/timelinetranslatedAll').success(function(data){});
		}else{
			return $http.get('api/timelinetranslated/timelinetranslated?timelinetranslatedID='+id);
		}  		
	}

	services.getTranslateds=function(id=null){

		
			return $http.get('api/timelinetranslated/timelinetranslatedAll?timelineID='+id).success(function(data){});
		 		
	}
    services.saveTranslated = function (data) {

		 return $http.post('api/timelinetranslated/timelinetranslated',data).then(function (results) {
        	return results;
    	});
	};

	services.deleteTranslated=function(id){
		  
		return $http.delete('api/timelinetranslated/timelinetranslated?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.editTranslated=function(data){
 		 return $http.put('api/timelinetranslated/timelinetranslated',data).then(function (results) {
        	return results;
    	});  	
   }	
	return services;

});