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
                <li>Home</li><li>Laporan</li><li>{{ $section }}</li>
            </ol>
        </div>
        <!-- END RIBBON -->
        <!-- MAIN CONTENT -->
        <div id="content">
            <div class="row">
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                    <h1 class="page-title txt-color-blueDark">
                        <i class="fa fa-table fa-fw "></i>
                        Laporan
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
                                {{--<h3 style="font-weight: bold; color: #1883B8;font-size: 19px;">Mode : INSERT</h3>--}}
                                <!-- widget content -->
                                <div class="widget-body no-padding">
                                    <div class="container">
                                        <div id="report">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <br>
                                                    <h4 class="text-center">PT Officepedia Solusi Indonesia</h4>
                                                    <h4 class="text-center">Laporan Buku Penjualan</h4>
                                                    <h4 class="text-center">Periode 1 November - 30 November</h4>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <p class="col-md-1 report-label">Gudang</p>
                                                <select v-selecttwo class="col-md-2" v-model="selected_warehouse">
                                                    <option value="">Semua</option>
                                                    <option v-for="wh in warehouses" :value="wh.id">@{{ wh.mwarehousename }}</option>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <p class="col-md-1 report-label">Barang</p>
                                                <select v-selecttwo v-model="selected_goods" class="col-md-2">
                                                    <option value="">Semua</option>
                                                    <option v-for="good in goods" :value="good.mgoodscode">@{{ good.mgoodsname }}</option>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <p class="col-md-1 report-label">Sort By</p>
                                                <select v-selecttwo v-model="selected_sorts" class="col-md-2">
                                                    <option v-for="sort in sorts" :value="sort.id">@{{ sort.label }}</option>
                                                </select>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-3 col-md-offset-9">
                                                    <button class="dt-button pull-right" v-on:click="printTable">Print</button>
                                                    <button class="dt-button pull-right">CSV</button>
                                                    <button class="dt-button pull-right">Excel</button>
                                                    <button class="dt-button pull-right">PDF</button>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-bordered" id="tableapi">
                                                        <thead>
                                                            <tr>
                                                                <th>Customer</th>
                                                                <th>Tgl Invoice</th>
                                                                <th>Jumlah Invoice</th>
                                                                <th>Penjualan</th>
                                                                <th>Bonus Barang</th>
                                                                <th>Discount</th>
                                                                <th>Subtotal</th>
                                                                <th>PPN</th>
                                                                <th>Total</th>
                                                                <th>Retur</th>
                                                                <th>Total - Retur</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="sale in sales">
                                                                <td>@{{ sale.mhinvoicecustomername }}</td>
                                                                <td>@{{ sale.mhinvoicedate }}</td>
                                                                <td>@{{ sale.detail_count }}</td>
                                                                <td style="text-align:right" v-priceformatlabel="num_format" >@{{ sale.mhinvoicesubtotal + sale.mhinvoicediscounttotal }}</td>
                                                                <td style="text-align:right" v-priceformatlabel="num_format">0</td>
                                                                <td style="text-align:right" v-priceformatlabel="num_format" >@{{ sale.mhinvoicediscounttotal }}</td>
                                                                <td style="text-align:right" v-priceformatlabel="num_format" >@{{ sale.mhinvoicesubtotal }}</td>
                                                                <td style="text-align:right" v-priceformatlabel="num_format" >@{{ sale.mhinvoicetaxtotal }}</td>
                                                                <td style="text-align:right" v-priceformatlabel="num_format" >@{{ sale.mhinvoicegrandtotal }}</td>
                                                                <td style="text-align:right">0</td>
                                                                <td style="text-align:right" v-priceformatlabel="num_format" >@{{ sale.mhinvoicegrandtotal }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <br>
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
    <script src="{{ url('/js/salesreport.js') }}"></script>
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
    </style>
@stop
