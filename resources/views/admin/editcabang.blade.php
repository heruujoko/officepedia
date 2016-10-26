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
      <li>Home</li><li>Cabang</li><li>Buat baru</li>
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
<h6>&nbsp &nbspMode : <span class="label label-danger">EDIT</span></h6>
		<form class="form-horizontal" action="#" method="post">
					{{ csrf_field() }}
          <input type="hidden" name="id" value="{{ $a->id }}"></input>
          <div class="container">
            <div class="jumbotron">


				<style>
              .alert-info {
                color: #D9ECF5;
                background-color: #48AFE3;
                border-color: #2F9ACF;
}
              </style>
              
                    @if(count($errors) > 0)

              <div class="alert alert-info" role="alert">

                @foreach($errors->all() as $error)

                <span class="sr-only">Error:</span>

                  <span class="sr-only"></span>
                  <li>{{ $error }}</li>


                @endforeach
                </div>
              @endif

              <div class="form-group">
              <label class="col-md-3 control-label"><b>Kode Cabang</b> (<font color="red">*</font>) &nbsp  :</label>
              <div class="col-md-7">
              <div class="icon-addon addon-md">
              <input value="{{$a->mbranchcode}}" name="mbranchcode" class="form-control" placeholder="Kode Cabang" type="text" required id="mbranchcode" @if (Session::has('autofocus')) autofocus @endif >
              <label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="Kode Cabang"></label>
              </div>
              </div>
              </div>
              <div class="form-group">
              <label class="col-md-3 control-label"><b>Nama Cabang</b> (<font color="red">*</font>) &nbsp  :</label>
              <div class="col-md-7">
              <div class="icon-addon addon-md">
              <input value="{{$a->mbranchname}}" name="mbranchname" class="form-control" placeholder="Nama Cabang" type="text" required @if (Session::has('autofocus')) autofocus @endif >
              <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Cabang"></label>
              </div>
              </div>
              </div>
              <div class="form-group">
              <label class="col-md-3 control-label"><b>Alamat</b> (<font color="red">*</font>) &nbsp  :</label>
              <div class="col-md-7">
              <div class="icon-addon addon-md">
              <input value="{{$a->address}}" name="address" class="form-control" placeholder="Alamat" type="text" required @if (Session::has('autofocus')) autofocus @endif >
              <label for="mgoodsgroup1" class="glyphicon glyphicon-home" rel="tooltip" title="Alamat"></label>
              </div>
              </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><b>Telepon</b> (<font color="red">*</font>) &nbsp  :</label>
                <div class="col-md-7">
                <div class="icon-addon addon-md">
                <input value="{{$a->phone}}" name="phone" class="form-control" placeholder="Telepon" type="number" required @if (Session::has('autofocus')) autofocus @endif >
                <label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Telepon"></label>
                </div>
                </div>
                </div>
              <div class="form-group">
              <label class="col-md-3 control-label"><b>Kota</b> (<font color="red">*</font>) &nbsp  :</label>
              <div class="col-md-7">
              <div class="icon-addon addon-md">
              <input value="{{$a->city}}" name="city" class="form-control" placeholder="Kota" type="text" required @if (Session::has('autofocus')) autofocus @endif >
              <label for="mgoodsgroup1" class="glyphicon glyphicon-road" rel="tooltip" title="Kota"></label>
              </div>
              </div>
              </div>
              <div class="form-group">
              <label class="col-md-3 control-label"><b>Orang Yang Bertanggung Jawab</b>(<font color="red">*</font>) &nbsp  :</label>
              <div class="col-md-7">
              <div class="icon-addon addon-md">
              <input value="{{$a->person_in_charge}}" name="person_in_charge" class="form-control" placeholder="Orang yang bertanggung jawab" type="text" required @if (Session::has('autofocus')) autofocus @endif >
              <label for="mgoodsgroup1" class="glyphicon glyphicon-user" rel="tooltip" title="Orang Yang Bertanggung Jawab"></label>
              </div>
              </div>
              </div>
              <div class="form-group">
              <label class="col-md-3 control-label"><b>Keterangan</b> &nbsp  :</label>
              <div class="col-md-7">
              <div class="icon-addon addon-md">
              <input value="{{$a->information}}" name="information" class="form-control" placeholder="Keterangan" type="text" id="information" @if (Session::has('autofocus')) autofocus @endif >
              <label for="mgoodsgroup1" class="glyphicon glyphicon-search" rel="tooltip" title="Keterangan"></label>
              </div>
              </div>
              </div>
            <center>
              <div class="row">
              <div class="col-md-12">
              <a href="{{URL::to('/')}}/admin-nano/cabang" title="" class="btn btn-default">Batal</a>
              <button class="btn btn-primary" type="submit">
              <i class="fa fa-save"></i> Simpan</button>

              </div>
              </div>
            </center>
	</div>
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
