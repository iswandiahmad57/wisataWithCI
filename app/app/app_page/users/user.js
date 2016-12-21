                        
        'use_strict';
        angular.module('myApp.user', ['ngRoute','textAngular']).config(["$routeProvider", function($routeProvider) {
          $routeProvider.when("/user", {
            templateUrl: "app/app/app_page/users/user.html",
            controller: "userController"
          }).when("/user/add",{
            templateUrl:"app/app/app_page/users/user_form.html",
            controller:"userControllerAdd"
          }).when("/user/:userID/edit",{
            templateUrl:"app/app/app_page/users/user_form.html",
            controller:"userControllerEdit"    
          });
        }])

        .controller("userController", ["$scope","$http","$q","Dokumen","DTOptionsBuilder","DTColumnBuilder","$window","user","$compile","SweetAlert",function($scope,$http,$q,Dokumen,DTOptionsBuilder,DTColumnBuilder,$window,user,$compile,SweetAlert) {
          // $scope.projectName="Balaldflaldsfasd";

          
          $scope.data={};
          $scope.datas={};
          $scope.user={};
          $scope.submitting=false;
          Dokumen.select2();

          

            var vm = this;
            $scope.data="adfasdf";
            $scope.dtOptions = DTOptionsBuilder.newOptions().withOption("ajax", {
            
                    url: "api/user/userAll",
                    type:"POST"
                }).withOption("createdRow", function(row) {
                // Recompiling so we can bind Angular directive to the DT
                $compile(angular.element(row).contents())($scope);
              }).withDataProp("data")
              .withOption("processing", true) //for show progress bar
                .withOption("serverSide", true) // for server side processing
                .withPaginationType("full_numbers") // for get full pagination options // first / last / prev / next and page numbers
                .withDisplayLength(10) // Page size
                .withOption("aaSorting",[0,"asc"]); // for default sorting column // here 0 means first columnf

            $scope.dtColumns = [
                DTColumnBuilder.newColumn('userCode').withTitle('userCode'),DTColumnBuilder.newColumn('userNickname').withTitle('userNickname'),DTColumnBuilder.newColumn('userPhoto').withTitle('userPhoto'),DTColumnBuilder.newColumn('userType').withTitle('userType'),DTColumnBuilder.newColumn('username').withTitle('username'),
                DTColumnBuilder.newColumn(null).withTitle('Actions').notSortable()
                    .renderWith(function(data, type, full, meta) {
                        return '<button class="btn btn-warning" ng-click="edit(\'' + data.userID + '\')">' +
                            '   <i class="fa fa-edit"></i>' +
                            '</button> ' +
                            '<button class="btn btn-danger" ng-click="delete(\'' + data.userID + '\')">' +
                            '   <i class="fa fa-trash-o"></i>' +
                            '</button>';
                    })

            ];
            $scope.newPromise = $scope.newPromise;
            $scope.reloadData = $scope.reloadData;
            $scope.dtInstance = {};

            $scope.liat=function(){
              console.log($scope.dtInstance);
              $scope.dtInstance.changeData($scope.newPromise);
            }

            $scope.reloadData=function() {
                var resetPaging = false;
                $scope.dtInstance.reloadData($scope.callback,false);
                // $scope.dtInstance.rerender(); 
                
            }
            $scope.add=function(){
              $window.location.href="#!/user/add";
            }
            $scope.callback=function(json) {
                console.log(json);
            }

            $scope.edit=function(id){
                $window.location.href="#!/user/"+id+"/edit";
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
                        userID:id
                      });
                      user.delete(data).success(function(status){
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

        }])
        //add controller
        .controller("userControllerAdd", ["$window","FileUploader","$scope","$http","$q","$location","Dokumen","DTOptionsBuilder","DTColumnBuilder","$routeParams","user","$compile","SweetAlert","$filter",function($window, FileUploader,$scope,$http,$q,$location,Dokumen,DTOptionsBuilder,DTColumnBuilder,$routeParams,user,$compile,SweetAlert,$filter) {
                $scope.title="Tambah Data Users";
                $scope.user={};
                $scope.submitting=false;
                $scope.id="";
                var id="";
                $scope.clearModal=function(){
          
                  $("#form")[0].reset(); // reset form on modals
                  $(".form-group").removeClass("has-error"); // clear error class
                  $(".help-block").empty(); // clear error string 
                }
                Dokumen.select2();

                $http.get('api/user/type').then(function(result){
                  $scope.userType=result.data.data;
                });
                var uploader = $scope.uploader = new FileUploader({
                          url: 'api/user/uploadImage'
                });
                uploader.filters.push({
                    name: 'customFilter',
                    fn: function(item /*{File|FileLikeObject}*/, options) {
                        return this.queue.length < 2;
                    }
                }); 

                $scope.save=function(){

                  //lakukan validasi disisi server terlebih dahulu

                  user.save($scope.user).then(function(result){

                      if(result.data.status==true){
                        $scope.id=result.data.id;
                        uploader.uploadAll(); 
                        $window.history.back();
                      }else{
                        angular.forEach(result.data.data,function(key,val){
                           
                           $("[name="+val+"]").parent().parent().addClass("has-error"); //select parent twice to select div form-group class and add has-error class
                            $("[name="+val+"]").next().html(key); //select span help-block class set text error string
                        
                        });
                      }

                  });

                 
                }  

          //init uploader
          uploader.onAfterAddingAll = function(addedFileItems) {
              console.info('onAfterAddingAll', addedFileItems);
            if(uploader.getNotUploadedItems().length>1){
              uploader.removeFromQueue(0);
            };

          };
          uploader.onAfterAddingFile = function(fileItem) {
                console.info('cek',this.getNotUploadedItems().length);
                console.info('ob',this.getNotUploadedItems()[0].file.name);
                  
                 for (var i =0; i < this.getNotUploadedItems().length-1; i++) {
                   if(this.getNotUploadedItems()[i].file.name == fileItem.file.name){
                     this.removeFromQueue(i);
                   }
                 }
            $scope.user.userPhoto=fileItem.file.name;
            console.log(fileItem.file.name);
                 
          };
          uploader.onBeforeUploadItem = function(item) {

              //push form data apabila item index adalah yang ke 0
              var indexID={};

              indexID.id=$scope.id;

              item.formData.push(indexID);
            
              console.info('onBeforeUploadItem', item);
          };
         // FILTERS

       }])
        .controller("userControllerEdit", ["$window","FileUploader","$scope","$http","$q","$location","Dokumen","DTOptionsBuilder","DTColumnBuilder","$routeParams","user","$compile","SweetAlert","$filter",function($window, FileUploader,$scope,$http,$q,$location,Dokumen,DTOptionsBuilder,DTColumnBuilder,$routeParams,user,$compile,SweetAlert,$filter) {
                $scope.title="Edit Data Users";
                $scope.user={};
                $scope.submitting=false;
                var id="";
                Dokumen.select2();
                 
          //init uploader
                var uploader = $scope.uploader = new FileUploader({
                          url: 'api/user/uploadImage'
                });
                uploader.filters.push({
                    name: 'customFilter',
                    fn: function(item /*{File|FileLikeObject}*/, options) {
                        return this.queue.length < 2;
                    }
                });                      
                $scope.clearModal=function(){
          
                  $("#form")[0].reset(); // reset form on modals
                  $(".form-group").removeClass("has-error"); // clear error class
                  $(".help-block").empty(); // clear error string 
                };
                
                $http.get('api/user/type').then(function(result){
                  $scope.userType=result.data.data;
                });
                  //cek terlebih dahulu terdapat data translate atau tidak 
                  user.get($routeParams.userID).then(function(result){
                    if(result.data.status==true){
                      $scope.user.userID=result.data.data.userID;
                      $scope.user.userCode=result.data.data.userCode;
                      $scope.user.userNickname=result.data.data.userNickname;
                      $scope.user.userPhoto=result.data.data.userPhoto;
                      $scope.user.userType=result.data.data.userType;
                      $scope.user.username=result.data.data.username;
                      $scope.user.password=result.data.data.password;

                      $scope.images=[{"_file":result.data.data.userPhoto}];

                      console.log(uploader.queue);
                    }else{
                      $window.history.back();
                    }
                  })
  
          //init uploader
                var uploader = $scope.uploader = new FileUploader({
                          url: 'api/user/uploadImage'
                });
                uploader.filters.push({
                    name: 'customFilter',
                    fn: function(item /*{File|FileLikeObject}*/, options) {
                        return this.queue.length < 2;
                    }
                }); 
          uploader.onAfterAddingAll = function(addedFileItems) {
              console.info('onAfterAddingAll', addedFileItems);
            if(uploader.getNotUploadedItems().length>1){
              uploader.removeFromQueue(0);
            };

          };
          uploader.onAfterAddingFile = function(fileItem) {
                console.info('cek',this.getNotUploadedItems().length);
                console.info('ob',this.getNotUploadedItems()[0].file.name);
                  
                 for (var i =0; i < this.getNotUploadedItems().length-1; i++) {
                   if(this.getNotUploadedItems()[i].file.name == fileItem.file.name){
                     this.removeFromQueue(i);
                   }
                 }
            $scope.user.userPhoto=fileItem.file.name;
            console.log(fileItem.file.name);
                 
          };
          uploader.onBeforeUploadItem = function(item) {

              //push form data apabila item index adalah yang ke 0
              var indexID={};

              indexID.id=$scope.id;

              item.formData.push(indexID);
            
              console.info('onBeforeUploadItem', item);
          };
                $scope.save=function(){

                  //lakukan validasi disisi server terlebih dahulu

                  user.edit($scope.user).then(function(result){

                      if(result.data.status==true){
                        $window.history.back();
                      }else{
                        angular.forEach(result.data.data,function(key,val){
                           
                           $("[name="+val+"]").parent().parent().addClass("has-error"); //select parent twice to select div form-group class and add has-error class
                            $("[name="+val+"]").next().html(key); //select span help-block class set text error string
                        
                        });
                      }

                  });

                 
                }   

                 


        }]);                        