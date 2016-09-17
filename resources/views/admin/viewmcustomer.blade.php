
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
			<li>Home</li><li>BARANG</li><li>Data Barang</li>
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

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa fa-table fa-fw "></i>
						BARANG
					<span>
						Data Barang
					</span>
				</h1>
			</div>
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
		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
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

					 		<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body no-padding">

								 <div class="container">
  <h2></h2>
  <ul class="nav nav-tabs">
   	<li class="active"><a data-toggle="tab" href="#menu1">Profil Pelanggan</a></li>
    <li><a data-toggle="tab" href="#menu2">Pengiriman</a></li>
    <li><a data-toggle="tab" href="#menu3">Kontak</a></li>
    <li><a data-toggle="tab" href="#menu4">Penjualan</a></li>
    <li><a data-toggle="tab" href="#menu5">Pajak</a></li>
    <li><a data-toggle="tab" href="#menu6">Saldo</a></li>
    <li><a data-toggle="tab" href="#menu7">Lain-lain</a></li>
    <li><a data-toggle="tab" href="#menu8">Pengguna</a></li>
  </ul>

  <div class="tab-content">
    <div id="menu1" class="tab-pane fade in active">
    
    	 </br>
<form id="teste" class="form-horizontal" action="{{URL::to('/')}}/admin-nano/tambahcabang" method="post">
    <div class="col-md-6">
    <div class="tab-content">
        <div class="tab-pane active" id="info-tab">
    
    <div style="height: 21px;" class="form-group">
	<label class="control-label"><b>ID Pelanggan</b> (<font color="red">*</font>) &nbsp  :</label>
								<div class="">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomerid" value="{{old('mcustomerid')}}" name="mcustomerid" class="form-control forminput" placeholder="ID Pelanggan" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="ID Pelanggan"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="control-label"><b>Nama Pelanggan</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomername" value="{{old('mcustomername')}}" name="mcustomername" class="form-control forminput" placeholder="Nama Pelanggan" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Pelanggan"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="control-label"><b>Email</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomeremail" value="{{old('mcustomeremail')}}" name="mcustomeremail" class="form-control forminput" placeholder="Email" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label"><b>Telepon Kantor</b> (<font color="red">*</font>) &nbsp  :</label>
									<div  class="">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomerphone" value="{{old('mcustomerphone')}}" name="mcustomerphone" class="form-control forminput" placeholder="Telepon Kantor" type="number" required @if (Session::has('autofocus')) autofocus @endif >
											
											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Telepon Kantor"></label>
											
										<div style="height: 5px;">
										<h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
										</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label"><b>Fax Kantor</b> (<font color="red">*</font>) &nbsp  :</label>
									<div  class="">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomerfax" value="{{old('mcustomerfax')}}" name="mcustomerfax" class="form-control forminput" placeholder="Fax Kantor" type="number" required @if (Session::has('autofocus')) autofocus @endif >
											
											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Fax Kantor"></label>
											
										<div style="height: 5px;">
										<h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
										</div>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="control-label"><b>Website</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomerwebsite" value="{{old('mcustomerwebsite')}}" name="mcustomerwebsite" class="form-control forminput" placeholder="Website" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Website"></label>
										</div>
									</div>
								</div></div>
								</br>
								</br>
    

        </div>
        </div>


{{-- PEMISAH --}}

<div class="col-md-6">
    <div class="tab-content">
        <div class="tab-pane active" id="info-tab">
    
    <div style="height: 85px;" class="form-group">
	&nbsp &nbsp &nbsp<label class="control-label"><b>Alamat Penagihan</b> (<font color="red">*</font>) &nbsp  :</label>
								</br>
								</br>
								<div class="col-lg-12">
										<div class="icon-addon addon-md">
											<textarea id="insert-mcustomeraddress" value="{{old('mcustomeraddress')}}" name="mcustomeraddress" class="form-control forminput" rows="5" placeholder="Jalan" type="text" required @if (Session::has('autofocus')) autofocus @endif ></textarea>

											<label for="mgoodsgroup1" class="glyphicon glyphicon-road" rel="tooltip" title="Jalan"></label>
										</div>
									</div>
								</div>
				<div style="" class="form-group col-lg-6">
				<input id="insert-mcustomercity" value="{{old('mcustomercity')}}" name="mcustomercity" class="form-control forminput" placeholder="Kota" type="text" required @if (Session::has('autofocus')) autofocus @endif >
				</div>
				
				<div style="padding-left: 21px; height: 21px;" class="form-group col-lg-6">				
				<input id="insert-mcustomerzipcode" value="{{old('mcustomerzipcode')}}" name="mcustomerzipcode" class="form-control forminput" placeholder="K.Pos" type="text" required @if (Session::has('autofocus')) autofocus @endif >			
				</div>
								<div style="height: 68px;" class="form-group">
									<div  class="col-lg-12">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomerprovince" value="{{old('mcustomerprovince')}}" name="mcustomerprovince" class="form-control forminput" placeholder="Provinsi " type="text" required @if (Session::has('autofocus')) autofocus @endif >
											
											<label for="mgoodsgroup1" class="glyphicon glyphicon-star" rel="tooltip" title="Propinsi"></label>
											
							
										</div>
									</div>
								</div>
	
								<div class="form-group">
									<div  class="col-lg-12">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomercountry" value="{{old('mcustomercountry')}}" name="mcustomercountry" class="form-control forminput" placeholder="Negara" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											
											<label for="mgoodsgroup1" class="glyphicon glyphicon-star" rel="tooltip" title="Negara"></label>
											
							
										</div>
									</div>
								</div>

					<center>
      				 <button type="submit" name="button" class="btn btn-primary">CREATE</button>
      				<a id="btn-insert-reset" onclick="resetcustomer()" class="btn btn-default" ><i class=""></i> Reset</a>
      				</center>
								</div></div>
								</br>
								</br>
     
        </div>
        </div>
				        
</form>
</row>

    </br>
  

    <div id="menu2" class="tab-pane fade">
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="menu3" class="tab-pane fade">
     <form id="teste" class="form-horizontal" action="{{URL::to('/')}}/admin-nano/tambahcabang" method="post">
      <div style="height: 21px;" class="form-group">
				
									<label class="col-md-2 control-label"><b>Nama Lengkap</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-4">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomercontactname" value="{{old('mcustomercontactname')}}" name="mcustomercontactname" class="form-control forminput" placeholder="Nama Lengkap" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Lengkap"></label>
										</div>
									</div>
								</div>
									<div style="height: 21px;" class="form-group">
									<label class="col-md-2 control-label"><b>Posisi Jabatan</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-4">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomercontactposition" value="{{old('mcustomercontactposition')}}" name="mcustomercontactposition" class="form-control forminput" placeholder="Posisi Jabatan" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon glyphicon-user" rel="tooltip" title="Posisi Jabatan"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-2 control-label"><b>Email</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-4">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomercontactemail" value="{{old('mcustomercontactemail')}}" name="mcustomercontactemail" class="form-control forminput" placeholder="Email" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-envelope" rel="tooltip" title="Email"></label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label"><b>Handphone</b> (<font color="red">*</font>) &nbsp  :</label>
									<div  class="col-md-4">
										<div class="icon-addon addon-md">
											<input id="insert-mcustomercontactemailphone" value="{{old('mcustomercontactemailphone')}}" name="mcustomercontactemailphone" class="form-control forminput" placeholder="Handphone" type="number" required @if (Session::has('autofocus')) autofocus @endif >
											
											<label for="mgoodsgroup1" class="glyphicon glyphicon-phone-alt" rel="tooltip" title="Handphone"></label>
											
										<div style="height: 5px;">
										<h5 style="font-size: 11px; margin-top: 36px;">&nbsp Example: 0542123456</h5>
										</div>
										</div>
									</div>
								</div>

  </form>
    </br>
  </br>
  </br>
  </br>
  </br>
    <center>
       <button type="submit" name="button" class="btn btn-primary">CREATE</button>
      <a id="btn-insert-reset" onclick="resetcustomer()" class="btn btn-default" ><i class=""></i> Reset</a>
       </center>
  </div>

	<div id="menu4" class="tab-pane fade">
      <h3>Menu 4</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>

	<div id="menu5" class="tab-pane fade">
      <h3>Menu 5</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div> 

    <div id="menu6" class="tab-pane fade">
      <h3>Menu 6</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>

    <div id="menu7" class="tab-pane fade">
      <h3>Menu 7</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>

    <div id="menu8" class="tab-pane fade">
      <h3>Menu 8</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
  </div>

  </br>



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


		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
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
											<input type="text" class="form-control" placeholder="Filter Kode Cabang" />
										</th>
										<th class="hasinput" style="width:9%">
											<input type="text" class="form-control" placeholder="Filter Nama Cabang" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Alamat" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Telepon" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Kota" />
										</th>

										<th class="hasinput" style="width:15%">

										</th>
									</tr>
									<tr>
										<th data-hide="no"><center>No</center></th>
										<th data-hide="mbranchcode"><center>Kode Cabang</center></th>
										<th data-hide="mbranchname"><center>Nama Cabang</center></th>
										<th data-hide="address"><center>Alamat</center></th>
										<th data-hide="phone"><center>Telepon</center></th>
										<th data-hide="city"><center>Kota</center></th>
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
			 dom: "<'dtpadding' <'row' <'clmn' C> <'srch' f> <'tablerow' l> <'clear'> <'masterbutton' B> r> <'row pb' tip>>",
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
