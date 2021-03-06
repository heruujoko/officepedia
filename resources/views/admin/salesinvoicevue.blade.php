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
			<li>Home</li><li>Penjualan</li><li>{{ $section }}</li>
		</ol>
	</div>
	<!-- END RIBBON -->
	<!-- MAIN CONTENT -->
	<div id="content">
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark">
					<i class="fa fa-table fa-fw "></i>
						Lain-lain
					<span>
						{{ $section }}
					</span>
				</h1>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
			</div>
		</div>
		<!-- widget grid -->
		<section id="widget-grid" class="">
			<!-- row -->
            @if(Auth::user()->has_role('C_sales'))
			<div class="row">
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<!-- Widget ID (each widget will need unique ID)-->
					<div id="forminput" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2>{{ $section }}</h2>
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
										<invoice mode="insert"></invoice>
							    </div>
	 					  </div>
	 				  </div>
          </div>
        </article>
      </div>
      @endif
			<div class="row">
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<!-- Widget ID (each widget will need unique ID)-->
					<div id="formedit" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2>{{ $section }}</h2>
						</header>
						<!-- widget div-->
						<div>
					 		<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
							</div>
							<!-- end widget edit box -->
							<h3 style="font-weight: bold; color: #1883B8;font-size: 19px;">Mode : EDIT</h3>
							<!-- widget content -->
							<div class="widget-body no-padding">
							    <div class="container">
										<invoice mode="edit"></invoice>
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
					<div id="formview" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2>{{ $section }}</h2>
						</header>
						<!-- widget div-->
						<div>
					 		<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
							</div>
							<!-- end widget edit box -->
							<h3 style="font-weight: bold; color: #1883B8;font-size: 19px;">Mode : VIEW</h3>
							<!-- widget content -->
							<div class="widget-body no-padding">
							    <div class="container">
										<invoice mode="view"></invoice>
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
					<div id="formtable" class="forminput jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2>Master {{ $section }}</h2>
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
							    <div class="container" style="padding-top:40px;">
										<table id="tableapi" class="tableapi table table-bordered" width="100%">
											<thead>
												<tr>
			                    <th class="hasinput" style="width:10%">
													</th>
													<th class="hasinput" style="width:5%">
														<input type="text" class="form-control" placeholder="Filter No" />
													</th>
													<th class="hasinput" style="width:9%">
														<input type="text" class="form-control" placeholder="Filter Nomor Invoice" />
													</th>
			                    <th class="hasinput" style="width:9%">
														<input type="text" class="form-control" placeholder="Filter Customer" />
													</th>
													<th class="hasinput" style="width:9%">
														<input type="text" class="form-control" placeholder="Filter Tanggal" />
													</th>
													<th class="hasinput" style="width:9%">
														<input type="text" class="form-control" placeholder="Filter Jatuh Tempo" />
													</th>
													<th class="hasinput" style="width:9%">
														<input type="text" class="form-control" placeholder="Filter Subtotal" />
													</th>
													<th class="hasinput" style="width:9%">
														<input type="text" class="form-control" placeholder="Filter Pajak" />
													</th>
													<th class="hasinput" style="width:9%">
														<input type="text" class="form-control" placeholder="Filter Diskon" />
													</th>
													<th class="hasinput" style="width:9%">
														<input type="text" class="form-control" placeholder="Filter Total" />
													</th>
												</tr>
												<tr>
													<th data-hide="action"><center>Aksi</center></th>
			                    <th data-hide="no"><center>No</center></th>
			                    <th data-hide="mhinvoiceno"><center>Nomor Invoice</center></th>
													<th data-hide="mhinvoicecustomername"><center>Customer</center></th>
													<th data-hide="mhinvoicedate"><center>Tanggal</center></th>
													<th data-hide="mhinvoiceduedate"><center>Jatuh Tempo</center></th>
													<th data-hide="mhinvoicesubtotal"><center>Sub Total</center></th>
													<th data-hide="mhinvoicetaxtotal"><center>Pajak</center></th>
													<th data-hide="mhinvoicediscounttotal"><center>Diskon</center></th>
													<th data-hide="mhinvoicegrandtotal"><center>Total</center></th>
												</tr>
											</thead>
											<tbody>
											</tbody>
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
<!-- @push('scripts')	 -->
@section('js')
<script src="{{ url('/js/numeral.min.js') }}"></script>
<script src="{{ url('/js/salesinvoice.js') }}"></script>
<script src="{{ url('/js/bootstrap-datepicker.min.js') }}"></script>
<script>
	function editinvoice(id){
		$('#forminput').hide();
		$('#formview').hide();
		$('#formedit').show();
		window.location.href="#formedit";
		invoiceapp.$emit('edit-selected',id);
	}
	function viewinvoice(id){
		$('#forminput').hide();
		$('#formedit').hide();
		$('#formview').show();
		window.location.href="#formview";
		invoiceapp.$emit('edit-selected',id);
	}
  $(document).ready(function(){
    $('#disableforminput').prop('checked',true);
    $('#insert-mcustomerid').prop('disabled',true);
		$('#formedit').hide();
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
        "aoColumnDefs": [{ "bVisible": false, "aTargets": [5,6,7,8] }],
        buttons: [ {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9]
            }
        },
        {
            text: 'CSV',
            action: function(){
              window.location.href = "{{ url('/admin-nano/salesinvoice/export/csv') }}"
            }
        },
        {
            text: 'Excel',
            action: function(){
              window.location.href = "{{ url('/admin-nano/salesinvoice/export/excel') }}"
            }
        },
        {
            text: 'PDF',
            action: function(){
              window.location.href = "{{ url('/admin-nano/salesinvoice/export/pdf') }}"
            }
        },
        {
            extend: 'print',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9] //setting kolom mana yg mau di print
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
                ajax: '{{URL::to('/')}}/admin-api/salesinvoice',
                columns: [
                {data: 'action', name:'action', searchable: false, orderable: false},
                {data: 'no', no: 'no' },
								{data: 'mhinvoiceno', mhinvoiceno: 'mhinvoiceno' },
								{data: 'mhinvoicecustomername', mhinvoicecustomername: 'mhinvoicecustomername' },
								{data: 'mhinvoicedate', mhinvoicedate: 'mhinvoicedate' },
								{data: 'mhinvoiceduedate', mhinvoiceduedate: 'mhinvoiceduedate' },
								{data: 'subtotal', subtotal: 'subtotal' },
								{data: 'tax', tax: 'tax' },
								{data: 'disc', disc: 'disc' },
								{data: 'gtotal', gtotal: 'gtotal' }
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
    function popupdelete(id){
      swal({
        title: "Anda Yakin Akan Mengapus ?",
        text: "Anda Tidak Dapat Mengembalikan Data Ini!",
        type: "warning",   showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Iya, Hapus!",
        cancelButtonText: "Tidak, Batal!",
        closeOnConfirm: false,
        closeOnCancel: false,
        timer: 1500
      },
      function(isconfirm){
        if (isconfirm) {
          $.ajax({
            type: "DELETE",
            url: API_URL+"/salesinvoice/"+id,
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
                timer: 1500
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
  <link rel="stylesheet" href="{{ url('/css/bootstrap-datepicker3.min.css') }}">
  <style>
    .tableapi_wrapper {
      margin-top: 50px;
    }
		#tableapi {
			border: 1px solid #ddd !important;
		}
    .pricelabel {
      text-align: right;
    }
  </style>
@stop
