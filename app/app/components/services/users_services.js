                        
        'use strict';

        angular.module('myApp.services25',[])

        .factory('user',function($http){
            var services={};
            var data={};
            services.setID=function(id,name){
                data.ids=id;
                data.names=name;

                // id.name=name;
            }
        services.get=function(id=null){

            if(id==null){
                return $http.get('api/user/userAll').success(function(data){});
            }else{
                return $http.get('api/user/user?userID='+id);
            }       
        }


        services.save = function (data) {

             return $http.post('api/user/user',data).then(function (results) {
                return results;
            });
        };


        services.delete=function(id){
              
            return $http.delete('api/user/user?'+id).success(function(data){
        
            }).error(function(data){
                console.log(data);
                console.log(id);
            });
        }
       services.edit=function(data){
             return $http.put('api/user/user',data).then(function (results) {
                return results;
            });     
       };

       return services; 
   })                        