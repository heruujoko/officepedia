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
                                            <br>
                                            <div class="row">
                                                <p class="col-md-1 report-label">Per</p>
                                                <input v-dpicker v-model="invoice_date_end" type="text" class="small-date form-control" />
                                            </div>
                                            <br>
                                            <div class="row">
                                                <p class="col-md-1 report-label">Cabang</p>
                                                <select v-selecttwo class="col-md-2" v-model="selected_branch">
                                                    <option value="">Semua</option>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <p class="col-md-1 report-label">Customer</p>
                                                <select v-selecttwo class="col-md-2" v-model="selected_customer">
                                                    <option value="">Semua</option>
                                                    <option v-for="c in customers" :value="c.mcustomerid">@{{ c.mcustomername }}</option>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <p class="col-md-1 report-label">Sort By</p>
                                                <select v-selecttwo class="col-md-2" v-model="selected_sort">
                                                    <option value="">Semua</option>
                                                    <option v-for="s in sorts" :value="s.id">@{{ s.label }}</option>
                                                </select>
                                            </div>
                                            <br>
                                            <div class="row">
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
                                                    <h4 class="text-center">Laporan Piutang</h4>
                                                    <h4 class="text-center">Per @{{ invoice_date_end }}</h4>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Cabang : @{{ label_branch }}</p>
                                                    <p>Customer : @{{ label_customer }}</p>
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
                                                                <th>Kode Customer</th>
                                                                <th>Nama Customer</th>
                                                                <th>No Invoice</th>
                                                                <th>Tgl Invoice</th>
                                                                <th>Tgl Jatuh Tempo</th>
                                                                <th>Nilai Nota</th>
                                                                <th>Outstanding</th>
                                                                <th>Aging</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="ar in ars">
                                                                <td>@{{ ar.customerid }}</td>
                                                                <td>@{{ ar.customername }}</td>
                                                                <td>@{{ ar.marcardtransno }}</td>
                                                                <td>@{{ ar.marcarddate }}</td>
                                                                <td>@{{ ar.marcardduedate }}</td>
                                                                <td style="text-align:right">@{{ ar.outstanding_prc }}</td>
                                                                <td style="text-align:right">@{{ ar.outstanding_prc }}</td>
                                                                <td>@{{ ar.aging }}</td>
                                                            </tr>
                                                        </tbody>
                                                        <thead>
                                                            <tr>
                                                                <th colspan="2">TOTAL</th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th style="text-align:right" v-priceformatlabel="num_format" >@{{ outstanding_total }}</th>
                                                                <th style="text-align:right" v-priceformatlabel="num_format" >@{{ outstanding_total }}</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
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
    <script src="{{ url('/js/arcustreport.js') }}"></script>
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
    </style>
@stop
