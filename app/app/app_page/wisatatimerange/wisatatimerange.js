'use strict';

angular.module('myApp.wisatatimerange', ['ngRoute','textAngular'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/wisatatimerange/:wisataID', {
    templateUrl: 'app/app/app_page/wisatatimerange/wisatatimerange.html',
    controller: 'wisatatimerangeController'
  });
}])

.controller('wisatatimerangeController', ['$scope','$http','$q','Dokumen','DTOptionsBuilder','DTColumnBuilder','wisatatimerange','wisata','$compile','SweetAlert','$routeParams',function($scope,$http,$q,Dokumen,DTOptionsBuilder,DTColumnBuilder,wisatatimerange,wisata,$compile,SweetAlert,$routeParams) {
  $scope.projectName="Balaldflaldsfasd";

  $scope.data={};
  $scope.wisatatimerange={};
  $scope.submitting=false;
  Dokumen.tanggal();
  wisata.get($routeParams.wisataID).then(function(result){
    if(result.data.status==false){
      $window.history.back();
    }else{
      $scope.wisataName=result.data.data.wisataName;
      $scope.wisatatimerange.originalID=result.data.data.wisataID;
    }
  })


  wisata.get().then(function(result){
    $scope.destination=result.data;
  })
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
   


  // vm.dtOptions=DTOptionsBuilder.newOptions()
  //       .withDisplayLength(10)
  //       .withOption('bLengthChange', false);
  // // $http.get('api/bahasa/bahasaAll')
  // //   .success(function(data, status, headers, config) {
  // //       $scope.data = data;
  // //   });
  // vm.dtInstance={};

  // vm.data=wisatatimerange.get().then(function(data){
  //       $scope.data = data.data;
  // });

  

  // // $scope.save=function(){
  // //   results= wisatatimerange.post($scope.wisatatimerange);
  // //   if(results=="")
  // // }

      var vm = this;
    $scope.data="adfasdf";
    $scope.dtOptions = DTOptionsBuilder.fromFnPromise(function() {
        var defer = $q.defer();
        wisatatimerange.gets($routeParams.wisataID).then(function(result) {
            defer.resolve(result.data);
        });
        return defer.promise;
    }).withPaginationType('full_numbers').withOption('createdRow', function(row) {
        // Recompiling so we can bind Angular directive to the DT
        $compile(angular.element(row).contents())($scope);
      });

    $scope.dtColumns = [


        DTColumnBuilder.newColumn(null).withTitle('Original').renderWith(function(){
          return $scope.wisataName;
        }),
        DTColumnBuilder.newColumn('wisataName').withTitle('Destination'),
          DTColumnBuilder.newColumn('duration').withTitle('Duration'),

        DTColumnBuilder.newColumn(null).withTitle('Actions').notSortable()
            .renderWith(function(data, type, full, meta) {
                return '<button class="btn btn-warning" ng-click="edit(\'' + data.wisatatimerangeID + '\')">' +
                    '   <i class="fa fa-edit"></i>' +
                    '</button>&nbsp;' +
                    '<button class="btn btn-danger" ng-click="delete(\'' + data.wisatatimerangeID + '\')">' +
                    '   <i class="fa fa-trash-o"></i>' +
                    '</button>';
            })

    ];

    $scope.newPromise = $scope.newPromise;
    $scope.reloadData = $scope.reloadData;
    $scope.dtInstance = {};

    $scope.newPromise=function() {
        var defer = $q.defer();
        wisatatimerange.get().then(function(result) {
            defer.resolve(result.data);
        });
        return defer.promise;
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



  $scope.actSave="save";
  $scope.id=null;
  $scope.add=function(){
    $scope.clearModal();
    $scope.actSave="save";

  }
  $scope.save=function(){
     $scope.submitting=true;

    if($scope.actSave=="save"){
      wisatatimerange.save($scope.wisatatimerange).then(function(result){

        if(result.data.status==true){
          $scope.submitting=false;
          $scope.dtInstance.reloadData();
          $('#modal_form').modal('hide');
          $scope.clearModal();  
         
        }else{
          $scope.submitting=false;
          angular.forEach(result.data.data,function(key,val){
             
             $('[name="'+val+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
              $('[name="'+val+'"]').next().html(key); //select span help-block class set text error string
          
          })
          //tampilkan error form validation
        }
      })

           
    }else{
      //disini untuk edit

        wisatatimerange.edit($scope.id,$scope.wisatatimerange).then(function(result){
          if(result){
            $scope.submitting=false;
            $scope.dtInstance.reloadData();
            $('#modal_form').modal('hide');
          
          }
        });
    }

  }

  $scope.edit=function(id){
    //get data and set to form
        $scope.actSave="edit";
        $scope.id=id;

        wisatatimerange.get(id).success(function(result) {

          $scope.wisatatimerange.destinationID=result.destinationID;
          $scope.wisatatimerange.duration=result.duration;
            $('#modal_form').modal('show');

        });
      
  }    

  // $scope.delete=function(id){
  //   console.log(id)
  //   $scope.pro={wisatatimerangeID:id};
  //           var data = $.param({
  //               wisatatimerangeID:id
  //           });
  //   wisatatimerange.delete(data).success(function(status){
  //       if(status){

  //       }else{

  //       }
  //   })
  // }

  //delete function 
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


              $scope.pro={wisatatimerangeID:id};
                      var data = $.param({
                          wisatatimerangeID:id
                      });
              wisatatimerange.delete(data).success(function(status){
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
  //end of delete



}]);