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
      <li>Home</li><li>Barang</li><li>Data Barang</li>
    </ol>
  </div>
  <!-- END RIBBON -->
  <!-- MAIN CONTENT -->
  <div id="content">
    <div class="row">
      <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
          <i class="fa fa-table fa-fw "></i>
            Barang
          <span>
            Data Barang
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
              <h2>Master Barang </h2>
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
                        <li class="active"><a data-toggle="tab" href="#menu1">Spesifikasi</a></li>
                        <li><a data-toggle="tab" href="#menu2">Spesifikasi 2</a></li>
                        <li><a data-toggle="tab" href="#menu3">Pajak</a></li>
                       
                      </ul>
                      <div id="insert-wrapper" class="tab-content" data-parsley-validate>
                        <div id="menu1" class="tab-pane fade in active">
                          <div class="form-horizontal" style="margin-top:21px;">
                            <div class="col-md-10">
                             <div class="errorBlock1" style="margin-left:23% !important;"></div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Kode Barang</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="insert-mgoodscode" value="{{old('mgoodscode')}}" name="mgoodscode" class="form-control forminput" placeholder="Kode Barang" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" data-parsley-errors-container=".errorBlock2" @if (Session::has('autofocus')) autofocus @endif>
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Kode Barang"></label>
                                  </div>
                                </div>
                              </div>
                              <div class="errorBlock2" style="margin-left:23% !important;"></div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Barcode</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="insert-mgoodsbarcode" value="{{old('mgoodsbarcode')}}" name="mgoodsbarcode" class="form-control forminput" placeholder="Barcode" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Barcode"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Nama Barang</b>  &nbsp  :</label>
                                <div  class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="insert-mgoodsname" value="{{old('mgoodsname')}}" name="mgoodsname" class="form-control forminput" placeholder="Nama Barang" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Barang"></label>
                                   
                                  </div>
                                </div>
                              </div>
                                 <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Nama Barang Alias</b>  &nbsp  :</label>
                                <div  class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="insert-mgoodsalias" value="{{old('mgoodsalias')}}" name="mgoodsalias" class="form-control forminput" placeholder="Nama Barang Alias" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Barang Alias"></label>
                                   
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Keterangan</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="insert-mgoodsremark" value="{{old('mgoodsremark')}}" name="mgoodsremark" class="form-control forminput" placeholder="Keterangan" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Keterangan"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Satuan-1</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="insert-mgoodsunit" value="{{old('mgoodsunit')}}" name="mgoodsunit" class="form-control forminput" placeholder="Satuan-1" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Satuan-1"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Satuan-2</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="insert-mgoodsunit2" value="{{old('mgoodsunit2')}}" name="mgoodsunit2" class="form-control forminput" placeholder="Satuan-2" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Satuan-2"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Satuan-3</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="insert-mgoodsunit3" value="{{old('mgoodsunit3')}}" name="mgoodsunit3" class="form-control forminput" placeholder="Satuan-3" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Satuan-3"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Status</b>  &nbsp  :</label>
                                  <div class="col-md-9">
                                    <input id="insert-mgoodsactive" value="" name="mgoodsactive" class="nice-toggle" placeholder="mgoodsactive" type="checkbox">
                                </div>
                              </div>
                                <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Harga Beli</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="insert-mgoodspricein" value="{{old('mgoodspricein')}}" name="mgoodspricein" class="form-control forminput" placeholder="Harga Beli" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Harga Beli"></label>
                                  </div>
                                </div>
                              </div>
                            <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Harga Jual</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="insert-mgoodspriceout" value="{{old('mgoodspriceout')}}" name="mgoodspriceout" class="form-control forminput" placeholder="Harga Beli" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Harga Jual"></label>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                      <div class="form form-horizontal" style="margin-top:21px;">
                        <div class="col-md-10">
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Tipe Barang</b>  &nbsp  :</label>
                            <div class="col-md-9 col-sm-12">
                              <div class="icon-addon addon-md">
                                <input id="insert-mgoodstype" value="{{old('mgoodstype')}}" name="mgoodstype" class="form-control forminput" placeholder="Tipe Barang" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Tipe Barang"></label>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Merk</b>  &nbsp  :</label>
                            <div class="col-md-9 col-sm-12">
                              <div class="icon-addon addon-md">
                                <input id="insert-mgoodsbrand" value="{{old('mgoodsbrand')}}" name="mgoodsbrand" class="form-control forminput" placeholder="Merk" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Merk"></label>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Group Barang 1</b>  &nbsp  :</label>
                            <div class="col-md-9 col-sm-12">
                              <div class="icon-addon addon-md">
                                <input id="insert-mgoodsgroup1" value="{{old('mgoodsgroup1')}}" name="mgoodsgroup1" class="form-control forminput" placeholder="Group Barang 1" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Group Barang 1"></label>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Group Barang 2</b>  &nbsp  :</label>
                            <div class="col-md-9 col-sm-12">
                              <div class="icon-addon addon-md">
                                <input id="insert-mgoodsgroup2" value="{{old('mgoodsgroup2')}}" name="mgoodsgroup2" class="form-control forminput" placeholder="Group Barang 2" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup2" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Group Barang 2"></label>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Group Barang 3</b>  &nbsp  :</label>
                            <div class="col-md-9 col-sm-12">
                              <div class="icon-addon addon-md">
                                <input id="insert-mgoodsgroup3" value="{{old('mgoodsgroup3')}}" name="mgoodsgroup3" class="form-control forminput" placeholder="Group Barang 3" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Group Barang 3"></label>
                              </div>
                            </div> 
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Kode Supplier</b>  &nbsp  :</label>
                           <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2" name="mgoodssuppliercode" id="insert-mgoodssuppliercode">
                                 
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Nama Supplier</b>  &nbsp  :</label>
                               <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2" name="mgoodssuppliername" id="insert-mgoodssuppliername">
                                 
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                              <label class="col-md-3 control-label"><b>Digunakan oleh semua cabang: </b>  &nbsp  :</label>
                              <div class="col-md-9 col-sm-12">
                                <input id="insert-mgoodsbranches" value="" name="mgoodsbranches" class="nice-toggle" placeholder="Nama Perusahaan" type="checkbox">
                              </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                              <label class="col-md-3 control-label"><b>Unique Transaction </b>  &nbsp  :</label>
                              <div class="col-md-9 col-sm-12">
                                <input id="insert-mgoodsbranches" value="" name="mgoodsbranches" class="nice-toggle" placeholder="Nama Perusahaan" type="checkbox">
                              </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Gambar</b>  &nbsp  :</label>
                            <div class="col-md-9 col-sm-12">
                              <div class="icon-addon addon-md">
                                <input id="insert-mgoodspicture" value="{{old('mgoodspicture')}}" name="mgoodspicture" class="form-control forminput" placeholder="Gambar" type="file" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="" rel="tooltip" title="Gambar"></label>
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
                            <label class="col-md-2 control-label"><b>Kode Pembelian</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2" name="mgoodcoapurchasing" id="insert-mgoodcoapurchasing">
                                 
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Nama Pembelian</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2" name="mgoodscoapurchasingname" id="insert-mgoodscoapurchasingname">
                                 
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Hpp</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2" name="mgoodscoacogs" id="insert-mgoodscoacogs">
                                 
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Nama Hpp</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2" name="mgoodscoacogsname" id="insert-mgoodscoacogsname">
                                 
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Penjualan</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2" name="mgoodscoaselling" id="insert-mgoodscoaselling">
                                 
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Nama Penjualan</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2" name="mgoodscoasellingname" id="insert-mgoodscoasellingname">
                                 
                                </select>
                              </div>
                            </div>
                          </div>

                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Retur Penjualan</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2" name="mgoodscoareturnofselling" id="insert-mgoodscoareturnofselling">
                                 
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Nama Retur Penjualan</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2" name="mgoodscoareturnofsellingname" id="insert-mgoodscoareturnofsellingname">
                                 
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Informasi</b>  &nbsp  :</label>
                            <div  class="col-md-4">
                              <div class="icon-addon addon-md">
                                <input disabled id="insert-mgoodscogs" value="{{old('mgoodscogs')}}" name="mgoodscogs" class="form-control forminput" placeholder="Informasi" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="" rel="tooltip" title="Informasi"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="menu4"></div>
                    <div class="row">
                      <div class="col-md-offset-5 col-md-5" style="margin-top:20px;margin-bottom:20px;">
                        <button onclick="insertmgoods()" type="submit" name="button" class="btn btn-primary">Simpan</button>
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
              <h2>Master Barang </h2>
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
                        <li><a data-toggle="tab" href="#editmenu4">Pajak</a></li>
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
                                <div class="col-md-offset-3 col-md-5 col-sm-12" style="margin-top:20px;">
                                  <div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input id="edit-mcustomercity" value="{{old('mcustomercity')}}" name="mcustomercity" class="form-control forminput" placeholder="Kota" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-4 col-sm-12" style="margin-top:20px;">
                                  <div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input id="edit-mcustomerzipcode" value="{{old('mcustomerzipcode')}}" name="mcustomerzipcode" class="form-control forminput" placeholder="K.Pos" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <div class="col-md-offset-3 col-md-9 col-sm-12" style="margin-top:20px;">
                                  <div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input id="editmcustomerprovince" value="{{old('mcustomerprovince')}}" name="mcustomerprovince" class="form-control forminput" placeholder="Provinsi " type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                      <label for="mgoodsgroup1" class="glyphicon glyphicon-star" rel="tooltip" title="Propinsi"></label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <div class="col-md-offset-3 col-md-9 col-sm-12" style="margin-top:20px;">
                                  <div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input id="editmcustomercountry" value="{{old('mcustomercountry')}}" name="mcustomercountry" class="form-control forminput" placeholder="Negara" type="text"  @if (Session::has('autofocus')) autofocus @endif >
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
                                  
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>TOP</b>  &nbsp  :</label>
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
                            <label class="col-md-2 control-label"><b>Default</b>  &nbsp  :</label>
                            <div  class="col-md-4">
                              <div class="icon-addon addon-md">
                                <input id="edit-mcustomerdefaultar" value="0" name="mcustomerdefaultar" class="form-control forminput" placeholder="Default" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Maksimal Nota"></label>
                              </div>
                            </div>
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
                        <li><a data-toggle="tab" href="#viewmenu4">Pajak</a></li>
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
                                <div class="col-md-offset-3 col-md-9 col-sm-12" style="margin-top:20px;">
                                  <div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input disabled id="editmcustomerprovince" value="{{old('mcustomerprovince')}}" name="mcustomerprovince" class="form-control forminput" placeholder="Provinsi " type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                      <label for="mgoodsgroup1" class="glyphicon glyphicon-star" rel="tooltip" title="Propinsi"></label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <div class="col-md-offset-3 col-md-9 col-sm-12" style="margin-top:20px;">
                                  <div class="icon-addon addon-md">
                                    <div class="icon-addon addon-md">
                                      <input disabled id="editmcustomercountry" value="{{old('mcustomercountry')}}" name="mcustomercountry" class="form-control forminput" placeholder="Negara" type="text"  @if (Session::has('autofocus')) autofocus @endif >
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
                                  
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>TOP</b>  &nbsp  :</label>
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
                            <label class="col-md-2 control-label"><b>Default</b>  &nbsp  :</label>
                            <div  class="col-md-4">
                              <div class="icon-addon addon-md">
                                <input disabled id="view-mcustomerdefaultar" value="0" name="mcustomerdefaultar" class="form-control forminput" placeholder="Default" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Maksimal Nota"></label>
                              </div>
                            </div>
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
              <h2>Master Barang </h2>
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
                            <input type="text" class="form-control" placeholder="Filter Kode Barang" />
                          </th>
                          <th class="hasinput" style="width:9%">
                            <input type="text" class="form-control" placeholder="Filter Barcode" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Nama Barang" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Nama Barang Alias" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Satuan-1" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Satuan-2" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Satuan-3" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Status" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Harga Beli" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Harga Jual" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Tipe Barang" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Merk" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Group Barang 1" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Group Barang 2" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Group Barang 3" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Kode Supplier" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Nama Supplier" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Digunakan oleh semua cabang" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Maksimal Unique Transaction" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Pembelian" />
                          </th>
                           <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Nama Pembelian" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Hpp" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Nama Hpp" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Penjualan" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Nama Penjualan" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Retur Penjualan" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Nama Retur Penjualan" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Maksimal Nota" />
                          </th>
                        
                        </tr>
                        <tr>
                          <th data-hide="action"><center>Aksi</center></th>
                          <th data-hide="no"><center>No</center></th>
                          <th data-hide="mgoodscode"><center>Kode Barang</center></th>
                          <th data-hide="mgoodsbarcode"><center>Barcode</center></th>
                          <th data-hide="mgoodsname"><center>Nama Barang</center></th>
                          <th data-hide="mgoodsalias"><center>Nama Barang Alias</center></th>
                          <th data-hide="mgoodsremark"><center>Keterangan</center></th>
                          <th data-hide="mgoodsunit"><center>Satruan-1</center></th>
                          <th data-hide="mgoodsunit2"><center>Satruan-2</center></th>
                          <th data-hide="mgoodsunit3"><center>Satruan-3</center></th>
                          <th data-hide="mgoodsactive"><center>Status</center></th>
                          <th data-hide="mgoodspricein"><center>Harga Beli</center></th>
                          <th data-hide="mgoodspriceout"><center>Harga Jual</center></th>
                          <th data-hide="mgoodstype"><center>Tipe Barang</center></th>
                          <th data-hide="mgoodsbrand"><center>Merk</center></th>
                          <th data-hide="mgoodsgroup1"><center>Group Barang 1</center></th>
                          <th data-hide="mgoodsgroup2"><center>Group Barang 2</center></th>
                          <th data-hide="mgoodsgroup3"><center>Group Barang 3</center></th>
                          <th data-hide="mgoodssuppliercode"><center>Supplier</center></th>
                          <th data-hide="mgoodssuppliername"><center>Nama Supplier</center></th>
                          <th data-hide="mgoodsbranches"><center>Digunakan Oleh Semua Orang</center></th>
                          <th data-hide="mgoodsuniquetransaction"><center>Unique Transaction</center></th>
                          <th data-hide="mgoodcoapurchasing"><center></center>Pembelian</th>
                          <th data-hide="mgoodscoapurchasingname"><center>Nama Pembelian</center></th>  
                          <th data-hide="mgoodscoacogs"><center>Hpp</center></th>
                          <th data-hide="mgoodscoacogsname"><center>Nama Hpp</center></th>
                          <th data-hide="mgoodscoaselling"><center>Penjualan</center></th>
                          <th data-hide="mgoodscoasellingname"><center>Nama Penjualan</center></th>  
                          <th data-hide="mgoodscoareturnofselling"><center>Retur Penjualan</center></th>
                          <th data-hide="mgoodscoareturnofsellingname"><center>Nama Retur Penjualan</center></th>  
                          <th data-hide="mgoodscogs"><center>N/A</center></th>
                          
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
@stop

@section('js')
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
        "aoColumnDefs": [{ "bVisible": false, "aTargets": [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30] }],
        buttons: [ {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21]
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
                ajax: '{{URL::to('/')}}/admin-api/barang',
                columns: [
                {data: 'action', name:'action', searchable: false, orderable: false},
                {data: 'no', no: 'no' },
                {data: 'mgoodscode', mgoodscode: 'mgoodscode'},
                {data: 'mgoodsbarcode', mgoodsbarcode: 'mgoodsbarcode'},
                {data: 'mgoodsname', mgoodsname: 'mgoodsname'},
                {data: 'mgoodsalias', mgoodsalias: 'mgoodsalias'},
                {data: 'mgoodsremark', mgoodsremark: 'mgoodsremark'},
                {data: 'mgoodsunit', mgoodsunit: 'mgoodsunit'},
                {data: 'mgoodsunit2', mgoodsunit2: 'mgoodsunit2'},
                {data: 'mgoodsunit3', mgoodsunit3: 'mgoodsunit3'},
                {data: 'mgoodsactive', mgoodsactive: 'mgoodsactive'},
                {data: 'mgoodspricein', mgoodspricein: 'mgoodspricein'},
                {data: 'mgoodspriceout', mgoodspriceout: 'mgoodspriceout'},
                {data: 'mgoodstype', mgoodstype: 'mgoodstype'},
                {data: 'mgoodsbrand', mgoodsbrand: 'mgoodsbrand'},
                {data: 'mgoodsgroup1', mgoodsgroup1: 'mgoodsgroup1'},
                {data: 'mgoodsgroup2', mgoodsgroup2: 'mgoodsgroup2'},
                {data: 'mgoodsgroup3', mgoodsgroup3: 'mgoodsgroup3'},
                {data: 'mgoodssuppliercode', mgoodssuppliercode: 'mgoodssuppliercode'},
                {data: 'mgoodssuppliername', mgoodssuppliername: 'mgoodssuppliername'},
                {data: 'mgoodsbranches', mgoodsbranches: 'mgoodsbranches'},
                {data: 'mgoodsuniquetransaction', mgoodsuniquetransaction: 'mgoodsuniquetransaction'},
                {data: 'mgoodscoapurchasing', mgoodscoapurchasing: 'mgoodscoapurchasing'},
                {data: 'mgoodscoapurchasingname', mgoodscoapurchasingname: 'mgoodscoapurchasingname'},
                {data: 'mgoodscoacogs', mgoodscoacogs: 'mgoodscoacogs'},
                {data: 'mgoodscoacogsname', mgoodscoacogsname: 'mgoodscoacogsname'},
                {data: 'mgoodscoaselling', mgoodscoaselling: 'mgoodscoaselling'},
                {data: 'mgoodscoasellingname', mgoodscoasellingname: 'mgoodscoasellingname'},
                {data: 'mgoodscoareturnofselling', mgoodscoareturnofselling: 'mgoodscoareturnofselling'},
                {data: 'mgoodscoareturnofsellingname', mgoodscoareturnofsellingname: 'mgoodscoareturnofsellingname'},
                {data: 'mgoodscogs', mgoodscogs: 'mgoodscogs'},
                ]
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
<script src="{{ url('/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ url('/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ url('/master/mgoods.js') }}"></script>
<script>
@stop

@section('css')
  <link rel="stylesheet" href="{{ url('/css/bootstrap-switch.min.css') }}">
  <link rel="stylesheet" href="{{ url('/css/bootstrap-datepicker3.min.css') }}">
  <style>
    .example-label {
      padding-top: 7px;
      font-size: 15px;
      color: #aaa;
    }
  </style>
  <style>
    .tableapi_wrapper {
      margin-top: 50px;
    }
  </style>
@stop
