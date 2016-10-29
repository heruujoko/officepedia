<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title> @yield('title')Administrator</title>
		<meta name="description" content="">
		<meta name="author" content="">

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Basic Styles -->

		<link rel="stylesheet" type="text/css" media="screen" href="{{URL::to('/')}}/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="{{URL::to('/')}}/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/js/datatable/Buttons-1.2.2/css/buttons.dataTables.css">
		<!-- SmartAdmin Styles : Caution! DO NOT change the order -->
		<link rel="stylesheet" type="text/css" media="screen" href="{{URL::to('/')}}/css/smartadmin-production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="{{URL::to('/')}}/css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="{{URL::to('/')}}/css/smartadmin-skins.min.css">

		<!-- SmartAdmin RTL Support  -->
		<!-- <link rel="stylesheet" type="text/css" media="screen" href="{{URL::to('/')}}/css/smartadmin-rtl.min.css"> -->

			<!-- SweetAlert  -->
		<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/master/1/dist/sweetalert.css">

		<link rel="stylesheet" type="text/css" href="{{ url('/css/select2.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ url('/css/select2-bootstrap.css') }}">



		<!-- We recommend you use "your_style.css" to override SmartAdmin
		     specific styles this will also ensure you retrain your customization with each SmartAdmin update.
		<link rel="stylesheet" type="text/css" media="screen" href="css/your_style.css"> -->

		<!-- FAVICONS -->
		<link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
		<link rel="icon" href="{{URL::to('/')}}/img/favicon/favicon.ico" type="image/x-icon">


		<!-- GOOGLE FONT -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

		<!-- Specifying a Webpage Icon for Web Clip
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<link rel="apple-touch-icon" href="img/splash/sptouch-icon-iphone.png">
		<link rel="apple-touch-icon" sizes="76x76" href="img/splash/touch-icon-ipad.png">
		<link rel="apple-touch-icon" sizes="120x120" href="img/splash/touch-icon-iphone-retina.png">
		<link rel="apple-touch-icon" sizes="152x152" href="img/splash/touch-icon-ipad-retina.png">
		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		@yield('css')
		<!-- Startup image for web apps -->
		<link rel="apple-touch-startup-image" href="img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
		<link rel="apple-touch-startup-image" href="img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
		<link rel="apple-touch-startup-image" href="img/splash/iphone.png" media="screen and (max-device-width: 320px)">
		<style media="screen">


	.phone-number .col-xs-3::after{
	content: "-";
	position:absolute;
	right: 6px;
	color: black;
	border: 0px solid;
	top: 5px;
	}

	.phone-number .col-xs-4{
	width:40%;
	}


	.phone-number .col-xs-3, .phone-number .col-xs-4{

	padding-left:0;
	}
	*{
	font:11px Arial, Arial;
	}
	</style>
	<style>

	/*CSS UNTUK FORM INPUT*/
	.hasinput > input{
	font-size: 11px;

	}
	.forminput{
	font-size: 11px;
    line-height: 10px;
    font-family:


	}

	/*CSS UNTUK FORM INPUT*/

	/* CSS UNTUK MODIFIKASI TABLE */
	.srch {
    float: left;
    margin-right: 10px;
    margin-top: -25px;
	}
	.clmn >.ColVis > button{
	height: 24px !important;
	margin-left: 0px;
	margin-top: -25px;

	}
	.tablerow > div.dataTables_length label{
		margin-top: -25px;
	}
	.masterbutton {
	float: right!Important;
    margin-top: -25px;
    margin-right: 124px;
	}
 	.dtpadding {
    padding: 10px;
    }
  	.pb {
            margin-top: 1%;

     }
     td {

		width: 1%;
		font-size: 11px;
		table-layout: fixed;
	}
	.sorting_1{
	text-align: center;
   }
   .sa-confirm-button-container:hover > button{
   	background-color: rgb(212, 103, 82)!important;
   }


   .bg-red{
   	background-color: rgb(212, 103, 82)!important;
   }
	 .parsley-required{
		 color :rgb(212, 103, 82)!important;
		 margin-left: -6%;
	 }
	 .parsley-type {
		 color :rgb(212, 103, 82)!important;
		 margin-left: -6%;
	 }
   .bg-gray{
   	background: #C1C1C1 !important;
   }
	 .select2-container .select2-choice .select2-arrow b:before, .select2-selection__arrow b:before {
		 content: "" !important;
	 }
	 /* CSS UNTUK MODIFIKASI TABLE */

	.phonemargin{
		margin-top: 36px;
	}
	.treemenu li {
		margin-left: -40px;
	}
	.treemenu li:before {
		border-left: none !important;
	}
	.treemenu li:after {
		border-top: none !important;
	}
	.btn-tree {
		padding: 6px 10px 5px;
	}
	.addtree{
		cursor: pointer;
    padding: 7px;
	}
	.masterbutton {
		margin-right: 0 !important;
	}
	.parsley-errors-list{
		list-style: none;
	}
	.select-dropdown {
	  position: static;
	    .select-dropdown--above {
	      margin-top: 336px;
	   }
	}
	hr.style1{
		border-top: 1px solid #8c8b8b;
	}
</style>
<style>


}
</style>
	<script type="text/javascript">
    function zoom() {
    document.body.style.zoom = "90%"
    }
	</script>

	</head>

	<!--

	TABLE OF CONTENTS.

	Use search to find needed section.

	===================================================================

	|  01. #CSS Links                |  all CSS links and file paths  |
	|  02. #FAVICONS                 |  Favicon links and file paths  |
	|  03. #GOOGLE FONT              |  Google font link              |
	|  04. #APP SCREEN / ICONS       |  app icons, screen backdrops   |
	|  05. #BODY                     |  body tag                      |
	|  06. #HEADER                   |  header tag                    |
	|  07. #PROJECTS                 |  project lists                 |
	|  08. #TOGGLE LAYOUT BUTTONS    |  layout buttons and actions    |
	|  09. #MOBILE                   |  mobile view dropdown          |
	|  10. #SEARCH                   |  search field                  |
	|  11. #NAVIGATION               |  left panel & navigation       |
	|  12. #RIGHT PANEL              |  right panel userlist          |
	|  13. #MAIN PANEL               |  main panel                    |
	|  14. #MAIN CONTENT             |  content holder                |
	|  15. #PAGE FOOTER              |  page footer                   |
	|  16. #SHORTCUT AREA            |  dropdown shortcuts area       |
	|  17. #PLUGINS                  |  all scripts and plugins       |

	===================================================================

	-->

	<!-- #BODY -->
	<!-- Possible Classes

		* 'smart-style-{SKIN#}'
		* 'smart-rtl'         - Switch theme mode to RTL
		* 'menu-on-top'       - Switch to top navigation (no DOM change required)
		* 'no-menu'			  - Hides the menu completely
		* 'hidden-menu'       - Hides the main menu but still accessable by hovering over left edge
		* 'fixed-header'      - Fixes the header
		* 'fixed-navigation'  - Fixes the main menu
		* 'fixed-ribbon'      - Fixes breadcrumb
		* 'fixed-page-footer' - Fixes footer
		* 'container'         - boxed layout mode (non-responsive: will not work with fixed-navigation & fixed-ribbon)
	-->
	<body onload="zoom()" class="">

		<!-- HEADER -->
		<header id="header">
			<div id="logo-group">

				<!-- PLACE YOUR LOGO HERE -->
				<span id="logo"> <img src="{{URL::to('/')}}/img/logo.png" alt="SmartAdmin"> </span>
				<!-- END LOGO PLACEHOLDER -->
			</div>

			<!-- projects dropdown -->
			<div class="project-context hidden-xs">

			</div>
			<!-- end projects dropdown -->

			<!-- pulled right: nav area -->
			<div class="pull-right">

				<!-- collapse menu button -->
				<div id="hide-menu" class="btn-header pull-right">
					<span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
				</div>
				<!-- end collapse menu -->

				<!-- #MOBILE -->
				<!-- Top menu profile link : this shows only when top menu is active -->
				<ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
					<li class="">
						<a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown">
							<img src="{{URL::to('/')}}/img/avatars/sunny.png" alt="John Doe" class="online" />
						</a>
						<ul class="dropdown-menu pull-right">
							<li>
								<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"><i class="fa fa-cog"></i> Setting</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="profile.html" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-user"></i> <u>P</u>rofile</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="toggleShortcut"><i class="fa fa-arrow-down"></i> <u>S</u>hortcut</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i> Full <u>S</u>creen</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="login.html" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout"><i class="fa fa-sign-out fa-lg"></i> <strong><u>L</u>ogout</strong></a>
							</li>
						</ul>
					</li>
				</ul>

				<!-- logout button -->
				<div id="logout" class="btn-header transparent pull-right">
					<span> <a href="login.html" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
				</div>
				<!-- end logout button -->

				<!-- search mobile button (this is hidden till mobile view port) -->
				<div id="search-mobile" class="btn-header transparent pull-right">
					<span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
				</div>
				<!-- end search mobile button -->

				<!-- input: search field -->
				<form action="search.html" class="header-search pull-right">
					<input id="search-fld"  type="text" name="param" placeholder="Find reports and more" data-autocomplete='[
					"ActionScript",
					"AppleScript",
					"Asp",
					"BASIC",
					"C",
					"C++",
					"Clojure",
					"COBOL",
					"ColdFusion",
					"Erlang",
					"Fortran",
					"Groovy",
					"Haskell",
					"Java",
					"JavaScript",
					"Lisp",
					"Perl",
					"PHP",
					"Python",
					"Ruby",
					"Scala",
					"Scheme"]'>
					<button type="submit">
						<i class="fa fa-search"></i>
					</button>
					<a href="javascript:void(0);" id="cancel-search-js" title="Cancel Search"><i class="fa fa-times"></i></a>
				</form>
				<!-- end input: search field -->

				<!-- fullscreen button -->
				<div id="fullscreen" class="btn-header transparent pull-right">
					<span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
				</div>
				<!-- end fullscreen button -->

				<!-- #Voice Command: Start Speech -->

				<!-- end voice command -->

				<!-- multiple lang dropdown : find all flags in the flags page -->
				<!-- end multiple lang -->

			</div>
			<!-- end pulled right: nav area -->

		</header>
		<!-- END HEADER -->

		<!-- Left panel : Navigation area -->
		<!-- Note: This width of the aside area can be adjusted through LESS variables -->
		<aside id="left-panel">

			<!-- User info -->
			<div class="login-info">
				<span> <!-- User image size is adjusted inside CSS, it should stay as it -->

					<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
						<img src="{{URL::to('/')}}/img/avatars/sunny.png" alt="me" class="online" />
						<span>
							john.doe
						</span>
						<i class="fa fa-angle-down"></i>
					</a>

				</span>
			</div>
			<!-- end user info -->

			<!-- NAVIGATION : This navigation is also responsive-->
			<nav>
				<!--
				NOTE: Notice the gaps after each icon usage <i></i>..
				Please note that these links work a bit different than
				traditional href="" links. See documentation for details.
				-->
				@include('admin.nav.nav')
			</nav>


			<span class="minifyme" data-action="minifyMenu">
				<i class="fa fa-arrow-circle-left hit"></i>
			</span>

		</aside>
		<!-- END NAVIGATION -->
		@yield('content')


    		<!-- PAGE FOOTER -->
    		<div class="page-footer">
    			<div class="row">
    				<div class="col-xs-12 col-sm-6">
    				<span class="txt-color-white">Nano Project <span class="hidden-xs"> </span> ©2016</span>
    				</div>

    				<div class="col-xs-6 col-sm-6 text-right hidden-xs">
    					<div class="txt-color-white inline-block">
    						<i class="txt-color-blueLight hidden-mobile">Last account activity <i class="fa fa-clock-o"></i> <strong>52 mins ago &nbsp;</strong> </i>
    						<div class="btn-group dropup">
    							<button class="btn btn-xs dropdown-toggle bg-color-blue txt-color-white" data-toggle="dropdown">
    								<i class="fa fa-link"></i> <span class="caret"></span>
    							</button>
    							<ul class="dropdown-menu pull-right text-left">
    								<li>
    									<div class="padding-5">
    										<p class="txt-color-darken font-sm no-margin">Download Progress</p>
    										<div class="progress progress-micro no-margin">
    											<div class="progress-bar progress-bar-success" style="width: 50%;"></div>
    										</div>
    									</div>
    								</li>
    								<li class="divider"></li>
    								<li>
    									<div class="padding-5">
    										<p class="txt-color-darken font-sm no-margin">Server Load</p>
    										<div class="progress progress-micro no-margin">
    											<div class="progress-bar progress-bar-success" style="width: 20%;"></div>
    										</div>
    									</div>
    								</li>
    								<li class="divider"></li>
    								<li>
    									<div class="padding-5">
    										<p class="txt-color-darken font-sm no-margin">Memory Load <span class="text-danger">*critical*</span></p>
    										<div class="progress progress-micro no-margin">
    											<div class="progress-bar progress-bar-danger" style="width: 70%;"></div>
    										</div>
    									</div>
    								</li>
    								<li class="divider"></li>
    								<li>
    									<div class="padding-5">
    										<button class="btn btn-block btn-default">refresh</button>
    									</div>
    								</li>
    							</ul>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    		<!-- END PAGE FOOTER -->

    		<!-- SHORTCUT AREA : With large tiles (activated via clicking user name tag)
    		Note: These tiles are completely responsive,
    		you can add as many as you like
    		-->
    		<div id="shortcut">
    			<ul>
    				<li>
    					<a href="inbox.html" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-envelope fa-4x"></i> <span>Mail <span class="label pull-right bg-color-darken">14</span></span> </span> </a>
    				</li>
    				<li>
    					<a href="calendar.html" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i class="fa fa-calendar fa-4x"></i> <span>Calendar</span> </span> </a>
    				</li>
    				<li>
    					<a href="gmap-xml.html" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-map-marker fa-4x"></i> <span>Maps</span> </span> </a>
    				</li>
    				<li>
    					<a href="invoice.html" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-book fa-4x"></i> <span>Invoice <span class="label pull-right bg-color-darken">99</span></span> </span> </a>
    				</li>
    				<li>
    					<a href="gallery.html" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-picture-o fa-4x"></i> <span>Gallery </span> </span> </a>
    				</li>
    				<li>
    					<a href="profile.html" class="jarvismetro-tile big-cubes selected bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>My Profile </span> </span> </a>
    				</li>
    			</ul>
    		</div>
    		<!-- END SHORTCUT AREA -->

    		<!--================================================== -->

    		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
    		<!-- <script data-pace-options='{ "restartOnRequestAfter": true }' src="{{URL::to('/')}}/js/plugin/pace/pace.min.js"></script> -->

    		<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
    		<script src="{{URL::to('/')}}/js/jquery-2.2.4.min.js"></script>
				<!-- <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script> -->
				<!-- <script src="{{ url('/js/jquery.min.js') }}"></script> -->
    		<script>
    			if (!window.jQuery) {
    				document.write('<script src="js/libs/jquery-2.1.1.min.js"><\/script>');
    			}
    		</script>

    		<script src="{{URL::to('/')}}/js/jqueryui.min.js"></script>
    		<script>
    			if (!window.jQuery.ui) {
    				document.write('<script src="js/libs/jquery-ui-1.10.3.min.js"><\/script>');
    			}
    		</script>


    		<!-- IMPORTANT: APP CONFIG -->
    		<script src="{{URL::to('/')}}/js/app.config.js"></script>

    		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
    		<script src="{{URL::to('/')}}/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script>

    		<!-- BOOTSTRAP JS -->
    		<script src="{{URL::to('/')}}/js/bootstrap/bootstrap.min.js"></script>

    		<!-- CUSTOM NOTIFICATION -->
    		<script src="{{URL::to('/')}}/js/notification/SmartNotification.min.js"></script>

    		<!-- JARVIS WIDGETS -->
    		<script src="{{URL::to('/')}}/js/smartwidgets/jarvis.widget.min.js"></script>

    		<!-- EASY PIE CHARTS -->
    		<script src="{{URL::to('/')}}/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

    		<!-- SPARKLINES -->
    		<!-- <script src="{{URL::to('/')}}/js/plugin/sparkline/jquery.sparkline.min.js"></script> -->

    		<!-- JQUERY VALIDATE -->
    		<!-- <script src="{{URL::to('/')}}/js/plugin/jquery-validate/jquery.validate.min.js"></script> -->

    		<!-- JQUERY MASKED INPUT -->
    		<script src="{{URL::to('/')}}/js/plugin/masked-input/jquery.maskedinput.min.js"></script>

    		<!-- JQUERY UI + Bootstrap Slider -->
    		<script src="{{URL::to('/')}}/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

    		<!-- browser msie issue fix -->
    		<script src="{{URL::to('/')}}/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

    		<!-- FastClick: For mobile devices -->
    		<script src="{{URL::to('/')}}/js/plugin/fastclick/fastclick.min.js"></script>

    		<!--[if IE 8]>

    		<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

    		<![endif]-->

    		<!-- MAIN APP JS FILE -->
    		<script src="{{URL::to('/')}}/js/app.min.js"></script>

    		<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->

    		<!-- SmartChat UI : plugin -->
    		<!-- <script src="{{URL::to('/')}}/js/smart-chat-ui/smart.chat.ui.min.js"></script>
    		<script src="{{URL::to('/')}}/js/smart-chat-ui/smart.chat.manager.min.js"></script> -->

    		<!-- PAGE RELATED PLUGIN(S) -->
    		<script src="{{URL::to('/')}}/js/plugin/datatables/jquery.dataTables.min.js"></script>
    		<script src="{{URL::to('/')}}/js/plugin/datatables/dataTables.colVis.min.js"></script>
    		<script src="{{URL::to('/')}}/js/plugin/datatables/dataTables.tableTools.min.js"></script>
    		<script src="{{URL::to('/')}}/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
    		<script src="{{URL::to('/')}}/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
    		<script src="{{ url('/') }}/js/parsley.min.js"></script>
				<script src="{{ url('/') }}/js/select2.min.js"></script>
				<script src="{{ url('/') }}/js/jquery.mask.min.js"></script>
    		<script src="{{URL::to('/')}}/master/main.js"></script>

    		<script src="{{ url('/js/datatable/DataTables-1.10.12/js/jquery.dataTables.min.js') }}"></script>
				<script src="{{ url('/js/datatable/Buttons-1.2.2/js/dataTables.buttons.js') }}"></script>
				<script src="{{ url('/js/datatable/dataTables.bootstrap.min.js') }}"></script>
				<script src="{{ url('/js/datatable-responsive/datatables.responsive.min.js') }}"></script>
				<script src="{{ url('/js/datatable/Buttons-1.2.2/js/buttons.html5.js') }}"></script>
				<script src="{{ url('/js/datatable/dataTables.colVis.min.js') }}"></script>
				<script src="{{ url('/js/datatable/Buttons-1.2.2/js/buttons.print.js') }}"></script>
				<script src="{{ url('/js/datatable/Buttons-1.2.2/js/buttons.colVis.js') }}"></script>
				<script src="{{ url('/js/datatable/Buttons-1.2.2/js/buttons.flash.js') }}"></script>
				<script src="{{ url('/js/datatable/pdfmake-0.1.18/build/pdfmake.js') }}"></script>
				<script src="{{ url('/js/datatable/pdfmake-0.1.18/build/vfs_fonts.js') }}"></script>

	    	<script src="{{URL::to('/')}}/master/1/dist/sweetalert.min.js"></script>
	    	<script src="{{URL::to('/')}}/master/script.js" type="text/javascript" charset="utf-8" async defer></script>
	    	@stack('scripts')
	    	@include('sweet::alert')
	    	<script>
					$('.confirmdelete').click(function(e) {
		            e.preventDefault();
		            var href = $(this).attr('href');
		            var jobname = $(this).data('jobname');
		            return vex.dialog.confirm({
		                message: 'Are you sure you want to withdraw job ' + jobname + '?',
		                callback: function(confirmed) {
		                    if (confirmed) {
		                        window.location.href = href;
		                    }
		                }
		            });
		      });
				</script>
    		@yield('js')


    		<script type="text/javascript">


    		// DO NOT REMOVE : GLOBAL FUNCTIONS!

    		$(document).ready(function() {

					$('.select2').select2({
						width: "100%",
						dropdownParent: 'inside'
					});
					$('.select2-bold').select2({
						width: "100%",
				    templateResult: formatOutput,
						templateSelection: formatOutput
				  });

				  function formatOutput (optionElement) {
				    if (!optionElement.id) { return optionElement.text; }
						// optionElement.text = '<span><strong>' + optionElement.element.value + '</strong> ' + optionElement.text + '</span>'
						var textElement = optionElement.text.split(" ");
						var code = textElement[0];
						var textarray = textElement.splice(0, 1);
						var text = textElement.join(' ');
				    var $state = $(
				      '<strong>' + code + '</strong> <span>'+ text+'</span>'
				    );
				    return $state;
				  };
					$('.phoneregex').mask('(0000) 000-000');
					$('.mobileregex').mask('0000-0000-0000');
					$('.buttons-colvis').click(function(){
						console.log('click');
						$('.buttons-columnVisibility').each(function(){
							if($(this).has('input').length < 1){
								if($(this).hasClass('active')){
									$(this).prepend('<input type="checkbox" checked> ');
								} else {
									$(this).prepend('<input type="checkbox"> ');
								}
							}

						});

						$('.buttons-columnVisibility').on('click', function(){
							console.log($(this).hasClass('active'));
							if($(this).hasClass('active')){
									$(this).children('input').prop('checked',true);
							} else {
									$(this).children('input').prop('checked',false);
							}
						});
					});
    			pageSetUp();

    			/* // DOM Position key index //

    			l - Length changing (dropdown)
    			f - Filtering input (search)
    			t - The Table! (datatable)
    			i - Information (records)
    			p - Pagination (paging)
    			r - pRocessing
    			< and > - div elements
    			<"#id" and > - div with an id
    			<"class" and > - div with a class
    			<"#id.class" and > - div with an id and class

    			Also see: http://legacy.datatables.net/usage/features
    			*/

    			/* BASIC ;*/
    				var responsiveHelper_dt_basic = undefined;
    				var responsiveHelper_datatable_fixed_column = undefined;
    				var responsiveHelper_datatable_col_reorder = undefined;
    				var responsiveHelper_datatable_tabletools = undefined;

    				var breakpointDefinition = {
    					tablet : 1024,
    					phone : 480
    				};

    			/* END BASIC */

    			/* COLUMN FILTER  */


    		    // custom toolbar
    		    // $("div.toolbar").html('<div class="text-right"><img src="img/logo.png" alt="SmartAdmin" style="width: 111px; margin-top: 3px; margin-right: 10px;"></div>');

    		    // Apply the filter
    		    /* END COLUMN FILTER */

    			/* COLUMN SHOW - HIDE */

    			/* END COLUMN SHOW - HIDE */

    			/* TABLETOOLS */

    			/* END TABLETOOLS */

    		})

    		</script>

    		<!-- Your GOOGLE ANALYTICS CODE Below -->

    	</body>

    </html>
