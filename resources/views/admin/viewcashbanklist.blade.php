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
			<li>Home</li><li>Kas Bank</li><li>{{ $section }}</li>
		</ol>
	</div>
	<!-- END RIBBON -->
	<!-- MAIN CONTENT -->
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa fa-table fa-fw "></i>
						Kas Bank
					<span>
						{{ $section }}
					</span>
				</h1>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
			</div>
		</div>

		<section id="widget-grid" class="">
			<!-- row -->
			<div class="row">
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<!-- Widget ID (each widget will need unique ID)-->
					<div id="forminput" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2> {{ $section }}</h2>
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
											<div id="insert-wrapper" class="tab-content">
												<div id="menu1" class="tab-pane fade in active">
													<div class="container">
														<div class="row">
															<div class="col-md-12" style="margin-top:30px">
																<table id="tableapi" class="tableapi table table-bordered" width="100%">
																	<thead>
																		<tr>
																			<th class="hasinput" style="width:5%">
																			</th>
																			<th class="hasinput" style="width:9%">
																				<input type="text" class="form-control" placeholder="Filter Akun" />
																			</th>
																			<th class="hasinput" style="width:9%">
																				<input type="text" class="form-control" placeholder="Filter Saldo" />
																			</th>
																		</tr>
																		<tr>
																				<th data-hide="action"><center>Aksi</center></th>
																				<th data-hide="mcoaname"><center>Nama Akun</center></th>
																				<th data-hide="rightsaldo"><center>Saldo</center></th>
																		</tr>
																	</thead>
																	<tbody>
																	</tbody>
																	<tfoot>
																		<tr>
																			<th colspan="2" style="text-align:center;">TOTAL</th>
																			<td style="text-align:right"><span id="totalcash">0</span></td>
																		</tr>
																	</tfoot>
																</table>
															</div>
														</div>
													<div>
												</div>
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

<div id="addkasmodal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Master Kas</h4>
      </div>
			<div id="modalkas-wrapper" data-parsley-validate>
	      <div class="modal-body" >
	        <label class="control-label">Nama Akun</label>
					<input type="text" class="form-control" id="insert-mcoaname" data-parsley-required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
	      </div>
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button onclick="insert_kas()" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="editkasmodal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Master Kas</h4>
      </div>
			<input type="hidden" id="mcoaid">
			<div id="editmodalkas-wrapper" data-parsley-validate>
	      <div class="modal-body" >
	        <label class="control-label">Nama Akun</label>
					<input type="text" class="form-control" id="edit-mcoaname" data-parsley-required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
	      </div>
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button onclick="update_kas()" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="addbankmodal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Master Bank</h4>
      </div>
			<div id="modalbank-wrapper" data-parsley-validate>
	      <div class="modal-body" >
	        <label class="control-label">Nama Akun</label>
					<input type="text" class="form-control" id="insert-mcoanamebank" data-parsley-required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
	      </div>
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button onclick="insert_bank()" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="editbankmodal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Master Bank</h4>
      </div>
			<input type="hidden" id="mcoaidbank">
			<div id="editmodalbank-wrapper" data-parsley-validate>
	      <div class="modal-body" >
	        <label class="control-label">Nama Akun</label>
					<input type="text" class="form-control" id="edit-mcoanamebank" data-parsley-required data-parsley-required-message="Field Ini Tidak Boleh Kosong">
	      </div>
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button onclick="update_bank()" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop

@section('js')
<script src="{{ url('master/cashbank.js') }}"></script>
<script>
var tablekas;
$(function(){
	tablekas = $('.tableapi').DataTable({
						dom: "<'dtpadding' <'row' <'clmn' > <'srch' f> <'tablerow' l> <'clear'> <'masterbutton' B> r> <'row pb' tip>>",
								"autoWidth" : true,
								"oLanguage": {
									"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
									"sLengthMenu": "Show _MENU_ Entries",
									"sInfo": "Showing ( _START_ to _END_ ) to _TOTAL_ Entries"
								},
						buttons: [
								{
										text: 'Tambah Master Kas',
										action: function(){
											add_master_kas();
										}
								},
								{
										text: 'Tambah Master Bank',
										action: function(){
											add_master_bank();
										}
								},
								{
									extend: 'copyHtml5',
									exportOptions: {
											columns: [ 2,3]
									}
								},
								{
										text: 'CSV',
										action: function(){
											window.location.href = "{{ url('admin-nano/cashbank/cash/export/csv') }}";
										}
								},
								{
										text: 'Excel',
										action: function(){
											window.location.href = "{{ url('admin-nano/cashbank/cash/export/excel') }}";
										}
								},
								{
										text: 'PDF',
										action: function(){
											window.location.href = "{{ url('admin-nano/cashbank/cash/export/pdf') }}";
										}
								},
								{
										extend: 'print',
										exportOptions: {
												columns: [ 1, 2, 3] //setting kolom mana yg mau di export
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
						ajax: '{{URL::to('/')}}/admin-api/cashbank/cash',
						columns: [
						{data: 'action', name:'action', searchable: false, orderable: false},
						{data: 'mcoaname', mcoaname: 'mcoaname'},
						{data: 'rightsaldo', rightsaldo: 'rightsaldo'}
						]
			 });

	$(".table thead th input[type=text]").on( 'keyup change', function () {
				tablekas
					.column( $(this).parent().index()+':visible' )
					.search( this.value )
					.draw();
		});
});

var tablebank;
$(function(){
	tablebank = $('#tablebank').DataTable({
						dom: "<'dtpadding' <'row' <'clmn' > <'srch' f> <'tablerow' l> <'clear'> <'masterbutton' B> r> <'row pb' tip>>",
								"autoWidth" : true,
								"oLanguage": {
									"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
									"sLengthMenu": "Show _MENU_ Entries",
									"sInfo": "Showing ( _START_ to _END_ ) to _TOTAL_ Entries"
								},
						buttons: [
								{
										text: 'Tambah Master Bank',
										action: function(){
											add_master_bank();
										}
								},
								{
									extend: 'copyHtml5',
									exportOptions: {
											columns: [ 2,3]
									}
								},
								{
										text: 'CSV',
										action: function(){
											window.location.href = "{{ url('admin-nano/cashbank/bank/export/csv') }}";
										}
								},
								{
										text: 'Excel',
										action: function(){
											window.location.href = "{{ url('admin-nano/cashbank/bank/export/excel') }}";
										}
								},
								{
										text: 'PDF',
										action: function(){
											window.location.href = "{{ url('admin-nano/cashbank/bank/export/pdf') }}";
										}
								},
								{
										extend: 'print',
										exportOptions: {
												columns: [ 1, 2, 3] //setting kolom mana yg mau di export
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
						ajax: '{{URL::to('/')}}/admin-api/cashbank/bank',
						columns: [
						{data: 'action', name:'action', searchable: false, orderable: false},
						{data: 'no', no: 'no' },
						{data: 'mcoaname', mcoaname: 'mcoaname'},
						{data: 'rightsaldo', rightsaldo: 'rightsaldo'}
						]
			 });

	$(".table thead th input[type=text]").on( 'keyup change', function () {
				tablebank
					.column( $(this).parent().index()+':visible' )
					.search( this.value )
					.draw();
		});
});

function refreshtbl(){
	tablekas.ajax.reload();
}

$(document).ready(function(){
	var columnBtn = "<span>Show / Hide columns</span>";
	$('.ColVis_MasterButton').html(columnBtn);
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
				url: API_URL+"/mcoa/"+id,
				success: function(response){
					tablekas.ajax.reload();
					tablebank.ajax.reload();
					refreshtotal();
					window.location = "#tableapi";
					swal({
						title: "Terhapus!",
						text: "Data Anda Berhasil Terhapus.",
						type: "success",
					});
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
@stop

@section('css')
  <style>
		#tableapi {
			border: 1px solid #ddd !important;
		}
		#tablebank {
			border: 1px solid #ddd !important;
		}
    .sorting_1 {
			text-align: left !important;
		}
		.modal {
		  text-align: center;
		  padding: 0!important;
		}

		.modal:before {
		  content: '';
		  display: inline-block;
		  height: 100%;
		  vertical-align: middle;
		  margin-right: -4px; /* Adjusts for spacing */
		}

		.modal-dialog {
		  display: inline-block;
		  text-align: left;
		  vertical-align: middle;
		}
  </style>
@stop
