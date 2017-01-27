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
	</div>

	<section id="widget-grid" class="">
		<!-- row -->
		<!-- row -->
        @if(Auth::user()->has_role('C_user'))
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
							<div id="insert-wrapper" class="form-horizontal" data-parsley-validate>
								{{ csrf_field() }}
								<div class="container">
								</br>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama User</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-musername" value="{{old('musername')}}" name="musername" class="form-control forminput" placeholder="Nama User" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Kategori"></label>
										</div>
									</div>
								</div>
                                <div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Email User</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-museremail" value="{{old('musername')}}" name="museremail" class="form-control forminput" placeholder="Email User" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Kategori"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Password</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="insert-muserpass" value="{{old('muserpass')}}" name="muserpass" class="form-control forminput" placeholder="Password" type="password" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Kategori"></label>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label"><b>Kategori User</b> &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                                            <select id="insert-musercategory" name="musercategory" class="select2">
                                                @foreach($roles as $r)
                                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                                @endforeach
                                            </select>
										</div>
									</div>
								</div>
                                <div class="form-group">
									<label class="col-md-3 control-label"><b>Akses Cabang</b> &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                                            <select multiple id="insert-muserbranches" name="musercategory" class="select2">
                                                @foreach($branches as $br)
                                                    <option value="{{ $br->id }}">{{ $br->mbranchname }}</option>
                                                @endforeach
                                            </select>
										</div>
									</div>
								</div>
								<input type="hidden" name="void" value="0">
								<center>
									<div class="row">
										<div class="col-md-12">
											<a id="btn-insert-reset" onclick="resetmuser()" class="btn btn-default" ><i class=""></i> Reset</a>
											<button class="btn btn-primary" onclick="insertmuser()"><i class="fa fa-save"></i> Simpan</button>
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
        @endif
		<!-- end widget -->
		<div class="row">
			<!-- NEW WIDGET START -->
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div id="formedit" style="display: none;" class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
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
                                <input type="hidden" id="mfixedassetsid">
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Nama User</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="edit-musername" value="{{old('musername')}}" name="musername" class="form-control forminput" placeholder="Nama User" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Kategori"></label>
										</div>
									</div>
								</div>
                                <div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Email User</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="edit-museremail" value="{{old('musername')}}" name="museremail" class="form-control forminput" placeholder="Email User" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Kategori"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Password</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input id="edit-muserpass" value="{{old('muserpass')}}" name="muserpass" class="form-control forminput" placeholder="Biarkan kosong untuk tidak merubah password" type="password" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama Kategori"></label>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label"><b>Kategori User</b> &nbsp  :</label>
									<div class="col-md-7">
                                        <select id="edit-musercategory" name="musercategory" class="select2">
                                            @foreach($roles as $r)
                                                <option value="{{ $r->id }}">{{ $r->name }}</option>
                                            @endforeach
                                        </select>
									</div>
								</div>
                                <div class="form-group">
									<label class="col-md-3 control-label"><b>Akses Cabang</b> &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
                                            <select multiple id="edit-muserbranches" name="musercategory" class="select2">
                                                @foreach($branches as $br)
                                                    <option value="{{ $br->id }}">{{ $br->mbranchname }}</option>
                                                @endforeach
                                            </select>
										</div>
									</div>
								</div>
								<input type="hidden" name="void" value="0">
								<center>
									<div class="row">
										<div class="col-md-12">
											<a onclick="backmuser()" title="" class="btn btn-default">Batal</a>
											<button onclick="updatemuser()" class="btn btn-primary" type="submit">
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
							<div id="formview" style="display: none;" class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
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
									<label class="col-md-3 control-label"><b>Nama User</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="view-musername" value="{{old('musername')}}" name="musername" class="form-control forminput" placeholder="Nama Kategori" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Nama User"></label>
										</div>
									</div>
								</div>
								<div style="height: 21px;" class="form-group">
									<label class="col-md-3 control-label"><b>Password</b> (<font color="red">*</font>) &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="view-muserpass" value="{{old('muserpass')}}" name="muserpass" class="form-control forminput" placeholder="Nama Kategori" type="text" required data-parsley-required-message="Field Ini Tidak Boleh Kosong" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-info-sign" rel="tooltip" title="Password"></label>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label"><b>Kategori User</b> &nbsp  :</label>
									<div class="col-md-7">
										<div class="icon-addon addon-md">
											<input disabled id="view-musercategory" value="{{old('musercategory')}}" name="musercategory" class="form-control forminput" placeholder="Kategori User" type="text" @if (Session::has('autofocus')) autofocus @endif >
											<label for="mgoodsgroup1" class="glyphicon glyphicon-search" rel="tooltip" title="Keterangan"></label>
										</div>
									</div>
								</div>
								<center>
									<div class="row">
										<div class="col-md-12">
											</br>
											<button onclick="backmuser()" class="btn btn-default" type="submit">
												<i class=""></i> Kembali
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
											<input type="text" class="form-control" placeholder="Filter Nama User" />
										</th>
                    <th class="hasinput" style="width:9%">
											<input type="text" class="form-control" placeholder="Filter Email" />
										</th>
										<th class="hasinput" style="width:9%">
											<input type="text" class="form-control" placeholder="Filter Kategori User" />
										</th>
									</tr>
									<tr>
										<th data-hide="action"><center>Aksi</center></th>
                    <th data-hide="no"><center>No</center></th>
                    <th data-hide="musername"><center>Nama User</center></th>
										<th data-hide="muserpass"><center>Email</center></th>
										<th data-hide="musercategory"><center>Kategori User</center></th>
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
                  			      dom: "<'dtpadding' <'row' <'clmn' > <'srch' f> <'tablerow' l> <'clear'> <'masterbutton' B> r> <'row pb' tip>>",
                                  "autoWidth" : true,
                                  "oLanguage": {
                                    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
																		"sLengthMenu": "Show _MENU_ Entries",
																		"sInfo": "Showing ( _START_ to _END_ ) to _TOTAL_ Entries"
                                  },
                              buttons: [ {
                                    extend: 'copyHtml5',
                                    exportOptions: {
                                        columns: [ 1,2,3,4]
                                    }
                                  },
                                  {
                                      text: 'CSV',
                                      action: function(){
																				window.location.href = "{{ url('admin-nano/muser/export/csv') }}";
																			}
                                  },
                                  {
																			text: 'Excel',
																			action: function(){
																				window.location.href = "{{ url('admin-nano/muser/export/excel') }}";
																			}
                                  },
                                  {
																			text: 'PDF',
																			action: function(){
																				window.location.href = "{{ url('admin-nano/muser/export/pdf') }}";
																			}
                                  },
                                  {
                                      extend: 'print',
                                      exportOptions: {
                                          columns: [ 1, 2, 3,4] //setting kolom mana yg mau di export
                                      }

                                  },
																  {
																	  extend: 'colvis',
																	  text: 'Show / Hide Columns',
																	  columns: ':gt(1)'
																  }
                              ],
					       				      processing: false,
										          serverSide: false,
										          ajax: '{{URL::to('/')}}/admin-api/muser',
          										columns: [
                              {data: 'action', name:'action', searchable: false, orderable: false},
                              {data: 'no', no: 'no' },
                              {data: 'musername', musername: 'musername'},
                              {data: 'museremail', museremail: 'museremail'},
							  {data: 'musercategory', musercategory: 'musercategory'}
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
                        url: API_URL+"/muser/"+id,
                        success: function(response){
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
@section('js')
<script src="{{ url('/master/muser.js') }}"></script>
@stop
