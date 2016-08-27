@extends('admin/nav/layout')
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
      <li>Home</li><li>Barang</li><li>Buat baru</li>
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
</br>
</br>
</br>
</br>
<form class="form-horizontal" action="#" method="post">
      {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $a->id }}"></input>
      <div class="container">
        <div class="jumbotron">


      @if(count($errors) > 0)
<div class="alert alert-danger">
@foreach($errors->all() as $error)
  <ul>
    <li>{{ $error }}</li>
  </ul>
@endforeach
</div>
@endif









    <header>
      <h2><strong>Tabs / Pills</strong> <i>Widget</i></h2>

      <ul id="widget-tab-1" class="nav nav-tabs pull-right">

        <li class="active">

          <a data-toggle="tab" href="#hr1"> <i class="fa fa-lg fa-arrow-circle-o-down"></i> <span class="hidden-mobile hidden-tablet"> Spesifikasi </span> </a>

        </li>

        <li>
          <a data-toggle="tab" href="#hr2"> <i class="fa fa-lg fa-arrow-circle-o-up"></i> <span class="hidden-mobile hidden-tablet"> Satuan </span></a>
        </li>
        <li>
          <a data-toggle="tab" href="#hr3"> <i class="fa fa-lg fa-arrow-circle-o-up"></i> <span class="hidden-mobile hidden-tablet"> Supplier </span></a>
        </li>
        <li>
          <a data-toggle="tab" href="#hr4"> <i class="fa fa-lg fa-arrow-circle-o-up"></i> <span class="hidden-mobile hidden-tablet"> Harga </span></a>
        </li>
        <li>
          <a data-toggle="tab" href="#hr5"> <i class="fa fa-lg fa-arrow-circle-o-up"></i> <span class="hidden-mobile hidden-tablet"> Pajak </span></a>
        </li>
        <li>
          <a data-toggle="tab" href="#hr6"> <i class="fa fa-lg fa-arrow-circle-o-up"></i> <span class="hidden-mobile hidden-tablet"> Gambar </span></a>
        </li>
      </ul>

    </header>

    <!-- widget div-->
    <div>

      <!-- widget edit box -->
      <div class="jarviswidget-editbox">
        <!-- This area used as dropdown edit box -->

      </div>
      <!-- end widget edit box -->

      <!-- widget content -->
      <div class="widget-body no-padding">

        <!-- widget body text-->

        <div class="tab-content padding-10">
          <div class="tab-pane fade in active" id="hr1">

              <h4 class="alert alert-danger"> Insert tabs / pills to widget header </h4>
              <div class="form-group">
                <label  name="mgoodscode" class="col-md-3 control-label">GOODS CODE :</label>
                <div class="col-sm-5">
                  <input value="{{$a->mgoodscode}}" name="mgoodscode" class="form-control" placeholder="GOODS CODE" type="text">
                </div>
              </div>
              <div class="form-group">
                <label name="mgoodsbarcode" class="col-md-3 control-label">GOODS BAR CODE :</label>
                <div class="col-sm-5">
                  <input value="{{$a->mgoodsbarcode}}" name="mgoodsbarcode" class="form-control" placeholder="GOODS BAR CODE" type="text">
                </div>
              </div>
              <div class="form-group">
                <label name="mgoodsname" class="col-md-3 control-label">GOODS NAME :</label>
                <div class="col-sm-5">
                  <input value="{{$a->mgoodsname}}" name="mgoodsname" class="form-control" placeholder="GOODS NAME" type="text">
                </div>
              </div>
              <div class="form-group">
                <label name="mgoodsalias" class="col-md-3 control-label">GOODS ALIAS :</label>
                <div class="col-sm-5">
                  <input value="{{$a->mgoodsalias}}" name="mgoodsalias" class="form-control" placeholder="GOODS ALIAS" type="text">
                </div>
              </div>
              <div class="form-group">
                <label name="goodstype" class="col-md-3 control-label">GOODS TYPE :</label>
                <div class="col-sm-5">
                  <input value="{{$a->mgoodstype}}" name="mgoodstype" class="form-control" placeholder="GOODS TYPE" type="text">
                </div>
              </div>
              <div class="form-group">
                <label name="mgoodsgroup1" class="col-md-3 control-label">GOODS GROUP 1 :</label>
                <div class="col-sm-5">
                  <input value="{{$a->mgoodsgroup1}}" name="mgoodsgroup1" class="form-control" placeholder="GOODS GROUP 1" type="text">
                </div>
              </div>
              <div class="form-group">
                <label name="mgoodsgroup2" class="col-md-3 control-label">GOODS GROUP 2 :</label>
                <div class="col-sm-5">
                  <input value="{{$a->mgoodsgroup2}}" name="mgoodsgroup2" class="form-control" placeholder="GOODS GROUP 2" type="text">
                </div>
              </div>
              <div class="form-group">
                <label name="mgoodsgroup3" class="col-md-3 control-label">GOODS GROUP 3 :</label>
                <div class="col-sm-5">
                  <input value="{{$a->mgoodsgroup3}}" name="mgoodsgroup3" class="form-control" placeholder="GOODS GROUP 3" type="text">
                </div>
              </div>
              <div class="form-group">
                <label name="mgoodsremark" class="col-md-3 control-label">GOODS REMARK :</label>
                <div class="col-sm-5">
                  <input value="{{$a->mgoodsremark}}" name="mgoodsremark" class="form-control" placeholder="GOODS REMARK" type="text">
                </div>
              </div>
              <div class="form-group">
                <label name="mgoodsbranches" class="col-md-3 control-label">GOODS BRANCHES :</label>
                <div class="col-sm-5">
                  <input value="{{$a->mgoodsbranches}}" name="mgoodsbranches" class="form-control" placeholder="GOODS BRANCHES" type="text">
                </div>
              </div>
              <div class="form-group">
                <label name="mgoodsactive" class="col-md-3 control-label">GOODS ACTIVE :</label>
                <div class="col-sm-5">
                  <input value="{{$a->mgoodsactive}}" name="mgoodsactive" class="form-control" placeholder="GOODS ACTIVE" type="text">
                </div>
              </div>
              <button type="submit" name="button" class="btn btn-primary">UPDATE</button>
          </div>

          <div class="tab-pane fade" id="hr2">
              <h4 class="alert alert-warning"> Checkout the <a href="general-elements.html">General Elements</a> page for more tab options </h4>
              <div class="form-group">
                <label name="mgoodsunit" class="col-md-3 control-label">GOODS UNIT :</label>
                <div class="col-sm-5">
                  <input value="{{$a->mgoodsunit}}" name="mgoodsunit" class="form-control" placeholder="GOODS UNIT" type="text">
                </div>
              </div>
                <div class="form-group">
                  <label name="mgoodsunit2" class="col-md-3 control-label">GOODS UNIT 2 :</label>
                  <div class="col-sm-5">
                    <input value="{{$a->mgoodsunit2}}" name="mgoodsunit2" class="form-control" placeholder="GOODS UNIT 2" type="text">
                  </div>
                </div>
                  <div class="form-group">
                    <label name="mgoodsunit3" class="col-md-3 control-label">GOODS UNIT 3 :</label>
                    <div class="col-sm-5">
                      <input value="{{$a->mgoodsunit3}}" name="mgoodsunit3" class="form-control" placeholder="GOODS UNIT 3" type="text">
                    </div>
                  </div>
                  <div class="form-group">
                    <label name="mgoodsunit2convert" class="col-md-3 control-label">GOODS UNIT 2 CONVERT :</label>
                    <div class="col-sm-5">
                      <input value="{{$a->mgoodsunit2convert}}" name="mgoodsunit2convert" class="form-control" placeholder="GOODS UNIT 2 CONVERT" type="text">
                    </div>
                  </div>
                  <div class="form-group">
                    <label name="mgoodsunit3convert" class="col-md-3 control-label">GOODS UNIT 3 CONVERT :</label>
                    <div class="col-sm-5">
                      <input value="{{$a->mgoodsunit3convert}}" name="mgoodsunit3convert" class="form-control" placeholder="GOODS UNIT 3 CONVERT" type="text">
                    </div>
                  </div>
          </div>

          <div class="tab-pane fade" id="hr3">
            <h4 class="alert alert-warning"> Checkout the <a href="general-elements.html">General Elements</a> page for more tab optionss </h4>
            <div class="form-group">
              <label name="mgoodssuppliercode" class="col-md-3 control-label">GOODS SUPPLIER CODE :</label>
              <div class="col-sm-5">
                <input value="{{$a->mgoodssuppliercode}}" name="mgoodssuppliercode" class="form-control" placeholder="GOODS SUPPLIER CODE" type="text">
              </div>
            </div>
            <div class="form-group">
              <label name="mgoodssuppliername" class="col-md-3 control-label">GOODS SUPPLIER NAME :</label>
              <div class="col-sm-5">
                <input value="{{$a->mgoodssuppliername}}" name="mgoodssuppliername" class="form-control" placeholder="GOODS SUPPLIER NAME" type="text">
              </div>
            </div>
            <div class="form-group">
              <label name="mgoodsbrand" class="col-md-3 control-label">GOODS BRAND :</label>
              <div class="col-sm-5">
                <input value="{{$a->mgoodsbrand}}" name="mgoodsbrand" class="form-control" placeholder="GOODS BRAND" type="text">
              </div>
            </div>
            <div class="form-group">
              <label name="mgoodscogs" class="col-md-3 control-label">GOODS COGS :</label>
              <div class="col-sm-5">
                <input value="{{$a->mgoodscogs}}" name="mgoodscogs" class="form-control" placeholder="GOODS COGS" type="text">
              </div>
            </div>
            <div class="form-group">
              <label name="mgoodsuniquetransaction" class="col-md-3 control-label">GOODS UNIQUE TRANSACTION :</label>
              <div class="col-sm-5">
                <input value="{{$a->mgoodsuniquetransaction}}" name="mgoodsuniquetransaction" class="form-control" placeholder="GOODS UNIQUE TRANSACTION" type="text">
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="hr4">
            <h4 class="alert alert-warning"> Checkout the <a href="general-elements.html">General Elements</a> page for more tab optionsss </h4>
            <div class="form-group">
              <label name="mgoodspricein" class="col-md-3 control-label">GOODS PRICE IN :</label>
              <div class="col-sm-5">
                <input value="{{$a->mgoodspricein}}" name="mgoodspricein" class="form-control" placeholder="GOODS PRICE IN" type="text">
              </div>
            </div>
            <div class="form-group">
              <label name="mgoodspriceout" class="col-md-3 control-label">GOODS PRICE OUT :</label>
              <div class="col-sm-5">
                <input value="{{$a->mgoodspriceout}}" name="mgoodspriceout" class="form-control" placeholder="GOODS PRICE OUT" type="text">
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="hr5">
            <h4 class="alert alert-warning"> Checkout the <a href="general-elements.html">General Elements</a> page for more tabS optionss </h4>
            <div class="form-group">
              <label name="mgoodscoapurchasingname" class="col-md-3 control-label">GOODS PURCASHING NAME :</label>
              <div class="col-sm-5">
                <input value="{{$a->mgoodscoapurchasingname}}" name="mgoodscoapurchasingname" class="form-control" placeholder="GOODS PURCHASHING NAME" type="text">
              </div>
            </div>

            <div class="form-group">
              <label name="mgoodscoacogsname" class="col-md-3 control-label">GOODS COA COGS NAME :</label>
              <div class="col-sm-5">
                <input value="{{$a->mgoodscoacogsname}}" name="mgoodscoacogsname" class="form-control" placeholder="GOODS COA COGS NAME" type="text">
              </div>
            </div>
            <div class="form-group">
              <label name="mgoodscoasellingname" class="col-md-3 control-label">GOODS COA SELLING NAME:</label>
              <div class="col-sm-5">
                <input value="{{$a->mgoodscoasellingname}}" name="mgoodscoasellingname" class="form-control" placeholder="GOODS COA SELLING NAME" type="text">
              </div>
            </div>
            <div class="form-group">
              <label name="mgoodscoareturnofsellingname" class="col-md-3 control-label">GOODS COA RETURN OF SELLING NAME :</label>
              <div class="col-sm-5">
                <input value="{{$a->mgoodscoareturnofsellingname}}" name="mgoodscoareturnofsellingname" class="form-control" placeholder="GOODS COA RETURN OF SELLING NAME" type="text">
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="hr6">
            <h4 class="alert alert-warning"> Checkout the <a href="general-elements.html">GeneralS Elements</a> page for more tabS optionss </h4>
            <div class="form-group">
              <label name="mgoodspicture" class="col-md-3 control-label">GOODS PICTURE :</label>
              <div class="col-sm-5">
                <input value="{{$a->mgoodspicture}}" name="mgoodspicture" class="form-control" placeholder="GOODS PICTURE" type="text">
              </div>
            </div>
          </div>
        </div>
</form>
        <!-- end widget body text-->
</div>
</div>
<!-- end widget content -->

</div>
<!-- end widget div -->

</div>
<!-- end widget -->



</article>
<!-- WIDGET END -->

</div>

<!-- end row -->

<!-- end row -->

</section>
<!-- end widget grid -->

</div>
<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

@stop
