
@extends('admin/nav/layouttables')
@section('title')
@section('content')
<!-- MAIN PANEL -->
<div id="main" role="main">

	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment">
			<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
				<i class="fa fa-refresh"></i>
			</span>
		</span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>Home</li><li>Pelanggan</li><li>Data Pelanggan</li>
		</ol>
		<!-- end breadcrumb -->

		<!-- You can also add more buttons to the
		ribbon for further usability

		Example below:

		<span class="ribbon-button-alignment pull-right">
		<span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
		<span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
		<span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
		</span> -->

	</div>
	<!-- END RIBBON -->

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa fa-table fa-fw "></i>
						Pelanggan
					<span>
						Data Pelanggan
					</span>
				</h1>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">

			</div>
		</div>
		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div id="forminput" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
						<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

						data-widget-colorbutton="false"
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true"
						data-widget-sortable="false"

						-->
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2>Master Pelanggan </h2>

						</header>

						<!-- widget div-->
						<div>

					 		<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->
							<h3 style="font-weight: bold; color: #1883B8;font-size: 19px;">Mode : INSERT</h3>
							<!-- widget content -->
							<div class="widget-body no-padding">

								 <div class="container">
  <h2></h2>
  <ul class="nav nav-tabs">
  @if($activetab == 1)
   	<li class="active"><a data-toggle="tab" href="#menu1">Profil Pelanggan</a></li>
   	<li><a data-toggle="tab" href="#menu3">Kontak</a></li>
   @else
    <li><a data-toggle="tab" href="#menu1">Profil Pelanggan</a></li>
   	<li class="active"><a data-toggle="tab" href="#menu3">Kontak</a></li>
   @endif
	 	<li><a data-toggle="tab" href="#menu4">Kredit Limit</a></li>
    <li><a data-toggle="tab" href="#menu5">Pajak</a></li>
  </ul>

  <div class="tab-content">
  	@if($activetab == 1)
    	<div id="menu1" class="tab-pane fade in active">
    @else
    	<div id="menu1" class="tab-pane fade in">
    @endif
    	 </br>
<div id="insert-wrapper" class="form-horizontal" data-parsley-validate>

    <div class="col-md-6">

    <div style="padding-top:15px;" class="tab-content">
        <div class="tab-pane active" id="info-tab">
    <div style="height: 30px;" class="form-group">
								<label class="col-md-3 control-label"><b>ID Pelanggan</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-9">
										<div class="icon-addon addon-md">

											<div class="input-group">
      										<input id="insert-mcustomerid" value="{{old('mcustomerid')}}" name="mcustomerid" class="form-control forminput" placeholder="AUTO GENERATE" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".errorBlock1" @if (Session::has('autofocus')) autofocus @endif >
      										<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Pelanggan"></label>
      										<span class="input-group-addon" style="background: none;">
        									<input type="checkbox" id="disableforminput" name="autogen" rel="tooltip" title="ON/OFF auto generate ID Pelanggan">
      										</span>
    										</div>
    										</div>
										</div>

								</div>
								<div class="errorBlock1" style="margin-left:23% !important;"></div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Pelanggan</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-9 col-sm-12">
										<div class="icon-addon addon-md">

											<input id="insert-mcustomername" value="{{old('mcustomername')}}" name="mcustomername" class="form-control forminput" placeholder="Nama Pelanggan" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" data-parsley-errors-container=".errorBlock2" @if (Session::has('autofocus')) autofocus @endif>
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Pelanggan"></label>


										</div>
									</div>
								</div>
								<div class="errorBlock2" style="margin-left:23% !important;"></div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Email</b> &nbsp  :</label>
									<div class="col-md-9 col-sm-12">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomeremail" value="{{old('mcustomeremail')}}" name="mcustomeremail" class="form-control forminput" placeholder="Email" type="text"  @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"><b>Telepon Kantor</b>  &nbsp  :</label>
									<div  class="col-md-9 col-sm-12">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomerphone" value="{{old('mcustomerphone')}}" name="mcustomerphone" class="form-control forminput phoneexample phoneregex" placeholder="Telepon Kantor" type="text" @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Telepon Kantor"></label>

										<div style="height: 5px;">
										<h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
										</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"><b>Fax Kantor</b> &nbsp  :</label>
									<div  class="col-md-9 col-sm-12">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomerfax" value="{{old('mcustomerfax')}}" name="mcustomerfax" class="form-control forminput phoneregex" placeholder="Fax Kantor" type="text" @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Fax Kantor"></label>

										<div style="height: 5px;">
										<h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
										</div>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Website</b> &nbsp  :</label>
									<div class="col-md-9 col-sm-12">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomerwebsite" value="{{old('mcustomerwebsite')}}" name="mcustomerwebsite" class="form-control forminput" placeholder="Website" type="text"  @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Website"></label>
										</div>
									</div>
								</div></div>
								</br>
								</br>
					<div style="padding-left:400px;">
      				<button onclick="insertmcustomer()" type="submit" name="button" class="btn btn-primary">Simpan</button>
      				<a id="btn-insert-reset" onclick="resetcustomer1()" class="btn btn-default" ><i class=""></i> Reset</a>

      				</br>
      				</br>
					</div>


					       </div>

        </div>


{{-- PEMISAH --}}


<div class="col-md-6">
	<label style="padding-left: 20px; padding-top: 19px;" class="control-label"><b>Alamat Penagihan</b>  &nbsp  :</label>
    <div class="tab-content" style="margin-top:-41px; padding-left:148px;">

        <div class="tab-pane active" id="info-tab">

    <div style="height: 95px;" class="form-group">

								</br>
								</br>
								<div class="col-lg-12">
										<div class="icon-addon addon-md">
											<textarea id="insert-mcustomeraddress" value="{{old('mcustomeraddress')}}" name="mcustomeraddress" class="form-control forminput" rows="5" placeholder="Jalan" type="text"  @if (Session::has('autofocus')) autofocus @endif ></textarea>

											<label for="mgoodsgroup1" class="glyphicon glyphicon-road" rel="tooltip" title="Jalan"></label>
										</div>
									</div>
								</div>

				<div style="" class="form-group col-lg-6">
				<input id="insert-mcustomercity" value="{{old('mcustomercity')}}" name="mcustomercity" class="form-control forminput" placeholder="Kota" type="text"  @if (Session::has('autofocus')) autofocus @endif >
				</div>

				<div style="padding-left: 21px;" class="form-group col-lg-6">
				<input id="insert-mcustomerzipcode" value="{{old('mcustomerzipcode')}}" name="mcustomerzipcode" class="form-control forminput" placeholder="K.Pos" type="text"  @if (Session::has('autofocus')) autofocus @endif >
				</div>


								<div style="height: 80px;" class="form-group">
									<div  class="col-lg-12">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomerprovince" value="{{old('mcustomerprovince')}}" name="mcustomerprovince" class="form-control forminput" placeholder="Provinsi " type="text"  @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-star" rel="tooltip" title="Propinsi"></label>


										</div>
									</div>
								</div>

								<div class="form-group">
									<div  class="col-lg-12">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomercountry" value="{{old('mcustomercountry')}}" name="mcustomercountry" class="form-control forminput" placeholder="Negara" type="text"  @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-star" rel="tooltip" title="Negara"></label>


										</div>
									</div>
								</div>



								</div></div>
								</br>
								</br>

        </div>
        </div>

</div>
</row>

    </br>


    <div id="menu2" class="tab-pane fade">
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    @if($activetab == 1)
    	<div id="menu3" class="tab-pane fade">
    @else
    	<div id="menu3" class="tab-pane fade in active">
    @endif

      <div style="height: 21px;" class="form-group">
									<input type="hidden" value="{{$id}}" id="load-mcustomercontact2">
									<label class="col-md-2 control-label"><b>Nama Lengkap</b>  &nbsp  :</label>
									<div class="col-md-4">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomercontactname" value="{{old('mcustomercontactname')}}" name="mcustomercontactname" class="form-control forminput" placeholder="Nama Lengkap" type="text" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Lengkap"></label>
										</div>
									</div>
								</div>
									<div style="height: 21px;" class="form-group">
									<label class="col-md-2 control-label"><b>Posisi Jabatan</b>  &nbsp  :</label>
									<div class="col-md-4">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomercontactposition" value="{{old('mcustomercontactposition')}}" name="mcustomercontactposition" class="form-control forminput" placeholder="Posisi Jabatan" type="text" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon glyphicon-user" rel="tooltip" title="Posisi Jabatan"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-2 control-label"><b>Email</b>  &nbsp  :</label>
									<div class="col-md-4">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomercontactemail" value="{{old('mcustomercontactemail')}}" name="mcustomercontactemail" class="form-control forminput" placeholder="Email" type="text" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label"><b>Handphone</b>  &nbsp  :</label>
									<div  class="col-md-4">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomercontactemailphone" value="{{old('mcustomercontactemailphone')}}" name="mcustomercontactemailphone" class="form-control forminput mobileregex" placeholder="Handphone" type="text" @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Handphone"></label>

										<div style="height: 5px;">
										<h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
										</div>
										</div>
									</div>
								</div>


    </br>
  </br>
  </br>
  </br>
  </br>
    <center>
       <button onclick="insertmcustomer()" name="button" class="btn btn-primary">Simpan</button>
      <a id="btn-insert-reset" onclick="resetcustomer2()" class="btn btn-default" ><i class=""></i> Reset</a>
       </center>
  </div>

	<div id="menu4" class="tab-pane fade">
		<div class="form form-horizontal">
			<div style="padding-top: 21px;" class="form-group">
				<label class="col-md-2 control-label"><b>Limit</b>  &nbsp  :</label>
				<div class="col-md-4">
					<div class="icon-addon addon-md">
						<input id="insert-mcustomerarlimit" name="mcustomerarlimit" class="form-control forminput" placeholder="Limit" type="text" @if (Session::has('autofocus')) autofocus @endif >
						<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Limit"></label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label"><b>Akun</b>  &nbsp  :</label>
				<div class="col-md-4">
					<div class="icon-addon addon-md">
						<select id="insert-mcustomercoa" class="form-control select2">
							@foreach($mcoa as $coa)
								<option value="{{ $coa->id }}">{{ $coa->mcoaname }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		<div>
  </div>

	<div id="menu5" class="tab-pane fade">
      <h3>Empty</h3>

    </div>

    <div id="menu6" class="tab-pane fade">
      <h3>Menu 6</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>

    <div id="menu7" class="tab-pane fade">
      <h3>Menu 7</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>

    <div id="menu8" class="tab-pane fade">
      <h3>Menu 8</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
  </div>

  </br>



</div>


							 </div>
	 						<!-- end widget content -->

	 					</div>
	 					<!-- end widget div -->

	 				</div>
	 				<!-- end widget -->




<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div id="formedit" style="display:none;" class="formedit jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
						<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

						data-widget-colorbutton="false"
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true"
						data-widget-sortable="false"

						-->
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2>Master Pelanggan </h2>

						</header>

						<!-- widget div-->
						<div>

					 		<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->
							<h3 style="font-weight: bold; color: #C91503;font-size: 19px;">Mode : EDIT</h3>
							<!-- widget content -->
							<input type="hidden" id="idmcustomerid" class="idmcustomerid" value=""></input>
							<div class="widget-body no-padding">

								 <div class="container">
  <h2></h2>
  <ul class="nav nav-tabs">
  @if($activetab == 1)
   	<li class="active"><a data-toggle="tab" href="#menuedit1">Profil Pelanggan</a></li>
   	<li><a data-toggle="tab" href="#menuedit3">Kontak</a></li>
   @else
    <li><a data-toggle="tab" href="#menuedit1">Profil Pelanggan</a></li>
   	<li class="active"><a data-toggle="tab" href="#menuedit3">Kontak</a></li>
   @endif
    <li><a data-toggle="tab" href="#menuedit5">Pajak</a></li>
  </ul>

  <div class="tab-content">
  	@if($activetab == 1)
    	<div id="menuedit1" class="tab-pane fade in active">
    @else
    	<div id="menuedit1" class="tab-pane fade in">
    @endif
    	 </br>
<div id="edit-wrapper" class="form-horizontal" data-parsley-validate>
    <div class="col-md-6">
    <div style="padding-top:15px;" class="tab-content">
        <div class="tab-pane active" id="info-tab">

    <div style="height: 35px;" class="form-group">
	<label class="col-md-3 control-label"><b>ID Pelanggan</b> (<font color="red">*</font>) &nbsp  :</label>
								<div class="col-md-9">
										<div class="icon-addon addon-md">
									{{-- 		<input id="insert-mcustomerid" value="{{old('mcustomerid')}}" name="mcustomerid" class="form-control forminput" placeholder="ID Pelanggan" type="text" required @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Pelanggan"></label> --}}
											<div class="input-group">

      										<input disabled id="mcustomerid" value="{{old('mcustomerid')}}" name="mcustomerid" class="form-control forminput" placeholder="AUTO GENERATE" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" data-parsley-errors-container=".errorBlock3" @if (Session::has('autofocus')) autofocus @endif >
      										<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="ON/OFF auto generate ID Pelanggan"></label>
      										<span class="input-group-addon" style="background: none;">
        									<input disabled type="checkbox" id="disableforminput" name="autogen">
      										</span>
    										</div>
										</div>
									</div>
								</div>
								<div id="errorBlock3" style="margin-left:24%;"></div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Pelanggan</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-9 col-sm-12">
										<div class="icon-addon addon-md">
											<input id="mcustomername" value="{{old('mcustomername')}}" name="mcustomername" class="form-control forminput" placeholder="Nama Pelanggan" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" data-parsley-errors-container=".errorBlock4" @if (Session::has('autofocus')) autofocus @endif>
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Pelanggan"></label>
										</div>
									</div>
								</div>
								<div class="errorBlock4" style="margin-left:24%;"></div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Email</b>  &nbsp  :</label>
									<div class="col-md-9 col-sm-12">
										<div class="icon-addon addon-md">
											<input id="mcustomeremail" value="{{old('mcustomeremail')}}" name="mcustomeremail" class="form-control forminput" placeholder="Email" type="text"  @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"><b>Telepon Kantor</b>  &nbsp  :</label>
									<div  class="col-md-9 col-sm-12">
										<div class="icon-addon addon-md">
											<input id="mcustomerphone" value="{{old('mcustomerphone')}}" name="mcustomerphone" class="form-control forminput phoneexample phoneregex" placeholder="Telepon Kantor" type="text" @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Telepon Kantor"></label>

										<div style="height: 5px;">
										<h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
										</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"><b>Fax Kantor</b>  &nbsp  :</label>
									<div  class="col-md-9 col-sm-12">
										<div class="icon-addon addon-md">
											<input id="mcustomerfax" value="{{old('mcustomerfax')}}" name="mcustomerfax" class="form-control forminput phoneregex" placeholder="Fax Kantor" type="text" @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Fax Kantor"></label>

										<div style="height: 5px;">
										<h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
										</div>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Website</b>  &nbsp  :</label>
									<div class="col-md-9 col-sm-12">
										<div class="icon-addon addon-md">
											<input id="mcustomerwebsite" value="{{old('mcustomerwebsite')}}" name="mcustomerwebsite" class="form-control forminput" placeholder="Website" type="text"  @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Website"></label>
										</div>
									</div>
								</div></div>
								</br>
								</br>
					<div style="padding-left:400px;">
      				<button onclick="updatemcustomer()" type="submit" name="button" class="btn btn-primary">Simpan</button>
      				<a id="btn-insert-reset" onclick="back()" class="btn btn-default" ><i class=""></i> Batal</a>


      				</br>
      				</br>
					</div>


					       </div>

        </div>


{{-- PEMISAH --}}


<div class="col-md-6">
	<label style="padding-left: 20px; padding-top: 19px;" class="control-label"><b>Alamat Penagihan</b>  &nbsp  :</label>
    <div class="tab-content" style="margin-top:-41px; padding-left:148px;">

        <div class="tab-pane active" id="info-tab">

    <div style="height: 95px;" class="form-group">

								</br>
								</br>
								<div class="col-lg-12">
										<div class="icon-addon addon-md">
											<textarea id="mcustomeraddress" value="{{old('mcustomeraddress')}}" name="mcustomeraddress" class="form-control forminput" rows="5" placeholder="Jalan" type="text"  @if (Session::has('autofocus')) autofocus @endif ></textarea>

											<label for="mgoodsgroup1" class="glyphicon glyphicon-road" rel="tooltip" title="Jalan"></label>
										</div>
									</div>
								</div>
				<div style="" class="form-group col-lg-6">
				<input id="mcustomercity" value="{{old('mcustomercity')}}" name="mcustomercity" class="form-control forminput" placeholder="Kota" type="text"  @if (Session::has('autofocus')) autofocus @endif >
				</div>

				<div style="padding-left: 21px; height: 21px;" class="form-group col-lg-6">
				<input id="mcustomerzipcode" value="{{old('mcustomerzipcode')}}" name="mcustomerzipcode" class="form-control forminput" placeholder="K.Pos" type="text"  @if (Session::has('autofocus')) autofocus @endif >
				</div>
								<div style="height: 68px;" class="form-group">
									<div  class="col-lg-12">
										<div class="icon-addon addon-md">
											<input id="mcustomerprovince" value="{{old('mcustomerprovince')}}" name="mcustomerprovince" class="form-control forminput" placeholder="Provinsi " type="text"  @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-star" rel="tooltip" title="Propinsi"></label>


										</div>
									</div>
								</div>

								<div class="form-group">
									<div  class="col-lg-12">
										<div class="icon-addon addon-md">
											<input id="mcustomercountry" value="{{old('mcustomercountry')}}" name="mcustomercountry" class="form-control forminput" placeholder="Negara" type="text"  @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-star" rel="tooltip" title="Negara"></label>


										</div>
									</div>
								</div>



								</div></div>
								</br>
								</br>

        </div>
        </div>

</div>
</row>

    </br>


    <div id="menu2" class="tab-pane fade">
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    @if($activetab == 1)
    	<div id="menuedit3" class="tab-pane fade">
    @else
    	<div id="menuedit3" class="tab-pane fade in active">
    @endif

      <div style="height: 21px;" class="form-group">
									<input type="hidden" value="{{$id}}" id="load-mcustomercontact2">
									<label class="col-md-2 control-label"><b>Nama Lengkap</b>  &nbsp  :</label>
									<div class="col-md-4">
										<div class="icon-addon addon-md">
											<input id="mcustomercontactname" value="{{old('mcustomercontactname')}}" name="mcustomercontactname" class="form-control forminput" placeholder="Nama Lengkap" type="text" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Lengkap"></label>
										</div>
									</div>
								</div>
									<div style="height: 21px;" class="form-group">
									<label class="col-md-2 control-label"><b>Posisi Jabatan</b>  &nbsp  :</label>
									<div class="col-md-4">
										<div class="icon-addon addon-md">
											<input id="mcustomercontactposition" value="{{old('mcustomercontactposition')}}" name="mcustomercontactposition" class="form-control forminput" placeholder="Posisi Jabatan" type="text" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon glyphicon-user" rel="tooltip" title="Posisi Jabatan"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-2 control-label"><b>Email</b>  &nbsp  :</label>
									<div class="col-md-4">
										<div class="icon-addon addon-md">
											<input id="mcustomercontactemail" value="{{old('mcustomercontactemail')}}" name="mcustomercontactemail" class="form-control forminput" placeholder="Email" type="text" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label"><b>Handphone</b>  &nbsp  :</label>
									<div  class="col-md-4">
										<div class="icon-addon addon-md">
											<input id="mcustomercontactemailphone" value="{{old('mcustomercontactemailphone')}}" name="mcustomercontactemailphone" class="form-control forminput mobileregex" placeholder="Handphone" type="text" @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Handphone"></label>

										<div style="height: 5px;">
										<h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
										</div>
										</div>
									</div>
								</div>


    </br>
  </br>
  </br>
  </br>
  </br>
    <center>
       <button onclick="updatemcustomer()" name="button" class="btn btn-primary">Simpan</button>
     <a id="btn-insert-reset" onclick="back()" class="btn btn-default" ><i class=""></i> Batal</a>
       </center>
  </div>

	<div id="menu4" class="tab-pane fade">
      <h3>Menu 4</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>

	<div id="menuedit5" class="tab-pane fade">
      <h3>Empty</h3>

    </div>

    <div id="menu6" class="tab-pane fade">
      <h3>Menu 6</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>

    <div id="menu7" class="tab-pane fade">
      <h3>Menu 7</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>

    <div id="menu8" class="tab-pane fade">
      <h3>Menu 8</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
  </div>

  </br>



		</div>
							</div>
						</div>
						</div>


					</div>



	<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div id="formview" style="display:none;" class="formview jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
						<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

						data-widget-colorbutton="false"
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true"
						data-widget-sortable="false"

						-->
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2>Master Pelanggan </h2>

						</header>

						<!-- widget div-->
						<div>

					 		<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->
							<h3 style="font-weight: bold; color: #291817;font-size: 19px;">Mode : VIEW</h3>
							<!-- widget content -->
							<div class="widget-body no-padding">

								 <div class="container">
  <h2></h2>
  <ul class="nav nav-tabs">
  @if($activetab == 1)
   	<li class="active"><a data-toggle="tab" href="#menuview1">Profil Pelanggan</a></li>
   	<li><a data-toggle="tab" href="#menuview3">Kontak</a></li>
   @else
    <li><a data-toggle="tab" href="#menuview1">Profil Pelanggan</a></li>
   	<li class="active"><a data-toggle="tab" href="#menuview3">Kontak</a></li>
   @endif
    <li><a data-toggle="tab" href="#menuview5">Pajak</a></li>
  </ul>

  <div class="tab-content">
  	@if($activetab == 1)
    	<div id="menuview1" class="tab-pane fade in active">
    @else
    	<div id="menuview1" class="tab-pane fade in">
    @endif
    	 </br>
<div id="insert-wrapper" class="form-horizontal" data-parsley-validate>
    <div class="col-md-6">
    <div style="padding-top:15px;" class="tab-content">
        <div class="tab-pane active" id="info-tab">

    <div style="height: 35px;" class="form-group">
	<label class="col-md-3 control-label"><b>ID Pelanggan</b>  &nbsp  :</label>
								<div class="col-md-9">
										<div class="icon-addon addon-md">
											<div class="input-group">
											<input disabled id="view-mcustomerid" value="{{old('mcustomerid')}}" name="mcustomerid" class="form-control forminput" placeholder="ID Pelanggan" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong"  @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Pelanggan"></label>
      										<span class="input-group-addon" style="background: none;">
        									<input disabled type="checkbox" id="disableforminput" name="autogen">
      										</span>
    										</div>
										</div>
									</div>
								</div>

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Pelanggan</b>  &nbsp  :</label>
									<div class="col-md-9 col-sm-12">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcustomername" value="{{old('mcustomername')}}" name="mcustomername" class="form-control forminput" placeholder="Nama Pelanggan" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif>
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Pelanggan"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Email</b>  &nbsp  :</label>
									<div class="col-md-9 col-sm-12">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcustomeremail" value="{{old('mcustomeremail')}}" name="mcustomeremail" class="form-control forminput" placeholder="Email" type="text"  @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"><b>Telepon Kantor</b>  &nbsp  :</label>
									<div class="col-md-9 col-sm-12">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcustomerphone" value="{{old('mcustomerphone')}}" name="mcustomerphone" class="form-control forminput phoneexample" placeholder="Telepon Kantor" type="number" @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Telepon Kantor"></label>

										<div style="height: 5px;">
										<h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
										</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"><b>Fax Kantor</b>  &nbsp  :</label>
									<div  class="col-md-9 col-sm-12">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcustomerfax" value="{{old('mcustomerfax')}}" name="mcustomerfax" class="form-control forminput" placeholder="Fax Kantor" type="number" @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Fax Kantor"></label>

										<div style="height: 5px;">
										<h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
										</div>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Website</b>  &nbsp  :</label>
									<div class="col-md-9 col-sm-12">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcustomerwebsite" value="{{old('mcustomerwebsite')}}" name="mcustomerwebsite" class="form-control forminput" placeholder="Website" type="text"  @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Website"></label>
										</div>
									</div>
								</div></div>
								</br>
								</br>
					<div style="padding-left:400px;">
      				<a id="btn-insert-reset" onclick="back()" class="btn btn-default" ><i class=""></i> Kembali</a>

      				</br>
      				</br>
					</div>


					       </div>

        </div>


{{-- PEMISAH --}}


<div class="col-md-6">
	<label style="padding-left: 20px; padding-top: 19px;" class="control-label"><b>Alamat Penagihan</b>  &nbsp  :</label>
    <div class="tab-content" style="margin-top:-41px; padding-left:148px;">

        <div class="tab-pane active" id="info-tab">

    <div style="height: 95px;" class="form-group">
								</br>
								</br>
								<div class="col-lg-12">
										<div class="icon-addon addon-md">
											<textarea disabled id="view-mcustomeraddress" value="{{old('mcustomeraddress')}}" name="mcustomeraddress" class="form-control forminput" rows="5" placeholder="Jalan" type="text"  @if (Session::has('autofocus')) autofocus @endif ></textarea>

											<label for="mgoodsgroup1" class="glyphicon glyphicon-road" rel="tooltip" title="Jalan"></label>
										</div>
									</div>
								</div>
				<div style="" class="form-group col-lg-6">
				<input disabled id="view-mcustomercity" value="{{old('mcustomercity')}}" name="mcustomercity" class="form-control forminput" placeholder="Kota" type="text"  @if (Session::has('autofocus')) autofocus @endif >
				</div>

				<div style="padding-left: 21px; height: 21px;" class="form-group col-lg-6">
				<input disabled id="view-mcustomerzipcode" value="{{old('mcustomerzipcode')}}" name="mcustomerzipcode" class="form-control forminput" placeholder="K.Pos" type="text"  @if (Session::has('autofocus')) autofocus @endif >
				</div>
								<div style="height: 68px;" class="form-group">
									<div  class="col-lg-12">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcustomerprovince" value="{{old('mcustomerprovince')}}" name="mcustomerprovince" class="form-control forminput" placeholder="Provinsi " type="text"  @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-star" rel="tooltip" title="Propinsi"></label>


										</div>
									</div>
								</div>

								<div class="form-group">
									<div  class="col-lg-12">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcustomercountry" value="{{old('mcustomercountry')}}" name="mcustomercountry" class="form-control forminput" placeholder="Negara" type="text"  @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-star" rel="tooltip" title="Negara"></label>


										</div>
									</div>
								</div>



								</div></div>
								</br>
								</br>

        </div>
        </div>

</div>
</row>

    </br>


    <div id="menu2" class="tab-pane fade">
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    @if($activetab == 1)
    	<div id="menuview3" class="tab-pane fade">
    @else
    	<div id="menuview3" class="tab-pane fade in active">
    @endif

      <div style="height: 21px;" class="form-group">
									<input type="hidden" value="{{$id}}" id="load-mcustomercontact2">
									<label class="col-md-2 control-label"><b>Nama Lengkap</b>  &nbsp  :</label>
									<div class="col-md-4">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcustomercontactname" value="{{old('mcustomercontactname')}}" name="mcustomercontactname" class="form-control forminput" placeholder="Nama Lengkap" type="text" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Lengkap"></label>
										</div>
									</div>
								</div>
									<div style="height: 21px;" class="form-group">
									<label class="col-md-2 control-label"><b>Posisi Jabatan</b>  &nbsp  :</label>
									<div class="col-md-4">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcustomercontactposition" value="{{old('mcustomercontactposition')}}" name="mcustomercontactposition" class="form-control forminput" placeholder="Posisi Jabatan" type="text" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon glyphicon-user" rel="tooltip" title="Posisi Jabatan"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-2 control-label"><b>Email</b>  &nbsp  :</label>
									<div class="col-md-4">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcustomercontactemail" value="{{old('mcustomercontactemail')}}" name="mcustomercontactemail" class="form-control forminput" placeholder="Email" type="text" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label"><b>Handphone</b>  &nbsp  :</label>
									<div  class="col-md-4">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcustomercontactemailphone" value="{{old('mcustomercontactemailphone')}}" name="mcustomercontactemailphone" class="form-control forminput" placeholder="Handphone" type="number" @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Handphone"></label>

										<div style="height: 5px;">
										<h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
										</div>
										</div>
									</div>
								</div>


    </br>
  </br>
  </br>
  </br>
  </br>
    <center>
       <a id="btn-insert-reset" onclick="back()" class="btn btn-default" ><i class=""></i> Kembali</a>
       </center>
  </div>
`
	<div id="menu4" class="tab-pane fade">
      <h3>Menu 4</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>

	<div id="menuview5" class="tab-pane fade">
      <h3>Empty</h3>

    </div>

    <div id="menu6" class="tab-pane fade">
      <h3>Menu 6</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>

    <div id="menu7" class="tab-pane fade">
      <h3>Menu 7</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>

    <div id="menu8" class="tab-pane fade">
      <h3>Menu 8</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
  </div>

  </br>


		</div>
							</div>
						</div>
						</div>


					</div>










	 			</article>
	 			<!-- WIDGET END -->

	 		</div>






		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
						<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

						data-widget-colorbutton="false"
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true"
						data-widget-sortable="false"

						-->
							<header>
						<span class="widget-icon"> <i class="fa fa-table"></i> </span>
						<h2>Master Pelanggan </h2>
					</header>

					<!-- widget div-->
					<div>
					</br>
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body">

							<table  id="tableapi" class="tableapi table table-bordered" width="100%">

								<thead>
									<tr>
									<th class="hasinput" style="width:15%">

										</th>
										<th class="hasinput" style="width:5%">
											<input type="text" class="form-control" placeholder="Filter No" />
										</th>
										<th class="hasinput" style="width:9%">
											<input type="text" class="form-control" placeholder="Filter ID Pelanggan" />
										</th>
										<th class="hasinput" style="width:9%">
											<input type="text" class="form-control" placeholder="Filter Nama Pelanggan" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Nama Lengkap" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Handphone" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Email" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Telpon Kantor" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Fax" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Website" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Alamat" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Kota" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Kode Pos" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Provisi" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Negara" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Nama Kontak" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Jabatan" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Email Kontak" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Handphone" />
										</th>



									</tr>
									<tr>
										<th data-hide="action"><center>Aksi</center></th>
										<th data-hide="no"><center>No</center></th>
										<th data-hide="mcustomerid"><center>ID Pelanggan</center></th>
										<th data-hide="mcustomername"><center>Nama Pelanggan</center></th>
										<th data-hide="address"><center>Nama Lengkap</center></th>
										<th data-hide="phone"><center>Handphone</center></th>
										<th data-hide="mcustomeremail"><center>Email</center></th>
										<th data-hide="mcustomerphone"><center>Telpon Kantor</center></th>
										<th data-hide="mcustomerfax"><center>Fax</center></th>
										<th data-hide="mcustomerwebsite"><center>Website</center></th>
										<th data-hide="mcustomeraddress"><center>Alamat</center></th>
										<th data-hide="mcustomercity"><center>Kota</center></th>
										<th data-hide="mcustomerzipcode"><center>Kode Pos</center></th>
										<th data-hide="mcustomerprovince"><center>Provinsi</center></th>
										<th data-hide="mcustomercountry"><center>Negara</center></th>
										<th data-hide="mcustomercontactname"><center>Nama Kontak</center></th>
										<th data-hide="mcustomercontactposition"><center>Jabatan</center></th>
										<th data-hide="mcustomercontactemail"><center>Email Kontak</center></th>
										<th data-hide="mcustomercontactemailphone"><center>Handphone</center></th>

									</tr>
								</thead>
								<tbody>
								</tbody>

							</table>
							@push('scripts')
							<tfoot>
							<script>

							$(document).ready(function(){
								$('#disableforminput').prop('checked',true);
								$('#insert-mcustomerid').prop('disabled',true);
							});
			var table;
			$(function(){

			table = $('.tableapi').DataTable({
			 dom: "<'dtpadding' <'row' <'clmn' > <'srch' f> <'tablerow' l> <'clear'> <'masterbutton' B> r> <'row pb' tip>>",
            "autoWidth" : true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
								"sLengthMenu": "Show _MENU_ Entries",
								"sInfo": "Showing ( _START_ to _END_ ) to _TOTAL_ Entries"
            },
						"aoColumnDefs": [{ "bVisible": false, "aTargets": [6,7,8,9,10,11,12,13,14,15,16,17,18] }],
            buttons: [ {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18]
                }
            },
            {
                text: 'CSV',
                action: function(){
									window.location.href = "{{ url('/admin-nano/pelanggan/export/csv') }}"
								}
            },
            {
								text: 'Excel',
								action: function(){
									window.location.href = "{{ url('/admin-nano/pelanggan/export/excel') }}"
								}
            },
            {
								text: 'PDF',
								action: function(){
									window.location.href = "{{ url('/admin-nano/pelanggan/export/pdf') }}"
								}
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18] //setting kolom mana yg mau di print
                }

            },
						{
							extend: 'colvis',
							text:"Show / Hide Columns",
							columns: ':gt(1)'
						}
            ],

					       				processing: false,
										serverSide: false,
										ajax: '{{URL::to('/')}}/admin-api/pelanggan',
										columns: [
										{data: 'action', name:'action', searchable: false, orderable: false},
										{data: 'no', no: 'no' },
										{data: 'mcustomerid', mcustomerid: 'mcustomerid'},
										{data: 'mcustomername', mcustomername: 'mcustomername'},
										{data: 'mcustomeremail', mcustomeremail: 'mcustomeremail'},
										{data: 'mcustomerphone', mcustomerphone: 'mcustomerphone'},
										{data: 'mcustomeremail', mcustomeremail: 'mcustomeremail'},
										{data: 'mcustomerphone', mcustomerphone: 'mcustomerphone'},
										{data: 'mcustomerfax', mcustomerfax: 'mcustomerfax'},
										{data: 'mcustomerwebsite', mcustomerwebsite: 'mcustomerwebsite'},
										{data: 'mcustomeraddress', mcustomeraddress: 'mcustomeraddress'},
										{data: 'mcustomercity', mcustomercity: 'mcustomercity'},
										{data: 'mcustomerzipcode', mcustomerzipcode: 'mcustomerzipcode'},
										{data: 'mcustomerprovince', mcustomerprovince: 'mcustomerprovince'},
										{data: 'mcustomercountry', mcustomercountry: 'mcustomercountry'},
										{data: 'mcustomercontactname', mcustomercontactname: 'mcustomercontactname'},
										{data: 'mcustomercontactposition', mcustomercontactposition: 'mcustomercontactposition'},
										{data: 'mcustomercontactemail', mcustomercontactemail: 'mcustomercontactemail'},
										{data: 'mcustomercontactemailphone', mcustomercontactemailphone: 'mcustomercontactemailphone'},
										]
									});

								// table.on( 'order.dt search.dt', function () {
								// table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
								// cell.innerHTML = i+1;
								// 	} );
								// 	} ).draw();

					$(".table thead th input[type=text]").on( 'keyup change', function () {
		    		table
		            .column( $(this).parent().index()+':visible' )
		            .search( this.value )
		            .draw();

		    		} );

				});

			function refreshtbl(){
			table.ajax.reload();
			}

			$(document).ready(function(){
				var columnBtn = "<span>Show / Hide columns</span>";
				$('.ColVis_MasterButton').html(columnBtn);

			});


							</script>
							</tfoot>

							@endpush




						<script>
					 function popupdelete(id){
        					swal({
          					title: "Anda Yakin Akan Mengapus ?",
          					text: "Anda Tidak Dapat Mengembalikan Data Ini!",
          					type: "warning",   showCancelButton: true,
          					confirmButtonColor: "#DD6B55",
          					confirmButtonText: "Iya, Hapus!",
          					cancelButtonText: "Tidak, Batal!",
          					closeOnConfirm: false,
          					closeOnCancel: false
        					},
        					function(isconfirm){
        					  if (isconfirm) {
                      $.ajax({
                        type: "DELETE",
                        url: API_URL+"/pelanggan/"+id,
                        success: function(response){
                          console.log(response);
                          table.ajax.reload();
                          window.location = "#tableapi";
                          swal({
              						  title: "Terhapus!",
              						  text: "Data Anda Berhasil Terhapus.",
              						  type: "success",
            						  });
                          $('#forminput').show();
                    			$('#formview').hide();
                    			$('#formedit').hide();
                        },
                        error: function(response){
                          swal({
                    				title: "Pengubahan Gagal!",
                    				type: "error",
                    				timer: 1000
                    			});
                          window.location = "#tableapi";
                        }
                      });
        				  } else {
    						      swal({
            						title: "Batal Terhapus!",
            						text: "Data Anda Batal Terhapus.",
            						type: "error",
            						timer: 1000,
            						confirmButtonText: "Ok"
    						      });
    						      window.location = '#main';
					        }
					      });
					$(".sa-button-container").parent().find(".cancel").hover(
						function(){
							$(".sa-button-container").parent().find(".cancel").addClass("bg-red");
							$(".sa-confirm-button-container").parent().find(".confirm").addClass("bg-gray");
						},
						function(){
							$(".sa-confirm-button-container").parent().find(".confirm").removeClass("bg-gray");
							$(".sa-button-container").parent().find(".cancel").removeClass("bg-red");
						}
					);
					}

						</script>

					</div>


				</div>

				<!-- end widget -->

			</article>

		</div>

		<!-- end row -->

	</section>
	<!-- end widget grid -->

</div>
<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->



@stop
