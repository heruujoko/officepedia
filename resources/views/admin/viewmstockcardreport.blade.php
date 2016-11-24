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
                                {{--<h3 style="font-weight: bold; color: #1883B8;font-size: 19px;">Mode : INSERT</h3>--}}
                                <!-- widget content -->
                                <div class="widget-body no-padding">
                                    <div class="container">
                                        <div id="stockcardreport">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <br>
                                                    <h4 class="text-center">PT Officepedia Solusi Indonesia</h4>
                                                    <h4 class="text-center">Laporan Stock Card Report</h4>
                                                    <h4 class="text-center">Periode 1 November - 30 November</h4>
                                                </div>
                                            </div>
                                            <br>
                                                <div class="row">
                                                <p class="col-md-1 report-label">Gudang</p>
                                                <select class="col-md-2">
                          					                <option value="">Semua</option>
                                                    <option v-for="warehouse in warehouses" :value="warehouse.mwarehousename">@{{warehouse.mwarehousename}}</option>
                                                   
                                                </select>
                                            </div>
                                              <div class="row">
                                                <p class="col-md-1 report-label">Kode Barang</p>
                                                <select class="col-md-2">
                                                    <option>Semua</option>
                          						               <option v-for="good in goods" value="good.mgoodscode">@{{good.mgoodscode}}</option>
                                                    
                                                </select>
                                            </div>
                                            <br>
                                           {{--  <div class="row">
                                                <div class="col-md-3 col-md-offset-9">
                                                    <button class="dt-button pull-right" v-on:click="printTable">Print</button>
                                                    <button class="dt-button pull-right" v-on:click="pdfTable">PDF</button>
                                                    <button class="dt-button pull-right" v-on:click="excelTable">Excel</button>
                                                    <button class="dt-button pull-right" v-on:click="csvTable">CSV</button>
                                                </div>
                                            </div> --}}
                                            <br>
							<div class="row">
							 <div class="col-md-12">
							<table class="table table-bordered">
							<thead>
								<tr>
									<th>Kode Barang</th>
									<th>Nama Barang</th>
									<th>QTY Stock</th>
									<th>Multi Satuan</th>
									<th>Masuk</th>
									<th>Keluar</th>
									<th>Saldo</th>
									<th>Tgl Trans</th>
									<th>Tipe Transaksi</th>
									<th>No Transaksi</th>
									<th>Gudang</th>
									<th>Cabang</th>
									<th>Keterangan</th>

								</tr>
								</thead>
								<tbody>
								<tr v-for="stock in stocks">
									<td>@{{ stock.mstockcardgoodsid }}</td>
									<td>@{{ stock.mstockcardgoodsname }}</td>
									<td>@{{ stock.mstockcarddate }}</td>
									<td>@{{ stock.mstockcardtranstype }}</td>
									<td>@{{ stock.mstockcardtransno }}</td>
									<td>@{{ stock.mstockcardremark }}</td>
									<td>@{{ stock.mstockcardstockin }}</td>
									<td>@{{ stock.mstockcardstockout }}</td>
									<td>@{{ stock.mstockcardstocktotal }}</td>
									<td>@{{ stock.mstockcardwhouse }}</td>
									<td>@{{ stock.mstockcarduserid }}</td>
									<td>@{{ stock.mstockcardusername }}</td>
									<td>@{{ stock.mstockcardeventdate }}</td>
								</tr>
								</tbody>
							</table>
							</div>
							</div>
							</div>
							@push('scripts')
							<tfoot>
						
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
                        url: API_URL+"/mcategorycustomer/"+id,
                        success: function(response){
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
@section('js')
<script src="{{ url('/js/stockcardreport.js') }}"></script>
@stop