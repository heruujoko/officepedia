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
			<li>Home</li><li>Master</li><li>Pelanggan</li>
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
<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
	<h1 class="page-title txt-color-blueDark">
		<i class="fa fa-table fa-fw "></i>
		Pelanggan
		<span>
			Data Pelanggan
		</span>
	</h1>
</div>
<!-- MAIN CONTENT -->
<div id="content">

	<div class="row">

		<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
			<ul id="sparks" class="">
				<li class="sparks-info">
					<h5> My Income <span class="txt-color-blue">$47,171</span></h5>
					<div class="sparkline txt-color-blue hidden-mobile hidden-md hidden-sm">
						1300, 1877, 2500, 2577, 2000, 2100, 3000, 2700, 3631, 2471, 2700, 3631, 2471
					</div>
				</li>
				<li class="sparks-info">
					<h5> Site Traffic <span class="txt-color-purple"><i class="fa fa-arrow-circle-up" data-rel="bootstrap-tooltip" title="Increased"></i>&nbsp;45%</span></h5>
					<div class="sparkline txt-color-purple hidden-mobile hidden-md hidden-sm">
						110,150,300,130,400,240,220,310,220,300, 270, 210
					</div>
				</li>
				<li class="sparks-info">
					<h5> Site Orders <span class="txt-color-greenDark"><i class="fa fa-shopping-cart"></i>&nbsp;2447</span></h5>
					<div class="sparkline txt-color-greenDark hidden-mobile hidden-md hidden-sm">
						110,150,300,130,400,240,220,310,220,300, 270, 210
					</div>
				</li>
			</ul>
		</div>
	</div>

	<section id="widget-grid" class="">

		<!-- row -->
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

						<h2>Tambah Pelanggan </h2>



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

							<form id="teste" class="form-horizontal" action="{{URL::to('/')}}/admin-nano/tambahcabang" method="post">
								{{ csrf_field() }}
								<div class="container">


								</br>

								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>ID Pelanggan</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomerid" value="{{old('mcustomerid')}}" name="mcustomerid" class="form-control forminput" placeholder="ID Pelanggan" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Pelanggan"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Pelanggan</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomername" value="{{old('mcustomername')}}" name="mcustomername" class="form-control forminput" placeholder="Nama Pelanggan" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Pelanggan"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Email</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-email" value="{{old('email')}}" name="email" class="form-control forminput" placeholder="Email" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-home" rel="tooltip" title="Email"></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"><b>Telepon Kantor</b> (<font color="red">*</font>) &nbsp  :</label>
									<div  class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-officephone" value="{{old('officephone')}}" name="officephone" class="form-control forminput" placeholder="Telepon Kantor" type="number" required @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Telepon Kantor"></label>

										<div style="height: 5px;">
										<h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
										</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"><b>Fax Kantor</b> (<font color="red">*</font>) &nbsp  :</label>
									<div  class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomerfaxphone" value="{{old('mcustomerfaxphone')}}" name="mcustomerfaxphone" class="form-control forminput" placeholder="Fax Kantor" type="number" required @if (Session::has('autofocus')) autofocus @endif >

											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Fax Kantor"></label>

										<div style="height: 5px;">
										<h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
										</div>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Website</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomerwebsite" value="{{old('mcustomerwebsite')}}" name="mcustomerwebsite" class="form-control forminput" placeholder="Website" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-road" rel="tooltip" title="Website"></label>
										</div>
									</div>
								</div>

								<input type="hidden" name="void" value="0">
								<center>
									<div class="row">
										<div class="col-md-12">
											<a id="btn-insert-reset" onclick="reset()" class="btn btn-default" ><i class=""></i> Reset</a>
											<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Simpan</button>

										</div>
									</div>
								</center>
							</br>
						</div>

					</form>

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

				<div id="formedit" class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

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

						<h2>Pengubahan Cabang </h2>



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
									<label class="col-md-3 control-label"><b>Kode Cabang</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input  value="" id="mbranchcode" name="mbranchcode" class="form-control forminput" placeholder="Kode Cabang" type="text" required>
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="Kode Cabang"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Cabang</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input value="" id="mbranchname" name="mbranchname" class="form-control forminput" placeholder="Nama Cabang" type="text" required autofocus >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Cabang"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Alamat</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input value="" id="address" name="address" class="form-control forminput" placeholder="Alamat" type="text" required>
											<label for="mgoodsgroup1" class="glyphicon glyphicon-home" rel="tooltip" title="Alamat"></label>
										</div>
									</div>
								</div>
								<div  class="form-group">
									<label class="col-md-3 control-label"><b>Telepon</b> (<font color="red">*</font>) &nbsp  :</label>
									<div  class="col-md-7">
										<div class="icon-addon addon-md">
											<input value="" id="phone" name="phone" class="form-control forminput" placeholder="Telepon" type="number" required>

											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Telepon"></label>

										<div style="height: 5px;">
										<h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
										</div>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Kota</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input value="" id="city" name="city" class="form-control forminput" placeholder="Kota" type="text" required>
											<label for="mgoodsgroup1" class="glyphicon glyphicon-road" rel="tooltip" title="Kota"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Orang Yang Bertanggung Jawab</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input value="" id="person_in_charge" name="person_in_charge" class="form-control forminput" placeholder="Orang Yang Bertanggung Jawab" type="text" required>
											<label for="mgoodsgroup1" class="glyphicon glyphicon-user" rel="tooltip" title="Orang Yang Bertanggung Jawab"></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label"><b>Keterangan</b> &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input value="" id="information" name="information" class="form-control forminput" placeholder="Keterangan" type="text">
											<label for="mgoodsgroup1" class="glyphicon glyphicon-search" rel="tooltip" title="Keterangan"></label>
										</div>
									</div>
								</div>

								<center>
									<div class="row">
										<div class="col-md-12">
											<a onclick="back()" title="" class="btn btn-default">Batal</a>
											<button onclick="updatecabang()" class="btn btn-primary" type="submit">
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

							<div id="formview" class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

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

						<h2>View Cabang </h2>
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
									<label class="col-md-3 control-label"><b>Kode Cabang</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled value="" name="mbranchcode" class="form-control" placeholder="Kode Cabang" type="text" required id="mbranchcode2" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="Kode Cabang"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Cabang</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="mbranchname2" value="" name="mbranchname" class="form-control" placeholder="Nama Cabang" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Cabang"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Alamat</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="address2" value="" name="address" class="form-control" placeholder="Alamat" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-home" rel="tooltip" title="Alamat"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Telepon</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="phone2" value="" name="phone" class="form-control" placeholder="Telepon" type="number" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Telepon"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Kota</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="city2" value="" name="city" class="form-control" placeholder="Kota" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-road" rel="tooltip" title="Kota"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Orang Yang Bertanggung Jawab</b>(<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="person_in_charge2" value="" name="person_in_charge" class="form-control" placeholder="Orang yang bertanggung jawab" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-user" rel="tooltip" title="Orang Yang Bertanggung Jawab"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Keterangan</b> &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled value="" name="information" class="form-control" placeholder="Keterangan" type="text" id="information2" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-search" rel="tooltip" title="Keterangan"></label>
										</div>
									</div>
								</div>
								<center>
									<div class="row">
										<div class="col-md-12">
											</br>
											<button onclick="back()" class="btn btn-default" type="submit">
												<i class="fa fa-save"></i> Kembali</button>


											</div>
										</center>
									</br>

								</div>
							</div>
						</div>



					</div>


					<!-- end widget -->








					<!-- widget grid -->
					<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<section id="widget-grid" class="">

							<!-- row -->
							<div class="row">

								<!-- NEW WIDGET START -->


								<!-- Widget ID (each widget will need unique ID)-->
								<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
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
											<input type="text" class="form-control" placeholder="Filter Email" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter No Telp Kantor" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter No Fax Kantor" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Website" />
										</th>

										<th class="hasinput" style="width:15%">

										</th>
									</tr>
									<tr>
										<th data-hide="no"><center>No</center></th>
										<th data-hide="mcustomerid"><center>ID Pelanggan</center></th>
										<th data-hide="mcustomername"><center>Nama Pelanggan</center></th>
										<th data-hide="email"><center>Email</center></th>
										<th data-hide="officephone"><center>No Telp Kantor</center></th>
										<th data-hide="mcustomerfaxphone"><center>No Fax Kantor</center></th>
										<th data-hide="website"><center>Website</center></th>
										<th data-hide="action"><center>Aksi</center></th>



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
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            buttons: [ {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0,1,2]
                }
            },
            {
                extend: 'csvFlash',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5] //setting kolom mana yg mau di export
                }
            },
            {
                extend: 'excelFlash',
                exportOptions: {
	                    columns: [ 0, 1, 2, 3, 4, 5] //setting kolom mana yg mau di export
                }
            },
            {
                extend: 'pdfFlash',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5] //setting kolom mana yg mau di export
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5] //setting kolom mana yg mau di print
                }

            },
						{
							extend: 'colvis',
							columns: ':gt(1)'
						}
            ],

					       				processing: false,
										serverSide: false,
										ajax: '{{URL::to('/')}}/admin-api/datacabang',
										columns: [
										{data: 'no', no: 'no' },
										{data: 'mbranchcode', mbranchcode: 'mbranchcode'},
										{data: 'mbranchname', mbranchname: 'mbranchname'},
										{data: 'address', address: 'address'},
										{data: 'phone', phone: 'phone'},
										{data: 'phone', phone: 'phone'},
										{data: 'city', city: 'city'},
										{data: 'action', name:'action', searchable: false, orderable: false}
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
								// console.log('click');
								// var choice = confirm('Anda yakin akan menghapus ?');
								// if(choice){
								// 	window.location = '{{ URL::to('/') }}'+'/admin-nano/delcabang/'+id+'/delete';
								// }
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
					swal({
						title: "Terhapus!",
						text: "Data Anda Berhasil Terhapus.",
						type: "success",

						});
					window.setTimeout(function(){
					window.location = '{{ URL::to('/') }}'+'/admin-nano/delcabang/'+id+'/delete'
					},1000)
				}

					else {

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
