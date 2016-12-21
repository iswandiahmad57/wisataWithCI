                
'use strict';

angular.module('myApp.services24',[])

.factory('advertiserPopup',function($http){
    var services={};
    var data={};
    services.setID=function(id,name){
        data.ids=id;
        data.names=name;

        // id.name=name;
    }
        services.get=function(id=null){

            if(id==null){
                return $http.get('api/advertiserPopup/advertiserPopupAll').success(function(data){});
            }else{
                return $http.get('api/advertiserPopup/advertiserPopup?advertiserPopupID='+id);
            }       
        }


        services.save = function (data) {

             return $http.post('api/advertiserPopup/advertiserPopup',data).then(function (results) {
                return results;
            });
        };


        services.delete=function(id){
              
            return $http.delete('api/advertiserPopup/advertiserPopup?'+id).success(function(data){
        
            }).error(function(data){
                console.log(data);
                console.log(id);
            });
        }
       services.edit=function(data){
             return $http.put('api/advertiserPopup/advertiserPopup',data).then(function (results) {
                return results;
            });     
       }
       services.getAdvertisers=function(){
                    return $http.get('api/advertiserPopup/advertisers').success(function(data){});

        }
        services.getUsers=function(){
                    return $http.get('api/advertiserPopup/users').success(function(data){});

        }
        return services; 
});                        