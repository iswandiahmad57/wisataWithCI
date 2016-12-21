'use strict';

angular.module('myApp.wisata_translated', ['ngRoute'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/wisata_translated', {
    templateUrl: 'app/app/app_page/wisata_translate/wisata.html',
    controller: 'wisataTransController'
  }).when('/wisata_translated/:wisataID/add',{
    templateUrl:'app/app/app_page/wisata_translate/wisata_form.html',
    controller:'wisata_translatedAddController'
  }).when('/wisata_translated/:wisataID/view',{
    templateUrl:'app/app/app_page/wisata_translate/wisata_translate.html',
    controller:'wisataTranslateController'
  }).when('/wisata_translated/:wisataID/:wisatatranslatedID/edit',{
    templateUrl:'app/app/app_page/wisata_translate/wisata_edit_form.html',
    controller:'wisata_translatedEditController'
  });
}])
.directive('myUpload', [function () {
    return {
        restrict: 'A',
        link: function (scope, elem, attrs) {
            var reader = new FileReader();
            reader.onload = function (e) {
                scope.image = e.target.result;
                scope.$apply();
            }

            elem.on('change', function() {
                reader.readAsDataURL(elem[0].files[0]);
            });
        }
    };
}])
.filter('removeHTMLTags', function() {

  return function(text) {

    return  text ? String(text).replace(/<[^>]+>/gm, '') : '';

  };

})
.controller('wisataTransController', ['$window','$scope','$http','$q','Dokumen','DTOptionsBuilder','DTColumnBuilder','wisata','$compile','SweetAlert','$filter',function($window,$scope,$http,$q,Dokumen,DTOptionsBuilder,DTColumnBuilder,wisata,$compile,SweetAlert,$filter) {
  $scope.projectName="Balaldflaldsfasd";

  $scope.data={};
  $scope.wisata_translated={};
  $scope.submitting=false;
  Dokumen.tanggal();
    var vm = this;
    $scope.data="adfasdf";
    $scope.dtOptions = DTOptionsBuilder.fromFnPromise(function() {
        var defer = $q.defer();
        wisata.get().then(function(result) {
            defer.resolve(result.data);
        });
        return defer.promise;
    }).withPaginationType('full_numbers').withOption('createdRow', function(row) {
        // Recompiling so we can bind Angular directive to the DT
        $compile(angular.element(row).contents())($scope);
      })
      ;

    $scope.dtColumns = [

        DTColumnBuilder.newColumn('wisataIcon').withTitle('Icon').renderWith(function(data,type,full,meta){
          return '<img src="'+data.timelineCover+'" alt="'+data.timelinetitle+'"/>';
        }),
        DTColumnBuilder.newColumn('wisataName').withTitle('wisata'),
        DTColumnBuilder.newColumn(null).withTitle('Content').renderWith(function(data,type,full,meta){
          return $filter('removeHTMLTags')($filter('limitTo')(data.wisataContent,150));
        }),

        DTColumnBuilder.newColumn(null).withTitle('Actions').notSortable()
            .renderWith(function(data, type, full, meta) {
                return '<button class="btn btn-success" ng-click="view(\'' + data.wisataID + '\',\''+data.wisataName+'\')">' +
                    '   <i class="fa fa-eyes"></i>view translated' + 
                    '</button>&nbsp;' 
     
            })

    ];

    //remove gambar



    $scope.newPromise = $scope.newPromise;
    $scope.reloadData = $scope.reloadData;
    $scope.dtInstance = {};

    $scope.newPromise=function() {
        var defer = $q.defer();
        wisata_translated.get().then(function(result) {
            defer.resolve(result.data);
        });
        return defer.promise;
    }
    $scope.view=function(id,name){
      wisata.setID(id,name);
      $window.location.href='#!/wisata_translated/'+id+'/view';
    }



    $scope.liat=function(){
      console.log($scope.dtInstance);
      $scope.dtInstance.changeData($scope.newPromise);
    }

    $scope.reloadData=function() {
        var resetPaging = false;
        $scope.dtInstance.reloadData($scope.callback,false);
        // $scope.dtInstance.rerender(); 
        
    }

    $scope.callback=function(json) {
        console.log(json);
    }


}])
.controller('wisataTranslateController', ['$window','$scope','$http','$q','Dokumen','DTOptionsBuilder','DTColumnBuilder','wisata','$compile','SweetAlert','$filter','$routeParams',function($window,$scope,$http,$q,Dokumen,DTOptionsBuilder,DTColumnBuilder,wisata,$compile,SweetAlert,$filter,$routeParams) {
  $scope.projectName="Balaldflaldsfasd";

  $scope.data={};
  $scope.wisata={};
  $scope.submitting=false;
  Dokumen.tanggal();
  $scope.wisataID=wisata.getID().ids;



  wisata.get($routeParams.wisataID).then(function(result){
    $scope.wisataName=result.data.data.wisataName;
  })
  console.info(wisata.getID());

  $scope.clearModal=function(){
      // $("input").change(function(){
      // $(this).parent().parent().removeClass('has-error');
      // $(this).next().empty();
      // });
      // $("textarea").change(function(){
      //     $(this).parent().parent().removeClass('has-error');
      //     $(this).next().empty();
      // });
      // $("select").change(function(){
      //     $(this).parent().parent().removeClass('has-error');
      //     $(this).next().empty();
      // });      
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string 
  }
   


    var vm = this;
    $scope.data="adfasdf";
    $scope.dtOptions = DTOptionsBuilder.fromFnPromise(function() {
        var defer = $q.defer();
        wisata.getTranslateds($routeParams.wisataID).then(function(result) {
            defer.resolve(result.data);
        });
        return defer.promise;
    }).withPaginationType('full_numbers').withOption('createdRow', function(row) {
        // Recompiling so we can bind Angular directive to the DT
        $compile(angular.element(row).contents())($scope);
      })
      ;

    $scope.dtColumns = [
        DTColumnBuilder.newColumn(null).withTitle('Actions').notSortable()
            .renderWith(function(data, type, full, meta) {
                return '<button class="btn btn-warning" ng-click="edit(\'' + data.wisatatranslatedID + '\')">' +
                    '   <i class="fa fa-edit"></i>' +
                    '</button>&nbsp;' +
                    '<button class="btn btn-danger" ng-click="delete(\'' + data.wisatatranslatedID + '\')">' +
                    '   <i class="fa fa-trash-o"></i>' +
                    '</button>';
            }),

         DTColumnBuilder.newColumn('languageName').withTitle('Language'),
        DTColumnBuilder.newColumn('wisataName').withTitle('Wisata'),
        DTColumnBuilder.newColumn(null).withTitle('Content').renderWith(function(data,type,full,meta){
          return $filter('removeHTMLTags')($filter('limitTo')(data.wisataContent,150));
        })


    ];

    //remove gambar



    $scope.newPromise = $scope.newPromise;
    $scope.reloadData = $scope.reloadData;
    $scope.dtInstance = {};

    $scope.newPromise=function() {
        var defer = $q.defer();
        wisata.get().then(function(result) {
            defer.resolve(result.data);
        });
        return defer.promise;
    }
    $scope.edit=function(id){
      $window.location.href='#!/wisata_translated/'+$routeParams.wisataID+'/'+id+'/edit';
    }

    $scope.delete=function(id){
    swal({
     title: "Are you sure?",
     text: "Data will Be Deleted",
     type: "warning",
     showCancelButton: true,
     confirmButtonColor: "#DD6B55",confirmButtonText: "Yes, delete it!",
     cancelButtonText: "No, cancel !",
     closeOnConfirm: false,
     closeOnCancel: false }, 
      function(isConfirm){ 
          if(isConfirm){



              var data = $.param({
                  wisatatranslateID:id
              });
              wisata.deleteTranslated(data).success(function(status){
                 if (status) {
                    swal("Deleted!", "Data Berhasil Dihapus.", "success");
                    $scope.dtInstance.reloadData();
                 } else {
                    swal("Cancelled", "Deleted Cancelled :)", "error");
                 }
              })
          }else{
            swal("Cancelled", "Deleted Cancelled:)", "error");
          }

    });
    }
    $scope.add=function(){
      wisata.setID($scope.wisataID,$scope.wisataName);
      $window.location.href='#!/wisata_translated/'+$routeParams.wisataID+'/add';
    }

    $scope.liat=function(){
      console.log($scope.dtInstance);
      $scope.dtInstance.changeData($scope.newPromise);
    }

    $scope.reloadData=function() {
        var resetPaging = false;
        $scope.dtInstance.reloadData($scope.callback,false);
        // $scope.dtInstance.rerender(); 
        
    }

    $scope.callback=function(json) {
        console.log(json);
    }






}])
.controller('wisata_translatedEditController', ['$window','FileUploader','$scope','$http','$q','$location','Dokumen','DTOptionsBuilder','DTColumnBuilder','$routeParams','wisata','$compile','SweetAlert','$filter',function($window, FileUploader,$scope,$http,$q,$location,Dokumen,DTOptionsBuilder,DTColumnBuilder,$routeParams,wisata,$compile,SweetAlert,$filter) {
        $scope.title="Edit Data wisata translated";
        $scope.wisata_translated={};
        $scope.submitting=false;
        $scope.image="";

        var id="";
        console.info(wisata.getID());
        Dokumen.select2();
        $scope.cover={};
              
        $scope.clearModal=function(){
  
          $('#form')[0].reset(); // reset form on modals
          $('.form-group').removeClass('has-error'); // clear error class
          $('.help-block').empty(); // clear error string 
        }


        $scope.items="asdfasdfasdf";

        $http.get('api/localization/localizationAll').then(function(result){
          $scope.languages=result.data;
        })

        $scope.getItems=function(){
          //cek terlebih dahulu terdapat data translate atau tidak 
          wisata.getTranslated($routeParams.wisatatranslatedID).then(function(result){
            if(result.data.status==true){
              $scope.wisata_translated.wisataName=result.data.data.wisataName;
              $scope.wisata_translated.localizationID=result.data.data.localizationID;
              $scope.wisata_translated.wisataContent=result.data.data.wisataContent;
              $scope.wisata_translated.wisatatranslatedID=result.data.data.wisatatranslatedID;
            }else{
              $window.history.back();
            }
          })
        }
        $scope.getItems();

        $scope.save=function(){

          //lakukan validasi disisi server terlebih dahulu

          wisata.editTranslated($scope.wisata_translated).then(function(result){

              if(result.data.status==true){
                $window.history.back();
              }else{
                angular.forEach(result.data.data,function(key,val){
                   
                   $('[name="'+val+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+val+'"]').next().html(key); //select span help-block class set text error string
                
                });
              }

          });

         
        }   

         


}]).controller('wisata_translatedAddController', ['$window','FileUploader','$scope','$http','$q','$location','Dokumen','DTOptionsBuilder','DTColumnBuilder','$routeParams','wisata','$compile','SweetAlert','$filter',function($window, FileUploader,$scope,$http,$q,$location,Dokumen,DTOptionsBuilder,DTColumnBuilder,$routeParams,wisata,$compile,SweetAlert,$filter) {
        $scope.title="Tambah Data wisata_translated";
        $scope.wisata_translated={'wisataID':$routeParams.wisataID};
        $scope.submitting=false;
        $scope.image="";

        var id="";
        console.info(wisata.getID());
        Dokumen.select2();
        $scope.cover={};

        $scope.clearModal=function(){
  
          $('#form')[0].reset(); // reset form on modals
          $('.form-group').removeClass('has-error'); // clear error class
          $('.help-block').empty(); // clear error string 
        }


        $scope.items="asdfasdfasdf";

        $http.get('api/localization/localizationAll').then(function(result){
          $scope.languages=result.data;
        })

        $scope.save=function(){

          //lakukan validasi disisi server terlebih dahulu

          wisata.saveTranslated($scope.wisata_translated).then(function(result){

              if(result.data.status==true){
                $window.history.back();
              }else{
                angular.forEach(result.data.data,function(key,val){
                   
                   $('[name="'+val+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+val+'"]').next().html(key); //select span help-block class set text error string
                
                });
              }

          });

         
        }   

         


}]);
