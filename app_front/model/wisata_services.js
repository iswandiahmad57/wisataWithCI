'use strict';

angular.module('myApp.services',[])

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
			return $http.get('api/v1/wisata/wisataAll').success(function(data){});
		}else{
			return $http.get('api/v1/front/wisata?wisataID='+id);
		}  		
	}
	services.postAll=function(start){
		return $http.post('api/v1/front/wisatafront',start);
	}


	services.getGambar=function(id){
		return $http.get('api/wisata/getGambar?wisataID='+id).success(function(data){});
	}




    services.saveComment = function (data) {

		 return $http.post('api/v1/front/comment',data).then(function (results) {
        	return results;
    	});
	};
    services.saveRating = function (data) {

		 return $http.post('api/v1/front/rating',data).then(function (results) {
        	return results;
    	});
	};
   services.getComment=function(id=null){

		if(id==null){
			return $http.get('api/wisata/comment').success(function(data){});
		}else{
			return $http.get('api/v1/front/comment?wisataID='+id);
		}  	
   }

  //  services.deleteComment=function(id){
		// return $http.delete('api/wisata/comment?'+id).success(function(data){
	
		// }).error(function(data){
		// 	console.log(data);
		// 	console.log(id);
		// });	
  //  }
	return services;

});