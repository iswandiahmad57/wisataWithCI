<!doctype html>
<!--[if IE 7]>    <html class="ie7" > <![endif]-->
<!--[if IE 8]>    <html class="ie8" > <![endif]-->
<!--[if IE 9]>    <html class="ie9" > <![endif]-->
<!--[if IE 9]>    <html class="ie10" > <![endif]-->
<!--[if (gt IE 10)|!(IE)]><!--> <html lang="en-US" ng-app='myApp'> <!--<![endif]-->
		<head>
				<!-- META TAGS -->
				<meta charset="UTF-8" />
				<meta name="viewport" content="width=device-width" />
				
				<!-- Title -->
				<title>N-Travel</title>
				
				<!-- Style Sheet-->
                <link rel="stylesheet" href="bower_components/front/css/bootstrap.css">
				<link rel="stylesheet" href="bower_components/front/css/style.css">
				<link rel="stylesheet" href="bower_components/front/css/responsive.css">
                <link rel="stylesheet" href="bower_components/front/css/flexslider.css">
                <link rel="stylesheet" href="bower_components/angular-input-stars-directive/angular-input-stars.css">
                <link rel="stylesheet" type="text/css" href="bower_components/components-font-awesome/css/font-awesome.css">
               <!-- favicon -->
				<link rel="shortcut icon" href="images/favicon.png">
				
				<!--[if lt IE 9]>
						<script src="js/html5shiv.js"></script>
						<link rel="stylesheet" href="css/ie.css">
				<![endif]-->
                <!-- Scripts -->
                <script src="bower_components/front/js/jquery-1.7.1.min.js"></script>
                <script src="bower_components/front/js/jquery.flexslider.js"></script>
                <script src="bower_components/front/js/jquery.flexslider-min.js"></script>
                <script src="bower_components/front/js/jquery.elastislide.js"></script>
                <script src="bower_components/front/js/jquery.carouFredSel-6.0.4-packed.js"></script>
                <script src="bower_components/front/js/jcarousellite_1.0.1.js"></script>
                <script src="bower_components/front/js/jquery.zweatherfeed.js"></script>
                <script src="bower_components/front/js/jquery.simpleWeather-2.3.min.js"></script>
                <script src="bower_components/front/js/jquery.cycle.all.js"></script>
                <script src="bower_components/front/js/jquery-ui.js"></script>
                <script src="bower_components/front/js/bootstrap.min.js"></script>
                <script src="bower_components/front/js/jquery.isotope.min.js"></script>
                <script src="bower_components/front/js/jquery.tinyscrollbar.min.js"></script>
                
                <script src="bower_components/angular/angular.min.js"></script>
                <script src="bower_components/angular-route/angular-route.min.js"></script>
                <script type="text/javascript" src="bower_components/angular-input-stars-directive/angular-input-stars.js"></script>

                <script type="text/javascript" src="<?php echo base_url('app_front/app.js');?>"></script>
                <script type="text/javascript" src="<?php echo base_url('app_front/app_page/index/index.js');?>"></script>
                <script type="text/javascript" src="<?php echo base_url('app_front/model/wisata_services.js');?>"></script>
                <script>
                    function goToByScroll(id){
                        $ = jQuery;
                        $('html,body').animate({scrollTop: $("#"+id).offset().top},3000);
                    }
                </script>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $('.scrollbar1').tinyscrollbar();
                    });
                </script>
        <!--         <script src="bower_components/front/js/custom.js"></script>     -->
		</head>
		<body>	

				<!-- HEADER TOP -->
                <div id="top"></div>
				<div class="header-one">
					<div class="headertop-wrapper">
						<div class="container">
					    		
					            <div class="row">
					            	<div class="span5 clearfix">
					                	<div class="lang pull-right">
					                    	<span>Select a language:<a href="#">English</a></span>
					                    </div>
					                </div>
					                <div class="span4 srch">
                                        <form>
                                            <input type="submit" value="">
                                            <input type="text" name="search" placeholder="Search" ng-model="wisataSearch">
                                        </form>
					                </div>
					                <div class="span3">
					                	<div class="social-nav">
					                    	<a href="#" class="facebook "></a>
					                    	<a href="#" class="twitter" ></a>
					                    	<a href="#" class="google"></a>
					                    	<a href="#" class="rss"></a>
					                    </div>
                                        <a href="#" class="sign-in" id="login-link">Sign in</a>
					                </div>
					            </div>
					    </div>
					</div>
				</div>
				<!-- HEADER IOP -->

				<!-- HEADER -->
                <div class="header-wrapper">
                	<div class="container">
                    	<div class="row">
                        
                        	<!-- Logo -->
                            <div class="span4">
                            	<div class="logo">
                                	<a href="index.html"><img src="images/logo.png" alt="Logo"></a>
                                </div>
                            </div>
                        	<!-- Logo -->
                            
<!--                             <!--top Menu -->
                            <div class="span8">
                            	<div class="top-menu">
                                	<ul>
                                		<li><a href="#">About US</a></li>
                                		<li><a href="#">News</a></li>

                                		<li><a href="#" class="last">Support</a></li>
                                	</ul>
                                </div>
                            </div>
                            <!--top Menu --> -->
                        
                        </div>
                    </div>
                </div>
                <!-- HEADER -->

                <!-- Main Navigation -->
                <div class="nav-wrapper">
                	<div class="container">
                    	<div class="row">
                        	<div class="span12">
                            
                            	<nav>
                                    <ul>
                                        <li><a href="#!/index">Home </a>
                                        </li>
                                        <li><a href="travel_grid.html">Travel</a>
                                        </li>
                                        <li  class="last"><a href="contact.html">Contact</a></li>
                                    </ul>
                                </nav>

                                <div class="responsive_nav">
                                    <ul>
                                        <li class="open">
                                            <a href="#">HOME</a>
                                            <ul>
                                                <li><a href="#">Home </a></li>
                                                <li><a href="#">Hotels</a></li>
                                                <li><a href="#">Holidays</a></li>
                                                <li><a href="#">Flights</a> </li>
                                                <li><a href="#">Camera</a></li>
                                                <li><a href="#">Notebook </a></li>
                                                <li><a href="#">Tablet </a> </li>
                                                <li><a href="#">Television </a> </li>
                                                <li><a href="#">Smart Phone </a> </li>
                                                <li><a href="#">Projection </a> </li>
                                                <li><a href="#">Cars</a></li>
                                                <li><a href="#">Vacations</a></li>
                                                <li><a href="#">Guide Book</a></li>
                                                <li><a href="#">Hot Deal</a></li>
                                                <li><a href="#">Cruise</a></li>
                                                <li class="last"><a href="#">Promotion</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main Navigation -->


