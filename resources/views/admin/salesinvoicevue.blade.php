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
							<!-- <h3 style="font-weight: bold; color: #1883B8;font-size: 19px;">Mode : INSERT</h3> -->
							<!-- widget content -->
							<div class="widget-body no-padding">
							    <div class="container">
										<invoice></invoice>
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
<div id="insert_detail_modal" class="modal" style="top: 15%;" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="text-align: center">
        <h4>Detail Barang</h4>
			</div>
      <div class="modal-body">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#insertdetailmenu1">Detail Barang</a></li>
          <li><a data-toggle="tab" href="#insertdetailmenu2">Keterangan</a></li>
        </ul>
        <div class="tab-content">
          <div id="insertdetailmenu1" class="tab-pane fade in active">
            <div class="form form-horizontal" style="margin-top:10px;">
              <div class="form-group">
                <label class="control-label col-md-2">Nama barang</label>
                <div class="col-md-8">
                  <input class="form-control forminput" disabled type="text" id="insertdetailgoodsname"/>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-2">Kuantitas</label>
                <div class="col-md-4">
                  <input placeholder="Kuantitas" class="form-control forminput" value="1" type="text" id="insertdetailgoodsqty"/>
                </div>
                <div class="col-md-4">
                  <select class="select2" id="insertdetailgoodsunit">
                    <option>Unit</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-2">Harga Satuan</label>
                <div class="col-md-8">
                  <input class="form-control pricelabel" disabled type="text" id="insertdetailgoodsprice"/>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-2">Diskon</label>
                <div class="col-md-4">
                  <div class="input-group">
                    <input id="insert-detailgoodsdisc" class="form-control forminput" placeholder="Persentase" type="text">
                    <span class="input-group-addon" id="sizing-addon2" style="font-size:8px;">%</span>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <span class="input-group-addon" id="sizing-addon2" style="font-size:8px;">Rp</span>
                    <input id="insert-detailgoodsdiscrp" class="form-control forminput pricelabel" placeholder="Rupiah" type="text">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-2">Total Harga</label>
                <div class="col-md-8">
                  <input class="form-control pricelabel" disabled type="text" id="insertdetailgoodstotal"/>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-2">Pajak</label>
                <div class="col-md-8">
                  <select class="form-control select2" id="insertdetailgoodstax">
                    @foreach($taxes as $t)
                      @if($t->mtaxtdesc == 'Kosong')
                        <option value="{{ $t->id }}">&nbsp;</option>
                      @else
                        <option value="{{ $t->id }}">{{ $t->mtaxtdesc }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-2">Gudang</label>
                <div class="col-md-8">
                  <select class="form-control select2" id="insertdetailgoodswhouse">
                    @foreach($whouses as $t)
                      <option value="{{ $t->id }}">{{ $t->mwarehousename }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div id="insertdetailmenu2" class="tab-pane">
            <div class="form form-horizontal" style="margin-top:10px;">
              <div class="form-group">
                <label class="control-label col-md-2">Keterangan</label>
                <div class="col-md-8">
                  <textarea class="form-control" placeholder="Keterangan"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
			</div>
      <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
				      Cancel
				</button>
				<button type="button" class="btn btn-primary" onclick="insert_add_item()">
				      Lanjut
				</button>
			</div>
		</div>
	</div>
</div>
@stop

@section('js')
<script src="{{ url('/js/numeral.min.js') }}"></script>
<script src="{{ url('/js/salesinvoice.js') }}"></script>
<script src="{{ url('/js/bootstrap-datepicker.min.js') }}"></script>
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
        "aoColumnDefs": [{ "bVisible": false, "aTargets": [6,7,8,9,10,11,12,13] }],
        buttons: [ {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13]
            }
        },
        {
            text: 'CSV',
            action: function(){
              window.location.href = "{{ url('/admin-nano/memployee/export/csv') }}"
            }
        },
        {
            text: 'Excel',
            action: function(){
              window.location.href = "{{ url('/admin-nano/memployee/export/excel') }}"
            }
        },
        {
            text: 'PDF',
            action: function(){
              window.location.href = "{{ url('/admin-nano/memployee/export/pdf') }}"
            }
        },
        {
            extend: 'print',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13] //setting kolom mana yg mau di print
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
                ajax: '{{URL::to('/')}}/admin-api/memployee',
                columns: [
                {data: 'action', name:'action', searchable: false, orderable: false},
                {data: 'no', no: 'no' },
                {data: 'memployeeid', memployeeid: 'memployeeid'},
                {data: 'memployeename', memployeename: 'memployeename'},
								{data: 'memployeeposition', memployeeposition: 'memployeeposition'},
								{data: 'level', level: 'level'},
								{data: 'memployeephone', memployeephone: 'memployeephone'},
								{data: 'memployeehomephone', memployeehomephone: 'memployeehomephone'},
								{data: 'memployeebbmpin', memployeebbmpin: 'memployeebbmpin'},
								{data: 'memployeeidcard', memployeeidcard: 'memployeeidcard'},
								{data: 'memployeecity', memployeecity: 'memployeecity'},
								{data: 'memployeezipcode', memployeezipcode: 'memployeezipcode'},
								{data: 'memployeeprovince', memployeeprovince: 'memployeeprovince'},
								{data: 'memployeecountry', memployeecountry: 'memployeecountry'},
								{data: 'memployeeinfo', memployeeinfo: 'memployeeinfo'},
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
        closeOnCancel: false
      },
      function(isconfirm){
        if (isconfirm) {
          $.ajax({
            type: "DELETE",
            url: API_URL+"/memployee/"+id,
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
