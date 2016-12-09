@extends('admin/nav/layouttables')
@section('title')
@section('content')
<!-- MAIN PANEL -->
<div id="main" role="main">
	<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment">
			<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
				<i class="fa fa-refresh"></i>
			</span>
		</span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>Home</li><li>Master</li><li>{{ $section }}</li>
		</ol>
		<!-- end breadcrumb -->
</div>
<!-- END RIBBON -->
<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
	<h1 class="page-title txt-color-blueDark">
		<i class="fa fa-table fa-fw "></i>
		{{ $section }}
		<span>
			{{ $section }}
		</span>
	</h1>
</div>
<!-- MAIN CONTENT -->
<div id="content">

	<div class="row">
	</div>

	<section id="widget-grid" class="">
		<!-- row -->
		<!-- row -->
		<div class="row">
			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div id="forminput" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-table"></i> </span>
						<h2>Tambah {{ $section }}</h2>
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
						<style>
							.alert-info {
								color: #D9ECF5;
								background-color: #48AFE3;
								border-color: #2F9ACF;
							}
						</style>
  						@if(count($errors) > 0)
    						<div class="alert alert-info alerthide" role="alert">
    							@foreach($errors->all() as $error)
      							<span class="sr-only">Error:</span>
      							<span class="sr-only"></span>
      							<li><b>{{ $error }}</b></li>
    							@endforeach
    						</div>
  						@endif
						<div class="widget-body no-padding">
							<div id="insert-wrapper" class="form-horizontal" data-parsley-validate>
								{{ csrf_field() }}
								<div class="container">
								</br>
								<div class="row">
								<h4 class="pajak-text"></h4>
								<div class="col-md-11 box-group1">
								<div class="box-pajak-wrapper">

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Kode Grup</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-mcategoryfixedassetgroupcode" value="{{old('mcategoryfixedassetgroupcode')}}" name="mcategoryfixedassetgroupcode" class="form-control forminput" placeholder="Kode Grup" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Kode Grup"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Grup</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-mcategoryfixedassetgroupname" value="{{old('mcategoryfixedassetgroupname')}}" name="mcategoryfixedassetgroupname" class="form-control forminput" placeholder="Nama Grup" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Grup"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Umur Ekonomis (Tahun)</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<select id="insert-mcategoryfixedassetage" class="form-control select2">
											<?php
											    for ($i=1; $i<=100; $i++)
											    {
											        ?>
											            <option value="<?php echo $i;?>"><?php echo $i;?></option>
											        <?php
											    }
											?>
											</select>
										</div>
									</div>
								</div>
								

																</div>
															</div>
														</div>

								<div class="row">
								<h4 class="pajak-text"></h4>
								<div class="col-md-11 box-group1">
								<div class="box-pajak-wrapper">

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Mengalami Penyusutan</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<div class="yesnoswitch">
                                        <input id="insert-mcategoryfixedassetshrink" type="checkbox" name="mcategoryfixedassetshrink" class="yesnoswitch-checkbox" id="insert-mcategoryfixedassetshrink">
                                        <label class="yesnoswitch-label" for="insert-mcategoryfixedassetshrink">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
									</div>
								</div>

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Metode Depresiasi</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<select disabled id="insert-mcategoryfixedassetdepreciaton" class="form-control select2">
												<option value="Metode Garis Lurus">Metode Garis Lurus</option>
												<option value="Metode Saldo Menurun">Metode Saldo Menurun</option>
											</select>
										</div>
									</div>
								</div>

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>COA Harta</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<div class="icon-addon addon-md">
											<select disabled id="insert-mcategoryfixedassetcoaasset" class="form-control select2">
											@foreach($mcoa as $m)
												<option value="{{ $m->mcoacode }}">{{ $m->mcoaname }}</option>
											@endforeach
											</select>
										</div>
										</div>
									</div>
								</div>

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>COA Akumulasi Penyusutan</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<select id="insert-mcategoryfixedassetcoaaccudepr" class="form-control select2">
											@foreach($mcoa as $m)
												<option value="{{ $m->mcoacode }}">{{ $m->mcoaname }}</option>
											@endforeach
											</select>
										</div>
									</div>
								</div>

									<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>COA Beban Penyusutan</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<select id="insert-mcategoryfixedassetcoadeprexp" class="form-control select2">
											@foreach($mcoa as $m)
												<option value="{{ $m->mcoacode }}">{{ $m->mcoaname }}</option>
											@endforeach
											</select>
										</div>
									</div>
								</div>

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Keterangan</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-mcategoryfixedassetremark" value="{{old('mcategoryfixedassetremark')}}" name="mcategoryfixedassetremark" class="form-control forminput" placeholder="Keterangan" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Keterangan"></label>
										</div>
									</div>
								</div>

								</div>
								</div>
								</div>
								<input type="hidden" name="void" value="0">
								<center>
									<div class="row">
										<div class="col-md-12">
											<a id="btn-insert-reset" onclick="resetmcategory()" class="btn btn-default" ><i class=""></i> Reset</a>
											<button class="btn btn-primary" onclick="insertmcategory()"><i class="fa fa-save"></i> Simpan</button>
										</div>
									</div>
								</center>
							</br>
						</div>
					</div>
				</div>
				<!-- end widget content -->
			</div>
			<!-- end widget div -->
		</div>
		<!-- end widget -->
		<div class="row">
			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div id="formedit" style="display: none;" class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-table"></i> </span>
						<h2>Pengubahan {{ $section }}</h2>
					</header>
					<!-- widget div-->
					<div>
						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->
						</div>
						<!-- end widget edit box -->
						<h3 style="font-weight: bold; color: #C91503;font-size: 19px;">Mode : EDIT</h3>

						<input type="hidden" id="mbranchid" value=""></input>
						<div id="edit-wrapper" class="form-horizontal" data-parsley-validate>
							<div class="container">
								<style>
									.alert-info {
										color: #D9ECF5;
										background-color: #48AFE3;
										border-color: #2F9ACF;
									}
								</style>
                <input type="hidden" id="mfixedassetsid">
								<div class="row">
								<h4 class="pajak-text"></h4>
								<div class="col-md-11 box-group1">
								<div class="box-pajak-wrapper">

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Kode Grup</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="edit-mcategoryfixedassetgroupcode" value="{{old('mcategoryfixedassetgroupcode')}}" name="mcategoryfixedassetgroupcode" class="form-control forminput" placeholder="Kode Grup" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Kode Grup"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Grup</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="edit-mcategoryfixedassetgroupname" value="{{old('mcategoryfixedassetgroupname')}}" name="mcategoryfixedassetgroupname" class="form-control forminput" placeholder="Nama Grup" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Grup"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Umur Ekonomis (Tahun)</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<select id="insert-mcategoryfixedassetage" class="form-control select2">
											<?php
											    for ($i=1; $i<=100; $i++)
											    {
											        ?>
											            <option value="<?php echo $i;?>"><?php echo $i;?></option>
											        <?php
											    }
											?>
											</select>
										</div>
									</div>
								</div>
								

																</div>
															</div>
														</div>

								<div class="row">
								<h4 class="pajak-text"></h4>
								<div class="col-md-11 box-group1">
								<div class="box-pajak-wrapper">

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Mengalami Penyusutan</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<div class="yesnoswitch">
                                        <input id="edit-mcategoryfixedassetshrink" type="checkbox" name="mcategoryfixedassetshrink" class="yesnoswitch-checkbox" id="edit-mcategoryfixedassetshrink">
                                        <label class="yesnoswitch-label" for="edit-mcategoryfixedassetshrink">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
									</div>
								</div>

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Metode Depresiasi</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<select id="edit-mcategoryfixedassetdepreciaton" class="form-control select2">
												<option value="Metode Garis Lurus">Metode Garis Lurus</option>
												<option value="Metode Saldo Menurun">Metode Saldo Menurun</option>
											</select>
										</div>
									</div>
								</div>

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>COA Harta</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<div class="icon-addon addon-md">
											<select id="edit-mcategoryfixedassetcoaasset" class="form-control select2">
											@foreach($mcoa as $m)
												<option value="{{ $m->mcoacode }}">{{ $m->mcoaname }}</option>
											@endforeach
											</select>
										</div>
										</div>
									</div>
								</div>

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>COA Akumulasi Penyusutan</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<select id="edit-mcategoryfixedassetcoaaccudepr" class="form-control select2">
											@foreach($mcoa as $m)
												<option value="{{ $m->mcoacode }}">{{ $m->mcoaname }}</option>
											@endforeach
											</select>
										</div>
									</div>
								</div>

									<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>COA Beban Penyusutan</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<select id="edit-mcategoryfixedassetcoadeprexp" class="form-control select2">
											@foreach($mcoa as $m)
												<option value="{{ $m->mcoacode }}">{{ $m->mcoaname }}</option>
											@endforeach
											</select>
										</div>
									</div>
								</div>

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Keterangan</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="edit-mcategoryfixedassetremark" value="{{old('mcategoryfixedassetremark')}}" name="mcategoryfixedassetremark" class="form-control forminput" placeholder="Keterangan" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Keterangan"></label>
										</div>
									</div>
								</div>

								</div>
								</div>
								</div>
								<input type="hidden" name="void" value="0">
								<center>
									<div class="row">
										<div class="col-md-12">
											<a onclick="backmcategory()" title="" class="btn btn-default">Batal</a>
											<button onclick="updatemcategory()" class="btn btn-primary" type="submit">
												<i class="fa fa-save"></i> Simpan</button>
											</div>
										</center>
									</br>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<!-- NEW WIDGET START -->
						<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<!-- Widget ID (each widget will need unique ID)-->
							<div id="formview" style="display: none;" class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
					      <header>
						      <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                  <h2>View {{ $section }} </h2>
						    </header>
  						<!-- widget div-->
  					  <div>
						  <!-- widget edit box -->
						    <div class="jarviswidget-editbox">
							  <!-- This area used as dropdown edit box -->
						    </div>
						    <!-- end widget edit box -->
						    <h3 style="font-weight: bold; color: #291817;font-size: 19px;">Mode : VIEW</h3>

						    <input type="hidden" id="mbranchid" value=""></input>
						    <div class="form-horizontal">

							  <div class="container">
								<style>
									.alert-info {
										color: #D9ECF5;
										background-color: #48AFE3;
										border-color: #2F9ACF;
									}
								</style>
								<div class="row">
								<h4 class="pajak-text"></h4>
								<div class="col-md-11 box-group1">
								<div class="box-pajak-wrapper">

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Kode Grup</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcategoryfixedassetgroupcode" value="{{old('mcategoryfixedassetgroupcode')}}" name="mcategoryfixedassetgroupcode" class="form-control forminput" placeholder="Kode Grup" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Kode Grup"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Grup</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcategoryfixedassetgroupname" value="{{old('mcategoryfixedassetgroupname')}}" name="mcategoryfixedassetgroupname" class="form-control forminput" placeholder="Nama Grup" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Grup"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Umur Ekonomis (Tahun)</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<select disabled id="insert-mcategoryfixedassetage" class="form-control select2">
											<?php
											    for ($i=1; $i<=100; $i++)
											    {
											        ?>
											            <option value="<?php echo $i;?>"><?php echo $i;?></option>
											        <?php
											    }
											?>
											</select>
										</div>
									</div>
								</div>
								

																</div>
															</div>
														</div>

								<div class="row">
								<h4 class="pajak-text"></h4>
								<div class="col-md-11 box-group1">
								<div class="box-pajak-wrapper">

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Mengalami Penyusutan</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<div class="yesnoswitch">
                                        <input disabled id="view-mcategoryfixedassetshrink" type="checkbox" name="mcategoryfixedassetshrink" class="yesnoswitch-checkbox" id="view-mcategoryfixedassetshrink">
                                        <label class="yesnoswitch-label" for="view-mcategoryfixedassetshrink">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
									</div>
								</div>

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Metode Depresiasi</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<select disabled id="view-mcategoryfixedassetdepreciaton" class="form-control select2">
												<option value="Metode Garis Lurus">Metode Garis Lurus</option>
												<option value="Metode Saldo Menurun">Metode Saldo Menurun</option>
											</select>
										</div>
									</div>
								</div>

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>COA Harta</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<div class="icon-addon addon-md">
											<select disabled id="view-mcategoryfixedassetcoaasset" class="form-control select2">
											@foreach($mcoa as $m)
												<option value="{{ $m->mcoacode }}">{{ $m->mcoaname }}</option>
											@endforeach
											</select>
										</div>
										</div>
									</div>
								</div>

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>COA Akumulasi Penyusutan</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<select disabled id="view-mcategoryfixedassetcoaaccudepr" class="form-control select2">
											@foreach($mcoa as $m)
												<option value="{{ $m->mcoacode }}">{{ $m->mcoaname }}</option>
											@endforeach
											</select>
										</div>
									</div>
								</div>

									<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>COA Beban Penyusutan</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<select disabled id="view-mcategoryfixedassetcoadeprexp" class="form-control select2">
											@foreach($mcoa as $m)
												<option value="{{ $m->mcoacode }}">{{ $m->mcoaname }}</option>
											@endforeach
											</select>
										</div>
									</div>
								</div>

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Keterangan</b>  &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcategoryfixedassetremark" value="{{old('mcategoryfixedassetremark')}}" name="mcategoryfixedassetremark" class="form-control forminput" placeholder="Keterangan" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Keterangan"></label>
										</div>
									</div>
								</div>

								</div>
								</div>
								</div>
								<center>
									<div class="row">
										<div class="col-md-12">
											</br>
											<button onclick="backmcategory()" class="btn btn-default" type="submit">
												<i class="fa fa-save"></i> Kembali
                      </button>
										</div>
									</center>
									</br>
								</div>
							</div>
						</div>
					</div>
					<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<section id="widget-grid" class="">
							<!-- row -->
							<div class="row">
								<!-- NEW WIDGET START -->
								<!-- Widget ID (each widget will need unique ID)-->
								<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-table"></i> </span>
						<h2>Master {{ $section }} </h2>
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
                    <th class="hasinput" style="width:10%">

										</th>
										<th class="hasinput" style="width:5%">
											<input type="text" class="form-control" placeholder="Filter No" />
										</th>
										<th class="hasinput" style="width:9%">
											<input type="text" class="form-control" placeholder="Filter Kode Group" />
										</th>
										<th class="hasinput" style="width:9%">
											<input type="text" class="form-control" placeholder="Filter Nama Group" />
										</th>
										<th class="hasinput" style="width:9%">
											<input type="text" class="form-control" placeholder="Filter Umur Ekonomis (Tahun)" />
										</th>
										<th class="hasinput" style="width:9%">
											<input type="text" class="form-control" placeholder="Filter Mengalami Penyusutan" />
										</th>
										<th class="hasinput" style="width:9%">
											<input type="text" class="form-control" placeholder="Filter Metode Depresiasi" />
										</th>
										<th class="hasinput" style="width:9%">
											<input type="text" class="form-control" placeholder="Filter COA Harta" />
										</th>
										<th class="hasinput" style="width:9%">
											<input type="text" class="form-control" placeholder="Filter COA Akumulasi Penyusutan" />
										</th>
										<th class="hasinput" style="width:9%">
											<input type="text" class="form-control" placeholder="Filter COA Beban Penyusutan" />
										</th>
                    <th class="hasinput" style="width:9%">
											<input type="text" class="form-control" placeholder="Filter Keterangan" />
										</th>
									</tr>
									<tr>
					<th data-hide="action"><center>Aksi</center></th>
                    <th data-hide="no"><center>No</center></th>
                    <th data-hide="mcategoryfixedassetgroupcode"><center>Kode Group</center></th>
                    <th data-hide="mcategoryfixedassetgroupname"><center>Nama Group</center></th>
                    <th data-hide="mcategoryfixedassetage"><center>Umur Ekonomis (Tahun)</center></th>
                    <th data-hide="mcategoryfixedassetshrink"><center>Mengalami Penyusutan</center></th>
                    <th data-hide="mcategoryfixedassetdepreciaton"><center>Metode Depresiasi</center></th>
                    <th data-hide="mcategoryfixedassetcoaasset"><center>COA Harta</center></th>
                    <th data-hide="mcategoryfixedassetcoaaccudepr"><center>COA Akumulasi Penyusutan</center></th>
                    <th data-hide="mcategoryfixedassetcoadeprexp"><center>COA Beban Penyusutan</center></th>
					<th data-hide="mcategoryfixedassetremark"><center>Keterangan</center></th>
									</tr>
								</thead>
								<tbody>
								</tbody>

							</table>
							@push('scripts')
							<tfoot>
							<script>
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
                              buttons: [ {
                                    extend: 'copyHtml5',
                                    exportOptions: {
                                        columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9]
                                    }
                                  },
                                  {
                                      text: 'CSV',
                                      action: function(){
																				window.location.href = "{{ url('admin-nano/mcategoryfixedassets/export/csv') }}";
																			}
                                  },
                                  {
																			text: 'Excel',
																			action: function(){
																				window.location.href = "{{ url('admin-nano/mcategoryfixedassets/export/excel') }}";
																			}
                                  },
                                  {
																			text: 'PDF',
																			action: function(){
																				window.location.href = "{{ url('admin-nano/mcategoryfixedassets/export/pdf') }}";
																			}
                                  },
                                  {
                                      extend: 'print',
                                      exportOptions: {
                                          columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9] //setting kolom mana yg mau di export
                                      }

                                  },
																  {
																	  extend: 'colvis',
																	  text: 'Show / Hide Columns',
																	  columns: ':gt(1)'
																  }
                              ],
					       				      processing: false,
										          serverSide: false,
										          ajax: '{{URL::to('/')}}/admin-api/mcategoryfixedassets',
          										columns: [
                              {data: 'action', name:'action', searchable: false, orderable: false},
                              {data: 'no', no: 'no' },
                              {data: 'mcategoryfixedassetgroupcode', mcategoryfixedassetgroupcode: 'mcategoryfixedassetgroupcode'},
							  {data: 'mcategoryfixedassetgroupname', mcategoryfixedassetgroupname: 'mcategoryfixedassetgroupname'},
							  {data: 'mcategoryfixedassetage', mcategoryfixedassetage: 'mcategoryfixedassetage'},
							  {data: 'mcategoryfixedassetshrink', mcategoryfixedassetshrink: 'mcategoryfixedassetshrink'},
							  {data: 'mcategoryfixedassetdepreciaton', mcategoryfixedassetdepreciaton: 'mcategoryfixedassetdepreciaton'},
							  {data: 'mcategoryfixedassetcoaasset', mcategoryfixedassetcoaasset: 'mcategoryfixedassetcoaasset'},
							  {data: 'mcategoryfixedassetcoaaccudepr', mcategoryfixedassetcoaaccudepr: 'mcategoryfixedassetcoaaccudepr'},
							  {data: 'mcategoryfixedassetcoadeprexp', mcategoryfixedassetcoadeprexp: 'mcategoryfixedassetcoadeprexp'},
							  {data: 'mcategoryfixedassetremark', mcategoryfixedassetremark: 'mcategoryfixedassetremark'}
          										]
									       });

  					        $(".table thead th input[type=text]").on( 'keyup change', function () {
  		    		            table
  		                      .column( $(this).parent().index()+':visible' )
  		                      .search( this.value )
  		                      .draw();
  		    		      	});
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
                        url: API_URL+"/mcategoryfixedassets/"+id,
                        success: function(response){
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
@section('js')
<script src="{{ url('/master/mcategoryfixedassets.js') }}"></script>
<script src="{{ url('/js/bootstrap-switch.min.js') }}"></script>
@stop
@section('css')
<link rel="stylesheet" href="{{ url('/css/onoff.css') }}">
  	<link rel="stylesheet" href="{{ url('/css/yesno.css') }}">
  	<link rel="stylesheet" href="{{ url('/css/bootstrap-datepicker3.min.css') }}">
<style type="text/css">
	.box-group1 {
			width: 92%;
			border: 4px #ddd solid;
			padding: 2%;
			margin-left: 50px;
		}
		.box-pajak-wrapper {
			margin-left: -110px;
		}
		.pajak-text {
			color: #777;
			margin-left: 4%;
			margin-bottom: 1%;
			margin-top: 3%;
		}

</style>
@stop