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
			<li>Home</li><li>Master</li><li>{{ $section }}</li>
		</ol>
		<!-- end breadcrumb -->
</div>
<!-- END RIBBON -->
<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
	<h1 class="page-title txt-color-blueDark">
		<i class="fa fa-table fa-fw "></i>
		{{ $section }}
		<span>
			{{ $section }}
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
					<header>
						<span class="widget-icon"> <i class="fa fa-table"></i> </span>
						<h2>Tambah {{ $section }}</h2>
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
							<div id="insert-wrapper-gp" class="form-horizontal" data-parsley-validate>
								{{ csrf_field() }}
								<div class="container">
								</br>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Kode Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-mcoagrandparentcode" value="{{old('mbranchcode')}}" name="mcoagrandparentcode" class="form-control forminput" placeholder="Kode Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="Kode Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-mcoagrandparentname" value="{{old('mbranchname')}}" name="mcoagrandparentname" class="form-control forminput" placeholder="Nama Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Tipe Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                      <select id="insert-mcoagrandparenttype" value="{{old('address')}}" name="mcoagrandparenttype" class="form-control forminput" placeholder="Tipe Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif>
                        <option value="K">Kredit</option>
                        <option value="D">Debet</option>
                      </select>
											<!-- <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Tipe Grand Parent"></label> -->
										</div>
									</div>
								</div>
								<input type="hidden" name="void" value="0">
								<center>
									<div class="row">
										<div class="col-md-12">
											<a id="btn-insert-reset" onclick="resetgrandparent()" class="btn btn-default" ><i class=""></i> Reset</a>
											<button class="btn btn-primary" onclick="insertgrandparent()"><i class="fa fa-save"></i> Simpan</button>
										</div>
									</div>
								</center>
							</br>
						</div>
					</div>
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
					<header>
						<span class="widget-icon"> <i class="fa fa-table"></i> </span>
						<h2>Pengubahan {{ $section }}</h2>
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
						<div id="edit-wrapper" class="form-horizontal" data-parsley-validate>
							<div class="container">
								<style>
									.alert-info {
										color: #D9ECF5;
										background-color: #48AFE3;
										border-color: #2F9ACF;
									}
								</style>
                <input type="hidden" id="mcoagrandparentid">
                <div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Kode Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="edit-mcoagrandparentcode" value="{{old('mbranchcode')}}" name="mcoagrandparentcode" class="form-control forminput" placeholder="Kode Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="Kode Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="edit-mcoagrandparentname" value="{{old('mbranchname')}}" name="mcoagrandparentname" class="form-control forminput" placeholder="Nama Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Tipe Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                      <select id="edit-mcoagrandparenttype" value="{{old('address')}}" name="mcoagrandparenttype" class="form-control forminput" placeholder="Tipe Grand Parent" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif>
                        <option value="K">Kredit</option>
                        <option value="D">Debet</option>
                      </select>
											<!-- <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Tipe Grand Parent"></label> -->
										</div>
									</div>
								</div>
								<input type="hidden" name="void" value="0">
								<center>
									<div class="row">
										<div class="col-md-12">
											<a onclick="backgrandparent()" title="" class="btn btn-default">Batal</a>
											<button onclick="updategrandparent()" class="btn btn-primary" type="submit">
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
					      <header>
						      <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                  <h2>View {{ $section }} </h2>
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
									<label class="col-md-3 control-label"><b>Kode Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcoagrandparentcode" value="{{old('mbranchcode')}}" name="mcoagrandparentcode" class="form-control forminput" placeholder="Kode Grand Parent" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-barcode" rel="tooltip" title="Kode Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="view-mcoagrandparentname" value="{{old('mbranchname')}}" name="mcoagrandparentname" class="form-control forminput" placeholder="Nama Grand Parent" type="text" required @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Nama Grand Parent"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Tipe Grand Parent</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                      <select disabled id="view-mcoagrandparenttype" value="{{old('address')}}" name="mcoagrandparenttype" class="form-control forminput" placeholder="Tipe Grand Parent" type="text" required @if (Session::has('autofocus')) autofocus @endif>
                        <option value="K">Kredit</option>
                        <option value="D">Debet</option>
                      </select>
											<!-- <label for="mgoodsgroup1" class="glyphicon glyphicon-chevron-right" rel="tooltip" title="Tipe Grand Parent"></label> -->
										</div>
									</div>
								</div>
								<center>
									<div class="row">
										<div class="col-md-12">
											</br>
											<button onclick="backgrandparent()" class="btn btn-default" type="submit">
												<i class="fa fa-save"></i> Kembali
                      </button>
										</div>
									</center>
									</br>
								</div>
							</div>
						</div>
					</div>
					<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<section id="widget-grid" class="">
							<!-- row -->
							<div class="row">
								<!-- NEW WIDGET START -->
								<!-- Widget ID (each widget will need unique ID)-->
								<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-table"></i> </span>
						<h2>Master {{ $section }} </h2>
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
                    <th class="hasinput" style="width:10%">

										</th>
										<th class="hasinput" style="width:5%">
											<input type="text" class="form-control" placeholder="Filter No" />
										</th>
										<th class="hasinput" style="width:9%">
											<input type="text" class="form-control" placeholder="Filter Kode MCOAGrandParent" />
										</th>
										<th class="hasinput" style="width:9%">
											<input type="text" class="form-control" placeholder="Filter Nama MCOAGrandParent" />
										</th>
										<th class="hasinput" style="width:10%">
											<input type="text" class="form-control" placeholder="Filter Kode MCOAGrandParent" />
										</th>
									</tr>
									<tr>
										<th data-hide="action"><center>Aksi</center></th>
                    <th data-hide="no"><center>No</center></th>
										<th data-hide="mcoagrandparentcode"><center>Kode MCOAGrandParent</center></th>
										<th data-hide="mcoagrandparentname"><center>Nama MCOAGrandParent</center></th>
										<th data-hide="mcoagrandparenttype"><center>Tipe MCOAGrandParent</center></th>
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
                                        columns: [ 1,2]
                                    }
                                  },
                                  {
                                      extend: 'csvFlash',
                                      exportOptions: {
                                          columns: [ 1, 2, 3, 4] //setting kolom mana yg mau di export
                                      }
                                  },
                                  {
                                      extend: 'excelFlash',
                                      exportOptions: {
                                          columns: [ 1, 2, 3, 4] //setting kolom mana yg mau di export
                                      }
                                  },
                                  {
                                      extend: 'pdfFlash',
                                      exportOptions: {
                                          columns: [ 1, 2, 3, 4] //setting kolom mana yg mau di export
                                      }
                                  },
                                  {
                                      extend: 'print',
                                      exportOptions: {
                                          columns: [ 1, 2, 3, 4] //setting kolom mana yg mau di export
                                      }

                                  }
                              ],
					       				      processing: false,
										          serverSide: false,
										          ajax: '{{URL::to('/')}}/admin-api/mcoagrandparent',
          										columns: [
                              {data: 'action', name:'action', searchable: false, orderable: false},
                              {data: 'no', no: 'no' },
          										{data: 'mcoagrandparentcode', mcoagrandparentcode: 'mcoagrandparentcode'},
          										{data: 'mcoagrandparentname', mcoagrandparentname: 'mcoagrandparentname'},
          										{data: 'type', type: 'type'},
          										]
									       });

  					        $(".table thead th input[type=text]").on( 'keyup change', function () {
  		    		            table
  		                      .column( $(this).parent().index()+':visible' )
  		                      .search( this.value )
  		                      .draw();
  		    		      });
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
                        url: API_URL+"/mcoagrandparent/"+id,
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
