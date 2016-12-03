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
			<li>Home</li><li>Lain-lain</li><li>{{ $section }}</li>
		</ol>
	</div>
	<!-- END RIBBON -->
	<!-- MAIN CONTENT -->
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa fa-table fa-fw "></i>
						Lain-lain
					<span>
						{{ $section }}
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
							<h2>{{ $section }}</h2>
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
                       	<li class="active"><a data-toggle="tab" href="#menu1">Profil Karyawan</a></li>
                       	<li><a data-toggle="tab" href="#menu2">Keterangan</a></li>
                      </ul>
                      <div id="insert-wrapper" class="tab-content" data-parsley-validate>
                        <div id="menu1" class="tab-pane fade in active">
                          <div class="form-horizontal" style="margin-top:21px;">
                            <div class="col-md-6">
                              <div style="height: 21px;margin-bottom: -25px;" class="form-group">
              									<label class="col-md-3 control-label"><b>Nama Lengkap</b> (<font color="red">*</font>) &nbsp  :</label>
              									<div class="col-md-9 col-sm-12">
              										<div class="row">
                                    <div class="col-md-3">
                                      <select id="insert-memployeetitle" class="form-control select2" placeholder="sapaan">
                                        <option value="bapak">Bapak</option>
                                        <option value="ibu">Ibu</option>
                                      </select>
                                    </div>
                                    <div class="col-md-8" style="margin-left: -12px;">
                                      <input id="insert-memployeename" value="" name="memployeename" class="form-control forminput" placeholder="Nama Karyawan" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".erroremplname" @if (Session::has('autofocus')) autofocus @endif required>
                                    </div>
                                  </div>
																	<div style="margin-left:18%;" class="erroremplname"></div>
              									</div>
              								</div>
                              <div style="margin-left: 23%;" class="errorBlock2 form-group"></div>
                              <div style="height: 19px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Posisi Jabatan</b> &nbsp  :</label>
                                <div class="col-md-8">
                                  <input id="insert-memployeeposition" value="" name="memployeeposition" class="form-control forminput" placeholder="Posisi Jabatan" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                              </div>
                              <div style="height: 21px;margin-top: 20px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Level Karyawan</b> &nbsp  :</label>
                                <div class="col-md-8">
                                  <select id="insert-memployeelevel" class="form-control select2">
                                    @foreach($level as $l)
                                      <option value="{{ $l->id }}">{{ $l->level }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>HP</b> &nbsp  :</label>
                                <div class="col-md-8">
                                  <input id="insert-memployeephone" value="" name="memployeephone" class="form-control forminput mobileregex" placeholder="HP" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Telepon</b> &nbsp  :</label>
                                <div class="col-md-8">
                                  <input id="insert-memployeehomephone" value="" name="memployeehomephone" class="form-control forminput phoneregex" placeholder="Telepon" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>BBM Pin</b> &nbsp  :</label>
                                <div class="col-md-8">
                                  <input id="insert-memployeebbmpin" value="" name="memployeebbmpin" class="form-control forminput" placeholder="Pin BBM" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div style="height: 21px;margin-bottom: -19px;" class="form-group">
                          		  <label class="col-md-3 control-label"><b>ID Karyawan</b> (<font color="red">*</font>) &nbsp  :</label>
                          			<div class="col-md-9">
                          			  <div class="icon-addon addon-md">
                          				  <div class="input-group">
                                		  <input id="insert-memployeeid" name="memployeeid" class="form-control forminput" placeholder="AUTO GENERATE" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".errorBlock1" @if (Session::has('autofocus')) autofocus @endif >
                                			<label for="" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Karyawan"></label>
                                			<span class="input-group-addon" style="background: none;">
                                  		  <input type="checkbox" id="autogenemployee" name="autogen" rel="tooltip" title="ON/OFF auto generate ID Karyawan">
                                			</span>
                              			</div>
                              		</div>
                          			</div>
                              </div>
                              <div style="margin-top:5px;margin-left:12 0px;" class="errorBlock1 form-group" style="margin-left:23% !important;"></div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>No KTP</b> &nbsp  :</label>
                                <div class="col-md-9">
                                  <input id="insert-memployeeidcard" value="" name="memployeeidcard" class="form-control forminput" placeholder="No KTP" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Kota</b> &nbsp  :</label>
                                <div class="col-md-9">
                                  <input id="insert-memployeecity" value="" name="memployeecity" class="form-control forminput" placeholder="Kota" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Kode POS</b> &nbsp  :</label>
                                <div class="col-md-9">
                                  <input id="insert-memployeezipcode" value="" name="memployeezipcode" class="form-control forminput" placeholder="Kode POS" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Provinsi</b> &nbsp  :</label>
                                <div class="col-md-9">
                                  <input id="insert-memployeeprovince" value="" name="memployeeprovince" class="form-control forminput" placeholder="Provinsi" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Negara</b> &nbsp  :</label>
                                <div class="col-md-9">
                                  <input id="insert-memployeecountry" value="" name="memployeecountry" class="form-control forminput" placeholder="Negara" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
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
                            <label class="col-md-2 control-label"><b>Keterangan</b>  &nbsp  :</label>
                            <div class="col-md-4 col-sm-12">
          											<textarea id="insert-memployeeinfo" class="form-control" rows="10"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-offset-5 col-md-5" style="margin-top:20px;margin-bottom:20px;">
                        <button onclick="insertmemployee()" type="submit" name="button" class="btn btn-primary">Simpan</button>
                				<a id="btn-insert-reset" onclick="resetmemployee()" class="btn btn-default" ><i class=""></i> Reset</a>
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
							<h2>{{ $section }}</h2>
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
												<li class="active"><a data-toggle="tab" href="#editmenu1">Profil Karyawan</a></li>
                       	<li><a data-toggle="tab" href="#editmenu2">Keterangan</a></li>
                      </ul>
											<div id="edit-wrapper" class="tab-content" data-parsley-validate>
                        <div id="editmenu1" class="tab-pane fade in active">
													<input type="hidden" id="edit-idmemployeeid">
                          <div class="form-horizontal" style="margin-top:21px;">
                            <div class="col-md-6">
                              <div style="height: 21px;margin-bottom: -25px;" class="form-group">
              									<label class="col-md-3 control-label"><b>Nama Lengkap</b> (<font color="red">*</font>) &nbsp  :</label>
              									<div class="col-md-9 col-sm-12">
              										<div class="row">
                                    <div class="col-md-3">
                                      <select id="edit-memployeetitle" class="form-control select2" placeholder="sapaan">
                                        <option value="bapak">Bapak</option>
                                        <option value="ibu">Ibu</option>
                                      </select>
                                    </div>
                                    <div class="col-md-8" style="margin-left: -12px;">
                                      <input id="edit-memployeename" value="" name="memployeename" class="form-control forminput" placeholder="Nama Karyawan" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".erroremplnameedit" @if (Session::has('autofocus')) autofocus @endif required>
                                    </div>
                                  </div>
																	<div style="margin-left:18%;" class="erroremplnameedit"></div>
              									</div>
              								</div>
                              <div style="margin-left: 23%;" class="errorBlock2 form-group"></div>
                              <div style="height: 19px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Posisi Jabatan</b> &nbsp  :</label>
                                <div class="col-md-8">
                                  <input id="edit-memployeeposition" value="" name="memployeeposition" class="form-control forminput" placeholder="Posisi Jabatan" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                              </div>
                              <div style="height: 21px;margin-top: 20px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Level Karyawan</b> &nbsp  :</label>
                                <div class="col-md-8">
                                  <select id="edit-memployeelevel" class="form-control select2">
                                    @foreach($level as $l)
                                      <option value="{{ $l->id }}">{{ $l->level }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>HP</b> &nbsp  :</label>
                                <div class="col-md-8">
                                  <input id="edit-memployeephone" value="" name="memployeephone" class="form-control forminput mobileregex" placeholder="HP" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Telepon</b> &nbsp  :</label>
                                <div class="col-md-8">
                                  <input id="edit-memployeehomephone" value="" name="memployeehomephone" class="form-control forminput phoneregex" placeholder="Telepon" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>BBM Pin</b> &nbsp  :</label>
                                <div class="col-md-8">
                                  <input id="edit-memployeebbmpin" value="" name="memployeebbmpin" class="form-control forminput" placeholder="Pin BBM" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div style="height: 21px;margin-bottom: -19px;" class="form-group">
                          		  <label class="col-md-3 control-label"><b>ID Karyawan</b> (<font color="red">*</font>) &nbsp  :</label>
                          			<div class="col-md-9">
                          			  <div class="icon-addon addon-md">
                          				  <div class="input-group">
                                		  <input id="edit-memployeeid" name="memployeeid" class="form-control forminput" placeholder="AUTO GENERATE" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".errorBlock1" @if (Session::has('autofocus')) autofocus @endif >
                                			<label for="" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Karyawan"></label>
                                			<span class="input-group-addon" style="background: none;">
                                  		  <input type="checkbox" id="autogenemployee" name="autogen" rel="tooltip" title="ON/OFF auto generate ID Karyawan">
                                			</span>
                              			</div>
                              		</div>
                          			</div>
                              </div>
                              <div style="margin-top:5px;margin-left:12 0px;" class="errorBlock1 form-group" style="margin-left:23% !important;"></div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>No KTP</b> &nbsp  :</label>
                                <div class="col-md-9">
                                  <input id="edit-memployeeidcard" value="" name="memployeeidcard" class="form-control forminput" placeholder="No KTP" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Kota</b> &nbsp  :</label>
                                <div class="col-md-9">
                                  <input id="edit-memployeecity" value="" name="memployeecity" class="form-control forminput" placeholder="Kota" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Kode POS</b> &nbsp  :</label>
                                <div class="col-md-9">
                                  <input id="edit-memployeezipcode" value="" name="memployeezipcode" class="form-control forminput" placeholder="Kode POS" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Provinsi</b> &nbsp  :</label>
                                <div class="col-md-9">
                                  <input id="edit-memployeeprovince" value="" name="memployeeprovince" class="form-control forminput" placeholder="Provinsi" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Negara</b> &nbsp  :</label>
                                <div class="col-md-9">
                                  <input id="edit-memployeecountry" value="" name="memployeecountry" class="form-control forminput" placeholder="Negara" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
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
                            <label class="col-md-2 control-label"><b>Keterangan</b>  &nbsp  :</label>
                            <div class="col-md-4 col-sm-12">
          											<textarea id="edit-memployeeinfo" class="form-control" rows="10"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    </div>
                    <div class="row">
                      <div class="col-md-offset-5 col-md-5" style="margin-top:20px;margin-bottom:20px;">
                        <button onclick="updatememployee()" type="submit" name="button" class="btn btn-primary">Simpan</button>
                				<a id="btn-insert-reset" onclick="resetmemployee()" class="btn btn-default" ><i class=""></i> Reset</a>
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
					<div id="formview" style="display:none;margin-bottom:70px;" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2>{{ $section }}</h2>
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
												<li class="active"><a data-toggle="tab" href="#viewmenu1">Profil Karyawan</a></li>
												<li><a data-toggle="tab" href="#viewmenu2">Keterangan</a></li>
											</ul>
											<div id="edit-wrapper" class="tab-content" data-parsley-validate>
												<div id="viewmenu1" class="tab-pane fade in active">
													<input type="hidden" id="edit-idmemployeeid">
													<div class="form-horizontal" style="margin-top:21px;">
														<div class="col-md-6">
															<div style="height: 21px;margin-bottom: -25px;" class="form-group">
																<label class="col-md-3 control-label"><b>Nama Lengkap</b> (<font color="red">*</font>) &nbsp  :</label>
																<div class="col-md-9 col-sm-12">
																	<div class="row">
																		<div class="col-md-3">
																			<select disabled id="view-memployeetitle" class="form-control select2" placeholder="sapaan">
																				<option value="bapak">Bapak</option>
																				<option value="ibu">Ibu</option>
																			</select>
																		</div>
																		<div class="col-md-8" style="margin-left: -12px;">
																			<input disabled id="view-memployeename" value="" name="memployeename" class="form-control forminput" placeholder="Nama Karyawan" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".errorBlock2" @if (Session::has('autofocus')) autofocus @endif required>
																		</div>
																	</div>
																</div>
															</div>
															<div style="margin-left: 23%;" class="errorBlock2 form-group"></div>
															<div style="height: 19px;" class="form-group">
																<label class="col-md-3 control-label"><b>Posisi Jabatan</b> &nbsp  :</label>
																<div class="col-md-8">
																	<input disabled id="view-memployeeposition" value="" name="memployeeposition" class="form-control forminput" placeholder="Posisi Jabatan" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
																</div>
															</div>
															<div style="height: 21px;margin-top: 20px;" class="form-group">
																<label class="col-md-3 control-label"><b>Level Karyawan</b> &nbsp  :</label>
																<div class="col-md-8">
																	<select disabled id="view-memployeelevel" class="form-control select2">
																		@foreach($level as $l)
																			<option value="{{ $l->id }}">{{ $l->level }}</option>
																		@endforeach
																	</select>
																</div>
															</div>
															<div style="height: 21px;" class="form-group">
																<label class="col-md-3 control-label"><b>HP</b> &nbsp  :</label>
																<div class="col-md-8">
																	<input disabled id="view-memployeephone" value="" name="memployeephone" class="form-control forminput mobileregex" placeholder="HP" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
																</div>
															</div>
															<div style="height: 21px;" class="form-group">
																<label class="col-md-3 control-label"><b>Telepon</b> &nbsp  :</label>
																<div class="col-md-8">
																	<input disabled id="view-memployeehomephone" value="" name="memployeehomephone" class="form-control forminput phoneregex" placeholder="Telepon" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
																</div>
															</div>
															<div style="height: 21px;" class="form-group">
																<label class="col-md-3 control-label"><b>BBM Pin</b> &nbsp  :</label>
																<div class="col-md-8">
																	<input disabled id="view-memployeebbmpin" value="" name="memployeebbmpin" class="form-control forminput" placeholder="Pin BBM" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
																</div>
															</div>
														</div>
														<div class="col-md-6">
															<div style="height: 21px;margin-bottom: -19px;" class="form-group">
																<label class="col-md-3 control-label"><b>ID Karyawan</b> (<font color="red">*</font>) &nbsp  :</label>
																<div class="col-md-9">
																	<div class="icon-addon addon-md">
																		<div class="input-group">
																			<input disabled id="view-memployeeid" name="memployeeid" class="form-control forminput" placeholder="AUTO GENERATE" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".errorBlock1" @if (Session::has('autofocus')) autofocus @endif >
																			<label for="" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Karyawan"></label>
																			<span class="input-group-addon" style="background: none;">
																				<input type="checkbox" id="autogenemployee" name="autogen" rel="tooltip" title="ON/OFF auto generate ID Karyawan">
																			</span>
																		</div>
																	</div>
																</div>
															</div>
															<div style="margin-top:5px;margin-left:12 0px;" class="errorBlock1 form-group" style="margin-left:23% !important;"></div>
															<div style="height: 21px;" class="form-group">
																<label class="col-md-3 control-label"><b>No KTP</b> &nbsp  :</label>
																<div class="col-md-9">
																	<input disabled id="view-memployeeidcard" value="" name="memployeeidcard" class="form-control forminput" placeholder="No KTP" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
																</div>
															</div>
															<div style="height: 21px;" class="form-group">
																<label class="col-md-3 control-label"><b>Kota</b> &nbsp  :</label>
																<div class="col-md-9">
																	<input disabled disabled id="view-memployeecity" value="" name="memployeecity" class="form-control forminput" placeholder="Kota" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
																</div>
															</div>
															<div style="height: 21px;" class="form-group">
																<label class="col-md-3 control-label"><b>Kode POS</b> &nbsp  :</label>
																<div class="col-md-9">
																	<input disabled disabled id="view-memployeezipcode" value="" name="memployeezipcode" class="form-control forminput" placeholder="Kode POS" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
																</div>
															</div>
															<div style="height: 21px;" class="form-group">
																<label class="col-md-3 control-label"><b>Provinsi</b> &nbsp  :</label>
																<div class="col-md-9">
																	<input disabled disabled id="view-memployeeprovince" value="" name="memployeeprovince" class="form-control forminput" placeholder="Provinsi" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
																</div>
															</div>
															<div style="height: 21px;" class="form-group">
																<label class="col-md-3 control-label"><b>Negara</b> &nbsp  :</label>
																<div class="col-md-9">
																	<input disabled disabled id="view-memployeecountry" value="" name="memployeecountry" class="form-control forminput" placeholder="Negara" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong">
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
                            <label class="col-md-2 control-label"><b>Keterangan</b>  &nbsp  :</label>
                            <div class="col-md-4 col-sm-12">
          											<textarea disabled id="view-memployeeinfo" class="form-control" rows="10"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
										</div>
										<div class="row">
											<div class="col-md-offset-5 col-md-5" style="margin-top:20px;margin-bottom:20px;">
												<a id="btn-insert-reset" onclick="backmemployee()" class="btn btn-default" ><i class=""></i> Kembali</a>
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
              <h2>{{ $section }} </h2>
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
      											<input type="text" class="form-control" placeholder="Filter ID Karyawan" />
      										</th>
      										<th class="hasinput" style="width:9%">
      											<input type="text" class="form-control" placeholder="Filter Nama Karyawan" />
      										</th>
													<th class="hasinput" style="width:9%">
      											<input type="text" class="form-control" placeholder="Filter Posisi Karyawan" />
      										</th>
													<th class="hasinput" style="width:9%">
      											<input type="text" class="form-control" placeholder="Filter Level Karyawan" />
      										</th>
													<th class="hasinput" style="width:9%">
      											<input type="text" class="form-control" placeholder="Filter HP Karyawan" />
      										</th>
													<th class="hasinput" style="width:9%">
      											<input type="text" class="form-control" placeholder="Filter Telepon Karyawan" />
      										</th>
													<th class="hasinput" style="width:9%">
      											<input type="text" class="form-control" placeholder="Filter BBM Karyawan" />
      										</th>
													<th class="hasinput" style="width:9%">
      											<input type="text" class="form-control" placeholder="Filter KTP Karyawan" />
      										</th>
													<th class="hasinput" style="width:9%">
      											<input type="text" class="form-control" placeholder="Filter Kota" />
      										</th>
													<th class="hasinput" style="width:9%">
      											<input type="text" class="form-control" placeholder="Filter Kode Pos" />
      										</th>
													<th class="hasinput" style="width:9%">
      											<input type="text" class="form-control" placeholder="Filter Provinsi" />
      										</th>
													<th class="hasinput" style="width:9%">
      											<input type="text" class="form-control" placeholder="Filter Negara" />
      										</th>
													<th class="hasinput" style="width:9%">
      											<input type="text" class="form-control" placeholder="Filter Keterangan" />
      										</th>
      									</tr>
      									<tr>
      										<th data-hide="action"><center>Aksi</center></th>
      										<th data-hide="no"><center>No</center></th>
      										<th data-hide="memployeeid"><center>ID Karyawan</center></th>
      										<th data-hide="memployeename"><center>Nama Karyawan</center></th>
													<th data-hide="memployeeposition"><center>Posisi Karyawan</center></th>
													<th data-hide="memployeelevel"><center>Level Karyawan</center></th>
													<th data-hide="memployeephone"><center>HP Karyawan</center></th>
													<th data-hide="memployeehomephone"><center>Telepon Karyawan</center></th>
													<th data-hide="memployeebbmpin"><center>BBM Karyawan</center></th>
													<th data-hide="memployeeidcard"><center>KTP Karyawan</center></th>
													<th data-hide="memployeecity"><center>Kota</center></th>
													<th data-hide="memployeezipcode"><center>Kode Pos</center></th>
													<th data-hide="memployeeprovince"><center>Provinsi</center></th>
													<th data-hide="memployeecountry"><center>Negara</center></th>
													<th data-hide="memployeeinfo"><center>Keterangan</center></th>
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
<script src="{{ url('master/memployee.js') }}"></script>
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
        "aoColumnDefs": [{ "bVisible": false, "aTargets": [6,7,8,9,10,11,12,13] }],
        buttons: [ {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13]
            }
        },
        {
            text: 'CSV',
            action: function(){
              window.location.href = "{{ url('/admin-nano/memployee/export/csv') }}"
            }
        },
        {
            text: 'Excel',
            action: function(){
              window.location.href = "{{ url('/admin-nano/memployee/export/excel') }}"
            }
        },
        {
            text: 'PDF',
            action: function(){
              window.location.href = "{{ url('/admin-nano/memployee/export/pdf') }}"
            }
        },
        {
            extend: 'print',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13] //setting kolom mana yg mau di print
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
                ajax: '{{URL::to('/')}}/admin-api/memployee',
                columns: [
                {data: 'action', name:'action', searchable: false, orderable: false},
                {data: 'no', no: 'no' },
                {data: 'memployeeid', memployeeid: 'memployeeid'},
                {data: 'memployeename', memployeename: 'memployeename'},
								{data: 'memployeeposition', memployeeposition: 'memployeeposition'},
								{data: 'level', level: 'level'},
								{data: 'memployeephone', memployeephone: 'memployeephone'},
								{data: 'memployeehomephone', memployeehomephone: 'memployeehomephone'},
								{data: 'memployeebbmpin', memployeebbmpin: 'memployeebbmpin'},
								{data: 'memployeeidcard', memployeeidcard: 'memployeeidcard'},
								{data: 'memployeecity', memployeecity: 'memployeecity'},
								{data: 'memployeezipcode', memployeezipcode: 'memployeezipcode'},
								{data: 'memployeeprovince', memployeeprovince: 'memployeeprovince'},
								{data: 'memployeecountry', memployeecountry: 'memployeecountry'},
								{data: 'memployeeinfo', memployeeinfo: 'memployeeinfo'},
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
            url: API_URL+"/memployee/"+id,
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
