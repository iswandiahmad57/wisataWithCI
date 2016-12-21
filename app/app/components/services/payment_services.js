'use strict';

angular.module('myApp.services9',[])

.factory('payment',function($http){
	var services={};

	services.getWaitPayment=function(id=null){
			return $http.get('api/payment/waiting?orderStatus='+id).success(function(data){});
		
	}


    services.save = function (data) {

		 return $http.post('api/payment/payment',data).then(function (results) {
        	return results;
    	});
	};


	services.delete=function(id){
		  
		return $http.delete('api/payment/payment?'+id).success(function(data){
	
		}).error(function(data){
			console.log(data);
			console.log(id);
		});
	}
   
   services.editConfirm=function(id){
   		var confimValue={'orderStatus':'Paid'};
 		 return $http.put('api/payment/confirm?orderID='+id,confimValue).then(function (results) {
        	return results;
    	});  	
   }
   services.editConfirmCheck=function(id){
   		var confimValue={'orderStatus':'Check'};
 		 return $http.put('api/payment/confirm?orderID='+id,confimValue).then(function (results) {
        	return results;
    	});  	
   }
	return services;

});