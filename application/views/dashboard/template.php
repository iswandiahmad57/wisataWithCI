<!DOCTYPE html>
<html lang="en" ng-app="myApp">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mr Guides Dashboard Application</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url('asset/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url('asset/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url('asset/vendors/nprogress/nprogress.css');?>" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url('asset/vendors/iCheck/skins/flat/green.css');?>" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->

    <!-- Select2 -->
    <link href="<?php echo base_url('vendors/select2/dist/css/select2.min.css');?>" rel="stylesheet">
    <!-- Switchery -->
    <link href="<?php echo base_url('vendors/switchery/dist/switchery.min.css');?>" rel="stylesheet">
    <!-- starrr -->
    <link href="<?php echo base_url('vendors/starrr/dist/starrr.css');?>" rel="stylesheet">
    <!-- Datatables -->
    <link href="<?php echo base_url('asset/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css');?>" rel="stylesheet">

    <link href="<?php echo base_url('asset/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/build/css/custom.min.css');?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="bower_components/ladda/dist/ladda-themeless.min.css">

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/angular/angular.min.js"></script>
    <script src="bower_components/angular-datatables/dist/angular-datatables.min.js"></script>

    <script type="text/javascript" src="bower_components/angular-resource/angular-resource.min.js"></script>
    <link rel="stylesheet" href="bower_components/angular-datatables/dist/css/angular-datatables.css">

    <!--script stylish-->
    <script src="<?php echo base_url('asset/vendors/fastclick/lib/fastclick.js');?>"></script>
    <script src="<?php echo base_url('asset/vendors/nprogress/nprogress.js');?>"></script>
    <script src="<?php echo base_url('asset/vendors/iCheck/icheck.min.js');?>"></script>
    <script src="<?php echo base_url('asset/new/js/moment/moment.min.js');?>"></script>
    <script src="<?php echo base_url('asset/new/js/datepicker/daterangepicker.js');?>"></script>
     <script src="<?php echo base_url('asset/vendors/parsleyjs/dist/parsley.min.js');?>"></script> 
    <script src="<?php echo base_url('asset/vendors/Chart.js/dist/Chart.min.js');?>"></script>
    <script src="<?php echo base_url('asset/vendors/Flot/jquery.flot.js');?>"></script> 
     <script type="text/javascript" src="bower_components/spin.js/spin.js"></script>
    <script type="text/javascript" src="bower_components/ladda/dist/ladda.min.js"></script>
    <script type="text/javascript" src="bower_components/angular-ladda/dist/angular-ladda.min.js"></script>


    <!-- end of Script Stylish-->
    <!-- Custom Theme Style -->


    <!-- Bootstrap -->


    <!-- FastClick -->


    <script src="bower_components/angular/angular.min.js"></script>
    <script src="bower_components/angular-route/angular-route.min.js"></script>
    <script type="text/javascript" src="bower_components/angular-resource/angular-resource.min.js"></script>
    <script type="text/javascript" src="bower_components/angular-datatables/dist/angular-datatables.min.js"></script>
    <!--controller for app-->

    <script type="text/javascript" src="<?php echo base_url('app/app/app.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/produk/produk.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/produk_services.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/factory/document_factory.js');?>"></script>

    <!-- data tables-->
    <script src="<?php echo base_url('asset/vendors/datatables.net/js/jquery.dataTables.min.js');?>"></script>
    <script type="text/javascript" src="bower_components/angular-datatables/dist/angular-datatables.min.js"></script>
    <script src="<?php echo base_url('asset/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('asset/vendors/datatables.net-responsive/js/dataTables.responsive.min.js');?>"></script>
    <script src="<?php echo base_url('asset/vendors/datatables.net-buttons/js/dataTables.buttons.min.js');?>"></script>
    <script src="<?php echo base_url('asset/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('asset/vendors/datatables.net-buttons/js/buttons.flash.min.js');?>"></script>
    <script src="<?php echo base_url('asset/vendors/datatables.net-buttons/js/buttons.html5.min.js');?>"></script>
    <script src="<?php echo base_url('asset/vendors/datatables.net-buttons/js/buttons.print.min.js');?>"></script>
    <script src="<?php echo base_url('asset/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js');?>"></script>
    <script src="<?php echo base_url('asset/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js');?>"></script>
    <script src="<?php echo base_url('asset/vendors/datatables.net-responsive/js/dataTables.responsive.min.js');?>"></script>
    <script src="<?php echo base_url('asset/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js');?>"></script>
    <script src="<?php echo base_url('asset/vendors/datatables.net-scroller/js/datatables.scroller.min.js');?>"></script>

    <!-- Custom Theme Scripts -->

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
    <!-- left navigation-->      

        <?php $this->load->view('dashboard/sidebar'); ?>
        <!-- /left navigation-->

        <!-- top navigation -->
         <?php $this->load->view('dashboard/masthead'); ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main" >
          <div ng-view></div>

				</div>

          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
         <?php $this->load->view('dashboard/footer'); ?>
        <!-- /footer content -->
      </div>

    <script src="<?php echo base_url('asset/build/js/custom.min.js');?>"></script>

  </body>
</html>