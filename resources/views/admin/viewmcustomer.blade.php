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
                    <div class="row">
                      <h2></h2>
                      <ul class="nav nav-tabs" style="padding-left:10px;">
                       	<li class="active"><a data-toggle="tab" href="#menu1">Profil Pelanggan</a></li>
                       	<li><a data-toggle="tab" href="#menu2">Kontak</a></li>
                    	 	<li><a data-toggle="tab" href="#menu3">Kredit Limit</a></li>
                      </ul>
                      <div id="insert-wrapper" class="tab-content" data-parsley-validate>
                        <div id="menu1" class="tab-pane fade in active">
                          <div class="form-horizontal" style="margin-top:21px;">
                            <div class="col-md-6">
                              <div style="" class="form-group">
                          		  <label class="col-md-3 control-label"><b>ID Pelanggan</b> (<font color="red">*</font>) &nbsp  :</label>
                          			<div class="col-md-9">
                          			  <div class="icon-addon addon-md">
                          				  <div class="input-group">
                                		  <input id="insert-mcustomerid" value="" name="mcustomerid" class="form-control forminput" placeholder="AUTO GENERATE" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".errorBlock1" @if (Session::has('autofocus')) autofocus @endif >
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
															<div class="form-group" style="margin-top: 21px;">
																	<label class="col-md-3 control-label"><b>Kategori Pelanggan</b>  &nbsp  :</label>
																	<div class="col-md-9 col-sm-12">
																		<select class="select2 form-control" name="mcustomercategory" id="insert-mcustomercategory">
																			@foreach($categories as $cat)
																				<option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
																			@endforeach
																		</select>
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
              								</div>
                            </div>
                            <div class="col-md-6">
                              <div style="height: 21px;" class="form-group">
              									<label class="col-md-3 control-label"><b>Alamat Penagihan</b> &nbsp  :</label>
              									<div class="col-md-9 col-sm-12">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                											<textarea id="insert-mcustomeraddress" value="{{old('mcustomeraddress')}}" name="mcustomeraddress" class="form-control forminput" rows="5" placeholder="Jalan" type="text"  @if (Session::has('autofocus')) autofocus @endif ></textarea>
                											<label for="mgoodsgroup1" class="glyphicon glyphicon-road" rel="tooltip" title="Jalan"></label>
                										</div>
              										</div>
              									</div>
              								</div>
                              <div style="height: 21px;" class="form-group">
              									<div class="col-md-offset-3 col-md-5 col-sm-12" style="margin-top:10px;">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                											<input id="insert-mcustomercity" value="{{old('mcustomercity')}}" name="mcustomercity" class="form-control forminput" placeholder="Kota" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                										</div>
              										</div>
              									</div>
                                <div class="col-md-4 col-sm-12" style="margin-top:10px;">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                											<input id="insert-mcustomerzipcode" value="{{old('mcustomerzipcode')}}" name="mcustomerzipcode" class="form-control forminput" placeholder="K.Pos" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                										</div>
              										</div>
              									</div>
              								</div>
                              <div style="height: 21px;" class="form-group">
              									<div class="col-md-offset-3 col-md-9 col-sm-12" style="margin-top:9px;">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input id="insert-mcustomerprovince" value="{{old('mcustomerprovince')}}" name="mcustomerprovince" class="form-control forminput" placeholder="Provinsi " type="text"  @if (Session::has('autofocus')) autofocus @endif >
                											<label for="mgoodsgroup1" class="" rel="tooltip" title="Propinsi"></label>
                										</div>
              										</div>
              									</div>
              								</div>
                              <div style="height: 21px;" class="form-group">
              									<div class="col-md-offset-3 col-md-9 col-sm-12" style="margin-top:0px;">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input id="insert-mcustomercountry" value="{{old('mcustomercountry')}}" name="mcustomercountry" class="form-control forminput" placeholder="Negara" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                											<label for="mgoodsgroup1" class="" rel="tooltip" title="Negara"></label>
                										</div>
              										</div>
              									</div>
              								</div>
                            <div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                      <div class="form form-horizontal" style="margin-top:21px;">
                        <div class="col-md-12">
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Nama Lengkap</b>  &nbsp  :</label>
                            <div class="col-md-4 col-sm-12">
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
                          <div style="height: 21px;" class="form-group">
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
                        </div>
                      </div>
                    </div>
                    <div id="menu3" class="tab-pane fade">
                      <div class="form form-horizontal" style="margin-top:21px;">
                        <div class="col-md-12">
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Limit</b>  &nbsp  :</label>
                            <div class="col-md-4 col-sm-12">
                              <div class="icon-addon addon-md">
          											<input id="insert-mcustomerarlimit" value="0" name="mcustomerarlimit" class="form-control forminput" placeholder="Limit" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Limit"></label>
          										</div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Akun</b>  &nbsp  :</label>
          									<div class="col-md-4">
          										<div class="icon-addon addon-md">
          											<select class="form-control select2" name="mcustomercoa" id="insert-mcustomercoa">
                                  @foreach($mcoa as $coa)
                                    @if($coa->id == 8)
                                      <option selected value="{{ $coa->id }}">{{ $coa->mcoaname }}</option>
                                    @else
                                      <option value="{{ $coa->id }}">{{ $coa->mcoaname }}</option>
                                    @endif
                                  @endforeach
                                </select>
          										</div>
          									</div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Pembayaran</b>  &nbsp  :</label>
          									<div class="col-md-4">
          										<div class="icon-addon addon-md">
          											<select class="form-control select2" name="mcustomercoatop" id="insert-mcustomertop">
                                  <option value="cash">Cash</option>
                                  <option selected value="credit">Credit</option>
                                </select>
          										</div>
          									</div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Maksimal Nota</b>  &nbsp  :</label>
          									<div  class="col-md-4">
          										<div class="icon-addon addon-md">
          											<input id="insert-mcustomerarmax" value="{{old('mcustomercontactemailphone')}}" name="mcustomerarmax" class="form-control forminput" placeholder="Maksimal Nota" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Maksimal Nota"></label>
          										</div>
          									</div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                         {{--    <label class="col-md-2 control-label"><b>Default TOP</b>  &nbsp  :</label>
          									<div  class="col-md-4">
          										<div class="icon-addon addon-md">
          											<input id="insert-mcustomerdefaultar" value="0" name="mcustomerdefaultar" class="form-control forminput" placeholder="Default" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Maksimal Nota"></label>
          										</div>
          									</div> --}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="menu4"></div>
                    <div class="row">
                      <div class="col-md-offset-5 col-md-5" style="margin-top:20px;margin-bottom:20px;">
                        <button onclick="insertmcustomer()" type="submit" name="button" class="btn btn-primary">Simpan</button>
                				<a id="btn-insert-reset" onclick="resetcustomer()" class="btn btn-default" ><i class=""></i> Reset</a>
                      </div>
                    </div>
							    </div>
	 					  </div>
	 				  </div>
          </div>
        </article>
      </div>

      <div class="row">
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<!-- Widget ID (each widget will need unique ID)-->
					<div id="formedit" style="display:none;margin-bottom:50px;" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
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
							<div class="widget-body no-padding">
							    <div class="container">
                    <div class="row">
                      <h2></h2>
                      <ul class="nav nav-tabs" style="padding-left:10px;">
                       	<li class="active"><a data-toggle="tab" href="#editmenu1">Profil Pelanggan</a></li>
                       	<li><a data-toggle="tab" href="#editmenu2">Kontak</a></li>
                    	 	<li><a data-toggle="tab" href="#editmenu3">Kredit Limit</a></li>
                      </ul>
                      <div class="tab-content">
                        <div id="editmenu1" class="tab-pane fade in active">
                          <div id="edit-wrapper" class="form-horizontal" style="margin-top:21px;" data-parsley-validate>
                            <div class="col-md-6">
                              <input type="hidden" id="edit-idmcustomerid">
                              <div style="" class="form-group">
                          		  <label class="col-md-3 control-label"><b>ID Pelanggan</b> (<font color="red">*</font>) &nbsp  :</label>
                          			<div class="col-md-9">
                          			  <div class="icon-addon addon-md">
                          				  <div class="input-group">
                                		  <input id="edit-mcustomerid" value="{{old('mcustomerid')}}" name="mcustomerid" class="form-control forminput" placeholder="AUTO GENERATE" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".errorBlock3" @if (Session::has('autofocus')) autofocus @endif >
                                			<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Pelanggan"></label>
                                			<span class="input-group-addon" style="background: none;">
                                  		  <input type="checkbox" id="disableforminput" name="autogen" rel="tooltip" title="ON/OFF auto generate ID Pelanggan">
                                			</span>
                              			</div>
                              		</div>
                          			</div>
                              </div>
                              <div class="errorBlock3" style="margin-left:23% !important;"></div>
                              <div style="height: 21px;" class="form-group">
              									<label class="col-md-3 control-label"><b>Nama Pelanggan</b> (<font color="red">*</font>) &nbsp  :</label>
              									<div class="col-md-9 col-sm-12">
              										<div class="icon-addon addon-md">
              											<input id="edit-mcustomername" value="{{old('mcustomername')}}" name="mcustomername" class="form-control forminput" placeholder="Nama Pelanggan" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" data-parsley-errors-container=".errorBlock4" @if (Session::has('autofocus')) autofocus @endif>
              											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Pelanggan"></label>
              										</div>
              									</div>
              								</div>
															<div class="form-group" style="margin-top: 21px;">
																	<label class="col-md-3 control-label"><b>Kategori Pelanggan</b>  &nbsp  :</label>
																	<div class="col-md-9 col-sm-12">
																		<select class="select2 form-control" name="mcustomercategory" id="edit-mcustomercategory">
																			@foreach($categories as $cat)
																				<option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
																			@endforeach
																		</select>
																	</div>
															</div>
                              <div class="errorBlock4" style="margin-left:23% !important;"></div>
              								<div style="height: 21px;" class="form-group">
              									<label class="col-md-3 control-label"><b>Email</b> &nbsp  :</label>
              									<div class="col-md-9 col-sm-12">
              										<div class="icon-addon addon-md">
              											<input id="edit-mcustomeremail" value="{{old('mcustomeremail')}}" name="mcustomeremail" class="form-control forminput" placeholder="Email" type="text"  @if (Session::has('autofocus')) autofocus @endif >
              											<label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
              										</div>
              									</div>
              								</div>
                              <div class="form-group">
              									<label class="col-md-3 control-label"><b>Telepon Kantor</b>  &nbsp  :</label>
              									<div  class="col-md-9 col-sm-12">
              										<div class="icon-addon addon-md">
              											<input id="edit-mcustomerphone" value="{{old('mcustomerphone')}}" name="mcustomerphone" class="form-control forminput phoneexample phoneregex" placeholder="Telepon Kantor" type="text" @if (Session::has('autofocus')) autofocus @endif >
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
              											<input id="edit-mcustomerfax" value="{{old('mcustomerfax')}}" name="mcustomerfax" class="form-control forminput phoneregex" placeholder="Fax Kantor" type="text" @if (Session::has('autofocus')) autofocus @endif >
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
              											<input id="edit-mcustomerwebsite" value="{{old('mcustomerwebsite')}}" name="mcustomerwebsite" class="form-control forminput" placeholder="Website" type="text"  @if (Session::has('autofocus')) autofocus @endif >
              											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Website"></label>
              										</div>
              									</div>
              								</div>
                            </div>
                            <div class="col-md-6">
                              <div style="height: 21px;" class="form-group">
              									<label class="col-md-3 control-label"><b>Alamat Penagihan</b> &nbsp  :</label>
              									<div class="col-md-9 col-sm-12">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                											<textarea id="edit-mcustomeraddress" value="{{old('mcustomeraddress')}}" name="mcustomeraddress" class="form-control forminput" rows="5" placeholder="Jalan" type="text"  @if (Session::has('autofocus')) autofocus @endif ></textarea>
                											<label for="mgoodsgroup1" class="glyphicon glyphicon-road" rel="tooltip" title="Jalan"></label>
                										</div>
              										</div>
              									</div>
              								</div>
                              <div style="height: 21px;" class="form-group">
              									<div class="col-md-offset-3 col-md-5 col-sm-12" style="margin-top:10px;">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                											<input id="edit-mcustomercity" value="{{old('mcustomercity')}}" name="mcustomercity" class="form-control forminput" placeholder="Kota" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                										</div>
              										</div>
              									</div>
                                <div class="col-md-4 col-sm-12" style="margin-top:10px;">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                											<input id="edit-mcustomerzipcode" value="{{old('mcustomerzipcode')}}" name="mcustomerzipcode" class="form-control forminput" placeholder="K.Pos" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                										</div>
              										</div>
              									</div>
              								</div>
                              <div style="height: 21px;" class="form-group">
              									<div class="col-md-offset-3 col-md-9 col-sm-12" style="margin-top:9px;">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input id="edit-mcustomerprovince" value="{{old('mcustomerprovince')}}" name="mcustomerprovince" class="form-control forminput" placeholder="Provinsi " type="text"  @if (Session::has('autofocus')) autofocus @endif >
                											<label for="mgoodsgroup1" class="" rel="tooltip" title="Propinsi"></label>
                										</div>
              										</div>
              									</div>
              								</div>
                              <div style="height: 21px;" class="form-group">
              									<div class="col-md-offset-3 col-md-9 col-sm-12" style="margin-top:0px;">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input id="edit-mcustomercountry" value="{{old('mcustomercountry')}}" name="mcustomercountry" class="form-control forminput" placeholder="Negara" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                											<label for="mgoodsgroup1" class="" rel="tooltip" title="Negara"></label>
                										</div>
              										</div>
              									</div>
              								</div>
                            <div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="editmenu2" class="tab-pane fade">
                      <div class="form form-horizontal" style="margin-top:21px;">
                        <div class="col-md-12">
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Nama Lengkap</b>  &nbsp  :</label>
                            <div class="col-md-4 col-sm-12">
                              <div class="icon-addon addon-md">
          											<input id="edit-mcustomercontactname" value="{{old('mcustomercontactname')}}" name="mcustomercontactname" class="form-control forminput" placeholder="Nama Lengkap" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Lengkap"></label>
          										</div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Posisi Jabatan</b>  &nbsp  :</label>
          									<div class="col-md-4">
          										<div class="icon-addon addon-md">
          											<input id="edit-mcustomercontactposition" value="{{old('mcustomercontactposition')}}" name="mcustomercontactposition" class="form-control forminput" placeholder="Posisi Jabatan" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon glyphicon-user" rel="tooltip" title="Posisi Jabatan"></label>
          										</div>
          									</div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Email</b>  &nbsp  :</label>
          									<div class="col-md-4">
          										<div class="icon-addon addon-md">
          											<input id="edit-mcustomercontactemail" value="{{old('mcustomercontactemail')}}" name="mcustomercontactemail" class="form-control forminput" placeholder="Email" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
          										</div>
          									</div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Handphone</b>  &nbsp  :</label>
          									<div  class="col-md-4">
          										<div class="icon-addon addon-md">
          											<input id="edit-mcustomercontactemailphone" value="{{old('mcustomercontactemailphone')}}" name="mcustomercontactemailphone" class="form-control forminput mobileregex" placeholder="Handphone" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Handphone"></label>
            										<div style="height: 5px;">
            										  <h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
            										</div>
          										</div>
          									</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="editmenu3" class="tab-pane fade">
                      <div class="form form-horizontal" style="margin-top:21px;">
                        <div class="col-md-12">
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Limit</b>  &nbsp  :</label>
                            <div class="col-md-4 col-sm-12">
                              <div class="icon-addon addon-md">
          											<input id="edit-mcustomerarlimit" value="0" name="mcustomerarlimit" class="form-control forminput" placeholder="Limit" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Limit"></label>
          										</div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Akun</b>  &nbsp  :</label>
          									<div class="col-md-4">
          										<div class="icon-addon addon-md">
          											<select class="form-control select2" name="mcustomercoa" id="edit-mcustomercoa">
                                  @foreach($mcoa as $coa)
                                    @if($coa->id == 8)
                                      <option selected value="{{ $coa->id }}">{{ $coa->mcoaname }}</option>
                                    @else
                                      <option value="{{ $coa->id }}">{{ $coa->mcoaname }}</option>
                                    @endif
                                  @endforeach
                                </select>
          										</div>
          									</div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Pembayaran</b>  &nbsp  :</label>
          									<div class="col-md-4">
          										<div class="icon-addon addon-md">
          											<select class="form-control select2" name="mcustomercoatop" id="edit-mcustomertop">
                                  <option value="cash">Cash</option>
                                  <option selected value="credit">Credit</option>
                                </select>
          										</div>
          									</div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Maksimal Nota</b>  &nbsp  :</label>
          									<div  class="col-md-4">
          										<div class="icon-addon addon-md">
          											<input id="edit-mcustomerarmax" value="{{old('mcustomercontactemailphone')}}" name="mcustomerarmax" class="form-control forminput" placeholder="Maksimal Nota" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Maksimal Nota"></label>
          										</div>
          									</div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                         {{--    <label class="col-md-2 control-label"><b>Default TOP</b>  &nbsp  :</label>
          									<div  class="col-md-4">
          										<div class="icon-addon addon-md">
          											<input id="edit-mcustomerdefaultar" value="0" name="mcustomerdefaultar" class="form-control forminput" placeholder="Default" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Maksimal Nota"></label>
          										</div>
          									</div> --}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="editmenu4"></div>
                    <div class="row">
                      <div class="col-md-offset-5 col-md-5" style="margin-top:20px;margin-bottom:20px;">
                        <button onclick="updatemcustomer()" type="submit" name="button" class="btn btn-primary">Simpan</button>
                				<a id="btn-insert-reset" onclick="resetcustomer()" class="btn btn-default" ><i class=""></i> Reset</a>
                      </div>
                    </div>
							    </div>
	 					  </div>
	 				  </div>
          </div>
        </article>
      </div>

      <div class="row">
        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <!-- Widget ID (each widget will need unique ID)-->
          <div id="formview" style="display:none;margin-bottom:90px;" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
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
                    <div class="row">
                      <h2></h2>
                      <ul class="nav nav-tabs" style="padding-left:10px;">
                        <li class="active"><a data-toggle="tab" href="#viewmenu1">Profil Pelanggan</a></li>
                        <li><a data-toggle="tab" href="#viewmenu2">Kontak</a></li>
                        <li><a data-toggle="tab" href="#viewmenu3">Kredit Limit</a></li>
                      </ul>
                      <div id="insert-wrapper" class="tab-content" data-parsley-validate>
                        <div id="viewmenu1" class="tab-pane fade in active">
                          <div class="form-horizontal" style="margin-top:21px;">
                            <div class="col-md-6">
                              <div style="" class="form-group">
                                <label class="col-md-3 control-label"><b>ID Pelanggan</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-9">
                                  <div class="icon-addon addon-md">
                                    <div class="input-group">
                                      <input disabled id="view-mcustomerid" value="{{old('mcustomerid')}}" name="mcustomerid" class="form-control forminput" placeholder="AUTO GENERATE" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".errorBlock5" @if (Session::has('autofocus')) autofocus @endif >
                                      <label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Pelanggan"></label>
                                      <span class="input-group-addon" style="background: none;">
                                        <input disabled type="checkbox" id="disableforminput" name="autogen" rel="tooltip" title="ON/OFF auto generate ID Pelanggan">
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="errorBlock5" style="margin-left:23% !important;"></div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Nama Pelanggan</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-mcustomername" value="{{old('mcustomername')}}" name="mcustomername" class="form-control forminput" placeholder="Nama Pelanggan" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" data-parsley-errors-container=".errorBlock6" @if (Session::has('autofocus')) autofocus @endif>
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Pelanggan"></label>
                                  </div>
                                </div>
                              </div>
															<div class="form-group" style="margin-top: 21px;">
																	<label class="col-md-3 control-label"><b>Kategori Pelanggan</b>  &nbsp  :</label>
																	<div class="col-md-9 col-sm-12">
																		<select disabled class="select2 form-control" name="mcustomercategory" id="view-mcustomercategory">
																			@foreach($categories as $cat)
																				<option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
																			@endforeach
																		</select>
																	</div>
															</div>
                              <div class="errorBlock6" style="margin-left:23% !important;"></div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Email</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-mcustomeremail" value="{{old('mcustomeremail')}}" name="mcustomeremail" class="form-control forminput" placeholder="Email" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Telepon Kantor</b>  &nbsp  :</label>
                                <div  class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-mcustomerphone" value="{{old('mcustomerphone')}}" name="mcustomerphone" class="form-control forminput phoneexample phoneregex" placeholder="Telepon Kantor" type="text" @if (Session::has('autofocus')) autofocus @endif >
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
                                    <input disabled id="view-mcustomerfax" value="{{old('mcustomerfax')}}" name="mcustomerfax" class="form-control forminput phoneregex" placeholder="Fax Kantor" type="text" @if (Session::has('autofocus')) autofocus @endif >
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
                                    <input disabled id="view-mcustomerwebsite" value="{{old('mcustomerwebsite')}}" name="mcustomerwebsite" class="form-control forminput" placeholder="Website" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Website"></label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Alamat Penagihan</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <textarea disabled id="view-mcustomeraddress" value="{{old('mcustomeraddress')}}" name="mcustomeraddress" class="form-control forminput" rows="5" placeholder="Jalan" type="text"  @if (Session::has('autofocus')) autofocus @endif ></textarea>
                                      <label for="mgoodsgroup1" class="glyphicon glyphicon-road" rel="tooltip" title="Jalan"></label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <div class="col-md-offset-3 col-md-5 col-sm-12" style="margin-top:20px;">
                                  <div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input disabled id="view-mcustomercity" value="{{old('mcustomercity')}}" name="mcustomercity" class="form-control forminput" placeholder="Kota" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-4 col-sm-12" style="margin-top:20px;">
                                  <div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input disabled id="view-mcustomerzipcode" value="{{old('mcustomerzipcode')}}" name="mcustomerzipcode" class="form-control forminput" placeholder="K.Pos" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <div class="col-md-offset-3 col-md-9 col-sm-12" style="margin-top:9px;">
                                  <div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input disabled id="view-mcustomerprovince" value="{{old('mcustomerprovince')}}" name="mcustomerprovince" class="form-control forminput" placeholder="Provinsi " type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                      <label for="mgoodsgroup1" class="" rel="tooltip" title="Propinsi"></label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <div class="col-md-offset-3 col-md-9 col-sm-12" style="margin-top:0px;">
                                  <div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input disabled id="view-mcustomercountry" value="{{old('mcustomercountry')}}" name="mcustomercountry" class="form-control forminput" placeholder="Negara" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                      <label for="mgoodsgroup1" class="" rel="tooltip" title="Negara"></label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="viewmenu2" class="tab-pane fade">
                      <div class="form form-horizontal" style="margin-top:21px;">
                        <div class="col-md-12">
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Nama Lengkap</b>  &nbsp  :</label>
                            <div class="col-md-4 col-sm-12">
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
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Handphone</b>  &nbsp  :</label>
                            <div  class="col-md-4">
                              <div class="icon-addon addon-md">
                                <input disabled id="view-mcustomercontactemailphone" value="{{old('mcustomercontactemailphone')}}" name="mcustomercontactemailphone" class="form-control forminput mobileregex" placeholder="Handphone" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Handphone"></label>
                                <div style="height: 5px;">
                                  <h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="viewmenu3" class="tab-pane fade">
                      <div class="form form-horizontal" style="margin-top:21px;">
                        <div class="col-md-12">
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Limit</b>  &nbsp  :</label>
                            <div class="col-md-4 col-sm-12">
                              <div class="icon-addon addon-md">
                                <input disabled id="view-mcustomerarlimit" value="0" name="mcustomerarlimit" class="form-control forminput" placeholder="Limit" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Limit"></label>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Akun</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select disabled class="form-control select2" name="mcustomercoa" id="view-mcustomercoa">
                                  @foreach($mcoa as $coa)
                                    @if($coa->id == 8)
                                      <option selected value="{{ $coa->id }}">{{ $coa->mcoaname }}</option>
                                    @else
                                      <option value="{{ $coa->id }}">{{ $coa->mcoaname }}</option>
                                    @endif
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Pembayaran</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select disabled class="form-control select2" name="mcustomercoatop" id="view-mcustomertop">
                                  <option value="cash">Cash</option>
                                  <option selected value="credit">Credit</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Maksimal Nota</b>  &nbsp  :</label>
                            <div  class="col-md-4">
                              <div class="icon-addon addon-md">
                                <input disabled id="view-mcustomerarmax" value="{{old('mcustomercontactemailphone')}}" name="mcustomerarmax" class="form-control forminput" placeholder="Maksimal Nota" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Maksimal Nota"></label>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                           {{--  <label class="col-md-2 control-label"><b>Default TOP</b>  &nbsp  :</label>
                            <div  class="col-md-4">
                              <div class="icon-addon addon-md">
                                <input disabled id="view-mcustomerdefaultar" value="0" name="mcustomerdefaultar" class="form-control forminput" placeholder="Default" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Maksimal Nota"></label>
                              </div>
                            </div> --}}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="viewmenu4"></div>
                    <div class="row">
                      <div class="col-md-offset-6 col-md-5" style="margin-top:20px;margin-bottom:20px;">
                        <a id="btn-insert-reset" onclick="backcustomer()" class="btn btn-default" ><i class=""></i> Kembali</a>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </article>
      </div>

      <div class="row">
        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <!-- Widget ID (each widget will need unique ID)-->
          <div id="" style="margin-top:-50px;" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
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
              <!-- widget content -->
              <div class="widget-body no-padding" style="margin-top: 30px !important;">
                  <div class="container">
                    <table id="tableapi" class="tableapi table table-bordered" width="100%">
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
													<th class="hasinput" style="width:9%">
      											<input type="text" class="form-control" placeholder="Filter Kategori Pelanggan" />
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
													<th class="hasinput" style="width:10%">
      											<input type="text" class="form-control" placeholder="Filter Limit" />
      										</th>
													<th class="hasinput" style="width:10%">
      											<input type="text" class="form-control" placeholder="Filter Akun" />
      										</th>
													<th class="hasinput" style="width:10%">
      											<input type="text" class="form-control" placeholder="Filter TOP" />
      										</th>
													<th class="hasinput" style="width:10%">
      											<input type="text" class="form-control" placeholder="Filter Maksimal Nota" />
      										</th>
													<th class="hasinput" style="width:10%">
      											<input type="text" class="form-control" placeholder="Filter Default" />
      										</th>
      									</tr>
      									<tr>
      										<th data-hide="action"><center>Aksi</center></th>
      										<th data-hide="no"><center>No</center></th>
      										<th data-hide="mcustomerid"><center>ID Pelanggan</center></th>
      										<th data-hide="mcustomername"><center>Nama Pelanggan</center></th>
													<th data-hide="mcustomercategory"><center>Kategori Pelanggan</center></th>
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
													<th data-hide="mcustomerarlimit"><center>Limit</center></th>
													<th data-hide="akun"><center>Akun</center></th>
													<th data-hide="mcustomertop"><center>TOP</center></th>
													<th data-hide="mcustomerarmax"><center>Maksimal Nota</center></th>
													<th data-hide="mcustomerdefaultar"><center>Default</center></th>
      									</tr>
      								</thead>
                    </table>
                  </div>
              </div>
            </div>
          </div>
        </article>
      </div>
	  </section>
  </div>
<!-- END MAIN CONTENT -->
</div>
<!-- END MAIN PANEL -->
<div id="loading_modal" class="modal" style="top: 20%;" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="text-align: center">
				<h3>Loading Data</h3>
				<img src="{{ url('master/ajax-loader.gif') }}">
			</div>
		</div>
	</div>
</div>

@stop

@section('js')
<script>
  $(document).ready(function(){
    $('#disableforminput').prop('checked',true);
    $('#insert-mcustomerid').prop('disabled',true);
  });
  var table;
  $(function(){
    table = $('.tableapi')
		.on('preXhr.dt',function(){
			$('#loading_modal').modal('show');
		})
		.DataTable({
    dom: "<'dtpadding' <'row' <'clmn' > <'srch' f> <'tablerow' l> <'clear'> <'masterbutton' B> r> <'row pb' tip>>",
        "autoWidth" : true,
        "oLanguage": {
            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
            "sLengthMenu": "Show _MENU_ Entries",
            "sInfo": "Showing ( _START_ to _END_ ) to _TOTAL_ Entries"
        },
        "aoColumnDefs": [{ "bVisible": false, "aTargets": [4,5,6,7,9,10,11,12,13,14,15,17,18,19,20,21,22] }],
        buttons: [ {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22]
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
                columns: [ 0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21] //setting kolom mana yg mau di print
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
								{data: 'category', category: 'category'},
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
								{data: 'mcustomerarlimit', mcustomerarlimit: 'mcustomerarlimit'},
								{data: 'akun', akun: 'akun'},
								{data: 'mcustomertop', mcustomertop: 'mcustomertop'},
								{data: 'mcustomerarmax', mcustomerarmax: 'mcustomerarmax'},
								{data: 'mcustomerdefaultar', mcustomerdefaultar: 'mcustomerdefaultar'},
                ]
              }).on('xhr.dt',function(){
								$('#loading_modal').modal('hide');
							});
      $(".table thead th input[type=text]").on( 'keyup change', function () {
        table
            .column( $(this).parent().index()+':visible' )
            .search( this.value )
            .draw();
        } );
    });
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
                timer: 1000
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
@stop

@section('css')
  <style>
    .tableapi_wrapper {
      margin-top: 50px;
    }
		#tableapi {
			border: 1px solid #ddd !important;
		}
  </style>
@stop
