'use strict';

angular.module('myApp.services5',[])

.factory('wisata',function($http){
	var services={};
	//get wisata 
	var data={};
	services.setID=function(id,name){
		data.ids=id;
		data.names=name;

		// id.name=name;
	}

	services.getID=function(){
		return data;
	}
	services.get=function(id=null){

		if(id==null){
			return $http.get('api/wisata/wisataAll').success(function(data){});
		}else{
			return $http.get('api/wisata/wisata?wisataID='+id);
		}  		
	}


    services.save = function (data) {

		 return $http.post('api/wisata/wisata',data).then(function (results) {
        	return results;
    	});
	};
	services.getGambar=function(id){
		return $http.get('api/wisata/getGambar?wisataID='+id).success(function(data){});
	}

	services.delete=function(id){
		  
		return $http.delete('api/wisata/wisata?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.edit=function(data){
 		 return $http.put('api/wisata/wisata',data).then(function (results) {
        	return results;
    	});  	
   }

   services.getWilayah=function(){
   	return $http.get('api/wisata/wilayah').then(function(data){ return data.data;});
   }
	

   //get wisata translated
	services.getTranslated=function(id=null){

		if(id==null){
			return $http.get('api/wisatatranslated/wisatatranslatedAll').success(function(data){});
		}else{
			return $http.get('api/wisatatranslated/wisatatranslated?wisatatranslatedID='+id);
		}  		
	}
	services.getTranslateds=function(id=null){

		
			return $http.get('api/wisatatranslated/wisatatranslatedAll?wisataID='+id).success(function(data){});
		
	}

    services.saveTranslated = function (data) {

		 return $http.post('api/wisatatranslated/wisatatranslated',data).then(function (results) {
        	return results;
    	});
	};

	services.deleteTranslated=function(id){
		  
		return $http.delete('api/wisatatranslated/wisatatranslated?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.editTranslated=function(data){
 		 return $http.put('api/wisatatranslated/wisatatranslated',data).then(function (results) {
        	return results;
    	});  	
   }

//	tiket
	services.getTiket=function(id=null){

			return $http.get('api/wisata/tiket?wisataID='+id).success(function(data){}); 		
	}
	services.getTiketBy=function(id=null){

			return $http.get('api/wisata/tiketBy?wisatatiketID='+id).success(function(data){}); 		
	}
    services.saveTiket= function (data) {

		 return $http.post('api/wisata/tiket',data).then(function (results) {
        	return results;
    	});
	};

	services.deleteTiket=function(id){
		return $http.delete('api/wisata/tiket?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});		
	}
   services.editTiket=function(id,data){
 		 return $http.put('api/wisata/tiket?wisatatiketID='+id,data).then(function (results) {
        	return results;
    	});  	
   }


   services.getComment=function(id=null){

		if(id==null){
			return $http.get('api/wisata/comment').success(function(data){});
		}else{
			return $http.get('api/wisata/comment?wisataID='+id);
		}  	
   }

   services.deleteComment=function(id){
		return $http.delete('api/wisata/comment?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});	
   }
	return services;

});