<!DOCTYPE html>
<html ng-app='myApp'>
<head>
	<title>angular try</title>
    <!-- Bootstrap -->
    <!-- Bootstrap -->
    <link href="<?php echo base_url('asset/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url('asset/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url('asset/vendors/nprogress/nprogress.css');?>" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url('asset/vendors/iCheck/skins/flat/green.css');?>" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
<link href="<?php echo base_url('asset/vendors/switchery/dist/switchery.min.css');?>" rel="stylesheet">
    <!-- Select2 -->

<link rel="stylesheet" href="bower_components/ngProgress/ngProgress.css">
    <link rel="stylesheet" href="bower_components/select2/select2.css">
    <link href="<?php echo base_url('asset/vendors/select2/dist/css/select2.min.css');?>" rel="stylesheet">
    <!-- Datatables -->
    <link href="<?php echo base_url('asset/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css');?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="bower_components/sweetalert/dist/sweetalert.css">
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url('asset/build/css/custom.min.css');?>" rel="stylesheet">

    <style>
        .my-drop-zone { border: dotted 3px lightgray; }
        .nv-file-over { border: dotted 3px red; } /* Default class applied to drop zones on over */
        .another-file-over-class { border: dotted 3px green; }
        html, body { height: 100%; }
        canvas {
            background-color: #f3f3f3;
            -webkit-box-shadow: 3px 3px 3px 0 #e3e3e3;
            -moz-box-shadow: 3px 3px 3px 0 #e3e3e3;
            box-shadow: 3px 3px 3px 0 #e3e3e3;
            border: 1px solid #c3c3c3;
            height: 100px;
            margin: 6px 0 0 6px;
        }

        .img-thumb{
            width: 100px;
            height: 100px;
        }
    </style>

    <link rel="stylesheet" type="text/css" href="bower_components/ladda/dist/ladda-themeless.min.css">


	<script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="bower_components/angular/angular.min.js"></script>
    <script src="bower_components/angular-route/angular-route.min.js"></script>
    <link rel='stylesheet' href='bower_components/textAngular/dist/textAngular.css'>
    <script src='bower_components/textAngular/dist/textAngular-rangy.min.js'></script>
    <script src='bower_components/textAngular/dist/textAngular-sanitize.min.js'></script>
    <script src='bower_components/textAngular/dist/textAngular.min.js'></script>
    <script type="text/javascript" src="bower_components/angular-file-upload/dist/angular-file-upload.min.js"></script>
        <script src="<?php echo base_url('asset/vendors/google-code-prettify/src/prettify.js');?>"></script>
    <script src="<?php echo base_url('asset/vendors/switchery/dist/switchery.min.js');?>"></script>

    <script src="<?php echo base_url('asset/vendors/select2/dist/js/select2.full.min.js');?>"></script>
    <script src="bower_components/ngProgress/build/ngProgress.js"></script>
<!--     <script type="text/javascript" src="bower_components/select2/select2.js"></script>
    <script type="text/javascript" src="bower_components/angular-ui-select2/src/select2.js"></script> -->

    <script type="text/javascript" src="<?php echo base_url('app/app/app.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/produk/produk.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/produk_services.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/posting/posting.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/posting_services.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/wilayah/wilayah.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/wilayah_services.js');?>"></script>

    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/bahasa/bahasa.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/bahasa_service.js');?>"></script>

        <script type="text/javascript" src="<?php echo base_url('app/app/app_page/transport/transport.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/transport_services.js');?>"></script>

        <script type="text/javascript" src="<?php echo base_url('app/app/app_page/advertiser/advertiser.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/advertiser_service.js');?>"></script>

    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/wisata/wisata.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/wisata_services.js');?>"></script>

    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/insurance/insurance.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/insurance_services.js');?>"></script>

    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/wisatatimerange/wisatatimerange.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/wisatatimerange_services.js');?>"></script>

    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/guides/guides.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/guide_services.js');?>"></script>

    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/advertiserPopup/popup.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/advertiserPopup_services.js');?>"></script>

    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/withdrawal/withdrawal.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/withdrawal_services.js');?>"></script>

    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/countries/countries.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/countries_services.js');?>"></script>

    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/topup/topup.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/topup_services.js');?>"></script>

    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/localization/localization.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/localization_services.js');?>"></script>

    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/payment/payment.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/payment_services.js');?>"></script>

    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/users/user.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/users_services.js');?>"></script>

    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/wisata_translate/wisata.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/timeline_translate/timeline.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/produk_translate/produk.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/app_page/skill/skill.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/services/skill_services.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('app/app/components/factory/document_factory.js');?>"></script>
    <script type="text/javascript" src="bower_components/coba.js"></script>
	<script src="bower_components/angular-datatables/dist/angular-datatables.min.js"></script>

	<script type="text/javascript" src="bower_components/angular-resource/angular-resource.min.js"></script>
    <script src="<?php echo base_url('asset/vendors/fastclick/lib/fastclick.js');?>"></script>

    <script src="<?php echo base_url('asset/vendors/iCheck/icheck.min.js');?>"></script>

    <script src="<?php echo base_url('asset/new/js/moment/moment.min.js');?>"></script>
    <script src="<?php echo base_url('asset/new/js/datepicker/daterangepicker.js');?>"></script>
    <script src="<?php echo base_url('asset/vendors/Chart.js/dist/Chart.min.js');?>"></script>
   

    
     <script type="text/javascript" src="bower_components/spin.js/spin.js"></script>
    <script type="text/javascript" src="bower_components/ladda/dist/ladda.min.js"></script>
    <script type="text/javascript" src="bower_components/angular-ladda/dist/angular-ladda.min.js"></script>
    <script type="text/javascript" src="bower_components/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="bower_components/ng-sweet-alert/ng-sweet-alert.js"></script>



    <!--datatables-->
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

    <!--datatables-->

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

    <script src="<?php echo base_url('asset/build/js/custom.js');?>"></script>

  </body>
</html>