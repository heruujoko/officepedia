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
                       	<li class="active"><a data-toggle="tab" href="#menu1">Fitur Penjualan</a></li>
                       	<li><a data-toggle="tab" href="#menu2">Fitur Pembelian</a></li>
                    	 	<li><a data-toggle="tab" href="#menu3">Fitur Akuntansi</a></li>
                        <li><a data-toggle="tab" href="#menu4">Fitur Kas Bank</a></li>
                        <li><a data-toggle="tab" href="#menu5">Inventory</a></li>
                      </ul>
                        <div id="insert-wrapper" class="tab-content" data-parsley-validate>
                        <div id="menu1" class="tab-pane fade in active">
                          <div class="form form-horizontal" style="margin-top:21px;">
                            <div class="col-md-12">
                            

                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Penawaran Penjualan </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msysinvquotation" class="yesnoswitch-checkbox" id="edit-msysinvquotation">
                                        <label class="yesnoswitch-label" for="edit-msysinvquotation">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>
                               <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Order Penjualan (Performa Invoice) </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msysinvproformainvoice" class="yesnoswitch-checkbox" id="edit-msysinvproformainvoice">
                                        <label class="yesnoswitch-label" for="edit-msysinvproformainvoice">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>
                               <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Invoice Penjualan </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msysinvsellinginvoice" class="yesnoswitch-checkbox" id="edit-msysinvsellinginvoice">
                                        <label class="yesnoswitch-label" for="edit-msysinvsellinginvoice">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>

                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Lock Harga Jual </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msysinvlocksellingprice" class="yesnoswitch-checkbox" id="edit-msysinvlocksellingprice">
                                        <label class="yesnoswitch-label" for="edit-msysinvlocksellingprice">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>

                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Mengikuti Credit Limit </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msysinvcreditlimit" class="yesnoswitch-checkbox" id="edit-msysinvcreditlimit">
                                        <label class="yesnoswitch-label" for="edit-msysinvcreditlimit">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>



                            
                              
                              
                             
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Footnote Invoice</b> (<font color="red">*</font>) &nbsp  :</label>
                          			<div class="col-md-7">
																	<textarea rows="6" id="edit-msysinvinvfootnote" class="form-control forminput" placeholder="Footnote Invoice" data-parsley-required-message="Field Ini Tidak Boleh Kosong" required></textarea>
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Footnote Penjualan</b> (<font color="red">*</font>) &nbsp  :</label>
                          			<div class="col-md-7">
																	<textarea rows="6" id="edit-msysinvsellingfootnote" class="form-control forminput" placeholder="Footnote Penjualan" data-parsley-required-message="Field Ini Tidak Boleh Kosong" required></textarea>
                          			</div>
                              </div>
                               <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Harga Jual < HPP </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msysinvspbelowcog" class="yesnoswitch-checkbox" id="edit-msysinvspbelowcog">
                                        <label class="yesnoswitch-label" for="edit-msysinvspbelowcog">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Cetak Nota Penjualan Lebih Dari 1x </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msysinvprintinvmorethanonce" class="yesnoswitch-checkbox" id="edit-msysinvprintinvmorethanonce">
                                        <label class="yesnoswitch-label" for="edit-msysinvprintinvmorethanonce">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>
                               <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Cetak Surat jalan > 1 X </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msysinvprintdomorethanonce" class="yesnoswitch-checkbox" id="edit-msysinvprintdomorethanonce">
                                        <label class="yesnoswitch-label" for="edit-msysinvprintdomorethanonce">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>

                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Cetak Order Penjualan > 1 X </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msysinvprintordmorethanonce" class="yesnoswitch-checkbox" id="edit-msysinvprintordmorethanonce">
                                        <label class="yesnoswitch-label" for="edit-msysinvprintordmorethanonce">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>
                            
                             
                              
                             
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Default Credit Limit</b> (<font color="red">*</font>) &nbsp  :</label>
                          			<div class="col-md-7">
                                  <input id="edit-msysinvdefaultcreditlimit" value="" name="msysinvdefaultcreditlimit" data-parsley-required-message="Field Ini Tidak Boleh Kosong" class="form-control forminput" placeholder="Default Credit Limit" type="number" required>
                          			</div>
                              </div>
                               <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Print Direct Dot Matrix </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msysinvlptdirectprinting" class="yesnoswitch-checkbox" id="edit-msysinvlptdirectprinting">
                                        <label class="yesnoswitch-label" for="edit-msysinvlptdirectprinting">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>

                              
                            </div>
                          </div>
                        </div>
                        <div id="menu2" class="tab-pane">
                          <div class="form form-horizontal" style="margin-top:21px;">
                            <div class="col-md-12">
                             

                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Permintaan Pembelian </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msyspurchrequest" class="yesnoswitch-checkbox" id="edit-msyspurchrequest">
                                        <label class="yesnoswitch-label" for="edit-msyspurchrequest">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>

                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Order Pembelian </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msyspurchorder" class="yesnoswitch-checkbox" id="edit-msyspurchorder">
                                        <label class="yesnoswitch-label" for="edit-msyspurchorder">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>

                                 <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Invoice Pembelian </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msyspurchinvoice" class="yesnoswitch-checkbox" id="edit-msyspurchinvoice">
                                        <label class="yesnoswitch-label" for="edit-msyspurchinvoice">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>

                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Mengikuti Credit Limit </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msyspurchcreditlimit" class="yesnoswitch-checkbox" id="edit-msyspurchcreditlimit">
                                        <label class="yesnoswitch-label" for="edit-msyspurchcreditlimit">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>

                              
                             
                            
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Foot Note Invoice</b> (<font color="red">*</font>) &nbsp  :</label>
                          			<div class="col-md-7">
																	<textarea rows="6" id="edit-msyspurchinvfootnote" class="form-control forminput" placeholder="Foot Note Invoice" data-parsley-required-message="Field Ini Tidak Boleh Kosong" required></textarea>
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Foot Note Order Pembelian</b> (<font color="red">*</font>) &nbsp  :</label>
                          			<div class="col-md-7">
																	<textarea rows="6" id="edit-msyspurchorderfootnote" class="form-control forminput" placeholder="Foot Note Invoice" data-parsley-required-message="Field Ini Tidak Boleh Kosong" required></textarea>
                          			</div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="menu3" class="tab-pane">
                          <div class="form form-horizontal" style="margin-top:21px;">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Metode HPP</b> &nbsp  :</label>
                          			<div class="col-md-4">
                                  <select id="edit-msysacccogmethod" name="msysacccogmethod" class="form-control select2">
                                    <option value="average">Rata-Rata</option>
                                  </select>
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Persediaan - Pilihan Akun</b> &nbsp  :</label>
                          			<div class="col-md-4">
                                  <select id="edit-msysaccstock" name="msysaccstock" class="form-control select2-bold">
                                    @foreach($mcoa as $c)
                                      <option value="{{ $c->mcoacode }}">{{ $c->mcoacode }} {{ $c->mcoaname }}</option>
                                    @endforeach
                                  </select>
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Penjualan - Pilihan Akun</b> &nbsp  :</label>
                          			<div class="col-md-4">
                                  <select id="edit-msysaccinv" name="msysaccinv" class="form-control select2-bold">
                                    @foreach($mcoa as $c)
                                      <option value="{{ $c->mcoacode }}">{{ $c->mcoacode }} {{ $c->mcoaname }}</option>
                                    @endforeach
                                  </select>
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Retur Penjualan - Pilihan Akun</b> &nbsp  :</label>
                          			<div class="col-md-4">
                                  <select id="edit-msysaccreturninv" name="msysaccreturninv" class="form-control select2-bold">
                                    @foreach($mcoa as $c)
                                      <option value="{{ $c->mcoacode }}">{{ $c->mcoacode }} {{ $c->mcoaname }}</option>
                                    @endforeach
                                  </select>
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Discount Penjualan - Pilihan Akun</b> &nbsp  :</label>
                          			<div class="col-md-4">
                                  <select id="edit-msysaccinvdisc" name="msysaccinvdisc" class="form-control select2-bold">
                                    @foreach($mcoa as $c)
                                      <option value="{{ $c->mcoacode }}">{{ $c->mcoacode }} {{ $c->mcoaname }}</option>
                                    @endforeach
                                  </select>
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Barang Terkirim - Pilihan Akun</b> &nbsp  :</label>
                          			<div class="col-md-4">
                                  <select id="edit-msysaccsentgoods" name="msysaccsentgoods" class="form-control select2-bold">
                                    @foreach($mcoa as $c)
                                      <option value="{{ $c->mcoacode }}">{{ $c->mcoacode }} {{ $c->mcoaname }}</option>
                                    @endforeach
                                  </select>
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Beban Pokok Penjualan - Pilihan Akun</b> &nbsp  :</label>
                          			<div class="col-md-4">
                                  <select id="edit-msysaccsellingexpense" name="msysaccsellingexpense" class="form-control select2-bold">
                                    @foreach($mcoa as $c)
                                      <option value="{{ $c->mcoacode }}">{{ $c->mcoacode }} {{ $c->mcoaname }}</option>
                                    @endforeach
                                  </select>
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Retur Pembelian - Pilihan Akun</b> &nbsp  :</label>
                          			<div class="col-md-4">
                                  <select id="edit-msysaccreturnpurchase" name="msysaccreturnpurchase" class="form-control select2-bold">
                                    @foreach($mcoa as $c)
                                      <option value="{{ $c->mcoacode }}">{{ $c->mcoacode }} {{ $c->mcoaname }}</option>
                                    @endforeach
                                  </select>
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Barang Tertagih - Pilihan Akun</b> &nbsp  :</label>
                          			<div class="col-md-4">
                                  <select id="edit-msysaccar" name="msysaccar" class="form-control select2-bold">
                                    @foreach($mcoa as $c)
                                      <option value="{{ $c->mcoacode }}">{{ $c->mcoacode }} {{ $c->mcoaname }}</option>
                                    @endforeach
                                  </select>
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Modal Disetor - Pilihan Akun</b> &nbsp  :</label>
                          			<div class="col-md-4">
                                  <select id="edit-msysaccpaidcapital" name="msysaccpaidcapital" class="form-control select2-bold">
                                    @foreach($mcoa as $c)
                                      <option value="{{ $c->mcoacode }}">{{ $c->mcoacode }} {{ $c->mcoaname }}</option>
                                    @endforeach
                                  </select>
                          			</div>
                              </div>
                              <div class="form-group">
                                <label class="col-md-3 control-label"><b>Laba Ditahan - Pilihan Akun</b> &nbsp  :</label>
                          			<div class="col-md-4">
                                  <select id="edit-msysaccretainedearning" name="msysaccretainedearning" class="form-control select2-bold">
                                    @foreach($mcoa as $c)
                                      <option value="{{ $c->mcoacode }}">{{ $c->mcoacode }} {{ $c->mcoaname }}</option>
                                    @endforeach
                                  </select>
                          			</div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="menu4" class="tab-pane">
                          <div class="form form-horizontal" style="margin-top:21px;">
                            <div class="col-md-12">
                              

                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Kas Bank Boleh Minus </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msysbankminus" class="yesnoswitch-checkbox" id="edit-msysbankminus">
                                        <label class="yesnoswitch-label" for="edit-msysbankminus">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>


                            </div>
                          </div>
                        </div>

                        <div id="menu5" class="tab-pane">
                          <div class="form form-horizontal" style="margin-top:21px;">
                            <div class="col-md-12">
                              

                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Multi Gudang </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msysinventmultiwarehouse" class="yesnoswitch-checkbox" id="edit-msysinventmultiwarehouse">
                                        <label class="yesnoswitch-label" for="edit-msysinventmultiwarehouse">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>

                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Multi Satuan Default </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msysinventmultiuom" class="yesnoswitch-checkbox" id="edit-msysinventmultiuom">
                                        <label class="yesnoswitch-label" for="edit-msysinventmultiuom">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>

                               <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Menggunakan Nomor Serial </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msysinventuseserial" class="yesnoswitch-checkbox" id="edit-msysinventuseserial">
                                        <label class="yesnoswitch-label" for="edit-msysinventuseserial">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>

                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Stock Boleh Minus </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msysinventallowminus" class="yesnoswitch-checkbox" id="edit-msysinventallowminus">
                                        <label class="yesnoswitch-label" for="edit-msysinventallowminus">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Harga Jual Bertingkat </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="msysinventslabprice" class="yesnoswitch-checkbox" id="edit-msysinventslabprice">
                                        <label class="yesnoswitch-label" for="edit-msysinventslabprice">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>
                             
                             
                              
                             
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-offset-5 col-md-5" style="margin-top:20px;margin-bottom:20px;">
                        <button onclick="update_feature()" type="submit" name="button" class="btn btn-primary">Simpan</button>
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
<script src="{{ url('/master/sysfeature.js') }}"></script>

@stop

@section('css')
  <link rel="stylesheet" href="{{ url('/css/bootstrap-switch.min.css') }}">
  <link rel="stylesheet" href="{{ url('/css/bootstrap-datepicker3.min.css') }}">
  <link rel="stylesheet" href="{{ url('/css/onoff.css') }}">
  <link rel="stylesheet" href="{{ url('/css/yesno.css') }}">
  <style>
    .example-label {
      padding-top: 7px;
      font-size: 15px;
      color: #aaa;
    }
  </style>
@stop
