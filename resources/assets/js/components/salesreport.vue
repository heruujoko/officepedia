<template>
    <div>
        <br>
        <div class="row">
            <p class="col-md-1 report-label">Mulai</p>
            <input v-dpicker v-model="invoice_date_start" type="text" class="small-date form-control" />
        </div>
        <br>
        <div class="row">
            <p class="col-md-1 report-label">Selesai</p>
            <input v-dpicker v-model="invoice_date_end" type="text" class="small-date form-control" />
        </div>
        <br>
        <div class="row">
            <p class="col-md-1 report-label">Gudang</p>
            <select v-selecttwo class="col-md-2" v-model="selected_warehouse">
                <option value="">Semua</option>
                <option v-for="wh in warehouses" :value="wh.id">{{ wh.mwarehousename }}</option>
            </select>
        </div>
        <div class="row">
            <p class="col-md-1 report-label">Barang</p>
            <select v-selecttwo v-model="selected_goods" class="col-md-2">
                <option value="">Semua</option>
                <option v-for="good in goods" :value="good.mgoodscode">{{ good.mgoodsname }}</option>
            </select>
        </div>
        <div class="row">
            <p class="col-md-1 report-label">Sort By</p>
            <select v-selecttwo v-model="selected_sorts" class="col-md-2">
                <option v-for="sort in sorts" :value="sort.id">{{ sort.label }}</option>
            </select>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <button class="dt-button pull-left" v-on:click="fetchSales">Filter</button>
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
                <h4 class="text-center">{{ compname }}</h4>
                <h4 class="text-center">Laporan Buku Penjualan</h4>
                <h4 class="text-center">Periode {{ invoice_date_start}} - {{ invoice_date_end }}</h4>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <p>Gudang : {{ label_warehouse }}</p>
                <p>Barang : {{ label_goods }}</p>
            </div>
            <div class="pull-right" style="padding-right:20px;">
                <p>User : {{ username }}</p>
                <p>Tgl Cetak : {{ print_date }}</p>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered" id="tableapi">
                    <thead>
                        <tr>
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
                            <td>
                                <span>
                                    <input type="checkbox" :checked="expand_all"/>
                                </span>
                                <span style="float: right">
                                    {{ sale.mhinvoicedate }}
                                </span>
                            </td>
                            <td>{{ sale.numoftrans }}</td>
                            <td style="text-align:right" v-priceformatlabel="num_format" >{{ sale.mhinvoicesubtotal_sum }}</td>
                            <td style="text-align:right" v-priceformatlabel="num_format">0</td>
                            <td style="text-align:right" v-priceformatlabel="num_format" >{{ sale.mhinvoicediscounttotal_sum }}</td>
                            <td style="text-align:right" v-priceformatlabel="num_format" >{{ sale.mhinvoicesubtotal_sum }}</td>
                            <td style="text-align:right" v-priceformatlabel="num_format" >{{ sale.mhinvoicetaxtotal_sum }}</td>
                            <td style="text-align:right" v-priceformatlabel="num_format" >{{ sale.mhinvoicegrandtotal_sum }}</td>
                            <td style="text-align:right" v-priceformatlabel="num_format">0</td>
                            <td style="text-align:right" v-priceformatlabel="num_format" >{{ sale.mhinvoicegrandtotal_sum }}</td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th>TOTAL</th>
                            <th>{{ invoice_count_total }}</th>
                            <th style="text-align:right" v-priceformatlabel="num_format" >{{ sales_total }}</th>
                            <th style="text-align:right" v-priceformatlabel="num_format" >{{ free_total }}</th>
                            <th style="text-align:right" v-priceformatlabel="num_format" >{{ discount_total }}</th>
                            <th style="text-align:right" v-priceformatlabel="num_format" >{{ sales_total }}</th>
                            <th style="text-align:right" v-priceformatlabel="num_format" >{{ tax_total }}</th>
                            <th style="text-align:right" v-priceformatlabel="num_format" >{{ sales_total + tax_total - discount_total }}</th>
                            <th style="text-align:right" v-priceformatlabel="num_format" >0</th>
                            <th style="text-align:right" v-priceformatlabel="num_format" >{{ sales_total + tax_total - discount_total }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <br>
    </div>
</template>
<script>
    import Axios from 'axios'
    import _ from 'lodash'
    import moment from 'moment'
    import numeral from 'numeral'

    export default {
        props: ['username'],
        data(){
            return {
                expand_all: true,
                print_date: moment().format('L'),
                compname: "",
                num_format: "0,0.00",
                selected_goods:"",
                selected_warehouse:"",
                selected_sorts:"mhinvoicedate",
                invoice_date_start: moment().format('L'),
                invoice_date_end:moment().format('L'),
                sales: [],
                warehouses:[],
                goods:[],
                brands:[],
                types:[],
                sorts:[
                    { id: "mhinvoicedate", label: "Tanggal Invoice"},
                    { id: "mwarehouse", label: "Gudang"},
                    { id: "mbranch", label: "Cabang"},
                    { id: "retur", label: "Total Retur"},
                    { id: "mhinvoicecustomername", label: "Nama Customer"}
                ]
            }
        },
        computed:{
            label_warehouse(){
                let self = this;
                if(this.selected_warehouse != ""){
                    return _.find(this.warehouses,(wh) => {
                        return wh.id == self.selected_warehouse;
                    }).mwarehousename;
                } else {
                    return "Semua"
                }
            },
            label_goods(){
                let self = this;
                if(this.selected_goods != ""){
                    return _.find(this.goods,(wh) => {
                        return wh.mgoodscode == self.selected_goods;
                    }).mgoodsname;
                } else {
                    return "Semua"
                }
            },
            invoice_count_total(){
                return _.sumBy(this.sales, (iv) => {
                    return iv.numoftrans;
                })
            },
            sales_total(){
                return _.sumBy(this.sales, (iv) => {
                    return iv.mhinvoicesubtotal_sum;
                })
            },
            free_total(){
                return 0;
            },
            discount_total(){
                return _.sumBy(this.sales, (iv) => {
                    return iv.mhinvoicediscounttotal_sum;
                })
            },
            tax_total(){
                return _.sumBy(this.sales, (iv) => {
                    return iv.mhinvoicetaxtotal_sum;
                })
            }
        },
        computed:{
            label_warehouse(){
                let self = this;
                if(this.selected_warehouse != ""){
                    return _.find(this.warehouses,(wh) => {
                        return wh.id == self.selected_warehouse;
                    }).mwarehousename;
                } else {
                    return "Semua"
                }
            },
            label_goods(){
                let self = this;
                if(this.selected_goods != ""){
                    return _.find(this.goods,(wh) => {
                        return wh.mgoodscode == self.selected_goods;
                    }).mgoodsname;
                } else {
                    return "Semua"
                }
            },
            invoice_count_total(){
                return _.sumBy(this.sales, (iv) => {
                    return iv.numoftrans;
                })
            },
            sales_total(){
                return _.sumBy(this.sales, (iv) => {
                    return iv.mhinvoicesubtotal_sum;
                })
            },
            free_total(){
                return 0;
            },
            discount_total(){
                return _.sumBy(this.sales, (iv) => {
                    return iv.mhinvoicediscounttotal_sum;
                })
            },
            tax_total(){
                return _.sumBy(this.sales, (iv) => {
                    return iv.mhinvoicetaxtotal_sum;
                })
            }
        },
        methods:{
            fetchConfig(){
                var self = this;
                Axios.get('/admin-api/mconfig')
                    .then(function(res){
                        let separator = res.data.msysnumseparator
                        let decimals = res.data.msysgenrounddec
                        console.log(separator +" "+decimals);
                        if(separator == ',' && decimals == 2){
                            self.num_format = "0,0.00"
                        } else if(separator == ',' && decimals == 0){
                            self.num_format = "0,0"
                        } else if(separator == '.' && decimals == 2){
                            self.num_format = "0.0,00"
                        } else {
                            self.num_format = "0.0"
                        }
                        this.compname = res.data.msyscompname;
                    })
                    .catch(function(err){
                        console.log(err);
                    });
            },
            fetchSales(){
                $('#loading_modal').modal('toggle');
                var self = this;
                Axios.get('/admin-api/salesreport?wh='+this.selected_warehouse+'&goods='+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end)
                    .then(function(res){
                        console.log(res.data);
                        self.sales = res.data;
                        $('#loading_modal').modal('toggle');
                    })
                    .catch(function(err){
                        console.log(err);
                        $('#loading_modal').modal('toggle');
                    });
            },
            fetchWarehouses(){
                var self = this;
                Axios.get('/admin-api/mwarehouse/datalist')
                .then(function(res){
                    console.log(res.data);
                    self.warehouses = res.data;
                })
                .catch(function(err){
                    console.log(err);
                });
            },
            fetchGoods(){
                var self = this;
                Axios.get('/admin-api/barang/datalist')
                .then(function(res){
                    console.log(res.data);
                    self.goods = res.data;
                })
                .catch(function(err){
                    console.log(err);
                });
            },
            sortData(){
                var self = this;
                this.sales = _.sortBy(this.sales,function(sl){
                    return sl[self.selected_sorts];
                });
            },
            printTable(){
                window.open('/admin-nano/reports/salesreport/export/print?wh='+this.selected_warehouse+'&goods='+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
            },
            pdfTable(){
                window.open('/admin-nano/reports/salesreport/export/pdf?wh='+this.selected_warehouse+'&goods='+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
            },
            excelTable(){
                window.open('/admin-nano/reports/salesreport/export/excel?wh='+this.selected_warehouse+'&goods='+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
            },
            csvTable(){
                window.open('/admin-nano/reports/salesreport/export/csv?wh='+this.selected_warehouse+'&goods='+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
            }
        },
        created(){
            this.fetchConfig();
            this.fetchSales();
            this.fetchWarehouses();
            this.fetchGoods();
        }
    }
</script>
