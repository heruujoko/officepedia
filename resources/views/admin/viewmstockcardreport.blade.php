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
                                            <br>
                                            <div class="row">
                                                <p class="col-md-1 report-label">Periode Awal</p>
                                                <input v-dpicker v-model="invoice_date_start" type="text" class="small-date form-control" />
                                            </div>
                                            <br>
                                            <div class="row">
                                                <p class="col-md-1 report-label">Periode Akhir</p>
                                                <input v-dpicker v-model="invoice_date_end" type="text" class="small-date form-control" />
                                            </div>
                                            <br>
                                                <div class="row">
                                                <p class="col-md-1 report-label">Gudang</p>
                                                <select v-selecttwo class="col-md-4" v-model="mstockcardwhouse">
                          					                <option value="">Semua</option>
                                                    <option v-for="warehouse in warehouses" :value="warehouse.id">@{{warehouse.mwarehousename}}</option>
                                                   </select>
                                            </div>
                                              <div class="row">
                                                <p class="col-md-1 report-label">Kode Barang</p>
                                                <select v-selecttwo class="col-md-4" v-model="mstockcardgoodsid">
                                                    <option value="">Semua</option>
                          						               <option v-for="good in goods" :value="good.mgoodscode">@{{good.mgoodscode}} @{{good.mgoodsname}}</option>
                                                    </select>
                                            </div>
                                            <br>
                                           <div class="row">
                                               <div class="col-md-3">
                                                   <button class="dt-button pull-left" v-on:click="fetchStocks">Filter</button>
                                               </div>
                                                <div class="col-md-3 col-md-offset-9">
                                                    <button class="dt-button pull-right" v-on:click="printTable">Print</button>
                                                    <button class="dt-button pull-right" v-on:click="pdfTable">PDF</button>
                                                    <button class="dt-button pull-right" v-on:click="excelTable">Excel</button>
                                                    <button class="dt-button pull-right" v-on:click="csvTable">CSV</button>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <br>
                                                    <h4 class="text-center">{{ $config->msyscompname }}</h4>
                                                    <h4 class="text-center">Laporan Stock Card Report</h4>
                                                     <h4 class="text-center">Periode @{{ invoice_date_start }} - @{{ invoice_date_end }}</h4>

                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Gudang : @{{ label_warehouse }}</p>
                                                    <p>Barang : @{{ label_goods }}</p>
                                                </div>
                                                <div class="pull-right" style="padding-right:20px;">
                                                    <p>User : {{ Auth::user()->name }}</p>
                                                    <p>Tgl Cetak : {{ Carbon\Carbon::now() }}</p>
                                                </div>
                                            </div>
                                            <br>
							<div class="row">
							 <div class="col-md-12">
							<table class="table table-bordered" id="tableapi">
							<thead>
								<tr>
									<th>Kode Barang</th>
									<th>Nama Barang</th>
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
									<td v-if="stock.footer == false"><span v-if="stock.data == false">@{{ stock.mstockcardgoodsid }}</span></td>
                                    <td v-if="stock.footer == false"><span v-if="stock.data == false">@{{ stock.mstockcardgoodsname }}</span></td>
                                    <td v-if="stock.footer == false"><span v-if="stock.data == true">@{{ stock.verbs }}</span></td>
                                    <td v-if="stock.footer == false"><span v-if="stock.data == true" v-numberformatlabel>@{{ stock.mstockcardstockin }}</span></td>
                                    <td v-if="stock.footer == false"><span v-if="stock.data == true" v-numberformatlabel>@{{ stock.mstockcardstockout }}</span></td>
                                    <td v-if="stock.footer == false"><span v-if="stock.data == true" v-numberformatlabel>@{{ (stock.mstockcardstocktotal) }}</span></td>
                                    <td v-if="stock.footer == false"><span v-if="stock.data == true">@{{ stock.mstockcarddate }}</span></td>
                                    <td v-if="stock.footer == false"><span v-if="stock.data == true">@{{ stock.mstockcardtranstype }}</span></td>
                                    <td v-if="stock.footer == false"><span v-if="stock.data == true">@{{ stock.mstockcardtransno }}</span></td>
                                    <td v-if="stock.footer == false"><span v-if="stock.data == true">@{{ stock.gudang }}</span></td>
                                    <td v-if="stock.footer == false"><span v-if="stock.data == true">@{{ stock.cabang }}</span></td>
                                    <td v-if="stock.footer == false">@{{ stock.mstockcardremark }}</td>
                                    <!--  footer -->
                                    <th v-if="stock.footer == true" class="tbl-footer" colspan="2">Saldo</th>
                                    <th v-if="stock.footer == true" class="tbl-footer">@{{ stock.verbs }}</th>
                                    <th v-if="stock.footer == true" class="tbl-footer" v-numberformatlabel>@{{ stock.mstockcardstockin }}</th>
                                    <th v-if="stock.footer == true" class="tbl-footer" v-numberformatlabel>@{{ stock.mstockcardstockout }}</th>
                                    <th v-if="stock.footer == true" class="tbl-footer" v-numberformatlabel>@{{ (stock.mstockcardstocktotal) }}</th>
                                    <th v-if="stock.footer == true" class="tbl-footer" colspan="6"></th>
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
@section('js')
<script src="{{ url('/js/stockcardreport.js') }}"></script>
<script>
    function refreshWarehouses(){
        stockcardreport.$emit('update-warehouses');
    }
</script>
@stop
@section('css')
    <style>
        .text-center {
            text-align: center;
        }
        .report-label {
            font-size: 14px;
            margin-top: 5px;
        }
        #tableapi {
          border: 1px solid #ddd !important;
      }
        .small-date{
            width: 195px;
            font-size: 11px;
        }
        .tbl-footer {
            background-image: -webkit-linear-gradient(top,#f2f2f2 0,#fafafa 100%);
        }
    </style>
@stop
