'use strict';

angular.module('myApp.services8',[])

.factory('guide',function($http){
	var services={};

	services.get=function(id=null){

		if(id==null){
			return $http.get('api/guides/guidesAll').success(function(data){});
		}else{
			return $http.get('api/guides/guides?guideID='+id);
		}  		
	}


 //    services.save = function (data) {

	// 	 return $http.post('api/produk/produk',data).then(function (results) {
 //        	return results;
 //    	});
	// };


	// services.delete=function(id){
		  
	// 	return $http.delete('api/produk/produk?'+id).success(function(data){
	
	// 	}).error(function(data){
	// 		console.log(data);
	// 		console.log(id);
	// 	});
	// }
   
   services.edit=function(id,data){
 		 return $http.put('api/produk/produk?productID='+id,data).then(function (results) {
        	return results;
    	});  	
   }
   //get languanges 

   services.getLanguage=function(id){
   	return $http.get('api/guidelanguage/guidelanguageAll?guideID='+id);
   }
   services.getLanguageGuide=function(id){
   	return $http.get('api/guidelanguage/guidelanguage?guidelanguageID='+id);
   }
    services.saveLanguage = function (data) {

		 return $http.post('api/guidelanguage/guidelanguage',data).then(function (results) {
        	return results;
    	});
	};


	services.deleteLanguage=function(id){
		  
		return $http.delete('api/guidelanguage/guidelanguage?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.editLanguage=function(id,data){
 		 return $http.put('api/guidelanguage/guidelanguage?guidelanguageID='+id,data).then(function (results) {
        	return results;
    	});  	
   }

     //get Skill 

   services.getSkill=function(id){
   	return $http.get('api/guideskill/guideskillAll?guideID='+id);
   }
   services.getskillGuide=function(id){
   	return $http.get('api/guideskill/guideskill?guideskillID='+id);
   }
    services.saveSkill = function (data) {

		 return $http.post('api/guideskill/guideskill',data).then(function (results) {
        	return results;
    	});
	};


	services.deleteSkill=function(id){
		  
		return $http.delete('api/guideskill/guideskill?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.editSkill=function(id,data){
 		 return $http.put('api/guideskill/guideskill?guideskillID='+id,data).then(function (results) {
        	return results;
    	});  	
   }

   //get prices

   services.getPrices=function(id=null){
   		if(id==null){
			return $http.get('api/member/memberpriceAll').success(function(data){});
		}else{
			return $http.get('api/member/memberprice?memberpriceID='+id);
		}  	
   }

    services.savePrices = function (data) {

		 return $http.post('api/member/memberprice',data).then(function (results) {
        	return results;
    	});
	};


	services.deletePrices=function(id){
		  
		return $http.delete('api/member/memberprice?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.editPrices=function(id,data){
 		 return $http.put('api/member/memberprice?memberpriceID='+id,data).then(function (results) {
        	return results;
    	});  	
   }

	return services;

});