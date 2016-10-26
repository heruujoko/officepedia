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
			<li>Home</li><li>Supplier</li><li>Data Supplier</li>
		</ol>
	</div>
	<!-- END RIBBON -->
	<!-- MAIN CONTENT -->
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa fa-table fa-fw "></i>
						Supplier
					<span>
						Data Supplier
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
							<h2>Master Supplier </h2>
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
                       	<li class="active"><a data-toggle="tab" href="#menu1">Profil Supplier</a></li>
                       	<li><a data-toggle="tab" href="#menu2">Kontak</a></li>
                    	 	<li><a data-toggle="tab" href="#menu3">Kredit Limit</a></li>
                        <li><a data-toggle="tab" href="#menu4">Pajak</a></li>
                      </ul>
                      <div id="insert-wrapper" class="tab-content" data-parsley-validate>
                        <div id="menu1" class="tab-pane fade in active">
                          <div class="form-horizontal" style="margin-top:21px;">
                            <div class="col-md-6">
                              <div style="" class="form-group">
                          		  <label class="col-md-3 control-label"><b>ID Supplier</b> (<font color="red">*</font>) &nbsp  :</label>
                          			<div class="col-md-9">
                          			  <div class="icon-addon addon-md">
                          				  <div class="input-group">
                                		  <input id="insert-msupplierid" value="" name="msupplierid" class="form-control forminput" placeholder="AUTO GENERATE" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".errorBlock1" @if (Session::has('autofocus')) autofocus @endif >
                                			<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Supplier"></label>
                                			<span class="input-group-addon" style="background: none;">
                                  		  <input type="checkbox" id="disableforminputspl" name="autogen" rel="tooltip" title="ON/OFF auto generate ID Supplier">
                                			</span>
                              			</div>
                              		</div>
                          			</div>
                              </div>
                              <div class="errorBlock1" style="margin-left:23% !important;"></div>
                              <div style="height: 21px;" class="form-group">
              									<label class="col-md-3 control-label"><b>Nama Supplier</b> (<font color="red">*</font>) &nbsp  :</label>
              									<div class="col-md-9 col-sm-12">
              										<div class="icon-addon addon-md">
              											<input id="insert-msuppliername" value="{{old('msuppliername')}}" name="msuppliername" class="form-control forminput" placeholder="Nama Supplier" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" data-parsley-errors-container=".errorBlock2" @if (Session::has('autofocus')) autofocus @endif>
              											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Supplier"></label>
              										</div>
              									</div>
              								</div>
															<div style="margin-top: 21px;" class="form-group">
              									<label class="col-md-3 control-label"><b>Kategori Supplier</b>  &nbsp  :</label>
              									<div class="col-md-9 col-sm-12">
              										<div class="icon-addon addon-md">
              											<select class="form-control select2" id="insert-msuppliercategory" name="msuppliercategory">
																			@foreach($categories as $cat)
																				<option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
																			@endforeach
																		</select>
              										</div>
              									</div>
              								</div>
                              <div class="errorBlock2" style="margin-left:23% !important;"></div>
              								<div style="height: 21px;" class="form-group">
              									<label class="col-md-3 control-label"><b>Email</b> &nbsp  :</label>
              									<div class="col-md-9 col-sm-12">
              										<div class="icon-addon addon-md">
              											<input id="insert-msupplieremail" value="{{old('msupplieremail')}}" name="msupplieremail" class="form-control forminput" placeholder="Email" type="text"  @if (Session::has('autofocus')) autofocus @endif >
              											<label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
              										</div>
              									</div>
              								</div>
                              <div class="form-group">
              									<label class="col-md-3 control-label"><b>Telepon Kantor</b>  &nbsp  :</label>
              									<div  class="col-md-9 col-sm-12">
              										<div class="icon-addon addon-md">
              											<input id="insert-msupplierphone" value="{{old('msupplierphone')}}" name="msupplierphone" class="form-control forminput phoneexample phoneregex" placeholder="Telepon Kantor" type="text" @if (Session::has('autofocus')) autofocus @endif >
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
              											<input id="insert-msupplierfax" value="{{old('msupplierfax')}}" name="msupplierfax" class="form-control forminput phoneregex" placeholder="Fax Kantor" type="text" @if (Session::has('autofocus')) autofocus @endif >
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
              											<input id="insert-msupplierwebsite" value="{{old('msupplierwebsite')}}" name="msupplierwebsite" class="form-control forminput" placeholder="Website" type="text"  @if (Session::has('autofocus')) autofocus @endif >
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
                											<textarea id="insert-msupplieraddress" value="{{old('msupplieraddress')}}" name="msupplieraddress" class="form-control forminput" rows="5" placeholder="Jalan" type="text"  @if (Session::has('autofocus')) autofocus @endif ></textarea>
                											<label for="mgoodsgroup1" class="glyphicon glyphicon-road" rel="tooltip" title="Jalan"></label>
                										</div>
              										</div>
              									</div>
              								</div>
                              <div style="height: 21px;" class="form-group">
              									<div class="col-md-offset-3 col-md-5 col-sm-12" style="margin-top:20px;">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                											<input id="insert-msuppliercity" value="{{old('msuppliercity')}}" name="msuppliercity" class="form-control forminput" placeholder="Kota" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                										</div>
              										</div>
              									</div>
                                <div class="col-md-4 col-sm-12" style="margin-top:20px;">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                											<input id="insert-msupplierzipcode" value="{{old('msupplierzipcode')}}" name="msupplierzipcode" class="form-control forminput" placeholder="K.Pos" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                										</div>
              										</div>
              									</div>
              								</div>
                              <div style="height: 21px;" class="form-group">
              									<div class="col-md-offset-3 col-md-9 col-sm-12" style="margin-top:20px;">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input id="insert-msupplierprovince" value="{{old('msupplierprovince')}}" name="msupplierprovince" class="form-control forminput" placeholder="Provinsi " type="text"  @if (Session::has('autofocus')) autofocus @endif >
                											<label for="mgoodsgroup1" class="glyphicon glyphicon-star" rel="tooltip" title="Propinsi"></label>
                										</div>
              										</div>
              									</div>
              								</div>
                              <div style="height: 21px;" class="form-group">
              									<div class="col-md-offset-3 col-md-9 col-sm-12" style="margin-top:20px;">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input id="insert-msuppliercountry" value="{{old('msuppliercountry')}}" name="msuppliercountry" class="form-control forminput" placeholder="Negara" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                											<label for="mgoodsgroup1" class="glyphicon glyphicon-star" rel="tooltip" title="Negara"></label>
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
          											<input id="insert-msuppliercontactname" value="{{old('msuppliercontactname')}}" name="msuppliercontactname" class="form-control forminput" placeholder="Nama Lengkap" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Lengkap"></label>
          										</div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Posisi Jabatan</b>  &nbsp  :</label>
          									<div class="col-md-4">
          										<div class="icon-addon addon-md">
          											<input id="insert-msuppliercontactposition" value="{{old('msuppliercontactposition')}}" name="msuppliercontactposition" class="form-control forminput" placeholder="Posisi Jabatan" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon glyphicon-user" rel="tooltip" title="Posisi Jabatan"></label>
          										</div>
          									</div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Email</b>  &nbsp  :</label>
          									<div class="col-md-4">
          										<div class="icon-addon addon-md">
          											<input id="insert-msuppliercontactemail" value="{{old('msuppliercontactemail')}}" name="msuppliercontactemail" class="form-control forminput" placeholder="Email" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
          										</div>
          									</div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Handphone</b>  &nbsp  :</label>
          									<div  class="col-md-4">
          										<div class="icon-addon addon-md">
          											<input id="insert-msuppliercontactemailphone" value="{{old('msuppliercontactemailphone')}}" name="msuppliercontactemailphone" class="form-control forminput mobileregex" placeholder="Handphone" type="text" @if (Session::has('autofocus')) autofocus @endif >
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
          											<input id="insert-msupplierarlimit" value="0" name="msupplierarlimit" class="form-control forminput" placeholder="Limit" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Limit"></label>
          										</div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Akun</b>  &nbsp  :</label>
          									<div class="col-md-4">
          										<div class="icon-addon addon-md">
          											<select class="form-control select2-bold" name="msuppliercoa" id="insert-msuppliercoa">
                                  @foreach($mcoa as $coa)
                                    @if($coa->id == 8)
                                      <option selected value="{{ $coa->id }}">{{ $coa->mcoacode }} {{ $coa->mcoaname }}</option>
                                    @else
                                      <option value="{{ $coa->id }}">{{ $coa->mcoacode }} {{ $coa->mcoaname }}</option>
                                    @endif
                                  @endforeach
                                </select>
          										</div>
          									</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="menu4"></div>
                    <div class="row">
                      <div class="col-md-offset-5 col-md-5" style="margin-top:20px;margin-bottom:20px;">
                        <button onclick="insertmsupplier()" type="submit" name="button" class="btn btn-primary">Simpan</button>
                				<a id="btn-insert-reset" onclick="resetmsupplier()" class="btn btn-default" ><i class=""></i> Reset</a>
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
							<h2>Master Supplier </h2>
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
                       	<li class="active"><a data-toggle="tab" href="#editmenu1">Profil Supplier</a></li>
                       	<li><a data-toggle="tab" href="#editmenu2">Kontak</a></li>
                    	 	<li><a data-toggle="tab" href="#editmenu3">Kredit Limit</a></li>
                        <li><a data-toggle="tab" href="#editmenu4">Pajak</a></li>
                      </ul>
                      <div class="tab-content">
                        <div id="editmenu1" class="tab-pane fade in active">
                          <div id="edit-wrapper" class="form-horizontal" style="margin-top:21px;" data-parsley-validate>
                            <div class="col-md-6">
                              <input type="hidden" id="edit-idmsupplierid">
                              <div style="" class="form-group">
                          		  <label class="col-md-3 control-label"><b>ID Supplier</b> (<font color="red">*</font>) &nbsp  :</label>
                          			<div class="col-md-9">
                          			  <div class="icon-addon addon-md">
                          				  <div class="input-group">
                                		  <input id="edit-msupplierid" value="{{old('msupplierid')}}" name="msupplierid" class="form-control forminput" placeholder="AUTO GENERATE" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".errorBlock3" @if (Session::has('autofocus')) autofocus @endif >
                                			<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Supplier"></label>
                                			<span class="input-group-addon" style="background: none;">
                                  		  <input type="checkbox" id="disableforminput" name="autogen" rel="tooltip" title="ON/OFF auto generate ID Supplier">
                                			</span>
                              			</div>
                              		</div>
                          			</div>
                              </div>
                              <div class="errorBlock3" style="margin-left:23% !important;"></div>
                              <div style="height: 21px;" class="form-group">
              									<label class="col-md-3 control-label"><b>Nama Supplier</b> (<font color="red">*</font>) &nbsp  :</label>
              									<div class="col-md-9 col-sm-12">
              										<div class="icon-addon addon-md">
              											<input id="edit-msuppliername" value="{{old('msuppliername')}}" name="msuppliername" class="form-control forminput" placeholder="Nama Supplier" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" data-parsley-errors-container=".errorBlock4" @if (Session::has('autofocus')) autofocus @endif>
              											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Supplier"></label>
              										</div>
              									</div>
              								</div>
															<div style="margin-top: 21px;" class="form-group">
              									<label class="col-md-3 control-label"><b>Kategori Supplier</b> &nbsp  :</label>
              									<div class="col-md-9 col-sm-12">
              										<div class="icon-addon addon-md">
              											<select class="form-control select2" id="edit-msuppliercategory" name="msuppliercategory">
																			@foreach($categories as $cat)
																				<option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
																			@endforeach
																		</select>
              										</div>
              									</div>
              								</div>
                              <div class="errorBlock4" style="margin-left:23% !important;"></div>
              								<div style="height: 21px;" class="form-group">
              									<label class="col-md-3 control-label"><b>Email</b> &nbsp  :</label>
              									<div class="col-md-9 col-sm-12">
              										<div class="icon-addon addon-md">
              											<input id="edit-msupplieremail" value="{{old('msupplieremail')}}" name="msupplieremail" class="form-control forminput" placeholder="Email" type="text"  @if (Session::has('autofocus')) autofocus @endif >
              											<label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
              										</div>
              									</div>
              								</div>
                              <div class="form-group">
              									<label class="col-md-3 control-label"><b>Telepon Kantor</b>  &nbsp  :</label>
              									<div  class="col-md-9 col-sm-12">
              										<div class="icon-addon addon-md">
              											<input id="edit-msupplierphone" value="{{old('msupplierphone')}}" name="msupplierphone" class="form-control forminput phoneexample phoneregex" placeholder="Telepon Kantor" type="text" @if (Session::has('autofocus')) autofocus @endif >
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
              											<input id="edit-msupplierfax" value="{{old('msupplierfax')}}" name="msupplierfax" class="form-control forminput phoneregex" placeholder="Fax Kantor" type="text" @if (Session::has('autofocus')) autofocus @endif >
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
              											<input id="edit-msupplierwebsite" value="{{old('msupplierwebsite')}}" name="msupplierwebsite" class="form-control forminput" placeholder="Website" type="text"  @if (Session::has('autofocus')) autofocus @endif >
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
                											<textarea id="edit-msupplieraddress" value="{{old('msupplieraddress')}}" name="msupplieraddress" class="form-control forminput" rows="5" placeholder="Jalan" type="text"  @if (Session::has('autofocus')) autofocus @endif ></textarea>
                											<label for="mgoodsgroup1" class="glyphicon glyphicon-road" rel="tooltip" title="Jalan"></label>
                										</div>
              										</div>
              									</div>
              								</div>
                              <div style="height: 21px;" class="form-group">
              									<div class="col-md-offset-3 col-md-5 col-sm-12" style="margin-top:20px;">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                											<input id="edit-msuppliercity" value="{{old('msuppliercity')}}" name="msuppliercity" class="form-control forminput" placeholder="Kota" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                										</div>
              										</div>
              									</div>
                                <div class="col-md-4 col-sm-12" style="margin-top:20px;">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                											<input id="edit-msupplierzipcode" value="{{old('msupplierzipcode')}}" name="msupplierzipcode" class="form-control forminput" placeholder="K.Pos" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                										</div>
              										</div>
              									</div>
              								</div>
                              <div style="height: 21px;" class="form-group">
              									<div class="col-md-offset-3 col-md-9 col-sm-12" style="margin-top:20px;">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input id="editmsupplierprovince" value="{{old('msupplierprovince')}}" name="msupplierprovince" class="form-control forminput" placeholder="Provinsi " type="text"  @if (Session::has('autofocus')) autofocus @endif >
                											<label for="mgoodsgroup1" class="glyphicon glyphicon-star" rel="tooltip" title="Propinsi"></label>
                										</div>
              										</div>
              									</div>
              								</div>
                              <div style="height: 21px;" class="form-group">
              									<div class="col-md-offset-3 col-md-9 col-sm-12" style="margin-top:20px;">
              										<div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input id="editmsuppliercountry" value="{{old('msuppliercountry')}}" name="msuppliercountry" class="form-control forminput" placeholder="Negara" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                											<label for="mgoodsgroup1" class="glyphicon glyphicon-star" rel="tooltip" title="Negara"></label>
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
          											<input id="edit-msuppliercontactname" value="{{old('msuppliercontactname')}}" name="msuppliercontactname" class="form-control forminput" placeholder="Nama Lengkap" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Lengkap"></label>
          										</div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Posisi Jabatan</b>  &nbsp  :</label>
          									<div class="col-md-4">
          										<div class="icon-addon addon-md">
          											<input id="edit-msuppliercontactposition" value="{{old('msuppliercontactposition')}}" name="msuppliercontactposition" class="form-control forminput" placeholder="Posisi Jabatan" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon glyphicon-user" rel="tooltip" title="Posisi Jabatan"></label>
          										</div>
          									</div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Email</b>  &nbsp  :</label>
          									<div class="col-md-4">
          										<div class="icon-addon addon-md">
          											<input id="edit-msuppliercontactemail" value="{{old('msuppliercontactemail')}}" name="msuppliercontactemail" class="form-control forminput" placeholder="Email" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
          										</div>
          									</div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Handphone</b>  &nbsp  :</label>
          									<div  class="col-md-4">
          										<div class="icon-addon addon-md">
          											<input id="edit-msuppliercontactemailphone" value="{{old('msuppliercontactemailphone')}}" name="msuppliercontactemailphone" class="form-control forminput mobileregex" placeholder="Handphone" type="text" @if (Session::has('autofocus')) autofocus @endif >
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
          											<input id="edit-msupplierarlimit" value="0" name="msupplierarlimit" class="form-control forminput" placeholder="Limit" type="text" @if (Session::has('autofocus')) autofocus @endif >
          											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Limit"></label>
          										</div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Akun</b>  &nbsp  :</label>
          									<div class="col-md-4">
          										<div class="icon-addon addon-md">
          											<select class="form-control select2-bold" name="msuppliercoa" id="edit-msuppliercoa">
                                  @foreach($mcoa as $coa)
                                    @if($coa->id == 8)
                                      <option selected value="{{ $coa->id }}">{{ $coa->mcoacode }} {{ $coa->mcoaname }}</option>
                                    @else
                                      <option value="{{ $coa->id }}">{{ $coa->mcoacode }} {{ $coa->mcoaname }}</option>
                                    @endif
                                  @endforeach
                                </select>
          										</div>
          									</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="editmenu4"></div>
                    <div class="row">
                      <div class="col-md-offset-5 col-md-5" style="margin-top:20px;margin-bottom:20px;">
                        <button onclick="updatemsupplier()" type="submit" name="button" class="btn btn-primary">Simpan</button>
                				<a id="btn-insert-reset" onclick="resetmsupplier()" class="btn btn-default" ><i class=""></i> Reset</a>
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
              <h2>Master Supplier </h2>
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
                        <li class="active"><a data-toggle="tab" href="#viewmenu1">Profil Supplier</a></li>
                        <li><a data-toggle="tab" href="#viewmenu2">Kontak</a></li>
                        <li><a data-toggle="tab" href="#viewmenu3">Kredit Limit</a></li>
                        <li><a data-toggle="tab" href="#viewmenu4">Pajak</a></li>
                      </ul>
                      <div id="insert-wrapper" class="tab-content" data-parsley-validate>
                        <div id="viewmenu1" class="tab-pane fade in active">
                          <div class="form-horizontal" style="margin-top:21px;">
                            <div class="col-md-6">
                              <div style="" class="form-group">
                                <label class="col-md-3 control-label"><b>ID Supplier</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-9">
                                  <div class="icon-addon addon-md">
                                    <div class="input-group">
                                      <input disabled id="view-msupplierid" value="{{old('msupplierid')}}" name="msupplierid" class="form-control forminput" placeholder="AUTO GENERATE" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".errorBlock5" @if (Session::has('autofocus')) autofocus @endif >
                                      <label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Supplier"></label>
                                      <span class="input-group-addon" style="background: none;">
                                        <input disabled type="checkbox" id="disableforminput" name="autogen" rel="tooltip" title="ON/OFF auto generate ID Supplier">
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="errorBlock5" style="margin-left:23% !important;"></div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Nama Supplier</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-msuppliername" value="{{old('msuppliername')}}" name="msuppliername" class="form-control forminput" placeholder="Nama Supplier" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" data-parsley-errors-container=".errorBlock6" @if (Session::has('autofocus')) autofocus @endif>
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Supplier"></label>
                                  </div>
                                </div>
                              </div>
															<div style="margin-top: 21px;" class="form-group">
              									<label class="col-md-3 control-label"><b>Kategori Supplier</b>  &nbsp  :</label>
              									<div class="col-md-9 col-sm-12">
              										<div class="icon-addon addon-md">
              											<select disabled class="form-control select2" id="view-msuppliercategory" name="msuppliercategory">
																			@foreach($categories as $cat)
																				<option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
																			@endforeach
																		</select>
              										</div>
              									</div>
              								</div>
                              <div class="errorBlock6" style="margin-left:23% !important;"></div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Email</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-msupplieremail" value="{{old('msupplieremail')}}" name="msupplieremail" class="form-control forminput" placeholder="Email" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Telepon Kantor</b>  &nbsp  :</label>
                                <div  class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-msupplierphone" value="{{old('msupplierphone')}}" name="msupplierphone" class="form-control forminput phoneexample phoneregex" placeholder="Telepon Kantor" type="text" @if (Session::has('autofocus')) autofocus @endif >
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
                                    <input disabled id="view-msupplierfax" value="{{old('msupplierfax')}}" name="msupplierfax" class="form-control forminput phoneregex" placeholder="Fax Kantor" type="text" @if (Session::has('autofocus')) autofocus @endif >
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
                                    <input disabled id="view-msupplierwebsite" value="{{old('msupplierwebsite')}}" name="msupplierwebsite" class="form-control forminput" placeholder="Website" type="text"  @if (Session::has('autofocus')) autofocus @endif >
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
                                      <textarea disabled id="view-msupplieraddress" value="{{old('msupplieraddress')}}" name="msupplieraddress" class="form-control forminput" rows="5" placeholder="Jalan" type="text"  @if (Session::has('autofocus')) autofocus @endif ></textarea>
                                      <label for="mgoodsgroup1" class="glyphicon glyphicon-road" rel="tooltip" title="Jalan"></label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <div class="col-md-offset-3 col-md-5 col-sm-12" style="margin-top:20px;">
                                  <div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input disabled id="view-msuppliercity" value="{{old('msuppliercity')}}" name="msuppliercity" class="form-control forminput" placeholder="Kota" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-4 col-sm-12" style="margin-top:20px;">
                                  <div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input disabled id="view-msupplierzipcode" value="{{old('msupplierzipcode')}}" name="msupplierzipcode" class="form-control forminput" placeholder="K.Pos" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <div class="col-md-offset-3 col-md-9 col-sm-12" style="margin-top:20px;">
                                  <div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input disabled id="editmsupplierprovince" value="{{old('msupplierprovince')}}" name="msupplierprovince" class="form-control forminput" placeholder="Provinsi " type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                      <label for="mgoodsgroup1" class="glyphicon glyphicon-star" rel="tooltip" title="Propinsi"></label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <div class="col-md-offset-3 col-md-9 col-sm-12" style="margin-top:20px;">
                                  <div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input disabled id="editmsuppliercountry" value="{{old('msuppliercountry')}}" name="msuppliercountry" class="form-control forminput" placeholder="Negara" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                      <label for="mgoodsgroup1" class="glyphicon glyphicon-star" rel="tooltip" title="Negara"></label>
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
                                <input disabled id="view-msuppliercontactname" value="{{old('msuppliercontactname')}}" name="msuppliercontactname" class="form-control forminput" placeholder="Nama Lengkap" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Lengkap"></label>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Posisi Jabatan</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <input disabled id="view-msuppliercontactposition" value="{{old('msuppliercontactposition')}}" name="msuppliercontactposition" class="form-control forminput" placeholder="Posisi Jabatan" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon glyphicon-user" rel="tooltip" title="Posisi Jabatan"></label>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Email</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <input disabled id="view-msuppliercontactemail" value="{{old('msuppliercontactemail')}}" name="msuppliercontactemail" class="form-control forminput" placeholder="Email" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Handphone</b>  &nbsp  :</label>
                            <div  class="col-md-4">
                              <div class="icon-addon addon-md">
                                <input disabled id="view-msuppliercontactemailphone" value="{{old('msuppliercontactemailphone')}}" name="msuppliercontactemailphone" class="form-control forminput mobileregex" placeholder="Handphone" type="text" @if (Session::has('autofocus')) autofocus @endif >
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
                                <input disabled id="view-msupplierarlimit" value="0" name="msupplierarlimit" class="form-control forminput" placeholder="Limit" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Limit"></label>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Akun</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select disabled class="form-control select2-bold" name="msuppliercoa" id="view-msuppliercoa">
                                  @foreach($mcoa as $coa)
                                    @if($coa->id == 8)
                                      <option selected value="{{ $coa->id }}">{{ $coa->mcoacode }} {{ $coa->mcoaname }}</option>
                                    @else
                                      <option value="{{ $coa->id }}">{{ $coa->mcoacode }} {{ $coa->mcoaname }}</option>
                                    @endif
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="viewmenu4"></div>
                    <div class="row">
                      <div class="col-md-offset-6 col-md-5" style="margin-top:20px;margin-bottom:20px;">
                        <a id="btn-insert-reset" onclick="backmsupplier()" class="btn btn-default" ><i class=""></i> Kembali</a>
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
              <h2>Master Supplier </h2>
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
      											<input type="text" class="form-control" placeholder="Filter ID Supplier" />
      										</th>
      										<th class="hasinput" style="width:9%">
      											<input type="text" class="form-control" placeholder="Filter Nama Supplier" />
      										</th>
													<th class="hasinput" style="width:9%">
      											<input type="text" class="form-control" placeholder="Filter Kategori Supplier" />
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
      										<th data-hide="msupplierid"><center>ID Supplier</center></th>
      										<th data-hide="msuppliername"><center>Nama Supplier</center></th>
													<th data-hide="category"><center>Kategori Supplier</center></th>
      										<th data-hide="msupplieremail"><center>Email</center></th>
      										<th data-hide="msupplierphone"><center>Telpon Kantor</center></th>
      										<th data-hide="msupplierfax"><center>Fax</center></th>
      										<th data-hide="msupplierwebsite"><center>Website</center></th>
      										<th data-hide="msupplieraddress"><center>Alamat</center></th>
      										<th data-hide="msuppliercity"><center>Kota</center></th>
      										<th data-hide="msupplierzipcode"><center>Kode Pos</center></th>
      										<th data-hide="msupplierprovince"><center>Provinsi</center></th>
      										<th data-hide="msuppliercountry"><center>Negara</center></th>
      										<th data-hide="msuppliercontactname"><center>Nama Kontak</center></th>
      										<th data-hide="msuppliercontactposition"><center>Jabatan</center></th>
      										<th data-hide="msuppliercontactemail"><center>Email Kontak</center></th>
      										<th data-hide="msuppliercontactemailphone"><center>Handphone</center></th>
													<th data-hide="msupplierarlimit"><center>Limit</center></th>
													<th data-hide="akun"><center>Akun</center></th>
													<th data-hide="msuppliertop"><center>TOP</center></th>
													<th data-hide="msupplierarmax"><center>Maksimal Nota</center></th>
													<th data-hide="msupplierdefaultar"><center>Default</center></th>
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
<script src="{{ url('/master/msupplier.js') }}"></script>
<script>
  $(document).ready(function(){
    $('#disableforminputspl').prop('checked',true);
    $('#insert-msupplierid').prop('disabled',true);
		  $('#disableforminputspl').on('change',function() {
		      console.log(document.getElementById('insert-msupplierid'));
		      document.getElementById('insert-msupplierid').disabled = this.checked;
		      if($('#disableforminput').is(':checked')){
		        $('#insert-msupplierid').removeAttr('required');
		        $('#insert-wrapper').parsley().validate();
		      } else{
		        $('#insert-msupplierid').attr('required','true');
		        $('#insert-wrapper').parsley().validate();
		      }
		  });
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
        "aoColumnDefs": [{ "bVisible": false, "aTargets": [4,5,6,7,9,10,11,12,13,14,15,17,18,19,20,21] }],
        buttons: [ {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21]
            }
        },
        {
            text: 'CSV',
            action: function(){
              window.location.href = "{{ url('/admin-nano/msupplier/export/csv') }}"
            }
        },
        {
            text: 'Excel',
            action: function(){
              window.location.href = "{{ url('/admin-nano/msupplier/export/excel') }}"
            }
        },
        {
            text: 'PDF',
            action: function(){
              window.location.href = "{{ url('/admin-nano/msupplier/export/pdf') }}"
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
                ajax: '{{URL::to('/')}}/admin-api/msupplier',
                columns: [
                {data: 'action', name:'action', searchable: false, orderable: false},
                {data: 'no', no: 'no' },
                {data: 'msupplierid', msupplierid: 'msupplierid'},
                {data: 'msuppliername', msuppliername: 'msuppliername'},
								{data: 'category', category: 'category'},
                {data: 'msupplieremail', msupplieremail: 'msupplieremail'},
                {data: 'msupplierphone', msupplierphone: 'msupplierphone'},
                {data: 'msupplierfax', msupplierfax: 'msupplierfax'},
                {data: 'msupplierwebsite', msupplierwebsite: 'msupplierwebsite'},
                {data: 'msupplieraddress', msupplieraddress: 'msupplieraddress'},
                {data: 'msuppliercity', msuppliercity: 'msuppliercity'},
                {data: 'msupplierzipcode', msupplierzipcode: 'msupplierzipcode'},
                {data: 'msupplierprovince', msupplierprovince: 'msupplierprovince'},
                {data: 'msuppliercountry', msuppliercountry: 'msuppliercountry'},
                {data: 'msuppliercontactname', msuppliercontactname: 'msuppliercontactname'},
                {data: 'msuppliercontactposition', msuppliercontactposition: 'msuppliercontactposition'},
                {data: 'msuppliercontactemail', msuppliercontactemail: 'msuppliercontactemail'},
                {data: 'msuppliercontactemailphone', msuppliercontactemailphone: 'msuppliercontactemailphone'},
								{data: 'msupplierarlimit', msupplierarlimit: 'msupplierarlimit'},
								{data: 'akun', akun: 'akun'},
								{data: 'msuppliertop', msuppliertop: 'msuppliertop'},
								{data: 'msupplierarmax', msupplierarmax: 'msupplierarmax'},
								{data: 'msupplierdefaultar', msupplierdefaultar: 'msupplierdefaultar'},
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
            url: API_URL+"/msupplier/"+id,
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

@stop

@section('css')
  <style>
    .tableapi_wrapper {
      margin-top: 50px;
    }
  </style>
@stop
