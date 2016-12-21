'use strict';

angular.module('myApp.wisata', ['ngRoute'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/wisata', {
    templateUrl: 'app/app/app_page/wisata/wisata.html',
    controller: 'wisataController'
  }).when('/wisata/add',{
    templateUrl:'app/app/app_page/wisata/wisata_form.html',
    controller:'wisataAddController'
  }).when('/wisata/:wisataID/edit',{
    templateUrl:'app/app/app_page/wisata/wisata_edit_form.html',
    controller:'wisataEditController'
  }).when('/wisata/:wisataID/tiket',{
    templateUrl:'app/app/app_page/wisata/wisata_tiket.html',
    controller:'tiketController'
  }).when('/wisata_comment',{
    templateUrl:'app/app/app_page/wisata/wisata_comment.html',
    controller:'commentController',
  }).when('/wisata_comment/:wisataID',{
    templateUrl:'app/app/app_page/wisata/wisata_comment.html',
    controller:'commentController',
  });
}])
.directive('ngThumb', ['$window', function($window) {
        var helper = {
            support: !!($window.FileReader && $window.CanvasRenderingContext2D),
            isFile: function(item) {
                return angular.isObject(item) && item instanceof $window.File;
            },
            isImage: function(file) {
                var type =  '|' + file.type.slice(file.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        };

        return {
            restrict: 'A',
            template: '<canvas/>',
            link: function(scope, element, attributes) {
                if (!helper.support) return;

                var params = scope.$eval(attributes.ngThumb);

                if (!helper.isFile(params.file)) return;
                if (!helper.isImage(params.file)) return;

                var canvas = element.find('canvas');
                var reader = new FileReader();

                reader.onload = onLoadFile;
                reader.readAsDataURL(params.file);

                function onLoadFile(event) {
                    var img = new Image();
                    img.onload = onLoadImage;
                    img.src = event.target.result;
                }

                function onLoadImage() {
                    var width = params.width || this.width / this.height * params.height;
                    var height = params.height || this.height / this.width * params.width;
                    canvas.attr({ width: width, height: height });
                    canvas[0].getContext('2d').drawImage(this, 0, 0, width, height);
                }
            }
        };
}]).filter('removeHTMLTags', function() {

  return function(text) {

    return  text ? String(text).replace(/<[^>]+>/gm, '') : '';

  };

})
.controller('wisataController', ['$window','$scope','$http','$q','Dokumen','DTOptionsBuilder','DTColumnBuilder','wisata','$compile','SweetAlert','$filter',function($window,$scope,$http,$q,Dokumen,DTOptionsBuilder,DTColumnBuilder,wisata,$compile,SweetAlert,$filter) {
  $scope.projectName="Balaldflaldsfasd";

  $scope.data={};
  $scope.wisata={};
  $scope.submitting=false;
  Dokumen.tanggal();


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
        wisata.get().then(function(result) {
            defer.resolve(result.data);
        });
        return defer.promise;
    }).withPaginationType('full_numbers').withOption('createdRow', function(row) {
        // Recompiling so we can bind Angular directive to the DT
        $compile(angular.element(row).contents())($scope);
      });

    $scope.dtColumns = [

        DTColumnBuilder.newColumn(null).withTitle('Icon').renderWith(function(data,type,full,meta){
          return '<img style="width:100px; height:100px" src="uploads/'+data.wisataCover+'" alt="'+data.wisataName+'"/>';
        }),
        DTColumnBuilder.newColumn('wisataName').withTitle('Wisata'),
        DTColumnBuilder.newColumn(null).withTitle('Content').renderWith(function(data,type,full,meta){
          return $filter('removeHTMLTags')($filter('limitTo')(data.wisataContent,30));
        }),

        DTColumnBuilder.newColumn(null).withTitle('Actions').notSortable()
            .renderWith(function(data, type, full, meta) {
                return '<button class="btn btn-warning" ng-click="edit(\'' + data.wisataID + '\')">' +
                    '   <i class="fa fa-edit"></i>' +
                    '</button>&nbsp;' +
                    '<button class="btn btn-danger" ng-click="delete(\'' + data.wisataID + '\')">' +
                    '   <i class="fa fa-trash-o"></i>' +
                    '</button>&nbsp;' +
                    '<button class="btn btn-info" ng-click="comment(\'' + data.wisataID + '\')">' +
                    '   <i class="fa fa-time"></i>Comment' +
                    '</button>'+
                    '<button class="btn btn-info" ng-click="tiket(\'' + data.wisataID + '\')">' +
                    '   <i class="fa fa-time"></i>Tiket' +
                    '</button>';
            })

    ];

    //remove gambar
    $scope.comment=function(wisataID){
       $window.location.href='#!/wisata_comment/'+wisataID;
    }
    $scope.tiket=function(wisataID){
       $window.location.href='#!/wisata/'+wisataID+'/tiket';
    }


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
    $scope.reloadData=function() {
        var resetPaging = false;
        $scope.dtInstance.reloadData($scope.callback,false);
        // $scope.dtInstance.rerender(); 
        
    }

    $scope.callback=function(json) {
        console.log(json);
    }
    $scope.edit=function(id){
      $window.location.href='#!/wisata/'+id+'/edit';
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
                          wisataID:id
                      });
              wisata.delete(data).success(function(status){
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


    $scope.liat=function(){
      console.log($scope.dtInstance);
      $scope.dtInstance.changeData($scope.newPromise);
    }








}])
.controller('wisataAddController', ['$window','FileUploader','$scope','$http','$q','$location','Dokumen','DTOptionsBuilder','DTColumnBuilder','$routeParams','wisata','$compile','SweetAlert','$filter',function($window, FileUploader,$scope,$http,$q,$location,Dokumen,DTOptionsBuilder,DTColumnBuilder,$routeParams,wisata,$compile,SweetAlert,$filter) {
        $scope.title="Tambah Data wisata";
        $scope.wisata={'wisataName':"",'wisataWilayah':"",'wisataLng':"",'wisataLat':"",'wisataContent':"",'cover':"",'coverIndex':null};
        $scope.submitting=false;
        $scope.image="";
        $scope.type=['News','Event','Advertising'];
        var id="";

        Dokumen.select2();
        $scope.cover={};
        // wisata.getWilayah().then(function(result){


        // //      $scope.wilayah=result;
        // //      console.log($scope.wilayah);
           
        // // })
        $scope.wilayah=[{'wilayahName':'Sleman'},{'wilayahName':'Gunung Kidul'},{'wilayahName':'Yogyakarta'},{'wilayahName':'Kulon Progo'}];
        $scope.category=['Pegunungan','Pantai','Laut','Romantis','Culiner','Sun Set','Sun Rise'];

        

        $scope.clearModal=function(){
  
          $('#form')[0].reset(); // reset form on modals
          $('.form-group').removeClass('has-error'); // clear error class
          $('.help-block').empty(); // clear error string 
        }

        //init uploader
        var uploader = $scope.uploader = new FileUploader({
                  url: 'api/wisata/wisata'
        });
       // FILTERS

        uploader.filters.push({
            name: 'customFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                return this.queue.length < 10;
            }
        }); 

        $scope.items="asdfasdfasdf";

        $scope.set_cover=function(name, index){
          $scope.wisata.coverIndex=index;
          $scope.wisata.cover=name;
        }

        $scope.save=function(){

          //lakukan validasi disisi server terlebih dahulu
          $http.post('api/wisata/validasi',$scope.wisata).then(function(result){

            if(result.data.status==true){
                $scope.clearModal();
                if($scope.wisata.coverIndex==null){
                  swal("Cover", "silahkan pilih cover dari gambar yang anda upload", "warning");
                }else{
                   uploader.uploadAll(); 
                }              
              }else{
                angular.forEach(result.data.data,function(key,val){
                   
                   $('[name="'+val+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+val+'"]').next().html(key); //select span help-block class set text error string
                
                });
              }

          });

         
        }   

         

         
      
        // CALLBACKS UPLOADEr

        uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
            console.info('onWhenAddingFileFailed', item, filter, options);
        };
        uploader.onAfterAddingFile = function(fileItem) {
              console.info('cek',this.getNotUploadedItems().length);
              console.info('ob',this.getNotUploadedItems()[0].file.name);
           for (var i =0; i < this.getNotUploadedItems().length-1; i++) {
             if(this.getNotUploadedItems()[i].file.name == fileItem.file.name){
               this.removeFromQueue(i);
             }
           }



              console.info('onAfterAddingFile', fileItem);
            
            
        };
        uploader.onAfterAddingAll = function(addedFileItems) {
            console.info('onAfterAddingAll', addedFileItems);
        };
        uploader.onBeforeUploadItem = function(item) {

            //push form data apabila item index adalah yang ke 0
            var indexID={};

            indexID.wisataID=id;

            indexID.imageNumber=uploader.getIndexOfItem(item);


            if(this.getIndexOfItem(item)==0){
              $scope.wisata.imageNumber=uploader.getIndexOfItem(item);
              item.formData.push($scope.wisata);
            }else{
              item.formData.push(indexID);
            } 
          

   
            console.info('onBeforeUploadItem', item);
        };

        uploader.onProgressItem = function(fileItem, progress) {
            console.info('onProgressItem', fileItem, progress);
        };
        uploader.onProgressAll = function(progress) {

            console.info('onProgressAll', progress);
            $scope.submitting=true;
        };
        uploader.onSuccessItem = function(fileItem, response, status, headers) {

            console.info('onSuccessItem', fileItem, response, status, headers);
        };
        uploader.onErrorItem = function(fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);

            if(fileItem.isError==true && this.getIndexOfItem(fileItem)==0){
              this.cancelAll();
              console.info('error', fileItem.isError);
            }
            console.log(uploader.getReadyItems(fileItem));
            if(response.data.status==false  && response.data.error=="Validasi Failed"){
              $scope.submitting=false;
              id=response.data.id;
              
              angular.forEach(response.data,function(key,val){
                 if(val!="id"){

                 $('[name="'+val+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                  $('[name="'+val+'"]').next().html(key); //select span help-block class set text error string
              
            
                 }

              })
            }
        };
        uploader.onCancelItem = function(fileItem, response, status, headers) {
            console.info('onCancelItem', fileItem, response, status, headers);
            this.cancelItem(fileItem);
        };
        uploader.onCompleteItem = function(fileItem, response, status, headers) {
            console.info('onCompleteItem', fileItem, response, status, headers);
            // if(response.status==true){

            // }
            id=response.id;
            if(response.status==false  && response.error=="Validasi Failed"){
              $scope.submitting=false;

   
              angular.forEach(response.data,function(key,val){
                 if(val!="id"){

                 $('[name="'+val+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                  $('[name="'+val+'"]').next().html(key); //select span help-block class set text error string
              
            
                 }

              })
            }

            if(response.status==false && response.error=="Upload Failed"){
  
              swal("Gagal Mengupload dan menginput data , periksa jenis Gambar anda");
            }

            if(response.status=false && response.error=="Input Failed"){
     
              swal("Entah Mengapa Kami Gagal menginput wisataan ke database");
            }
            console.log(response.id);
        };
        uploader.onCompleteAll = function() {



          $scope.cover.name=null;
            console.info('onCompleteAll');
               $scope.submitting=false;
                swal({
                 title: "Nice , Good Job",
                 text: "Data berhasil di input , apakah anda ingin melanjutkan menginput data?",
                 type: "success",
                 showCancelButton: true,
                 confirmButtonColor: "#DD6B55",confirmButtonText: "Lanjutkan Input!",
                 cancelButtonText: "Kembali ke list",
                 closeOnConfirm: false,
                 closeOnCancel: false }, 
                  function(isConfirm){ 
                     if (isConfirm) {
                        // lanjut inputan 
                        uploader.clearQueue();
                        id="";
                        $('#form')[0].reset(); // reset form on modals
                        $('.form-group').removeClass('has-error'); // clear error class
                        $('.help-block').empty(); // clear error string 
                        swal("Input wisata", "", "success");

                     } else {
                        //kembali kelist wisata
                      id="";
                        $window.history.back();
                        swal("Wisata berhasil di input", "", "success");

                     }
                  });
        };

        console.info('uploader', uploader);

}])
.controller('wisataEditController', ['$window','FileUploader','$scope','$http','$q','$location','Dokumen','DTOptionsBuilder','DTColumnBuilder','$routeParams','wisata','$compile','SweetAlert','$filter',function($window, FileUploader,$scope,$http,$q,$location,Dokumen,DTOptionsBuilder,DTColumnBuilder,$routeParams,wisata,$compile,SweetAlert,$filter) {
        $scope.title="Tambah Data wisata";
        $scope.wisata={};
        $scope.submitting=false;
        $scope.image="";
        $scope.type=['News','Event','Advertising'];
        var id="";
        $scope.cover={};
        $scope.wilayah=[{'wilayahName':'Sleman'},{'wilayahName':'Gunung Kidul'},{'wilayahName':'Yogyakarta'},{'wilayahName':'Kulon Progo'}];
        $scope.category=['Pegunungan','Pantai','Laut','Romantis','Culiner','Sun Set','Sun Rise'];  

        $scope.clearModal=function(){
  

          $('#form')[0].reset(); // reset form on modals
          $('.form-group').removeClass('has-error'); // clear error class
          $('.help-block').empty(); // clear error string 
        }
        // $scope.fileName=function(){
        //   $scope.wisata.fileUpload=$scope.cover;
        //   $scope.cob=$scope.cover;
        // }
        var uploader = $scope.uploader = new FileUploader({
                  url: 'api/wisata/uploadImage'
        });
       // FILTERS

        uploader.filters.push({
            name: 'customFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                return this.queue.length < 10;
            }
        }); 
          // wisata.getWilayah().then(function(result){


          //      $scope.wilayah=result;
             
          // })


        $scope.images=function(id){
            var defer = $q.defer();
             wisata.getGambar(id).then(function(result) {
                defer.resolve(result.data);
            });
            return defer.promise;
        }
        $scope.getTimeline=function(){
          wisata.get($routeParams.wisataID).then(function(result){
              if(result.data.status==true){
                //jika status ada tampilkan data ke dalam form edit
                $scope.wisata.wisataName=result.data.data.wisataName;
                $scope.wisata.wisataWilayah=result.data.data.wisataWilayah;
                $scope.wisata.wisataLng=result.data.data.wisataLng;
                $scope.wisata.wisataLat=result.data.data.wisataLat;
                $scope.wisata.wisataCategory=result.data.data.wisataCategory;
                $scope.wisata.wisataContent=result.data.data.wisataContent;
                $scope.wisata.wisataCover=result.data.data.wisataCover;
                
                wisata.getGambar(result.data.data.wisataID).then(function(result){
                   $scope.wisataGambar=result.data;
                })

               
              }else{
                //jika status tidak ada maka kembali ke halaman sebelumnya

                $window.history.back();
              }
          });

        }


        $scope.remove=function(id){
          $http.get('api/wisata/deleteGambar?gambarID='+id).then(function(result){
            swal({title:"Data Berhasil Dihapus",type:"error",closeOnConfirm:true});
                wisata.getGambar($routeParams.wisataID).then(function(result){
                   $scope.wisataGambar=result.data;
                })
          });
        }
        //stop in here show image in the editing form

        $scope.getTimeline();

        $scope.save=function(){
            $scope.wisata.wisataID=$routeParams.wisataID;
            wisata.edit($scope.wisata).then(function(result){

              if(result.data.status==true){
                $scope.submitting=false;
                $scope.clearModal();  
                $scope.product=null;

                $window.history.back();
              }else{
                $scope.submitting=false;
                angular.forEach(result.data.data,function(key,val){
                   
                   $('[name="'+val+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+val+'"]').next().html(key); //select span help-block class set text error string
                
                })
                //tampilkan error form validation
              }
            })
        }      
        // CALLBACKS

        uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
            console.info('onWhenAddingFileFailed', item, filter, options);
        };
        uploader.onAfterAddingFile = function(fileItem) {
              console.info('cek',this.getNotUploadedItems().length);
              console.info('ob',this.getNotUploadedItems()[0].file.name);
           for (var i =0; i < this.getNotUploadedItems().length-1; i++) {
             if(this.getNotUploadedItems()[i].file.name == fileItem.file.name){
               this.removeFromQueue(i);
             }
           }

           uploader.uploadItem(fileItem);


              console.info('onAfterAddingFile', fileItem);
            
            
        };
        uploader.onAfterAddingAll = function(addedFileItems) {
            console.info('onAfterAddingAll', addedFileItems);
        };
        uploader.onBeforeUploadItem = function(item) {

            var form={'wisataID':$routeParams.wisataID,'imageNumber':this.getIndexOfItem(item)};
           

            item.formData.push(form);

            
   
            console.info('onBeforeUploadItem', item);
        };
        uploader.onProgressItem = function(fileItem, progress) {
            console.info('onProgressItem', fileItem, progress);
        };
        uploader.onProgressAll = function(progress) {

            console.info('onProgressAll', progress);
        };
        uploader.onSuccessItem = function(fileItem, response, status, headers) {

            console.info('onSuccessItem', fileItem, response, status, headers);
        };
        uploader.onErrorItem = function(fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);



        };
        uploader.onCancelItem = function(fileItem, response, status, headers) {

            console.info('onCancelItem', fileItem, response, status, headers);
        };
        uploader.onCompleteItem = function(fileItem, response, status, headers) {
                wisata.getGambar($routeParams.wisataID).then(function(result){
                   $scope.wisataGambar=result.data;
                })
            this.removeFromQueue(fileItem);
            // console.info('onCompleteItem', fileItem, response, status, headers);
            // // if(response.status==true){

            // // }
            // console.log(response);
        };
        uploader.onCompleteAll = function() {
        };

        console.info('uploader', uploader);

}]).controller('tiketController', ['$routeParams','$window','$scope','$http','$q','Dokumen','DTOptionsBuilder','DTColumnBuilder','wisata','$compile','SweetAlert','$filter',function($routeParams,$window,$scope,$http,$q,Dokumen,DTOptionsBuilder,DTColumnBuilder,wisata,$compile,SweetAlert,$filter) {
  $scope.projectName="Balaldflaldsfasd";

  $scope.data={};
  $scope.datas={};
  $scope.wisata={};
  $scope.submitting=false;
  Dokumen.tanggal();

  var id=$routeParams.wisataID
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
        wisata.getTiket(id).then(function(result) {
            defer.resolve(result.data);
        });
        return defer.promise;
    }).withPaginationType('full_numbers').withOption('createdRow', function(row) {
        // Recompiling so we can bind Angular directive to the DT
        $compile(angular.element(row).contents())($scope);
      })
      ;

    $scope.dtColumns = [


        DTColumnBuilder.newColumn('wisataName').withTitle('Wisata'),
        DTColumnBuilder.newColumn('wisatatiketPrice').withTitle('Adult price'),
        DTColumnBuilder.newColumn('wisatatiketChildrenPrice').withTitle('Child Price'),


        DTColumnBuilder.newColumn(null).withTitle('Actions').notSortable()
            .renderWith(function(data, type, full, meta) {
                return '<button class="btn btn-warning" ng-click="edit(\'' + data.wisatatiketID + '\')">' +
                    '   <i class="fa fa-edit"></i>' +
                    '</button>&nbsp;' +
                    '<button class="btn btn-danger" ng-click="delete(\'' + data.wisatatiketID + '\')">' +
                    '   <i class="fa fa-trash-o"></i>' +
                    '</button>&nbsp;' ;
            })

    ];

    //remove gambar
    $scope.timerange=function(wisataID){
       $window.location.href='#!/wisatatimerange/'+wisataID;
    }
    $scope.tiket=function(wisataID){
       $window.location.href='#!/wisata/'+wisataID+'/tiket';
    }


    $scope.newPromise = $scope.newPromise;
    $scope.reloadData = $scope.reloadData;
    $scope.dtInstance = {};

    $scope.newPromise=function() {
        var defer = $q.defer();
        wisata.getTiket(id).then(function(result) {
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

  $scope.add=function(){
    $scope.transport= angular.copy($scope.datas);
    $scope.clearModal();
    $scope.actSave="save";

  }
  $scope.save=function(){
     $scope.submitting=true;

    if($scope.actSave=="save"){
      $scope.wisata.wisataID=$routeParams.wisataID;
      wisata.saveTiket($scope.wisata).then(function(result){

        if(result.data.status==true){
          $scope.submitting=false;
          $scope.dtInstance.reloadData();
          $('#modal_form').modal('hide');
          $scope.clearModal();  
          $scope.product=null;
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

        wisata.editTiket($scope.id,$scope.wisata).then(function(result){
          if(result){
            $scope.submitting=false;
            $scope.reloadData();
            $('#modal_form').modal('hide');
          
          }
        });
    }

  }

  $scope.edit=function(id){

    //get data and set to form
       $scope.wisata= angular.copy($scope.datas);

        $scope.actSave="edit";
        $scope.id=id;

        wisata.getTiketBy(id).success(function(result) {

          for(var a in result){
            $scope.wisata[a]=result[a];
          }

         $('#modal_form').modal('show');

        });

      
  }    

  // $scope.delete=function(id){
  //   console.log(id)
  //   $scope.pro={productID:id};
  //           var data = $.param({
  //               productID:id
  //           });
  //   transport.delete(data).success(function(status){
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
              var data = $.param({
                  wisatatiketID:id
              });
              wisata.deleteTiket(data).success(function(status){
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




}]).controller('commentController',['$routeParams','$window','$scope','$http','$q','Dokumen','DTOptionsBuilder','DTColumnBuilder','wisata','$compile','SweetAlert','$filter',function($routeParams,$window,$scope,$http,$q,Dokumen,DTOptionsBuilder,DTColumnBuilder,wisata,$compile,SweetAlert,$filter) {
  if($routeParams.wisataID){

      wisata.get($routeParams.wisataID).then(function(result){
          $scope.wisata_title="("+result.data.data.wisataName+")";

      });
      
      $scope.dtOptions = DTOptionsBuilder.fromFnPromise(function() {
          var defer = $q.defer();
          wisata.getComment($routeParams.wisataID).then(function(result) {
              defer.resolve(result.data);
          });
          return defer.promise;
      }).withPaginationType('full_numbers').withOption('createdRow', function(row) {
          // Recompiling so we can bind Angular directive to the DT
          $compile(angular.element(row).contents())($scope);
      });
  }else{

      $scope.wisata_title="";
      $scope.dtOptions = DTOptionsBuilder.fromFnPromise(function() {
          var defer = $q.defer();
          wisata.getComment().then(function(result) {
              defer.resolve(result.data);
          });
          return defer.promise;
      }).withPaginationType('full_numbers').withOption('createdRow', function(row) {
          // Recompiling so we can bind Angular directive to the DT
          $compile(angular.element(row).contents())($scope);
        });
  }

    $scope.dtColumns = [


        DTColumnBuilder.newColumn('commentEmail').withTitle('Email'),
        DTColumnBuilder.newColumn(null).withTitle('Comment').renderWith(function(data,type,full,meta){
          return $filter('removeHTMLTags')($filter('limitTo')(data.commentContent,150));
        }),

        DTColumnBuilder.newColumn('commentDate').withTitle('Date'),

        DTColumnBuilder.newColumn(null).withTitle('Actions').notSortable()
            .renderWith(function(data, type, full, meta) {
                return '<button class="btn btn-danger" ng-click="delete(\'' + data.commentID + '\')">' +
                      '   <i class="fa fa-trash-o"></i>' +
                      '</button>&nbsp;';
            })

    ];  
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
    $scope.reloadData=function() {
        var resetPaging = false;
        $scope.dtInstance.reloadData($scope.callback,false);
        // $scope.dtInstance.rerender(); 
        
    }

    $scope.callback=function(json) {
        console.log(json);
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
                            commentID:id
                        });
                wisata.deleteComment(data).success(function(status){
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
}]);
