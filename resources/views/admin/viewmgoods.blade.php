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
        @if(Auth::user()->has_role('C_goods'))
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
                        <li><a data-toggle="tab" href="#menu4">Import Barang</a></li>
                        <li><a data-toggle="tab" href="#menu5">Import Harga Barang</a></li>

                      </ul>
                      <div id="insert-wrapper" class="tab-content" data-parsley-validate>
                        <div id="menu1" class="tab-pane fade in active">
                          <div class="container form form-horizontal" style="margin-top:21px;">
                            <!--  BOX Kiri -->
                            <div class="col-md-6 group-box">
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Kode Barang</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-9">
                                   <div class="icon-addon addon-md">
                                       <div class="input-group">
                                        <input id="insert-mgoodscode" name="mgoodscode" class="form-control forminput" maxlength="14" placeholder="AUTO GENERATE" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".errorBlock1" @if (Session::has('autofocus')) autofocus @endif >
                                        <label for="" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Pelanggan"></label>
                                        <span class="input-group-addon" style="background: none;">
                                           <input type="checkbox" id="autogenmgoods" name="autogen" rel="tooltip" title="ON/OFF auto generate ID Barang">
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="errorBlock2" style="margin-left:23% !important;"></div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Barcode</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="insert-mgoodsbarcode" value="{{old('mgoodsbarcode')}}" name="mgoodsbarcode" class="form-control forminput" maxlength="14" placeholder="Barcode" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Barcode"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Nama Barang</b>  (<font color="red">*</font>) &nbsp  :</label>
                                <div  class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input required id="insert-mgoodsname" value="{{old('mgoodsname')}}" name="mgoodsname" class="form-control forminput" placeholder="Nama Barang" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Barang"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Kategori Barang</b>  (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <select required id="insert-mgoodscategory" name="mgoodscategory" class="form-control select2">
                                      @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Tipe Barang</b>  &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <select id="insert-mgoodstype" name="mgoodstype" class="form-control select2">
                                      @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->mgoodstypename }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Sub Tipe Barang</b>  &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <select id="insert-mgoodssubtype" name="mgoodssubtype" class="form-control select2">
                                      @foreach($subtypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->mgoodssubtypename }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Merk</b>  &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <select id="insert-mgoodsbrand" name="mgoodsbrand" class="form-control select2">
                                      @foreach($marks as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                      @endforeach
                                    </select>
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
                                    <!-- <input id="insert-mgoodsremark" value="{{old('mgoodsremark')}}" name="mgoodsremark" class="form-control forminput" placeholder="Keterangan" type="text"  @if (Session::has('autofocus')) autofocus @endif > -->
                                    <textarea id="insert-mgoodsremark" name="mgoodsremark" class="form-control forminput" placeholder="Keterangan" rows="5"></textarea>
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Keterangan"></label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--  BOX Kanan -->
                            <div class="col-md-6 group-box">

                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>2 Satuan</b>  &nbsp  :</label>
                                <div class="col-md-1">
                                  <!-- <input id="insert-mgoodsmultiunit" value="" name="mgoodsmultiunit" class="nice-toggle" placeholder="mgoodsactive" type="checkbox" data-toggle="toggle"> -->
                                  <div class="yesnoswitch">
                                      <input type="checkbox" name="mgoodsbranches" class="yesnoswitch-checkbox" id="insert-mgoodsmultiunit">
                                      <label class="yesnoswitch-label" for="insert-mgoodsmultiunit">
                                          <span class="yesnoswitch-inner"></span>
                                          <span class="yesnoswitch-switch"></span>
                                      </label>
                                  </div>
                                </div>
                                <label class="col-md-3 control-label"><b>3 Satuan</b>  &nbsp  :</label>
                                <div class="col-md-3">
                                  <!-- <input id="insert-mgoodsmultiunit" value="" name="mgoodsmultiunit" class="nice-toggle" placeholder="mgoodsactive" type="checkbox" data-toggle="toggle"> -->
                                  <div class="yesnoswitch">
                                      <input type="checkbox" name="mgoodsbranches" class="yesnoswitch-checkbox" id="insert-mgoodsmultiunit3">
                                      <label class="yesnoswitch-label" for="insert-mgoodsmultiunit3">
                                          <span class="yesnoswitch-inner"></span>
                                          <span class="yesnoswitch-switch"></span>
                                      </label>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group" style="height: 21px;">
                                <label class="col-md-3 control-label"><b>Satuan-1</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <select class="form-group select2" id="insert-mgoodsunit" name="mgoodsunit">
                                      @foreach($units as $unit)
                                        <option id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group" style="height: 21px;">
                                <label class="col-md-3 control-label"><b>Satuan-2</b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <select class="form-group select2" disabled id="insert-mgoodsunit2" name="mgoodsunit2">
                                    @foreach($units as $unit)
                                      @if($unit->mgoodsunitname == 'Lusin')
                                        <option selected id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                      @else
                                        <option id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                      @endif
                                    @endforeach
                                  </select>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                  <input id="insert-mgoodsunit2conv" disabled name="mgoodunit2conv" class="form-control forminput" placeholder="Unit" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                </div>
                                <div class="col-md-1">
                                  <label class="control-label">Unit</label>
                                </div>
                              </div>
                              <div class="form-group" style="height: 21px;">
                                <label class="col-md-3 control-label"><b>Satuan-3</b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <select class="form-group select2" disabled id="insert-mgoodsunit3" name="mgoodsunit2">
                                    @foreach($units as $unit)
                                      @if($unit->mgoodsunitname == 'Karton')
                                        <option selected id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                      @else
                                        <option id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                      @endif
                                    @endforeach
                                  </select>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                  <input id="insert-mgoodsunit3conv" disabled name="mgoodunit3conv" class="form-control forminput" placeholder="Unit" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                </div>
                                <div class="col-md-1">
                                  <label class="control-label">Unit</label>
                                </div>
                              </div>
                              <!-- <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Semua cabang </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="mgoodsbranches" class="yesnoswitch-checkbox" id="insert-mgoodsbranches">
                                        <label class="yesnoswitch-label" for="insert-mgoodsbranches">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div> -->
                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Unique Transaction </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="mgoodsbranches" class="yesnoswitch-checkbox" id="insert-mgoodsuniquetransaction">
                                        <label class="yesnoswitch-label" for="insert-mgoodsuniquetransaction">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Status</b>  &nbsp  :</label>
                                  <div class="col-md-9">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="mgoodsactive" class="onoffswitch-checkbox" id="insert-mgoodsactive" checked>
                                        <label class="onoffswitch-label" for="insert-mgoodsactive">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Harga Beli</b> &nbsp  :</label>
                                <div class="row">
                                <div class="col-md-5 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="insert-mgoodspricein" value="{{old('mgoodspricein')}}" name="mgoodspricein" data-parsley-type="number" data-parsley-type-message="Field ini hanya dapat di isi oleh angka" parsley-error-container=".erroripricein" class="form-control forminput" placeholder="Harga Beli" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Harga Beli"></label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <label class="control-label muted">Harga Beli Diluar PPn</label>
                                </div>
                                </div>
                                <div class="erroripricein"></div>
                              </div>
                              <div class="form-group" style="height: 21px;">
                                <label class="col-md-3 control-label"><b>Satuan Beli</b> (<font color="red">*</font>) &nbsp  :</label>
                                  <div class="col-md-4 col-sm-12">
                                      <select class="form-group select2" id="insert-mgoodsunitin" name="mgoodsunitin">
                                        @foreach($units as $unit)
                                          <option id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                        @endforeach
                                      </select>
                                  </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Minimal Pembelian</b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="insert-mgoodsminimunin" value="{{old('mgoodsminimunin')}}" name="mgoodsminimunin" class="form-control forminput" placeholder="Minimal Pembelian" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Barang"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Harga Jual</b> &nbsp  :</label>
                                <div class="row">
                                <div class="col-md-5 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="insert-mgoodspriceout" value="{{old('mgoodspriceout')}}" name="mgoodspriceout" data-parsley-type="number" data-parsley-type-message="Field ini hanya dapat di isi oleh angka" parsley-error-container=".erroripriceout" class="form-control forminput" placeholder="Harga Jual" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Harga Jual"></label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <label class="control-label muted">Harga Jual Diluar PPn</label>
                                </div>
                                </div>
                                <div class="erroripriceout"></div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Maksimal Diskon</b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <div class="yesnoswitch">
                                      <input type="checkbox" name="mgoodsactive" class="yesnoswitch-checkbox" id="insert-mgoodssetmaxdisc">
                                      <label class="yesnoswitch-label" for="insert-mgoodssetmaxdisc">
                                          <span class="yesnoswitch-inner"></span>
                                          <span class="yesnoswitch-switch"></span>
                                      </label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Maksimal Diskon</b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <div class="input-group">
                                    <input id="insert-mgoodsmaxdisc" disabled name="mgoodsmaxdisc" data-parsley-type="number" data-parsley-type-message="Field ini hanya dapat di isi oleh angka" class="form-control forminput" placeholder="Persentase" type="text">
                                    <span class="input-group-addon" id="sizing-addon2">%</span>
                                  </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                  <div class="input-group">
                                    <span class="input-group-addon" id="sizing-addon2">Rp</span>
                                    <input id="insert-mgoodsmaxdiscrp" disabled name="mgoodsmaxdiscrp" data-parsley-type="number" data-parsley-type-message="Field ini hanya dapat di isi oleh angka" class="form-control forminput" placeholder="Rupiah" type="text">
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>HPP </b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="insert-mgoodscogs" value="{{old('mgoodscogs')}}" name="mgoodscogs" class="form-control forminput" placeholder="HPP" type="text"  @if (Session::has('autofocus')) autofocus @endif >
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
                                <label class="col-md-3 control-label"><b>Kode / Nama Supplier</b>  &nbsp  :</label>
                               <div class="col-md-4">
                                  <div class="icon-addon addon-md">
                                    <select class="form-control select2-bold" name="mgoodssuppliercode" id="insert-mgoodssuppliercode">
                                      @foreach($msupplier as $mg)
                                       <option value="{{$mg->msupplierid}}">{{$mg->msupplierid}} {{$mg->msuppliername}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Gambar</b>  &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                   <form action="upload.php">
                                          <input type="hidden">
                                          <div id="dropzone-gambar" class="dropzone"></div>
                                      </form>
                                      <br>
                                      <input id="insert-mgoodspicture" value="" name="mgoodspicture" class="form-control forminput" placeholder="Gambar" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
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
                                <label class="col-md-2 control-label"><b>Menggunakan Pajak</b>  &nbsp  :</label>
                                <div class="col-md-1">
                                  <!-- <input id="insert-mgoodsmultiunit" value="" name="mgoodsmultiunit" class="nice-toggle" placeholder="mgoodsactive" type="checkbox" data-toggle="toggle"> -->
                                  <div class="yesnoswitch">
                                      <input  type="checkbox" name="mgoodsbranches" class="yesnoswitch-checkbox" id="insert-mgoodstaxable">
                                      <label class="yesnoswitch-label" for="insert-mgoodstaxable">
                                          <span class="yesnoswitch-inner"></span>
                                          <span class="yesnoswitch-switch"></span>
                                      </label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-2 control-label"><b>Pajak</b>  (<font color="red">*</font>) &nbsp  :</label>
                                  <div class="col-md-4">
                                    <div class="icon-addon addon-md">
                                      <select disabled class="form-control select2" name="mgoodstaxppn" id="insert-mgoodstaxppn">

                                      @foreach($taxes as $tax)
                                        @if($tax->mtaxtype == 'Kosong')
                                          <option selected value="{{ $tax->id }}">&nbsp;</option>
                                        @else
                                          <option value="{{ $tax->id }}">{{ $tax->mtaxtdesc }}</option>
                                        @endif
                                      @endforeach

                                      </select>
                                    </div>
                                  </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-2 control-label"><b>Pajak Barang Mewah</b>  (<font color="red">*</font>) &nbsp  :</label>
                                  <div class="col-md-4">
                                    <div class="icon-addon addon-md">
                                      <select disabled class="form-control select2" name="mgoodstaxppnbm" id="insert-mgoodstaxppnbm">
                                      @foreach($taxes as $tax)
                                        @if($tax->mtaxtype == 'Kosong')
                                          <option selected value="{{ $tax->id }}">&nbsp;</option>
                                        @else
                                          <option value="{{ $tax->id }}">{{ $tax->mtaxtdesc }}</option>
                                        @endif
                                      @endforeach
                                      </select>
                                    </div>
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="menu4" class="tab-pane fade">
                            <div class="form form-horizontal" style="margin-top:21px;">
                              <div class="col-md-12">
                                <div style="height: 21px;" class="form-group">
                                    <label class="col-md-2 control-label"><b>File</b>  (<font color="red">*</font>) &nbsp  :</label>
                                    <div class="col-md-4">
                                        <input type="file" class="form-control"/>
                                        <br>
                                        <a style="font-size: 16px" href="#">Download template file upload.</a>
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div id="menu5" class="tab-pane fade"></div>
                    </div>
                    <div class="row">
                      <div class="col-md-offset-5 col-md-5" style="margin-top:20px;margin-bottom:20px;">
                        <button onclick="insertmgoods()" type="submit" name="button" class="btn btn-primary">Simpan</button>
                        <a id="btn-insert-reset" onclick="resetmgoods()" class="btn btn-default" ><i class=""></i> Reset</a>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </article>
        @endif
      </div>
      <!-- row -->
      <div class="row">
        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <!-- Widget ID (each widget will need unique ID)-->
          <div id="formedit" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
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
              <input type="hidden" id="edit-idmgoodscodeid" value=""></input>
              <!-- widget content -->
              <div class="widget-body no-padding">
                  <div class="container">
                    <div class="row">
                      <h2></h2>
                      <ul class="nav nav-tabs" style="padding-left:10px;">
                        <li class="active"><a data-toggle="tab" href="#menuedit1">Spesifikasi</a></li>
                        <li><a data-toggle="tab" href="#menuedit2">Spesifikasi 2</a></li>
                        <li><a data-toggle="tab" href="#menuedit3">Pajak</a></li>
                      </ul>
                      <div id="edit-wrapper" class="tab-content" data-parsley-validate>
                        <div id="menuedit1" class="tab-pane fade in active">
                          <div class="container form form-horizontal" style="margin-top:21px;">
                            <!--  BOX Kiri -->
                            <div class="col-md-6 group-box">
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Kode Barang</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-9">
                                   <div class="icon-addon addon-md">
                                       <div class="input-group">
                                        <input id="edit-mgoodscode" name="mgoodscode" class="form-control forminput" maxlength="14" placeholder="AUTO GENERATE" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".errorBlock1" @if (Session::has('autofocus')) autofocus @endif >
                                        <label for="" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Pelanggan"></label>
                                        <span class="input-group-addon" style="background: none;">
                                           <input type="checkbox" id="autogenmgoods" name="autogen" rel="tooltip" title="ON/OFF auto generate ID Barang">
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="errorBlock2" style="margin-left:23% !important;"></div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Barcode</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="edit-mgoodsbarcode" value="{{old('mgoodsbarcode')}}" name="mgoodsbarcode" class="form-control forminput" maxlength="14" placeholder="Barcode" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Barcode"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Nama Barang</b>  (<font color="red">*</font>) &nbsp  :</label>
                                <div  class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="edit-mgoodsname" value="{{old('mgoodsname')}}" name="mgoodsname" class="form-control forminput" placeholder="Nama Barang" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Barang"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Kategori Barang</b>  (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <select id="edit-mgoodscategory" name="mgoodscategory" class="form-control select2">
                                      @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Tipe Barang</b>  &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <select id="edit-mgoodstype" name="mgoodstype" class="form-control select2">
                                      @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->mgoodstypename }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Sub Tipe Barang</b>  &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <select id="edit-mgoodssubtype" name="mgoodssubtype" class="form-control select2">
                                      @foreach($subtypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->mgoodssubtypename }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Merk</b>  &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <select id="edit-mgoodsbrand" name="mgoodsbrand" class="form-control select2">
                                      @foreach($marks as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Nama Barang Alias</b>  &nbsp  :</label>
                                <div  class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="edit-mgoodsalias" value="{{old('mgoodsalias')}}" name="mgoodsalias" class="form-control forminput" placeholder="Nama Barang Alias" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Barang Alias"></label>

                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Keterangan</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <!-- <input id="edit-mgoodsremark" value="{{old('mgoodsremark')}}" name="mgoodsremark" class="form-control forminput" placeholder="Keterangan" type="text"  @if (Session::has('autofocus')) autofocus @endif > -->
                                    <textarea id="edit-mgoodsremark" name="mgoodsremark" class="form-control forminput" placeholder="Keterangan" rows="5"></textarea>
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Keterangan"></label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--  BOX Kanan -->
                            <div class="col-md-6 group-box">

                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>2 Satuan</b>  &nbsp  :</label>
                                <div class="col-md-1">
                                  <!-- <input id="edit-mgoodsmultiunit" value="" name="mgoodsmultiunit" class="nice-toggle" placeholder="mgoodsactive" type="checkbox" data-toggle="toggle"> -->
                                  <div class="yesnoswitch">
                                      <input type="checkbox" name="mgoodsbranches" class="yesnoswitch-checkbox" id="edit-mgoodsmultiunit">
                                      <label class="yesnoswitch-label" for="edit-mgoodsmultiunit">
                                          <span class="yesnoswitch-inner"></span>
                                          <span class="yesnoswitch-switch"></span>
                                      </label>
                                  </div>
                                </div>
                                <label class="col-md-3 control-label"><b>3 Satuan</b>  &nbsp  :</label>
                                <div class="col-md-3">
                                  <!-- <input id="insert-mgoodsmultiunit" value="" name="mgoodsmultiunit" class="nice-toggle" placeholder="mgoodsactive" type="checkbox" data-toggle="toggle"> -->
                                  <div class="yesnoswitch">
                                      <input type="checkbox" name="mgoodsbranches" class="yesnoswitch-checkbox" id="edit-mgoodsmultiunit3">
                                      <label class="yesnoswitch-label" for="edit-mgoodsmultiunit3">
                                          <span class="yesnoswitch-inner"></span>
                                          <span class="yesnoswitch-switch"></span>
                                      </label>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group" style="height: 21px;">
                                <label class="col-md-3 control-label"><b>Satuan-1</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <select class="form-group select2" id="edit-mgoodsunit" name="mgoodsunit">
                                      @foreach($units as $unit)
                                        <option id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group" style="height: 21px;">
                                <label class="col-md-3 control-label"><b>Satuan-2</b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <select class="form-group select2" disabled id="edit-mgoodsunit2" name="mgoodsunit2">
                                    @foreach($units as $unit)
                                      @if($unit->mgoodsunitname == 'Lusin')
                                        <option selected id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                      @else
                                        <option id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                      @endif
                                    @endforeach
                                  </select>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                  <input id="edit-mgoodsunit2conv" disabled name="mgoodunit2conv" class="form-control forminput" placeholder="Unit" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                </div>
                                <div class="col-md-1">
                                  <label class="control-label">Unit</label>
                                </div>
                              </div>
                              <div class="form-group" style="height: 21px;">
                                <label class="col-md-3 control-label"><b>Satuan-3</b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <select class="form-group select2" disabled id="edit-mgoodsunit3" name="mgoodsunit2">
                                    @foreach($units as $unit)
                                      @if($unit->mgoodsunitname == 'Karton')
                                        <option selected id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                      @else
                                        <option id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                      @endif
                                    @endforeach
                                  </select>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                  <input id="edit-mgoodsunit3conv" disabled name="mgoodunit3conv" class="form-control forminput" placeholder="Unit" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                </div>
                                <div class="col-md-1">
                                  <label class="control-label">Unit</label>
                                </div>
                              </div>
                              <!-- <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Semua cabang </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="mgoodsbranches" class="yesnoswitch-checkbox" id="edit-mgoodsbranches">
                                        <label class="yesnoswitch-label" for="edit-mgoodsbranches">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div> -->
                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Unique Transaction </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input type="checkbox" name="mgoodsbranches" class="yesnoswitch-checkbox" id="edit-mgoodsuniquetransaction">
                                        <label class="yesnoswitch-label" for="edit-mgoodsuniquetransaction">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Status</b>  &nbsp  :</label>
                                  <div class="col-md-9">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="mgoodsactive" class="onoffswitch-checkbox" id="edit-mgoodsactive">
                                        <label class="onoffswitch-label" for="edit-mgoodsactive">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Harga Beli</b> &nbsp  :</label>
                                <div class="row">
                                <div class="col-md-5 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="edit-mgoodspricein" value="{{old('mgoodspricein')}}" name="mgoodspricein" data-parsley-type="number" data-parsley-type-message="Field ini hanya dapat di isi oleh angka" parsley-error-container=".erroripricein" class="form-control forminput" placeholder="Harga Beli" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Harga Beli"></label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <label class="control-label muted">Harga Beli Diluar PPn</label>
                                </div>
                                </div>
                                <div class="erroripricein"></div>
                              </div>
                              <div class="form-group" style="height: 21px;">
                                <label class="col-md-3 control-label"><b>Satuan Beli</b> (<font color="red">*</font>) &nbsp  :</label>
                                  <div class="col-md-4 col-sm-12">
                                      <select class="form-group select2" id="edit-mgoodsunitin" name="mgoodsunitin">
                                        @foreach($units as $unit)
                                          <option id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                        @endforeach
                                      </select>
                                  </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Minimal Pembelian</b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="edit-mgoodsminimunin" value="{{old('mgoodsminimunin')}}" name="mgoodsminimunin" class="form-control forminput" placeholder="Minimal Pembelian" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Barang"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Harga Jual</b> &nbsp  :</label>
                                <div class="row">
                                <div class="col-md-5 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="edit-mgoodspriceout" value="{{old('mgoodspriceout')}}" name="mgoodspriceout" data-parsley-type="number" data-parsley-type-message="Field ini hanya dapat di isi oleh angka" parsley-error-container=".erroripriceout" class="form-control forminput" placeholder="Harga Jual" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Harga Jual"></label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <label class="control-label muted">Harga Jual Diluar PPn</label>
                                </div>
                                </div>
                                <div class="erroripriceout"></div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Maksimal Diskon</b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <div class="yesnoswitch">
                                      <input type="checkbox" name="mgoodsactive" class="yesnoswitch-checkbox" id="edit-mgoodssetmaxdisc">
                                      <label class="yesnoswitch-label" for="edit-mgoodssetmaxdisc">
                                          <span class="yesnoswitch-inner"></span>
                                          <span class="yesnoswitch-switch"></span>
                                      </label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Maksimal Diskon</b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <div class="input-group">
                                    <input id="edit-mgoodsmaxdisc" name="mgoodsmaxdisc" data-parsley-type="number" data-parsley-type-message="Field ini hanya dapat di isi oleh angka" class="form-control forminput" placeholder="Persentase" type="text">
                                    <span class="input-group-addon" id="sizing-addon2">%</span>
                                  </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                  <div class="input-group">
                                    <span class="input-group-addon" id="sizing-addon2">Rp</span>
                                    <input id="edit-mgoodsmaxdiscrp" name="mgoodsmaxdiscrp" data-parsley-type="number" data-parsley-type-message="Field ini hanya dapat di isi oleh angka" class="form-control forminput" placeholder="Rupiah" type="text">
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>HPP </b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="edit-mgoodscogs" value="{{old('mgoodscogs')}}" name="mgoodscogs" class="form-control forminput" placeholder="HPP" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Harga Jual"></label>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                        <div id="menuedit2" class="tab-pane fade">
                          <div class="form form-horizontal" style="margin-top:21px;">
                            <div class="col-md-10">
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Kode / Nama Supplier</b>  &nbsp  :</label>
                               <div class="col-md-4">
                                  <div class="icon-addon addon-md">
                                    <select class="form-control select2-bold" name="mgoodssuppliercode" id="edit-mgoodssuppliercode">
                                      @foreach($msupplier as $mg)
                                       <option value="{{$mg->msupplierid}}">{{$mg->msupplierid}} {{$mg->msuppliername}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Gambar</b>  &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                   <form action="upload.php">
                                          <input type="hidden">
                                          <div id="dropzone-gambar" class="dropzone"></div>
                                      </form>
                                      <br>
                                      <input id="edit-mgoodspicture" value="" name="mgoodspicture" class="form-control forminput" placeholder="Gambar" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="" rel="tooltip" title="Gambar"></label>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="menuedit3" class="tab-pane fade">
                          <div class="form form-horizontal" style="margin-top:21px;">
                            <div class="col-md-12">
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-2 control-label"><b>Menggunakan Pajak</b>  &nbsp  :</label>
                                <div class="col-md-1">
                                  <!-- <input id="insert-mgoodsmultiunit" value="" name="mgoodsmultiunit" class="nice-toggle" placeholder="mgoodsactive" type="checkbox" data-toggle="toggle"> -->
                                  <div class="yesnoswitch">
                                      <input type="checkbox" name="mgoodsbranches" class="yesnoswitch-checkbox" id="edit-mgoodstaxable">
                                      <label class="yesnoswitch-label" for="edit-mgoodstaxable">
                                          <span class="yesnoswitch-inner"></span>
                                          <span class="yesnoswitch-switch"></span>
                                      </label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-2 control-label"><b>Pajak</b>  (<font color="red">*</font>) &nbsp  :</label>
                                  <div class="col-md-4">
                                    <div class="icon-addon addon-md">
                                      <select class="form-control select2" name="mgoodstaxppn" id="edit-mgoodstaxppn">

                                      @foreach($taxes as $tax)
                                        @if($tax->mtaxtype == 'Kosong')
                                          <option selected value="{{ $tax->id }}">&nbsp;</option>
                                        @else
                                          <option value="{{ $tax->id }}">{{ $tax->mtaxtdesc }}</option>
                                        @endif
                                      @endforeach

                                      </select>
                                    </div>
                                  </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-2 control-label"><b>Pajak Barang Mewah</b>  (<font color="red">*</font>) &nbsp  :</label>
                                  <div class="col-md-4">
                                    <div class="icon-addon addon-md">
                                      <select class="form-control select2" name="mgoodstaxppnbm" id="edit-mgoodstaxppnbm">
                                      @foreach($taxes as $tax)
                                        @if($tax->mtaxtype == 'Kosong')
                                          <option selected value="{{ $tax->id }}">&nbsp;</option>
                                        @else
                                          <option value="{{ $tax->id }}">{{ $tax->mtaxtdesc }}</option>
                                        @endif
                                      @endforeach
                                      </select>
                                    </div>
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-offset-5 col-md-5" style="margin-top:20px;margin-bottom:20px;">
                        <button onclick="updatemgoods()" type="submit" name="button" class="btn btn-primary">Simpan</button>
                        <a id="btn-insert-reset" onclick="reseteditmgoods()" class="btn btn-default" ><i class=""></i> Reset</a>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </article>
      </div>

      <!-- row -->
      <div class="row">
        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <!-- Widget ID (each widget will need unique ID)-->
          <div id="formview" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
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
              <h3 style="font-weight: bold; color: #291817;font-size: 19px;">Mode : VIEW</h3>
              <!-- widget content -->
              <div class="widget-body no-padding">
                  <div class="container">
                    <div class="row">
                      <h2></h2>
                      <ul class="nav nav-tabs" style="padding-left:10px;">
                        <li class="active"><a data-toggle="tab" href="#menuview1">Spesifikasi</a></li>
                        <li><a data-toggle="tab" href="#menuview2">Spesifikasi 2</a></li>
                        <li><a data-toggle="tab" href="#menuview3">Pajak</a></li>

                      </ul>
                      <div id="edit-wrapper" class="tab-content" data-parsley-validate>
                        <div id="menuview1" class="tab-pane fade in active">
                          <div class="container form form-horizontal" style="margin-top:21px;">
                            <!--  BOX Kiri -->
                            <div class="col-md-6 group-box">
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Kode Barang</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-9">
                                   <div class="icon-addon addon-md">
                                       <div class="input-group">
                                        <input disabled id="view-mgoodscode" name="mgoodscode" class="form-control forminput" maxlength="14" placeholder="AUTO GENERATE" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".errorBlock1" @if (Session::has('autofocus')) autofocus @endif >
                                        <label for="" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Pelanggan"></label>
                                        <span class="input-group-addon" style="background: none;">
                                           <input type="checkbox" id="autogenmgoods" name="autogen" rel="tooltip" title="ON/OFF auto generate ID Barang">
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="errorBlock2" style="margin-left:23% !important;"></div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Barcode</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-mgoodsbarcode" value="{{old('mgoodsbarcode')}}" name="mgoodsbarcode" class="form-control forminput" maxlength="14" placeholder="Barcode" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Barcode"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Nama Barang</b>  (<font color="red">*</font>) &nbsp  :</label>
                                <div  class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-mgoodsname" value="{{old('mgoodsname')}}" name="mgoodsname" class="form-control forminput" placeholder="Nama Barang" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Barang"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Kategori Barang</b>  (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <select disabled id="view-mgoodscategory" name="mgoodscategory" class="form-control select2">
                                      @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Tipe Barang</b>  &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <select disabled id="view-mgoodstype" name="mgoodstype" class="form-control select2">
                                      @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->mgoodstypename }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Sub Tipe Barang</b>  &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <select disabled id="view-mgoodssubtype" name="mgoodssubtype" class="form-control select2">
                                      @foreach($subtypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->mgoodssubtypename }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Merk</b>  &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <select disabled id="view-mgoodsbrand" name="mgoodsbrand" class="form-control select2">
                                      @foreach($marks as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Nama Barang Alias</b>  &nbsp  :</label>
                                <div  class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-mgoodsalias" value="{{old('mgoodsalias')}}" name="mgoodsalias" class="form-control forminput" placeholder="Nama Barang Alias" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Barang Alias"></label>

                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Keterangan</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <!-- <input id="view-mgoodsremark" value="{{old('mgoodsremark')}}" name="mgoodsremark" class="form-control forminput" placeholder="Keterangan" type="text"  @if (Session::has('autofocus')) autofocus @endif > -->
                                    <textarea disabled id="view-mgoodsremark" name="mgoodsremark" class="form-control forminput" placeholder="Keterangan" rows="5"></textarea>
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Keterangan"></label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--  BOX Kanan -->
                            <div class="col-md-6 group-box">

                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>2 Satuan</b>  &nbsp  :</label>
                                <div class="col-md-1">
                                  <!-- <input id="view-mgoodsmultiunit" value="" name="mgoodsmultiunit" class="nice-toggle" placeholder="mgoodsactive" type="checkbox" data-toggle="toggle"> -->
                                  <div class="yesnoswitch">
                                      <input disabled type="checkbox" name="mgoodsbranches" class="yesnoswitch-checkbox" id="view-mgoodsmultiunit">
                                      <label class="yesnoswitch-label" for="view-mgoodsmultiunit">
                                          <span class="yesnoswitch-inner"></span>
                                          <span class="yesnoswitch-switch"></span>
                                      </label>
                                  </div>
                                </div>
                                <label class="col-md-3 control-label"><b>3 Satuan</b>  &nbsp  :</label>
                                <div class="col-md-3">
                                  <!-- <input id="insert-mgoodsmultiunit" value="" name="mgoodsmultiunit" class="nice-toggle" placeholder="mgoodsactive" type="checkbox" data-toggle="toggle"> -->
                                  <div class="yesnoswitch">
                                      <input type="checkbox" name="mgoodsbranches" class="yesnoswitch-checkbox" id="view-mgoodsmultiunit3">
                                      <label class="yesnoswitch-label" for="view-mgoodsmultiunit3l">
                                          <span class="yesnoswitch-inner"></span>
                                          <span class="yesnoswitch-switch"></span>
                                      </label>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group" style="height: 21px;">
                                <label class="col-md-3 control-label"><b>Satuan-1</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <select disabled class="form-group select2" id="view-mgoodsunit" name="mgoodsunit">
                                      @foreach($units as $unit)
                                        <option id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group" style="height: 21px;">
                                <label class="col-md-3 control-label"><b>Satuan-2</b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <select class="form-group select2" disabled id="view-mgoodsunit2" name="mgoodsunit2">
                                    @foreach($units as $unit)
                                      @if($unit->mgoodsunitname == 'Lusin')
                                        <option selected id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                      @else
                                        <option id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                      @endif
                                    @endforeach
                                  </select>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                  <input id="view-mgoodsunit2conv" disabled name="mgoodunit2conv" class="form-control forminput" placeholder="Unit" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                </div>
                                <div class="col-md-1">
                                  <label class="control-label">Unit</label>
                                </div>
                              </div>
                              <div class="form-group" style="height: 21px;">
                                <label class="col-md-3 control-label"><b>Satuan-3</b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <select class="form-group select2" disabled id="view-mgoodsunit3" name="mgoodsunit2">
                                    @foreach($units as $unit)
                                      @if($unit->mgoodsunitname == 'Karton')
                                        <option selected id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                      @else
                                        <option id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                      @endif
                                    @endforeach
                                  </select>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                  <input id="view-mgoodsunit3conv" disabled name="mgoodunit3conv" class="form-control forminput" placeholder="Unit" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                </div>
                                <div class="col-md-1">
                                  <label class="control-label">Unit</label>
                                </div>
                              </div>
                              <!-- <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Semua cabang </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input disabled type="checkbox" name="mgoodsbranches" class="yesnoswitch-checkbox" id="view-mgoodsbranches">
                                        <label class="yesnoswitch-label" for="view-mgoodsbranches">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div> -->
                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-3 control-label"><b>Unique Transaction </b>  &nbsp  :</label>
                                  <div class="col-md-9 col-sm-12">
                                    <div class="yesnoswitch">
                                        <input disabled type="checkbox" name="mgoodsbranches" class="yesnoswitch-checkbox" id="view-mgoodsuniquetransaction">
                                        <label class="yesnoswitch-label" for="view-mgoodsuniquetransaction">
                                            <span class="yesnoswitch-inner"></span>
                                            <span class="yesnoswitch-switch"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Status</b>  &nbsp  :</label>
                                  <div class="col-md-9">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="mgoodsactive" class="onoffswitch-checkbox" id="view-mgoodsactive">
                                        <label class="onoffswitch-label" for="view-mgoodsactive">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Harga Beli</b> &nbsp  :</label>
                                <div class="row">
                                <div class="col-md-5 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-mgoodspricein" value="{{old('mgoodspricein')}}" name="mgoodspricein" data-parsley-type="number" data-parsley-type-message="Field ini hanya dapat di isi oleh angka" parsley-error-container=".erroripricein" class="form-control forminput" placeholder="Harga Beli" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Harga Beli"></label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <label class="control-label muted">Harga Beli Diluar PPn</label>
                                </div>
                                </div>
                                <div class="erroripricein"></div>
                              </div>
                              <div class="form-group" style="height: 21px;">
                                <label class="col-md-3 control-label"><b>Satuan Beli</b> (<font color="red">*</font>) &nbsp  :</label>
                                  <div class="col-md-4 col-sm-12">
                                      <select disabled class="form-group select2" id="view-mgoodsunitin" name="mgoodsunitin">
                                        @foreach($units as $unit)
                                          <option id="{{ $unit->id }}">{{ $unit->mgoodsunitname }}</option>
                                        @endforeach
                                      </select>
                                  </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Minimal Pembelian</b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-mgoodsminimunin" value="{{old('mgoodsminimunin')}}" name="mgoodsminimunin" class="form-control forminput" placeholder="Minimal Pembelian" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Barang"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Harga Jual</b> &nbsp  :</label>
                                <div class="row">
                                <div class="col-md-5 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-mgoodspriceout" value="{{old('mgoodspriceout')}}" name="mgoodspriceout" data-parsley-type="number" data-parsley-type-message="Field ini hanya dapat di isi oleh angka" parsley-error-container=".erroripriceout" class="form-control forminput" placeholder="Harga Jual" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Harga Jual"></label>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <label class="control-label muted">Harga Jual Diluar PPn</label>
                                </div>
                                </div>
                                <div class="erroripriceout"></div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Maksimal Diskon</b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <div class="yesnoswitch">
                                      <input disabled type="checkbox" name="mgoodsactive" class="yesnoswitch-checkbox" id="view-mgoodssetmaxdisc">
                                      <label class="yesnoswitch-label" for="view-mgoodssetmaxdisc">
                                          <span class="yesnoswitch-inner"></span>
                                          <span class="yesnoswitch-switch"></span>
                                      </label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Maksimal Diskon</b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <div class="input-group">
                                    <span class="input-group-addon" id="sizing-addon2">%</span>
                                    <input disabled id="view-mgoodsmaxdisc" name="mgoodsmaxdisc" data-parsley-type="number" data-parsley-type-message="Field ini hanya dapat di isi oleh angka" class="form-control forminput" placeholder="Persentase" type="text">
                                  </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                  <div class="input-group">
                                    <input disabled id="view-mgoodsmaxdiscrp" name="mgoodsmaxdiscrp" data-parsley-type="number" data-parsley-type-message="Field ini hanya dapat di isi oleh angka" class="form-control forminput" placeholder="Rupiah" type="text">
                                    <span class="input-group-addon" id="sizing-addon2">Rp</span>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>HPP </b> &nbsp  :</label>
                                <div class="col-md-4 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-mgoodscogs" value="{{old('mgoodscogs')}}" name="mgoodscogs" class="form-control forminput" placeholder="HPP" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Harga Jual"></label>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                        <div id="menuview2" class="tab-pane fade">
                          <div class="form form-horizontal" style="margin-top:21px;">
                            <div class="col-md-10">
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Kode / Nama Supplier</b>  &nbsp  :</label>
                               <div class="col-md-4">
                                  <div class="icon-addon addon-md">
                                    <select disabled class="form-control select2-bold" name="mgoodssuppliercode" id="view-mgoodssuppliercode">
                                      @foreach($msupplier as $mg)
                                       <option value="{{$mg->msupplierid}}">{{$mg->msupplierid}} {{$mg->msuppliername}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Gambar</b>  &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                   <form action="upload.php">
                                          <input type="hidden">
                                          <div id="dropzone-gambar" class="dropzone"></div>
                                      </form>
                                      <br>
                                      <input id="view-mgoodspicture" value="" name="mgoodspicture" class="form-control forminput" placeholder="Gambar" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="" rel="tooltip" title="Gambar"></label>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="menuview3" class="tab-pane fade">
                          <div class="form form-horizontal" style="margin-top:21px;">
                            <div class="col-md-12">
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-2 control-label"><b>Menggunakan Pajak</b>  &nbsp  :</label>
                                <div class="col-md-1">
                                  <!-- <input id="insert-mgoodsmultiunit" value="" name="mgoodsmultiunit" class="nice-toggle" placeholder="mgoodsactive" type="checkbox" data-toggle="toggle"> -->
                                  <div class="yesnoswitch">
                                      <input type="checkbox" name="mgoodsbranches" class="yesnoswitch-checkbox" id="view-mgoodstaxable">
                                      <label class="yesnoswitch-label" for="edit-mgoodstaxable1">
                                          <span class="yesnoswitch-inner"></span>
                                          <span class="yesnoswitch-switch"></span>
                                      </label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-2 control-label"><b>Pajak</b>  (<font color="red">*</font>) &nbsp  :</label>
                                  <div class="col-md-4">
                                    <div class="icon-addon addon-md">
                                      <select disabled class="form-control select2" name="mgoodstaxppn" id="view-mgoodstaxppn">

                                      @foreach($taxes as $tax)
                                        @if($tax->mtaxtype == 'Kosong')
                                          <option selected value="{{ $tax->id }}">&nbsp;</option>
                                        @else
                                          <option value="{{ $tax->id }}">{{ $tax->mtaxtdesc }}</option>
                                        @endif
                                      @endforeach

                                      </select>
                                    </div>
                                  </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                  <label class="col-md-2 control-label"><b>Pajak Barang Mewah</b>  (<font color="red">*</font>) &nbsp  :</label>
                                  <div class="col-md-4">
                                    <div class="icon-addon addon-md">
                                      <select disabled class="form-control select2" name="mgoodstaxppnbm" id="view-mgoodstaxppnbm">
                                      @foreach($taxes as $tax)
                                        @if($tax->mtaxtype == 'Kosong')
                                          <option selected value="{{ $tax->id }}">&nbsp;</option>
                                        @else
                                          <option value="{{ $tax->id }}">{{ $tax->mtaxtdesc }}</option>
                                        @endif
                                      @endforeach
                                      </select>
                                    </div>
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-offset-5 col-md-5" style="margin-top:20px;margin-bottom:20px;">
                        <a id="btn-insert-reset" onclick="backmgoods()" class="btn btn-default" ><i class=""></i> Kembali</a>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </article>
      </div>

      <div class="row" id="tablewrapper">
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
                            <input type="text" class="form-control" placeholder="Filter Kategori" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Tipe" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Sub Tipe" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Merek" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Alias" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Keterangan" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Multi Satuan" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Multi Satuan 1" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Multi Satuan 2" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Multi Cabang" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Transaksi Unik" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Aktif" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Harga Beli" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Satuan Beli" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Satuan Beli" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Jumlah Minimal Pembelian" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Harga Jual" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter HPP" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Supplier" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter PPN" />
                          </th>
                          <th class="hasinput" style="width:10%">
                            <input type="text" class="form-control" placeholder="Filter Pajak Barang Mewah" />
                          </th>

                        </tr>
                        <tr>
                          <th data-hide="action"><center>Aksi</center></th>
                          <th data-hide="no"><center>No</center></th>
                          <th data-hide="mgoodscode"><center>Kode Barang</center></th>
                          <th data-hide="mgoodsbarcode"><center>Barcode</center></th>
                          <th data-hide="mgoodsname"><center>Nama Barang</center></th>
                          <th data-hide="category"><center>Kategori</center></th>
                          <th data-hide="tipe"><center>Tipe</center></th>
                          <th data-hide="subtipe"><center>Sub Tipe</center></th>
                          <th data-hide="merek"><center>Merek</center></th>
                          <th data-hide="mgoodsalias"><center>Alias</center></th>
                          <th data-hide="mgoodsremark"><center>Keterangan</center></th>
                          <th data-hide="mgoodsmultiunit"><center>Multi Unit</center></th>
                          <th data-hide="mgoodsunit"><center>Unit</center></th>
                          <th data-hide="mgoodsunit2"><center>Unit 2</center></th>
                          <th data-hide="mgoodsunit3"><center>Unit 3</center></th>
                          <th data-hide="mgoodsbranches"><center>Multi Cabang</center></th>
                          <th data-hide="mgoodsuniquetransaction"><center>Transaksi Unik</center></th>
                          <th data-hide="mgoodsactive"><center>Aktif</center></th>
                          <th data-hide="mgoodspricein"><center>Harga Beli</center></th>
                          <th data-hide="mgoodsunitin"><center>Satuan Beli</center></th>
                          <th data-hide="mgoodsminimumin"><center>Minimal Pembelian</center></th>
                          <th data-hide="mgoodspriceout"><center>Harga Jual</center></th>
                          <th data-hide="mgoodscogs"><center>HPP</center></th>
                          <th data-hide="supplier"><center>Supplier</center></th>
                          <th data-hide="mgoodtaxppn"><center>PPN</center></th>
                          <th data-hide="mgoodtaxppnbm"><center>PPN BM</center></th>
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
        "aoColumnDefs": [{ "bVisible": false, "aTargets": [6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25] }],
        buttons: [ {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25]
            }
        },
        {
            text: 'CSV',
            action: function(){
              window.location.href = "{{ url('/admin-nano/barang/export/csv') }}"
            }
        },
        {
            text: 'Excel',
            action: function(){
              window.location.href = "{{ url('/admin-nano/barang/export/excel') }}"
            }
        },
        {
            text: 'PDF',
            action: function(){
              window.location.href = "{{ url('/admin-nano/barang/export/pdf') }}"
            }
        },
        {
            extend: 'print',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25] //setting kolom mana yg mau di print
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
                {data: 'category', category: 'category'},
                {data: 'type', type: 'type'},
                {data: 'subtype', subtype: 'subtype'},
                {data: 'brand', brand: 'brand'},
                {data: 'mgoodsalias', mgoodsalias: 'mgoodsalias'},
                {data: 'mgoodsremark', mgoodsremark: 'mgoodsremark'},
                {data: 'mgoodsmultiunit', mgoodsmultiunit: 'mgoodsmultiunit'},
                {data: 'mgoodsunit', mgoodsunit: 'mgoodsunit'},
                {data: 'mgoodsunit2', mgoodsunit2: 'mgoodsunit2'},
                {data: 'mgoodsunit3', mgoodsunit3: 'mgoodsunit3'},
                {data: 'mgoodsbranches', mgoodsbranches: 'mgoodsbranches'},
                {data: 'mgoodsuniquetransaction', mgoodsuniquetransaction: 'mgoodsuniquetransaction'},
                {data: 'mgoodsactive', mgoodsactive: 'mgoodsactive'},
                {data: 'mgoodspricein', mgoodspricein: 'mgoodspricein'},
                {data: 'mgoodsunitin', mgoodsunitin: 'mgoodsunitin'},
                {data: 'mgoodsminimumin', mgoodsminimumin: 'mgoodsminimumin'},
                {data: 'mgoodspriceout', mgoodspriceout: 'mgoodspriceout'},
                {data: 'mgoodscogs', mgoodscogs: 'mgoodscogs'},
                {data: 'supplier', supplier: 'supplier'},
                {data: 'mgoodstaxppn', mgoodstaxppn: 'mgoodstaxppn'},
                {data: 'mgoodstaxppnbm', mgoodstaxppnbm: 'mgoodstaxppnbm'},
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
    function popupdelete(deleteid){
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
          console.log(deleteid);
          $.ajax({
            type: "DELETE",
            url: API_URL+"/barang/"+deleteid,
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
<!-- <script src="{{ url('/js/bootstrap-switch.min.js') }}"></script> -->
<!-- <script src="{{ url('/js/bootstrap-toggle.js') }}"></script> -->
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="{{ url('/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ url('/js/dropzone.js') }}"></script>
<script src="{{ url('/master/mgoods.js') }}"></script>
<script>
$("#dropzone-gambar").dropzone({
    paramName: "gambar",
    url: "{{ url('admin-api/barang/gambar/') }}",
    success: function(response){
      var parsed = $.parseJSON(response.xhr.response);
      console.log(parsed);
      $('#insert-mgoodspicture').val(parsed.url);
      swal({
        title: "Upload Sukses!",
        type: "success",
        timer: 1000
      });
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
   </script>
@stop

@section('css')
  <!-- <link rel="stylesheet" href="{{ url('/css/bootstrap-switch.min.css') }}"> -->
  <link rel="stylesheet" href="{{ url('/css/onoff.css') }}">
  <link rel="stylesheet" href="{{ url('/css/yesno.css') }}">
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
    .muted {
      color: #888;
    }
    .active-toggle {
      padding-top: 5px;
      margin-bottom: 5px;
    }
    .group-box {
      border: 4px #ddd solid;
      padding: 2%;
    }
    .box-bottom {
      border: 4px #ddd solid;
      padding: 2%;
      margin-left: 50px;
      margin-top: 10px;
    }
    .bootstrap-switch-primary{
      width: 53px;
    }
    #tableapi {
      border: 1px solid #ddd !important;
    }
  </style>
@stop
