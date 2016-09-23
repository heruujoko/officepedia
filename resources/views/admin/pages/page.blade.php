<div class="row">



				<!-- NEW WIDGET START -->

				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">



					<!-- Widget ID (each widget will need unique ID)-->

					<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

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

						<h6>&nbsp &nbspMode : <span class="label label-danger">EDIT</span></h6>
		<form class="form-horizontal" action="#" method="post">
					{{ csrf_field() }}
          <input type="hidden" name="id" value="{{ $a->id }}"></input>

          <div class="container">
          


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
            </center>
        </br>




			
			</div>

							<!-- end widget -->

						</article>
