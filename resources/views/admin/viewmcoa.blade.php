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
		<div class="row">
			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div style="display: none;" id="forminputgp" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-table"></i> </span>
						<h2>Tambah MCOA Grand Parent</h2>
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
							<div id="insert-wrapper-gp" class="form-horizontal" data-parsley-validate>
								{{ csrf_field() }}
								<div class="container">
								</br>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Kode Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-mcoagrandparentcode" value="{{old('mbranchcode')}}" name="mcoagrandparentcode" class="form-control forminput" placeholder="Kode Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="Kode Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-mcoagrandparentname" value="{{old('mbranchname')}}" name="mcoagrandparentname" class="form-control forminput" placeholder="Nama Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Tipe Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                      <select id="insert-mcoagrandparenttype" value="{{old('address')}}" name="mcoagrandparenttype" class="form-control forminput select2" placeholder="Tipe Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif>
                        <option value="K">Kredit</option>
                        <option value="D">Debet</option>
                      </select>
											<!-- <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Tipe Grand Parent"></label> -->
										</div>
									</div>
								</div>
								<input type="hidden" name="void" value="0">
								<center>
									<div class="row">
										<div class="col-md-12">
											<a id="btn-insert-reset" onclick="resetgrandparent()" class="btn btn-default" ><i class=""></i> Reset</a>
											<button class="btn btn-primary" onclick="insertgrandparent()"><i class="fa fa-save"></i> Simpan</button>
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
		<!-- row -->
		<div class="row">
			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div style="display: none;" id="formeditgp" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-table"></i> </span>
						<h2>EDIT MCOA Grand Parent</h2>
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
							<div id="edit-wrapper-gp" class="form-horizontal" data-parsley-validate>
								{{ csrf_field() }}
								<div class="container">
								</br>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Kode Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<input type="hidden" id="mcoagrandparentid">
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="edit-mcoagrandparentcode" value="{{old('mbranchcode')}}" name="mcoagrandparentcode" class="form-control forminput" placeholder="Kode Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="Kode Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="edit-mcoagrandparentname" value="{{old('mbranchname')}}" name="mcoagrandparentname" class="form-control forminput" placeholder="Nama Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Tipe Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                      <select id="edit-mcoagrandparenttype" value="{{old('address')}}" name="mcoagrandparenttype" class="form-control forminput select2" placeholder="Tipe Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif>
                        <option value="K">Kredit</option>
                        <option value="D">Debet</option>
                      </select>
											<!-- <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Tipe Grand Parent"></label> -->
										</div>
									</div>
								</div>
								<input type="hidden" name="void" value="0">
								<center>
									<div class="row">
										<div class="col-md-12">
											<a id="btn-insert-reset" onclick="resetgrandparent()" class="btn btn-default" ><i class=""></i> Reset</a>
											<button class="btn btn-primary" onclick="updategrandparent()"><i class="fa fa-save"></i> Simpan</button>
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
		<!-- row -->
		<div class="row">
			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div style="display: none;" id="formviewgp" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-table"></i> </span>
						<h2>View MCOA Grand Parent</h2>
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
							<div id="insert-wrapper-gp" class="form-horizontal" data-parsley-validate>
								{{ csrf_field() }}
								<div class="container">
								</br>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Kode Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcoagrandparentcode" value="{{old('mbranchcode')}}" name="mcoagrandparentcode" class="form-control forminput" placeholder="Kode Grand Parent" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="Kode Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcoagrandparentname" value="{{old('mbranchname')}}" name="mcoagrandparentname" class="form-control forminput" placeholder="Nama Grand Parent" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Tipe Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                      <select disabled id="view-mcoagrandparenttype" value="{{old('address')}}" name="mcoagrandparenttype" class="form-control forminput" placeholder="Tipe Grand Parent" type="text" required @if (Session::has('autofocus')) autofocus @endif>
                        <option value="K">Kredit</option>
                        <option value="D">Debet</option>
                      </select>
											<!-- <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Tipe Grand Parent"></label> -->
										</div>
									</div>
								</div>
								<center>
									<div class="row">
										<div class="col-md-12">
											</br>
											<button onclick="backall()" class="btn btn-default" type="submit">
												<i class="fa fa-save"></i> Kembali
                      </button>
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
		<!-- row -->
		<div class="row">
			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div id="forminputp" style="display: none;" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-table"></i> </span>
						<h2>Tambah MCOA Parent</h2>
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
							<div id="insert-wrapper-parent" class="form-horizontal" data-parsley-validate>
								{{ csrf_field() }}
								<div class="container">
								</br>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Kode Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-mcoaparentcode" value="{{old('mbranchcode')}}" name="mcoaparentcode" class="form-control forminput" placeholder="Kode Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="Kode Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-mcoaparentname" value="{{old('mbranchname')}}" name="mcoaparentname" class="form-control forminput" placeholder="Nama Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Grand Parent"></label>
										</div>
									</div>
								</div>
                <div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                      <select id="insert-mcoagrandparent" value="{{old('address')}}" name="mcoagrandparent" class="form-control forminput select2" placeholder="Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif>
                        @foreach($gparents as $gp)
                          <option value="{{ $gp->mcoagrandparentcode }}">{{ $gp->mcoagrandparentname }}</option>
                        @endforeach
                      </select>
											<!-- <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Tipe Grand Parent"></label> -->
										</div>
									</div>
								</div>
								<input type="hidden" name="void" value="0">
								<center>
									<div class="row">
										<div class="col-md-12">
											<a id="btn-insert-reset" onclick="resetparent()" class="btn btn-default" ><i class=""></i> Reset</a>
											<button class="btn btn-primary" onclick="insertparent()"><i class="fa fa-save"></i> Simpan</button>
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
		<!-- row -->
		<div class="row">
			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div id="formeditp" style="display: none;" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-table"></i> </span>
						<h2>Edit MCOA Parent</h2>
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
							<div id="edit-wrapper-parent" class="form-horizontal" data-parsley-validate>
								{{ csrf_field() }}
								<div class="container">
								</br>
								<div style="height: 21px;" class="form-group">
									<input type="hidden" id="mcoaparentid">
									<label class="col-md-3 control-label"><b>Kode Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="edit-mcoaparentcode" value="{{old('mbranchcode')}}" name="mcoaparentcode" class="form-control forminput" placeholder="Kode Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="Kode Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="edit-mcoaparentname" value="{{old('mbranchname')}}" name="mcoaparentname" class="form-control forminput" placeholder="Nama Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Grand Parent"></label>
										</div>
									</div>
								</div>
                <div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                      <select id="edit-mcoagrandparent" value="{{old('address')}}" name="mcoagrandparent" class="form-control forminput select2" placeholder="Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif>
                        @foreach($gparents as $gp)
                          <option value="{{ $gp->mcoagrandparentcode }}">{{ $gp->mcoagrandparentname }}</option>
                        @endforeach
                      </select>
											<!-- <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Tipe Grand Parent"></label> -->
										</div>
									</div>
								</div>
								<input type="hidden" name="void" value="0">
								<center>
									<div class="row">
										<div class="col-md-12">
											<a id="btn-edit-reset" onclick="resetparent()" class="btn btn-default" ><i class=""></i> Reset</a>
											<button class="btn btn-primary" onclick="updateparent()"><i class="fa fa-save"></i> Simpan</button>
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
		<!-- row -->
		<div class="row">
			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div id="formviewp" style="display: none;" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-table"></i> </span>
						<h2>View MCOA Parent</h2>
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
							<div id="insert-wrapper-parent" class="form-horizontal" data-parsley-validate>
								{{ csrf_field() }}
								<div class="container">
								</br>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Kode Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcoaparentcode" value="{{old('mbranchcode')}}" name="mcoaparentcode" class="form-control forminput" placeholder="Kode Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="Kode Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcoaparentname" value="{{old('mbranchname')}}" name="mcoaparentname" class="form-control forminput" placeholder="Nama Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Grand Parent"></label>
										</div>
									</div>
								</div>
                <div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                      <select disabled id="view-mcoagrandparent" value="{{old('address')}}" name="mcoagrandparent" class="form-control forminput" placeholder="Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif>
                        @foreach($gparents as $gp)
                          <option value="{{ $gp->mcoagrandparentcode }}">{{ $gp->mcoagrandparentname }}</option>
                        @endforeach
                      </select>
											<!-- <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Tipe Grand Parent"></label> -->
										</div>
									</div>
								</div>
								<center>
									<div class="row">
										<div class="col-md-12">
											</br>
											<button onclick="backall()" class="btn btn-default" type="submit">
												<i class="fa fa-save"></i> Kembali
                      </button>
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
		<!-- row -->
		<div class="row">
			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div id="forminput" style="display:none !important;" class="forminputcoa forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
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
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Kode</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<div class="input-group">
												<input id="insert-mcoacode" value="{{old('mbranchcode')}}" name="mcoa" class="form-control forminput" placeholder="Kode" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" data-parsley-errors-container=".errorBlock" @if (Session::has('autofocus')) autofocus @endif >
												<span class="input-group-addon">
									        <input id="insert-automcoacode" type="checkbox" name="automcoacode" title="Auto Generate Kode Akun" rel="tooltip">
									      </span>
											</div>
											<div class="errorBlock"></div>
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="Kode Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-mcoaname" value="{{old('mbranchname')}}" name="mcoa" class="form-control forminput" placeholder="Nama" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Grand Parent"></label>
										</div>
									</div>
								</div>
                <div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Tipe</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                      <select id="insert-mcoatype" value="{{old('address')}}" name="mcoatype" class="form-control forminput select2" placeholder="Tipe" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif>
                        <option value="K">Kredit</option>
                        <option value="D">Debet</option>
                      </select>
											<!-- <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Tipe Grand Parent"></label> -->
										</div>
									</div>
								</div>
                <div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                      <select id="insert-mcoaparent" value="{{old('address')}}" name="mcoaparent" class="form-control forminput select2" placeholder="Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif>
                        @foreach($parents as $gp)
                          <option value="{{ $gp->mcoaparentcode }}">{{ $gp->mcoaparentname }}</option>
                        @endforeach
                      </select>
											<!-- <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Tipe Grand Parent"></label> -->
										</div>
									</div>
								</div>
								<input type="hidden" name="void" value="0">
								<center>
									<div class="row">
										<div class="col-md-12">
											<a id="btn-insert-reset" onclick="resetmcoa()" class="btn btn-default" ><i class=""></i> Reset</a>
											<button class="btn btn-primary" onclick="insertmcoa()"><i class="fa fa-save"></i> Simpan</button>
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
                <input type="hidden" id="mcoaid">
                <div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Kode</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="edit-mcoacode" value="{{old('mbranchcode')}}" name="mcoaparentcode" class="form-control forminput" placeholder="Kode Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="Kode Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="edit-mcoaname" value="{{old('mbranchname')}}" name="mcoaparentname" class="form-control forminput" placeholder="Nama Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Grand Parent"></label>
										</div>
									</div>
								</div>
                <div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Tipe</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                      <select id="edit-mcoatype" value="{{old('address')}}" name="mcoatype" class="form-control forminput select2" placeholder="Tipe" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif>
                        <option value="K">Kredit</option>
                        <option value="D">Debet</option>
                      </select>
											<!-- <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Tipe Grand Parent"></label> -->
										</div>
									</div>
								</div>
                <div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                      <select id="edit-mcoaparent" value="{{old('address')}}" name="mcoagrandparent" class="form-control forminput select2" placeholder="Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif>
                        @foreach($parents as $gp)
                          <option value="{{ $gp->mcoaparentcode }}">{{ $gp->mcoaparentname }}</option>
                        @endforeach
                      </select>
											<!-- <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Tipe Grand Parent"></label> -->
										</div>
									</div>
								</div>
								<input type="hidden" name="void" value="0">
								<center>
									<div class="row">
										<div class="col-md-12">
											<a onclick="backmcoa()" title="" class="btn btn-default">Batal</a>
											<button onclick="updatemcoa()" class="btn btn-primary" type="submit">
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
                <div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Kode</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled="" id="view-mcoacode" value="{{old('mbranchcode')}}" name="mcoaparentcode" class="form-control forminput" placeholder="Kode Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="Kode Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled="" id="view-mcoaname" value="{{old('mbranchname')}}" name="mcoaparentname" class="form-control forminput" placeholder="Nama Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Grand Parent"></label>
										</div>
									</div>
								</div>
                <div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Tipe</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                      <select disabled="" id="view-mcoatype" value="{{old('address')}}" name="mcoatype" class="form-control forminput" placeholder="Tipe" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif>
                        <option value="K">Kredit</option>
                        <option value="D">Debet</option>
                      </select>
											<!-- <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Tipe Grand Parent"></label> -->
										</div>
									</div>
								</div>
                <div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                      <select disabled="" id="view-mcoaparent" value="{{old('address')}}" name="mcoagrandparent" class="form-control forminput" placeholder="Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif>
                        @foreach($parents as $gp)
                          <option value="{{ $gp->mcoaparentcode }}">{{ $gp->mcoaparentname }}</option>
                        @endforeach
                      </select>
											<!-- <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Tipe Grand Parent"></label> -->
										</div>
									</div>
								</div>
								<center>
									<div class="row">
										<div class="col-md-12">
											</br>
											<button onclick="backgrandparent()" class="btn btn-default" type="submit">
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
						<div class="row">
							<div class="container">
						<div class="row container">
						<table  id="tableapi" class="tableapi table table-bordered" width="100%">

							<thead>
								<tr>
									<th class="hasinput" style="width:10%">

									</th>
									<th class="hasinput" style="width:1%">
										<input type="text" class="form-control" placeholder="Filter No" />
									</th>
									<th class="hasinput" style="width:3%">
										<input type="text" class="form-control" placeholder="Filter Kode" />
									</th>
									<th class="hasinput" style="width:9%">
										<input type="text" class="form-control" placeholder="Filter Nama" />
									</th>
									<th class="hasinput" style="width:1%">
										<input type="text" class="form-control" placeholder="Filter Tipe" />
									</th>
									<th class="hasinput" style="width:9%">
										<input type="text" class="form-control" placeholder="Filter Saldo" />
									</th>
								</tr>
								<tr>
									<th data-hide="action"><center>Aksi</center></th>
									<th data-hide="no"><center>No</center></th>
									<th data-hide="code"><center>Kode</center></th>
									<th data-hide="name"><center>Nama</center></th>
									<th data-hide="type"><center>Tipe</center></th>
									<th data-hide="saldo"><center>Saldo</center></th>
								</tr>
							</thead>
							<tbody>
							</tbody>

						</table>
<<<<<<< HEAD
=======

						<div id="loading_modal" class="modal" style="top: 40%;" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
							<div class="modal-dialog">
						  	<div class="modal-content">
						    	<div class="modal-header" style="text-align: center">
						      	<h3>Loading Data</h3>
										<img src="{{ url('master/ajax-loader.gif') }}">
						      </div>
						    </div>
						  </div>
						</div>
>>>>>>> f7c713e376d2d81ea3f4ad1dbc57f77e37428c38
						<!-- <div class="tree smart-form container" id="mcoatree">
							<ul role="tree">
								@foreach($gparents as $gp)
								<li class="parent_li" role="treeitem">
									<span title="Collapse this branch"><i class="fa fa-lg fa-folder-open"></i> <b>{{ $gp->mcoagrandparentcode }}</b> {{ $gp->mcoagrandparentname }} / Rp. {{ $gp->saldo }}</span>
									<ul role="group">
										@foreach($gp->childs() as $parent)
										<li class="parent_li" role="treeitem">
											<span title="Collapse this branch"><i class="fa fa-lg fa-plus-circle"></i> <b>{{ $parent->mcoaparentcode }}</b> {{ $parent->mcoaparentname }} / Rp. {{ $parent->saldo }}</span>
											<ul role="group">
												<li>
													<span title="Collapse this branch" class="addtree" onclick="addcoa('{{ $parent->mcoaparentcode }}','{{ $parent->mcoaparenttype}}')"><i class="fa fa-lg fa-plus-circle"></i> <b>Add New</b></span>
												</li>
												@foreach($parent->childs() as $coa)
												<li>
													<span title="Collapse this branch"><i class="fa fa-lg fa-plus-circle"></i> <b>{{ $coa->mcoacode }}</b> {{ $coa->mcoaname }} / Rp. {{ $coa->saldo }}</span>
													<div class="btn-group">
														<button class="btn btn-default dropdown-toggle btn-tree" data-toggle="dropdown" aria-expanded="false">
															Action <i class="fa fa-caret-down"></i>
														</button>
														<ul class="dropdown-menu treemenu">
															<li>
																<a onclick="viewmcoa({{ $coa->id }})">View</a>
															</li>
															<li>
																<a onclick="editmcoa({{ $coa->id }})">Edit</a>
															</li>
															<li>
																<a onclick="popupdelete({{ $coa->id }})">Delete</a>
															</li>
														</ul>
													</div>
												</li>
												@endforeach
											</ul>
										</li>
										@endforeach
									</ul>
								</li>
								@endforeach
							</ul>
						</div> -->
						</div>
							@push('scripts')
							<tfoot>
							<script>
									$(document).ready(function(){
										$('.tree > ul').attr('role', 'tree').find('ul').attr('role', 'group');
										$('.tree').find('li:has(ul)').addClass('parent_li').attr('role', 'treeitem').find(' > span').attr('title', 'Collapse this branch').on('click', function(e) {
											var children = $(this).parent('li.parent_li').find(' > ul > li');
											if (children.is(':visible')) {
												children.hide('fast');
												$(this).attr('title', 'Expand this branch').find(' > i').removeClass().addClass('fa fa-lg fa-plus-circle');
											} else {
												children.show('fast');
												$(this).attr('title', 'Collapse this branch').find(' > i').removeClass().addClass('fa fa-lg fa-minus-circle');
											}
											e.stopPropagation();
										});
										$('#forminputgp').hide();
										$('#forminputp').hide();
										$('#forminput').hide();
									});
			            var table;
			            $(function(){
<<<<<<< HEAD
			                 table = $('.tableapi').DataTable({
=======
			                 table = $('.tableapi')
											 .on('preXhr.dt',function(){
												 $('#loading_modal').modal('show');
											 })
											 .DataTable({
>>>>>>> f7c713e376d2d81ea3f4ad1dbc57f77e37428c38
                  			      dom: "<'dtpadding' <'row' <'clmn' C> <'srch' f> <'tablerow' l> <'clear'> <'masterbutton' B> r> <'row pb' tip>>",
                                  "autoWidth" : true,
																	"oLanguage": {
                                    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
																		"sLengthMenu": "Show _MENU_ Entries",
																		"sInfo": "Showing ( _START_ to _END_ ) to _TOTAL_ Entries"
                                  },
                              buttons: [
																{
																		text: 'Add Grand Parent',
																		action: function(){
																			addgparent();
																		}
																},
																{
																		text: 'Add Parent',
																		action: function(){
																			addparent();
																		}
																},
																{
																		text: 'Add Akun',
																		action: function(){
																			addakun();
																		}
																},
																{
                                    extend: 'copyHtml5',
                                    exportOptions: {
                                        columns: [ 1,2,3,4,5]
                                    }
                                  },
																	{
                                      text: 'CSV',
                                      action: function(){
																				window.location.href = "{{ url('admin-nano/mcoa/export/csv') }}";
																			}
                                  },
                                  {
																			text: 'Excel',
																			action: function(){
																				window.location.href = "{{ url('admin-nano/mcoa/export/excel') }}";
																			}
                                  },
                                  {
																			text: 'PDF',
																			action: function(){
																				window.location.href = "{{ url('admin-nano/mcoa/export/pdf') }}";
																			}
                                  },
                                  {
                                      extend: 'print',
                                      exportOptions: {
                                          columns: [ 1, 2, 3, 4,5] //setting kolom mana yg mau di export
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
															iDisplayLength: 100,
										          ajax: '{{URL::to('/')}}/admin-api/mcoa',
          										columns: [
                              {data: 'action', name:'action', searchable: false, orderable: false},
                              {data: 'no', no: 'no' },
                              {data: 'code', code: 'code'},
          										{data: 'spanname', spanname: 'spanname'},
															{data: 'type', type: 'type'},
          										{data: 'saldoright', saldoright: 'saldoright'}
          										]
<<<<<<< HEAD
									       });
=======
									       })
												 .on('xhr.dt',function(){
													 $('#loading_modal').modal('hide');
												 });
>>>>>>> f7c713e376d2d81ea3f4ad1dbc57f77e37428c38

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
                        url: API_URL+"/mcoa/"+id,
                        success: function(response){
                          console.log(response);
                          table.ajax.reload();
                          window.location = "#tableapi";
                          swal({
              						  title: "Terhapus!",
              						  text: "Data Anda Berhasil Terhapus.",
              						  type: "success",
            						  });
                          $('#forminput').hide();
                    			$('#formview').hide();
                    			$('#formedit').hide();
													// updatetree();
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
