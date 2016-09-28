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
		<link rel="stylesheet" type="text/css" media="screen" href="{{URL::to('/')}}/css/smartadmin-rtl.min.css">

			<!-- SweetAlert  -->
		<link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/master/1/dist/sweetalert.css">

		<link rel="stylesheet" type="text/css" href="{{ url('/css/select2.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ url('/css/select2-bootstrap.css') }}">



		<!-- We recommend you use "your_style.css" to override SmartAdmin
		     specific styles this will also ensure you retrain your customization with each SmartAdmin update.
		<link rel="stylesheet" type="text/css" media="screen" href="css/your_style.css"> -->

		<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
		<link rel="stylesheet" type="text/css" media="screen" href="{{URL::to('/')}}/css/demo.min.css">

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

				<!-- Note: The activity badge color changes when clicked and resets the number to 0
				Suggestion: You may want to set a flag when this happens to tick off all checked messages / notifications -->
				<span id="activity" class="activity-dropdown"> <i class="fa fa-user"></i> <b class="badge"> 21 </b> </span>

				<!-- AJAX-DROPDOWN : control this dropdown height, look and feel from the LESS variable file -->
				<div class="ajax-dropdown">

					<!-- the ID links are fetched via AJAX to the ajax container "ajax-notifications" -->
					<div class="btn-group btn-group-justified" data-toggle="buttons">
						<label class="btn btn-default">
							<input type="radio" name="activity" id="ajax/notify/mail.html">
							Msgs (14) </label>
						<label class="btn btn-default">
							<input type="radio" name="activity" id="ajax/notify/notifications.html">
							notify (3) </label>
						<label class="btn btn-default">
							<input type="radio" name="activity" id="ajax/notify/tasks.html">
							Tasks (4) </label>
					</div>

					<!-- notification content -->
					<div class="ajax-notifications custom-scroll">

						<div class="alert alert-transparent">
							<h4>Click a button to show messages here</h4>
							This blank page message helps protect your privacy, or you can show the first message here automatically.
						</div>

						<i class="fa fa-lock fa-4x fa-border"></i>

					</div>
					<!-- end notification content -->

					<!-- footer: refresh area -->
					<span> Last updated on: 12/12/2013 9:43AM
						<button type="button" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Loading..." class="btn btn-xs btn-default pull-right">
							<i class="fa fa-refresh"></i>
						</button>
					</span>
					<!-- end footer -->

				</div>
				<!-- END AJAX-DROPDOWN -->
			</div>

			<!-- projects dropdown -->
			<div class="project-context hidden-xs">

				<span class="label">Projects:</span>
				<span class="project-selector dropdown-toggle" data-toggle="dropdown">Recent projects <i class="fa fa-angle-down"></i></span>

				<!-- Suggestion: populate this list with fetch and push technique -->
				<ul class="dropdown-menu">
					<li>
						<a href="javascript:void(0);">Online e-merchant management system - attaching integration with the iOS</a>
					</li>
					<li>
						<a href="javascript:void(0);">Notes on pipeline upgradee</a>
					</li>
					<li>
						<a href="javascript:void(0);">Assesment Report for merchant account</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="javascript:void(0);"><i class="fa fa-power-off"></i> Clear</a>
					</li>
				</ul>
				<!-- end dropdown-menu-->

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
				<div id="speech-btn" class="btn-header transparent pull-right hidden-sm hidden-xs">
					<div>
						<a href="javascript:void(0)" title="Voice Command" data-action="voiceCommand"><i class="fa fa-microphone"></i></a>
						<div class="popover bottom"><div class="arrow"></div>
							<div class="popover-content">
								<h4 class="vc-title">Voice command activated <br><small>Please speak clearly into the mic</small></h4>
								<h4 class="vc-title-error text-center">
									<i class="fa fa-microphone-slash"></i> Voice command failed
									<br><small class="txt-color-red">Must <strong>"Allow"</strong> Microphone</small>
									<br><small class="txt-color-red">Must have <strong>Internet Connection</strong></small>
								</h4>
								<a href="javascript:void(0);" class="btn btn-success" onclick="commands.help()">See Commands</a>
								<a href="javascript:void(0);" class="btn bg-color-purple txt-color-white" onclick="$('#speech-btn .popover').fadeOut(50);">Close Popup</a>
							</div>
						</div>
					</div>
				</div>
				<!-- end voice command -->

				<!-- multiple lang dropdown : find all flags in the flags page -->
				<ul class="header-dropdown-list hidden-xs">
					<li>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="{{URL::to('')}}/img/blank.gif" class="flag flag-us" alt="United States"> <span> English (US) </span> <i class="fa fa-angle-down"></i> </a>
						<ul class="dropdown-menu pull-right">
							<li class="active">
								<a href="javascript:void(0);"><img src="{{URL::to('')}}/img/blank.gif" class="flag flag-us" alt="United States"> English (US)</a>
							</li>
							<li>
								<a href="javascript:void(0);"><img src="{{URL::to('')}}/img/blank.gif" class="flag flag-fr" alt="France"> Français</a>
							</li>
							<li>
								<a href="javascript:void(0);"><img src="{{URL::to('')}}/img/blank.gif" class="flag flag-es" alt="Spanish"> Español</a>
							</li>
							<li>
								<a href="javascript:void(0);"><img src="{{URL::to('')}}/img/blank.gif" class="flag flag-de" alt="German"> Deutsch</a>
							</li>
							<li>
								<a href="javascript:void(0);"><img src="{{URL::to('')}}/img/blank.gif" class="flag flag-jp" alt="Japan"> 日本語</a>
							</li>
							<li>
								<a href="javascript:void(0);"><img src="{{URL::to('')}}/img/blank.gif" class="flag flag-cn" alt="China"> 中文</a>
							</li>
							<li>
								<a href="javascript:void(0);"><img src="{{URL::to('')}}/img/blank.gif" class="flag flag-it" alt="Italy"> Italiano</a>
							</li>
							<li>
								<a href="javascript:void(0);"><img src="{{URL::to('')}}/img/blank.gif" class="flag flag-pt" alt="Portugal"> Portugal</a>
							</li>
							<li>
								<a href="javascript:void(0);"><img src="{{URL::to('')}}/img/blank.gif" class="flag flag-ru" alt="Russia"> Русский язык</a>
							</li>
							<li>
								<a href="javascript:void(0);"><img src="{{URL::to('')}}/img/blank.gif" class="flag flag-kr" alt="Korea"> 한국어</a>
							</li>

						</ul>
					</li>
				</ul>
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

				<ul>
					<li class="active">
						<a href="{{URL::to('admin-nano')}}" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>

					</li>

					<li>
						<a href="#"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">Tables</span></a>
						<ul>
							@if($active == 'cabang')
								<li class="active">
									<a href="{{URL::to('/')}}/admin-nano/cabang">Cabang</a>
								</li>
							@else
								<li>
									<a href="{{URL::to('/')}}/admin-nano/cabang">Cabang</a>
								</li>
							@endif
							@if($active == 'barang')
								<li class="active">
									<a href="{{URL::to('/')}}/admin-nano/barang">Barang</a>
								</li>
							@else
								<li>
									<a href="{{URL::to('/')}}/admin-nano/barang">Barang</a>
								</li>
							@endif
							@if($active == 'customer')
								<li class="active">
									<a href="{{URL::to('/')}}/admin-nano/pelanggan">Pelanggan</a>
								</li>
							@else
								<li>
									<a href="{{URL::to('/')}}/admin-nano/pelanggan">Pelanggan</a>
								</li>
							@endif
							@if($active == 'mcoa')
								<li class="active">
									<a href="{{URL::to('/')}}/admin-nano/mcoa">Akun</a>
								</li>
							@else
							<li>
								<a href="{{URL::to('/')}}/admin-nano/mcoa">Akun</a>
							</li>
							@endif
							@if($active == 'mprefix')
								<li class="active">
									<a href="{{URL::to('/')}}/admin-nano/mprefix">Prefix</a>
								</li>
							@else
							<li>
								<a href="{{URL::to('/')}}/admin-nano/mprefix">Prefix</a>
							</li>
							@endif

						</ul>
					</li>

								<!-- END DISPLAY USERS -->
							</li>
						</ul>
					</li>
				</ul>
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
    		<script data-pace-options='{ "restartOnRequestAfter": true }' src="{{URL::to('/')}}/js/plugin/pace/pace.min.js"></script>

    		<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
    		<!-- <script src="{{URL::to('/')}}/js/jquery.min.js"></script> -->
				<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
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
    		<script src="{{URL::to('/')}}/js/plugin/sparkline/jquery.sparkline.min.js"></script>

    		<!-- JQUERY VALIDATE -->
    		<script src="{{URL::to('/')}}/js/plugin/jquery-validate/jquery.validate.min.js"></script>

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

    		<!-- Demo purpose only -->
    		<script src="{{URL::to('/')}}/js/demo.min.js"></script>

    		<!-- MAIN APP JS FILE -->
    		<script src="{{URL::to('/')}}/js/app.min.js"></script>

    		<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
    		<!-- Voice command : plugin -->
    		<script src="{{URL::to('/')}}/js/speech/voicecommand.min.js"></script>

    		<!-- SmartChat UI : plugin -->
    		<script src="{{URL::to('/')}}/js/smart-chat-ui/smart.chat.ui.min.js"></script>
    		<script src="{{URL::to('/')}}/js/smart-chat-ui/smart.chat.manager.min.js"></script>

    		<!-- PAGE RELATED PLUGIN(S) -->
    		<script src="{{URL::to('/')}}/js/plugin/datatables/jquery.dataTables.min.js"></script>
    		<script src="{{URL::to('/')}}/js/plugin/datatables/dataTables.colVis.min.js"></script>
    		<script src="{{URL::to('/')}}/js/plugin/datatables/dataTables.tableTools.min.js"></script>
    		<script src="{{URL::to('/')}}/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
    		<script src="{{URL::to('/')}}/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
    		<script src="{{ url('/') }}/js/parsley.min.js"></script>
				<script src="{{ url('/') }}/js/select2.min.js"></script>
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
						width: "100%"
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

    				$('#dt_basic').dataTable({
    					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
    						"t"+
    						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
    					"autoWidth" : true,
    			        "oLanguage": {
    					    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
    					},
    					"preDrawCallback" : function() {
    						// Initialize the responsive datatables helper once.
    						if (!responsiveHelper_dt_basic) {
    							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
    						}
    					},
    					"rowCallback" : function(nRow) {
    						responsiveHelper_dt_basic.createExpandIcon(nRow);
    					},
    					"drawCallback" : function(oSettings) {
    						responsiveHelper_dt_basic.respond();
    					}
    				});

    			/* END BASIC */

    			/* COLUMN FILTER  */
    		    var otable = $('#datatable_fixed_column').DataTable({
    		    	//"bFilter": false,
    		    	//"bInfo": false,
    		    	//"bLengthChange": false
    		    	//"bAutoWidth": false,
    		    	//"bPaginate": false,
    		    	//"bStateSave": true // saves sort state using localStorage
    				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
    						"t"+
    						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
    				"autoWidth" : true,
    				"oLanguage": {
    					"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'

    				},
    				"sDom": 'T<"clear">lfrtip',
        			"oTableTools": {
            		"sSwfPath": "/swf/copy_csv_xls_pdf.swf"
       				},
    				"preDrawCallback" : function() {
    					// Initialize the responsive datatables helper once.
    					if (!responsiveHelper_datatable_fixed_column) {
    						responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
    					}
    				},
    				"rowCallback" : function(nRow) {
    					responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
    				},
    				"drawCallback" : function(oSettings) {
    					responsiveHelper_datatable_fixed_column.respond();
    				}

    		    });

    		    // custom toolbar
    		    // $("div.toolbar").html('<div class="text-right"><img src="img/logo.png" alt="SmartAdmin" style="width: 111px; margin-top: 3px; margin-right: 10px;"></div>');

    		    // Apply the filter
    		    $("#datatable_fixed_column thead th input[type=text]").on( 'keyup change', function () {

    		        otable
    		            .column( $(this).parent().index()+':visible' )
    		            .search( this.value )
    		            .draw();

    		    } );
    		    /* END COLUMN FILTER */

    			/* COLUMN SHOW - HIDE */
    			$('#datatable_col_reorder').dataTable({
    				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>"+
    						"t"+
    						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
    				"autoWidth" : true,
    				"oLanguage": {
    					"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
    				},
    				"preDrawCallback" : function() {
    					// Initialize the responsive datatables helper once.
    					if (!responsiveHelper_datatable_col_reorder) {
    						responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder'), breakpointDefinition);
    					}
    				},
    				"rowCallback" : function(nRow) {
    					responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
    				},
    				"drawCallback" : function(oSettings) {
    					responsiveHelper_datatable_col_reorder.respond();
    				}
    			});

    			/* END COLUMN SHOW - HIDE */

    			/* TABLETOOLS */
    			$('#datatable_tabletools').dataTable({

    				// Tabletools options:
    				//   https://datatables.net/extensions/tabletools/button_options
    				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
    						"t"+
    						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
    				"oLanguage": {
    					"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
    				},
    		        "oTableTools": {
    		        	 "aButtons": [
    		             "copy",
    		             "csv",
    		             "xls",
    		                {
    		                    "sExtends": "pdf",
    		                    "sTitle": "SmartAdmin_PDF",
    		                    "sPdfMessage": "SmartAdmin PDF Export",
    		                    "sPdfSize": "letter"
    		                },
    		             	{
    	                    	"sExtends": "print",
    	                    	"sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
    	                	}
    		             ],
    		            "sSwfPath": "{{URL::to('/')}}/js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
    		        },
    				"autoWidth" : true,
    				"preDrawCallback" : function() {
    					// Initialize the responsive datatables helper once.
    					if (!responsiveHelper_datatable_tabletools) {
    						responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
    					}
    				},
    				"rowCallback" : function(nRow) {
    					responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
    				},
    				"drawCallback" : function(oSettings) {
    					responsiveHelper_datatable_tabletools.respond();
    				}
    			});

    			/* END TABLETOOLS */

    		})

    		</script>

    		<!-- Your GOOGLE ANALYTICS CODE Below -->
    		<script type="text/javascript">
    			var _gaq = _gaq || [];
    			_gaq.push(['_setAccount', 'UA-XXXXXXXX-X']);
    			_gaq.push(['_trackPageview']);

    			(function() {
    			var ga = document.createElement('script');
    			ga.type = 'text/javascript';
    			ga.async = true;
    			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    			var s = document.getElementsByTagName('script')[0];
    			s.parentNode.insertBefore(ga, s);
    			})();
    		</script>

    	</body>

    </html>
