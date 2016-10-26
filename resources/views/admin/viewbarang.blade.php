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
                            <div class="col-md-4 col-sm-12">
                              <div class="icon-addon addon-md">
                                <select id="insert-mgoodstype" name="mgoodstype" class="form-control select2">
                                  @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Merk</b>  &nbsp  :</label>
                            <div class="col-md-4 col-sm-12">
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
                              <label class="col-md-3 control-label"><b>Digunakan oleh semua cabang: </b>  &nbsp  :</label>
                              <div class="col-md-9 col-sm-12">
                                <input id="insert-mgoodsbranches" value="" name="mgoodsbranches" class="nice-toggle" placeholder="Nama Perusahaan" type="checkbox">
                              </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                              <label class="col-md-3 control-label"><b>Unique Transaction </b>  &nbsp  :</label>
                              <div class="col-md-9 col-sm-12">
                                <input id="insert-mgoodsuniquetransaction" value="" name="mgoodsbranches" class="nice-toggle" placeholder="Nama Perusahaan" type="checkbox">
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
                            <label class="col-md-2 control-label"><b>Pembelian</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2-bold" name="mgoodscoapurchasing" id="insert-mgoodscoapurchasing">

                                @foreach($mcoa as $coa)
                                    @if($coa->id == 8)
                                      <option value="{{ $coa->mcoacode }}">{{ $coa->mcoacode }} {{ $coa->mcoaname }}</option>
                                    @else
                                      <option value="{{ $coa->mcoacode }}">{{ $coa->mcoacode }} {{ $coa->mcoaname }}</option>
                                    @endif
                                  @endforeach

                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Hpp</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2-bold" name="mgoodscoacogs" id="insert-mgoodscoacogs">
                                 @foreach($mcoa as $coa)
                                    @if($coa->id == 8)
                                      <option value="{{ $coa->mcoacode }}">{{ $coa->mcoacode }} {{ $coa->mcoaname }}</option>
                                    @else
                                      <option value="{{ $coa->mcoacode }}">{{ $coa->mcoacode }} {{ $coa->mcoaname }}</option>
                                    @endif
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                         <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Penjualan</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2-bold" name="mgoodscoaselling" id="insert-mgoodscoaselling">
                                 @foreach($mcoa as $coa)
                                    @if($coa->id == 8)
                                      <option value="{{ $coa->mcoacode }}">{{ $coa->mcoacode }} {{ $coa->mcoaname }}</option>
                                    @else
                                      <option value="{{ $coa->mcoacode }}">{{ $coa->mcoacode }} {{ $coa->mcoaname }}</option>
                                    @endif
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Retur Penjualan</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2-bold" name="mgoodscoareturnofselling" id="insert-mgoodscoareturnofselling">
                                 @foreach($mcoa as $coa)
                                    @if($coa->id == 8)
                                      <option value="{{ $coa->mcoacode }}">{{ $coa->mcoacode }} {{ $coa->mcoaname }}</option>
                                    @else
                                      <option value="{{ $coa->mcoacode }}">{{ $coa->mcoacode }} {{ $coa->mcoaname }}</option>
                                    @endif
                                  @endforeach
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
                        <a id="btn-insert-reset" onclick="resetmgoods()" class="btn btn-default" ><i class=""></i> Reset</a>
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
                          <div class="form-horizontal" style="margin-top:21px;">
                            <div class="col-md-10">
                             <div class="errorBlock1" style="margin-left:23% !important;"></div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Kode Barang</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-9">
                              	   <div class="icon-addon addon-md">
                              		     <div class="input-group">
                                    	  <input id="edit-mgoodscode" name="mgoodscode" class="form-control forminput" placeholder="AUTO GENERATE" maxlength="14" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".errorBlock1" @if (Session::has('autofocus')) autofocus @endif >
                                    		<label for="" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Pelanggan"></label>
                                    		<span class="input-group-addon" style="background: none;">
                                      	   <input type="checkbox" id="edit-autogenmgoods" name="autogen" rel="tooltip" title="ON/OFF auto generate ID Barang">
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
                                <label class="col-md-3 control-label"><b>Nama Barang</b>  &nbsp  :</label>
                                <div  class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="edit-mgoodsname" value="{{old('mgoodsname')}}" name="mgoodsname" class="form-control forminput" placeholder="Nama Barang" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Barang"></label>

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
                                    <input id="edit-mgoodsremark" value="{{old('mgoodsremark')}}" name="mgoodsremark" class="form-control forminput" placeholder="Keterangan" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Keterangan"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Satuan-1</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="edit-mgoodsunit" value="{{old('mgoodsunit')}}" name="mgoodsunit" class="form-control forminput" placeholder="Satuan-1" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Satuan-1"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Satuan-2</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="edit-mgoodsunit2" value="{{old('mgoodsunit2')}}" name="mgoodsunit2" class="form-control forminput" placeholder="Satuan-2" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Satuan-2"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Satuan-3</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="edit-mgoodsunit3" value="{{old('mgoodsunit3')}}" name="mgoodsunit3" class="form-control forminput" placeholder="Satuan-3" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Satuan-3"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Status</b>  &nbsp  :</label>
                                  <div class="col-md-9">
                                    <input id="edit-mgoodsactive" value="" name="mgoodsactive" class="nice-toggle" placeholder="mgoodsactive" type="checkbox">
                                </div>
                              </div>
                                <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Harga Beli</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="edit-mgoodspricein" value="{{old('mgoodspricein')}}" name="mgoodspricein" class="form-control forminput" placeholder="Harga Beli" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Harga Beli"></label>
                                  </div>
                                </div>
                              </div>
                            <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Harga Jual</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input id="edit-mgoodspriceout" value="{{old('mgoodspriceout')}}" name="mgoodspriceout" class="form-control forminput" placeholder="Harga Beli" type="text"  @if (Session::has('autofocus')) autofocus @endif >
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
                            <label class="col-md-3 control-label"><b>Tipe Barang</b>  &nbsp  :</label>
                            <div class="col-md-4 col-sm-12">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2" id="edit-mgoodstype" name="mgoodstype">
                                  @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Merk</b>  &nbsp  :</label>
                            <div class="col-md-4 col-sm-12">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2" id="edit-mgoodsbrand" name="mgoodsbrand">
                                  @foreach($marks as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Group Barang 1</b>  &nbsp  :</label>
                            <div class="col-md-9 col-sm-12">
                              <div class="icon-addon addon-md">
                                <input id="edit-mgoodsgroup1" value="{{old('mgoodsgroup1')}}" name="mgoodsgroup1" class="form-control forminput" placeholder="Group Barang 1" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Group Barang 1"></label>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Group Barang 2</b>  &nbsp  :</label>
                            <div class="col-md-9 col-sm-12">
                              <div class="icon-addon addon-md">
                                <input id="edit-mgoodsgroup2" value="{{old('mgoodsgroup2')}}" name="mgoodsgroup2" class="form-control forminput" placeholder="Group Barang 2" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup2" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Group Barang 2"></label>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Group Barang 3</b>  &nbsp  :</label>

                            <div class="col-md-9 col-sm-12">
                              <div class="icon-addon addon-md">
                                <input id="edit-mgoodsgroup3" value="{{old('mgoodsgroup3')}}" name="mgoodsgroup3" class="form-control forminput" placeholder="Group Barang 3" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Group Barang 3"></label>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Kode / Nama Supplier</b>  &nbsp  :</label>
                           <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2-bold" name="mgoodssuppliercode" id="edit-mgoodssuppliercode">
                                  @foreach($msupplier as $mg)
                                 <option selected value="{{$mg->msupplierid}}">{{$mg->msupplierid}} {{ $mg->msuppliername}}</option>
                                @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                              <label class="col-md-3 control-label"><b>Digunakan oleh semua cabang: </b>  &nbsp  :</label>
                              <div class="col-md-9 col-sm-12">
                                <input id="edit-mgoodsbranches" value="" name="mgoodsbranches" class="nice-toggle" placeholder="Nama Perusahaan" type="checkbox">
                              </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                              <label class="col-md-3 control-label"><b>Unique Transaction </b>  &nbsp  :</label>
                              <div class="col-md-9 col-sm-12">
                                <input id="edit-mgoodsuniquetransaction" value="" name="mgoodsbranches" class="nice-toggle" placeholder="Nama Perusahaan" type="checkbox">
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
                            <label class="col-md-2 control-label"><b>Pembelian</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2" name="mgoodscoapurchasing" id="edit-mgoodscoapurchasing">
                                @foreach($mcoa as $coa)
                                  <option selected value="{{ $coa->mcoacode }}">{{ $coa->mcoacode }}</option>
                                @endforeach

                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Hpp</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2" name="mgoodscoacogs" id="edit-mgoodscoacogs">
                                 @foreach($mcoa as $coa)
                                  <option selected value="{{ $coa->mcoacode }}">{{ $coa->mcoacode }}</option>
                                @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                         <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Penjualan</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2" name="mgoodscoaselling" id="edit-mgoodscoaselling">
                                 @foreach($mcoa as $coa)
                                  <option selected value="{{ $coa->mcoacode }}">{{ $coa->mcoacode }}</option>
                                @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Retur Penjualan</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select class="form-control select2" name="mgoodscoareturnofselling" id="edit-mgoodscoareturnofselling">
                                 @foreach($mcoa as $coa)
                                  <option selected value="{{ $coa->mcoacode }}">{{ $coa->mcoacode }}</option>
                                @endforeach
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
                        <button onclick="updatemgoods()" type="submit" name="button" class="btn btn-primary">Simpan</button>
                        <a id="btn-edit-reset" onclick="reseteditmgoods()" class="btn btn-default" ><i class=""></i> Reset</a>
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
                      <div id="view-wrapper" class="tab-content" data-parsley-validate>
                        <div id="menuview1" class="tab-pane fade in active">
                          <div class="form-horizontal" style="margin-top:21px;">
                            <div class="col-md-10">
                             <div class="errorBlock1" style="margin-left:23% !important;"></div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Kode Barang</b> (<font color="red">*</font>) &nbsp  :</label>
                                <div class="col-md-9">
                              	   <div class="icon-addon addon-md">
                              		     <div class="input-group">
                                    	  <input disabled id="view-mgoodscode" name="mgoodscode" class="form-control forminput" maxlength="14" placeholder="AUTO GENERATE" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong"  data-parsley-errors-container=".errorBlock1" @if (Session::has('autofocus')) autofocus @endif >
                                    		<label for="" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Pelanggan"></label>
                                    		<span class="input-group-addon" style="background: none;">
                                      	   <input type="checkbox" id="view-autogenmgoods" name="autogen" rel="tooltip" title="ON/OFF auto generate ID Barang">
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
                                    <input disabled id="view-mgoodsbarcode" value="{{old('mgoodsbarcode')}}" name="mgoodsbarcode" class="form-control forminput" placeholder="Barcode" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Barcode"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Nama Barang</b>  &nbsp  :</label>
                                <div  class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-mgoodsname" value="{{old('mgoodsname')}}" name="mgoodsname" class="form-control forminput" placeholder="Nama Barang" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Barang"></label>

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
                                    <input disabled id="view-mgoodsremark" value="{{old('mgoodsremark')}}" name="mgoodsremark" class="form-control forminput" placeholder="Keterangan" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Keterangan"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Satuan-1</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-mgoodsunit" value="{{old('mgoodsunit')}}" name="mgoodsunit" class="form-control forminput" placeholder="Satuan-1" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Satuan-1"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Satuan-2</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-mgoodsunit2" value="{{old('mgoodsunit2')}}" name="mgoodsunit2" class="form-control forminput" placeholder="Satuan-2" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Satuan-2"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Satuan-3</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-mgoodsunit3" value="{{old('mgoodsunit3')}}" name="mgoodsunit3" class="form-control forminput" placeholder="Satuan-3" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Satuan-3"></label>
                                  </div>
                                </div>
                              </div>
                              <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Status</b>  &nbsp  :</label>
                                  <div class="col-md-9">
                                    <input id="view-mgoodsactive" value="" name="mgoodsactive" class="nice-toggle" placeholder="mgoodsactive" type="checkbox">
                                </div>
                              </div>
                                <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Harga Beli</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-mgoodspricein" value="{{old('mgoodspricein')}}" name="mgoodspricein" class="form-control forminput" placeholder="Harga Beli" type="text"  @if (Session::has('autofocus')) autofocus @endif >
                                    <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Harga Beli"></label>
                                  </div>
                                </div>
                              </div>
                            <div style="height: 21px;" class="form-group">
                                <label class="col-md-3 control-label"><b>Harga Jual</b> &nbsp  :</label>
                                <div class="col-md-9 col-sm-12">
                                  <div class="icon-addon addon-md">
                                    <input disabled id="view-mgoodspriceout" value="{{old('mgoodspriceout')}}" name="mgoodspriceout" class="form-control forminput" placeholder="Harga Beli" type="text"  @if (Session::has('autofocus')) autofocus @endif >
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
                            <label class="col-md-3 control-label"><b>Tipe Barang</b>  &nbsp  :</label>
                            <div class="col-md-4 col-sm-12">
                              <div class="icon-addon addon-md">
                                <select disabled id="view-mgoodstype" name="mgoodstype" class="form-control select2">
                                  @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Merk</b>  &nbsp  :</label>
                            <div class="col-md-4 col-sm-12">
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
                            <label class="col-md-3 control-label"><b>Group Barang 1</b>  &nbsp  :</label>
                            <div class="col-md-9 col-sm-12">
                              <div class="icon-addon addon-md">
                                <input disabled id="view-mgoodsgroup1" value="{{old('mgoodsgroup1')}}" name="mgoodsgroup1" class="form-control forminput" placeholder="Group Barang 1" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Group Barang 1"></label>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Group Barang 2</b>  &nbsp  :</label>
                            <div class="col-md-9 col-sm-12">
                              <div class="icon-addon addon-md">
                                <input disabled id="view-mgoodsgroup2" value="{{old('mgoodsgroup2')}}" name="mgoodsgroup2" class="form-control forminput" placeholder="Group Barang 2" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup2" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Group Barang 2"></label>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Group Barang 3</b>  &nbsp  :</label>
                            <div class="col-md-9 col-sm-12">
                              <div class="icon-addon addon-md">
                                <input disabled id="view-mgoodsgroup3" value="{{old('mgoodsgroup3')}}" name="mgoodsgroup3" class="form-control forminput" placeholder="Group Barang 3" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Group Barang 3"></label>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Kode Supplier</b>  &nbsp  :</label>
                           <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select disabled class="form-control select2" name="mgoodssuppliercode" id="view-mgoodssuppliercode">
                                  @foreach($msupplier as $mg)
                                  <option disabled value="{{$mg->msupplierid}}">{{$mg->msupplierid}} {{ $mg->msuppliername}}</option>
                                 @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                              <label class="col-md-3 control-label"><b>Digunakan oleh semua cabang: </b>  &nbsp  :</label>
                              <div class="col-md-9 col-sm-12">
                                <input disabled id="view-mgoodsbranches" value="" name="mgoodsbranches" class="nice-toggle" placeholder="Nama Perusahaan" type="checkbox">
                              </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                              <label class="col-md-3 control-label"><b>Unique Transaction </b>  &nbsp  :</label>
                              <div class="col-md-9 col-sm-12">
                                <input disabled id="view-mgoodsuniquetransaction" value="" name="mgoodsbranches" class="nice-toggle" placeholder="Nama Perusahaan" type="checkbox">
                              </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-3 control-label"><b>Gambar</b>  &nbsp  :</label>
                            <div class="col-md-9 col-sm-12">
                              <div class="icon-addon addon-md">

                                  <br>
                                  <input disabled id="view-mgoodspicture" value="" name="mgoodspicture" class="form-control forminput" placeholder="Gambar" type="text" data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
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
                            <label class="col-md-2 control-label"><b>Pembelian</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select disabled class="form-control select2" name="mgoodscoapurchasing" id="view-mgoodscoapurchasing">
                                @foreach($mcoa as $coa)
                                  <option disabled selected value="{{ $coa->mcoacode }}">{{ $coa->mcoacode }}</option>
                                @endforeach

                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Hpp</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select disabled class="form-control select2" name="mgoodscoacogs" id="view-mgoodscoacogs">
                                 @foreach($mcoa as $coa)
                                  <option disabled selected value="{{ $coa->mcoacode }}">{{ $coa->mcoacode }}</option>
                                @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                         <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Penjualan</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select disabled class="form-control select2" name="mgoodscoaselling" id="view-mgoodscoaselling">
                                 @foreach($mcoa as $coa)
                                  <option disabled selected value="{{ $coa->mcoacode }}">{{ $coa->mcoacode }}</option>
                                @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Retur Penjualan</b>  &nbsp  :</label>
                            <div class="col-md-4">
                              <div class="icon-addon addon-md">
                                <select disabled class="form-control select2" name="mgoodscoareturnofselling" id="view-mgoodscoareturnofselling">
                                 @foreach($mcoa as $coa)
                                  <option disabled selected value="{{ $coa->mcoacode }}">{{ $coa->mcoacode }}</option>
                                @endforeach
                                </select>
                              </div>
                            </div>
                          </div>

                          <div style="height: 21px;" class="form-group">
                            <label class="col-md-2 control-label"><b>Informasi</b>  &nbsp  :</label>
                            <div  class="col-md-4">
                              <div class="icon-addon addon-md">
                                <input disabled id="view-mgoodscogs" value="{{old('mgoodscogs')}}" name="mgoodscogs" class="form-control forminput" placeholder="Informasi" type="text" @if (Session::has('autofocus')) autofocus @endif >
                                <label for="mgoodsgroup1" class="" rel="tooltip" title="Informasi"></label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="menuview4"></div>
                    <div class="row">
                      <div class="col-md-offset-5 col-md-5" style="margin-top:20px;margin-bottom:20px;">
                        <button onclick="back()" type="submit" name="button" class="btn btn-default">Kembali</button>

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
        "aoColumnDefs": [{ "bVisible": false, "aTargets": [6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30] }],
        buttons: [ {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21]
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
                {data: 'category', category: 'category'},
                {data: 'brand', brand: 'brand'},
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
    #tableapi {
			border: 1px solid #ddd !important;
		}
  </style>
@stop
