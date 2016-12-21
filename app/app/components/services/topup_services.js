                        
'use strict';

angular.module('myApp.services26',[])

.factory('topup',function($http){
    var services={};
    var data={};
    services.setID=function(id,name){
        data.ids=id;
        data.names=name;

        // id.name=name;
    }
        services.get=function(id=null){

            if(id==null){
                return $http.get('api/topup/topupAll').success(function(data){});
            }else{
                return $http.get('api/topup/topup?topupID='+id);
            }       
        }


        services.save = function (data) {

             return $http.post('api/topup/topup',data).then(function (results) {
                return results;
            });
        };


        services.delete=function(id){
              
            return $http.delete('api/topup/topup?'+id).success(function(data){
        
            }).error(function(data){
                console.log(data);
                console.log(id);
            });
        }
       services.edit=function(data){
             return $http.put('api/topup/topup',data).then(function (results) {
                return results;
            });     
       }

       services.getCustomers=function(){
                    return $http.get('api/topup/customers').success(function(data){});

        };
        services.getUsers=function(){
                    return $http.get('api/topup/users').success(function(data){}); }

        return services; 
})                        