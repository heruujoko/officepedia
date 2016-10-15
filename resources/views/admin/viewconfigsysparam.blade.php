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
			<li>Home</li><li>Setting Sistem</li><li>{{ $section }}</li>
		</ol>
	</div>
	<!-- END RIBBON -->
	<!-- MAIN CONTENT -->
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa fa-table fa-fw "></i>
						Setting Sistem
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
							<!-- <h3 style="font-weight: bold; color: #1883B8;font-size: 19px;">Mode : INSERT</h3> -->
							<!-- widget content -->
							<div class="widget-body no-padding">
							    <div class="container">
                    <div class="row">
                      <h2></h2>
                      <ul class="nav nav-tabs" style="padding-left:10px;">
                       	<li class="active"><a data-toggle="tab" href="#menu1">Profil Perusahaan</a></li>
                       	<li><a data-toggle="tab" href="#menu2">Fitur Umum</a></li>
                    	 	<li><a data-toggle="tab" href="#menu3">Header Prefix</a></li>
                      </ul>
                      <div id="insert-wrapper" class="tab-content" data-parsley-validate>
                        <div id="menu1" class="tab-pane fade in active">
                          <div class="form form-horizontal" style="margin-top:21px;">
                            <div class="col-md-8">
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Nama</b> (<font color="red">*</font>) &nbsp  :</label>
                          			<div class="col-md-9">
                                  <input id="edit-msyscompname" value="" name="msyscompname" class="form-control forminput" placeholder="Nama Perusahaan" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Telpon</b> &nbsp  :</label>
                          			<div class="col-md-9">
                                  <input id="edit-msyscompphone" value="" name="msyscompphone" class="form-control forminput phoneregex" placeholder="Telpon Perusahaan" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Faximile</b> &nbsp  :</label>
                          			<div class="col-md-9">
                                  <input id="edit-msyscompfax" value="" name="msyscompfax" class="form-control forminput phoneregex" placeholder="Faximile Perusahaan" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Email</b> &nbsp  :</label>
                          			<div class="col-md-9">
                                  <input id="edit-msyscompemail" value="" name="msyscompemail" class="form-control forminput" placeholder="Email Perusahaan" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Website</b> &nbsp  :</label>
                          			<div class="col-md-9">
                                  <input id="edit-msyscompwebsite" value="" name="msyscompwebsite" class="form-control forminput" placeholder="Website Perusahaan" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Tanggal Mulai Data</b> &nbsp  :</label>
                          			<div class="col-md-9">
                                  <input id="edit-msyscompstartdate" value="" name="msyscompstartdate" class="form-control forminput datepicker" placeholder="Tanggal Mulai Data" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Mata Uang</b> &nbsp  :</label>
                          			<div class="col-md-9">
                                  <select id="edit-msyscompcurrency" class="form-control select2">
                                      <option value="Rp">Rupiah (Rp)</option>
                                  </select>
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Alamat</b> &nbsp  :</label>
                          			<div class="col-md-9">
                                  <input id="edit-msyscompaddress" value="" name="msyscompaddress" class="form-control forminput" placeholder="Alamat Perusahaan" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>NPWP</b> &nbsp  :</label>
                          			<div class="col-md-9">
                                  <input id="edit-msyscomptaxpayeridnumber" name="msyscomptaxpayeridnumber" class="form-control forminput" placeholder="NPWP Perusahaan" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>PKP Yes Or No</b> &nbsp  :</label>
                          			<div class="col-md-9">
                                  <input id="edit-msyscomptaxable" type="checkbox" class="nice-toggle" name="msyscomptaxable">
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Tgl PKP</b> &nbsp  :</label>
                          			<div class="col-md-9">
                                  <input id="edit-msyscomptaxabledate" type="text" class="form-control datepicker" name="msyscomptaxabledate" placeholder="Tgl PKP">
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>No PKP</b> &nbsp  :</label>
                          			<div class="col-md-9">
                                  <input id="edit-msyscomptaxablenumber" type="text" class="form-control" name="msyscomptaxablenumber" placeholder="No PKP">
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>KLU</b> &nbsp  :</label>
                          			<div class="col-md-9">
                                  <input id="edit-msyscompklu" type="text" class="form-control" name="msyscompklu" placeholder="KLU">
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Alamat NPWP</b> &nbsp  :</label>
                          			<div class="col-md-9">
                                  <input id="edit-msyscomptaxpayeridaddress" type="text" class="form-control" name="msyscomptaxpayeridaddress" placeholder="Alamat NPWP">
                          			</div>
                              </div>
                            </div>
														<div class="col-md-4">
															<div class="form-group">
                                <label class="col-md-3 control-label"><b>Logo</b> &nbsp  :</label>
                          			<div class="col-md-8">
																	<div class="row">
																		<img id="logoimageid" width="100" height="100">
																	</div>
																	<br>
																	<div class="row">
																		<form action="upload.php">
																        <input type="hidden">
																        <div id="dropzone-logo" class="dropzone"></div>
																    </form>
																		<br>
	                                  <input id="edit-msyscomplogo" value="" name="msyscomplogo" class="form-control forminput" placeholder="Logo Perusahaan" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
																	</div>
                          			</div>
                              </div>
														</div>
                          </div>
                        </div>
                        <div id="menu2" class="tab-pane">
                          <div class="form form-horizontal">
                            <div class="form-group" style="margin-top:21px;">
                              <label class="col-md-2 control-label"><b>Akuntansi Manufaktur</b> (<font color="red">*</font>) &nbsp  :</label>
                              <div class="col-md-9">
                                <input id="edit-msysgenmanufacturingacc" type="checkbox" class="nice-toggle" name="msysgenmanufacturingacc" placeholder="Akuntansi Manufaktur">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-2 control-label"><b>Multi Cabang</b> (<font color="red">*</font>) &nbsp  :</label>
                              <div class="col-md-9">
                                <input id="edit-msysgenmultibranch" type="checkbox" class="nice-toggle" name="msysgenmultibranch" placeholder="Multi Cabang">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-2 control-label"><b>Multi Mata Uang</b> (<font color="red">*</font>) &nbsp  :</label>
                              <div class="col-md-9">
                                <input id="edit-msysgenmulticurrency" type="checkbox" class="nice-toggle" name="msysgenmulticurrency" placeholder="Multi Mata Uang">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-2 control-label"><b>Default PPN</b> (<font color="red">*</font>) &nbsp  :</label>
                              <div class="col-md-9">
                                <input id="edit-msysgendefaulttax" type="checkbox" class="nice-toggle" name="msysgendefaulttax" placeholder="Default PPN">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-2 control-label"><b>Persetujuan</b> (<font color="red">*</font>) &nbsp  :</label>
                              <div class="col-md-9">
                                <input id="edit-msysgenapproval" type="checkbox" class="nice-toggle" name="msysgenapproval" placeholder="Default Persetujuan">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-2 control-label"><b>Persetujuan</b> (<font color="red">*</font>) &nbsp  :</label>
                              <div class="col-md-9">
                                <input id="edit-msysgenfixedasset" type="checkbox" class="nice-toggle" name="msysgenfixedasset" placeholder="Persetujuan">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-md-2 control-label"><b>Pembulatan Desimal</b> (<font color="red">*</font>) &nbsp  :</label>
                              <div class="col-md-1">
                                <select id="edit-msysgenrounddec" class="form-control select2">
                                  <option value="0">0</option>
                                  <option value="2">2</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="menu3" class="tab-pane">
                          <div class="tab-pane">
                            <div class="form form-horizontal" style="margin-top:21px;">
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Master Barang</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixgoods" type="text" maxlength="3" minlength="3" class="form-control" name="msysprefixgoods" placeholder="Prefix Master Barang" required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixgoodslastcount" disabled type="text" class="form-control" name="msysprefixgoodslastcount">
                                </div>
                                <div class="col-md-2">
                                  <label class="example-label" id="edit-msysprefixgoodsexample">BRG00001</label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Master Supplier</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixsupplier" type="text" maxlength="3" minlength="3" class="form-control" name="msysprefixsupplier" placeholder="Prefix Master Supplier" required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixsupplierlastcount" disabled type="text" class="form-control" name="msysprefixsupplierlastcount">
                                </div>
                                <div class="col-md-2">
                                  <label class="example-label" id="edit-msysprefixsupplierexample">BRG00001</label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Master Pelanggan</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixcustomer" type="text" maxlength="3" minlength="3" class="form-control" name="msysprefixcustomer" placeholder="Prefix Master Pelanggan" required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixcustomerlastcount" disabled type="text" class="form-control" name="msysprefixcustomerlastcount">
                                </div>
                                <div class="col-md-2">
                                  <label class="example-label" id="edit-msysprefixcustomerexample">BRG00001</label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Master Karyawan</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixemployee" type="text" maxlength="3" minlength="3" class="form-control" name="msysprefixemployee" placeholder="Prefix Master Karyawan" required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixemployeelastcount" disabled type="text" class="form-control" name="msysprefixemployeelastcount">
                                </div>
                                <div class="col-md-2">
                                  <label class="example-label" id="edit-msysprefixemployeeexample">BRG00001</label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Penawaran Penjualan</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixinvquotation" type="text" maxlength="3" minlength="3" class="form-control" name="msysprefixinvquotation" placeholder="Prefix Penawaran Penjualan" required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixinvquotationlastcount" disabled type="text" class="form-control" name="msysprefixinvquotationlastcount">
                                </div>
                                <div class="col-md-2">
                                  <label class="example-label" id="edit-msysprefixinvquotationexample">BRG00001</label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Order Penjualan</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixinvorder" type="text" maxlength="3" minlength="3" class="form-control" name="msysprefixinvorder" placeholder="Prefix Order Penjualan" required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixinvorderlastcount" disabled type="text" class="form-control" name="msysprefixinvorderlastcount">
                                </div>
                                <div class="col-md-2">
                                  <label class="example-label" id="edit-msysprefixinvorderexample">BRG00001</label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Invoice Penjualan</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixinvoice" type="text" maxlength="3" minlength="3" class="form-control" name="msysprefixinvoice" placeholder="Prefix Invoice Penjualan" required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixinvoicelastcount" disabled type="text" class="form-control" name="msysprefixinvoicelastcount">
                                </div>
                                <div class="col-md-2">
                                  <label class="example-label" id="edit-msysprefixinvoiceexample">BRG00001</label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Permintaan Pembelian</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixpurchrequest" type="text" maxlength="3" minlength="3" class="form-control" name="msysprefixpurchrequest" placeholder="Prefix Permintaan Pembelian" required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixpurchrequestlastcount" disabled type="text" class="form-control" name="msysprefixpurchrequestlastcount">
                                </div>
                                <div class="col-md-2">
                                  <label class="example-label" id="edit-msysprefixpurchrequestexample">BRG00001</label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Order Pembelian</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixpurchorder" type="text" maxlength="3" minlength="3" class="form-control" name="msysprefixpurchorder" placeholder="Prefix Order Pembelian" required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixpurchorderlastcount" disabled type="text" class="form-control" name="msysprefixpurchorderlastcount">
                                </div>
                                <div class="col-md-2">
                                  <label class="example-label" id="edit-msysprefixpurchorderexample">BRG00001</label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Invoice Pembelian</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixpurchinv" type="text" maxlength="3" minlength="3" class="form-control" name="msysprefixpurchinv" placeholder="Prefix Invoice Pembelian" required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixpurchinvlastcount" disabled type="text" class="form-control" name="msysprefixpurchinvlastcount">
                                </div>
                                <div class="col-md-2">
                                  <label class="example-label" id="edit-msysprefixpurchinvexample">BRG00001</label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Pembelian Aset Tetap</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixedasset" type="text" maxlength="3" minlength="3" class="form-control" name="msysprefixedasset" placeholder="Prefix Pembelian Aset Tetap" required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixedassetlastcount" disabled type="text" class="form-control" name="msysprefixedassetlastcount">
                                </div>
                                <div class="col-md-2">
                                  <label class="example-label" id="edit-msysprefixedassetexample">BRG00001</label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Penerimaan Kas</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixcashreceipt" type="text" maxlength="3" minlength="3" class="form-control" name="msysprefixcashreceipt" placeholder="Prefix Penerimaan Kas" required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixcashreceiptlastcount" disabled type="text" class="form-control" name="msysprefixcashreceiptlastcount">
                                </div>
                                <div class="col-md-2">
                                  <label class="example-label" id="edit-msysprefixcashreceiptexample">BRG00001</label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Pengeluaran Kas</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixcashout" type="text" maxlength="3" minlength="3" class="form-control" name="msysprefixcashout" placeholder="Prefix Pengeluaran Kas" required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixcashoutlastcount" disabled type="text" class="form-control" name="msysprefixcashoutlastcount">
                                </div>
                                <div class="col-md-2">
                                  <label class="example-label" id="edit-msysprefixcashoutexample">BRG00001</label>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-2 control-label"><b>Rekonsal Bank</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixbankrecon" type="text" maxlength="3" minlength="3" class="form-control" name="msysprefixbankrecon" placeholder="Prefix Rekonsal Bank" required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
                                </div>
                                <div class="col-md-2">
                                  <input id="edit-msysprefixbankreconlastcount" disabled type="text" class="form-control" name="msysprefixbankreconlastcount">
                                </div>
                                <div class="col-md-2">
                                  <label class="example-label" id="edit-msysprefixbankreconexample">BRG00001</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-offset-5 col-md-5" style="margin-top:20px;margin-bottom:20px;">
                        <button onclick="update_params()" type="submit" name="button" class="btn btn-primary">Simpan</button>
                      </div>
                    </div>
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
@stop

@section('js')
<script src="{{ url('/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ url('/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ url('/js/dropzone.js') }}"></script>
<script src="{{ url('/master/sysparam.js') }}"></script>
<script>
	$("#dropzone-logo").dropzone({
		paramName: "logo",
		url: "{{ url('admin-api/mconfig/logo/') }}",
		success: function(response){
			var parsed = $.parseJSON(response.xhr.response);
			$('#edit-msyscomplogo').val(parsed.url);
			swal({
				title: "Upload Sukses!",
				type: "success",
				timer: 3000
			});
			$("#logoimageid").attr('src', parsed.url);
		},
		error: function(response){
			var parsed = $.parseJSON(response.xhr.response);
			this.removeAllFiles(true);
			swal({
				title: "Upload Gagal!",
				text: parsed,
				type: "error",
				timer: 1000
			});
		}
	 });
	// new Dropzone($("#dropzone-logo").get(0));
</script>
@stop

@section('css')
	<link rel="stylesheet" href="{{ url('/css/dropzone.css') }}">
  <link rel="stylesheet" href="{{ url('/css/bootstrap-switch.min.css') }}">
  <link rel="stylesheet" href="{{ url('/css/bootstrap-datepicker3.min.css') }}">
  <style>
    .example-label {
      padding-top: 7px;
      font-size: 15px;
      color: #aaa;
    }
  </style>
@stop
