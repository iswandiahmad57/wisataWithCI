'use strict';

angular.module('myApp.wisata', ['ngRoute'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/index', {
    templateUrl: 'app_front/app_page/index/index.html',
    controller: 'indexController'
  }).when('/wisata/',{
    templateUrl:'app_front/app_page/index/wisata.html',
    controller:'wisataController'
  }).when('/wisata/:wisataID/view',{
    templateUrl:'app_front/app_page/index/wisata_detail.html',
    controller:'wisataControllerView'
  });
}])
.filter('removeHTMLTags', function() {

  return function(text) {

    return  text ? String(text).replace(/<[^>]+>/gm, '') : '';

  };

})
.controller('indexController',['$scope','wisata','$window',function($scope,wisata,$window){
  $scope.wisata=[];
  $scope.wilayah=["Sleman","Kulon Progo","Yogyakarta","Gunung Kidul"];
  $scope.category=['Pegunungan','Pantai','Laut','Romantis','Culiner','Sun Set','Sun Rise'];
  $scope.paramWilayah=[];
  $scope.paramCategory=[];
  $scope.ids=[];
  $scope.ids1=[];
  $scope.price=0;

  $scope.startPage=0;
  $scope.limitPage=10;
  $scope.totalPage=0;
  $scope.data={};





  $scope.data.paramWilayah=$scope.paramWilayah;
  $scope.data.paramCategory=$scope.paramCategory;
  $scope.data.price=$scope.price;
  $scope.data.start=$scope.startPage*$scope.limitPage;
  $scope.data.limit=$scope.limitPage;
  //get all wisata item without parameter

  //loader
  $scope.wisataLoaded=false;
  function send(data){
     wisata.postAll(data).success(function(result,status){
      if(result.status!="empty"){
           $scope.wisata=result.data;
           $scope.total=result.total;
           // console.log(result.data);
      }
      $scope.wisataLoaded=true;
      // console.log(status);

    }).error(function(data,status){
        console.log(status);
    });
  }
  send($scope.data);

  //for wilayah
  $scope.$watchCollection('ids', function(newVal) {
    for (var i = 0; i < newVal.length; ++i) {
      if(newVal[i]==true){
  
        $scope.paramWilayah[i]=$scope.wilayah[i];
      }else{
        $scope.paramWilayah.splice(i);
      }


    }
    $scope.wisataLoaded=false;
    $scope.data.paramWilayah=$scope.paramWilayah;
    $scope.data.start=0;
    send($scope.data);

  });

  //for category
  $scope.$watchCollection('ids1', function(newVal) {
    for (var i = 0; i < newVal.length; ++i) {

      // console.log(newVal[i]);
      if(newVal[i]==true){
        console.log($scope.category[i]);
        $scope.paramCategory[i]=$scope.category[i];
      }else{
        $scope.paramCategory.splice(i);
      }
    }
    $scope.wisataLoaded=false;
      $scope.data.start=0;
      send($scope.data);
  });



  //for price
  $scope.changedValue=function(value){
    $scope.price=value;
    $scope.data.start=0;
    $scope.wisataLoaded=false;
    send($scope.data);
  }
  
  //pagination

  $scope.pagination=function(isi){
    $scope.wisataLoaded=false;
    var total=$scope.start * $scope.limitPage;
     var totalPage=Math.ceil($scope.total/10);

     
      if(isi=="min" ){
        $scope.startPage-=1;
      }else{
        $scope.startPage+=1;
      }   

      if($scope.startPage < 0 || $scope.startPage >totalPage){
        $scope.startPage=0;
      }

      $scope.data.start=$scope.startPage*10;
      send($scope.data);
    
   
      
  }

  //sorting
  $scope.propertyName = 'age';
  $scope.reverse = true;

  $scope.sortBy = function(propertyName) {
    $scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;
    $scope.propertyName = propertyName;
  };
  $scope.wisataView=function(wisataID){
    $window.location.href='#!/wisata/'+wisataID+'/view';
  }



}])
.controller('wisataController',['$scope',function($scope){

}])
.controller('wisataControllerView',['$scope','$routeParams','wisata','$window','$rootScope',function($scope,$routeParams,wisata,$windows,$rootScope){



  //cek 

  $scope.wisata={};
  $scope.wisataGambar={};
  $scope.comments={};
  var wisataID=$routeParams.wisataID;
    // $scope.images=function(wisataID){
    //     var defer = $q.defer();
    //      wisata.getGambar(id).then(function(result) {
    //         defer.resolve(result.data);
    //     });
    //     return defer.promise;
    // }
    wisata.get(wisataID).then(function(result){
        if(result.data.status==true){
          //jika status ada tampilkan data ke dalam form edit
          $scope.wisata.wisataName=result.data.data.wisataName;
          $scope.wisata.wisataWilayah=result.data.data.wisataWilayah;
          $scope.wisata.wisataLng=result.data.data.wisataLng;
          $scope.wisata.wisataLat=result.data.data.wisataLat;
          $scope.wisata.wisataContent=result.data.data.wisataContent;
          $scope.wisata.wisataCover=result.data.data.wisataCover;
          $scope.wisata.wisatatiketPrice=result.data.data.wisatatiketPrice;
          $scope.wisata.wisatatiketChildrenPrice=result.data.data.wisatatiketChildrenPrice;
          
          wisata.getGambar(wisataID).then(function(result){
             $scope.wisataGambar=result.data;
             $scope.comments=result.data;
          })
          wisata.getComment(wisataID).then(function(result){
            $scope.comments=result.data.data;
            console.log($scope.comments);
           
          })



         
        }else{
          //jika status tidak ada maka kembali ke halaman sebelumnya

          $window.history.back();
        }
    });

  //
  $scope.comment={};
  $scope.comment.wisataID=wisataID;
  $scope.saveComment=function(){
    wisata.saveComment($scope.comment).then(function(result){
          if(result.data.status==true){
          wisata.getComment(wisataID).then(function(result){
            $scope.comments=result.data.data;
            console.log($scope.comments);
           
          })
            $scope.clearModal();  
 
          }else{
            alert('gagal menginput comment');
          }
    })    
  }
  // console.log($scope.comment.nama);
  $scope.clearModal=function(){     
    $('#form1')[0].reset(); // reset form on modals

  }
  $scope.rat={};
  $scope.send=function(ratinVal){
    
    console.log(ratinVal);
    alert('terimakasih telah memberi rating :)' + ratinVal +" Bintang");
    $scope.rat.ratingVal=ratinVal *20;
    $scope.rat.wisataID=wisataID;
    wisata.saveRating($scope.rat).then(function(result){
      if(result.status==true){
        $scope.enableReadonly=true;
      }
    })
   
  }

}]);