<template>
    <div>
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
        <div class="row">
            <p class="col-md-1 report-label">Expand All</p>
            <input type="checkbox" v-model="expand_all"/>
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
                            <th width="7%">Tgl Transaksi</th>
                            <th>Kode Customer</th>
                            <th>Customer</th>
                            <th>Jumlah Invoice</th>
                            <th>No Invoice</th>
                            <th>Kode Barang</th>
                            <th width="7%">Nama Barang</th>
                            <th>Quantity</th>
                            <th>Harga Satuan</th>
                            <th>Free Goods</th>
                            <th>Discount</th>
                            <th>Subtotal</th>
                            <th>PPN</th>
                            <th>Total</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(sale,index) in sales">
                            <td>
                                <span v-if="sale.header == true">
                                    <input type="checkbox" :checked="sale.expanded" @click="expander(index,sale)"/>
                                </span>
                                <span style="float: right" v-if="sale.header == true">
                                    {{ sale.mhinvoicedate }}
                                </span>
                            </td>
                            <td><span v-if="!sale.header">{{ sale.mdcustomerid }}<span></td>
                            <td><span v-if="!sale.header">{{ sale.mdcustomername }}<span></td>
                            <td><span v-if="sale.header">{{ sale.numoftrans }}</span></td>
                            <td><span v-if="!sale.header">{{ sale.mhinvoiceno }}<span></td>
                            <td><span v-if="!sale.header">{{ sale.mdinvoicegoodsid }}<span></td>
                            <td><span v-if="!sale.header">{{ sale.mdinvoicegoodsname }}<span></td>
                            <td><span v-if="!sale.header">{{ sale.mdinvoicegoodsqty }}<span></td>
                            <td style="text-align:right"><span v-if="!sale.header" v-priceformatlabel="num_format">{{ sale.mdinvoicegoodsprice }}<span></td>
                            <td></td>
                            <td style="text-align:right"><span v-if="!sale.header" v-priceformatlabel="num_format">{{ sale.mdinvoicegoodsdiscount }}<span></td>
                            <td style="text-align:right" v-priceformatlabel="num_format" >{{ sale.mhinvoicesubtotal_sum }}</td>
                            <td style="text-align:right" v-priceformatlabel="num_format" >{{ sale.mhinvoicetaxtotal_sum }}</td>
                            <td style="text-align:right" v-priceformatlabel="num_format" >{{ sale.mhinvoicegrandtotal_sum }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="3">Saldo</th>
                            <th>{{ invoice_count_total }}</th>
                            <th colspan="7">{{ sales_total }}</th>
                            <th style="text-align:right" v-priceformatlabel="num_format" >{{ sales_total }}</th>
                            <th style="text-align:right" v-priceformatlabel="num_format" >{{ tax_total }}</th>
                            <th style="text-align:right" v-priceformatlabel="num_format" >{{ sales_total + tax_total - discount_total }}</th>
                            <th></th>
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
    import base64 from 'base-64'

    export default {
        props: ['username'],
        data(){
            return {
                expand_all: false,
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
                let sum = 0;
                for(let i=0;i<this.sales.length;i++){
                    if(this.sales[i].header == true){
                        sum += this.sales[i].numoftrans;
                    }
                }
                return sum;
            },
            sales_total(){
                return _.sumBy(this.sales, (iv) => {
                    if(iv.header == true){
                        return iv.mhinvoicesubtotal_sum;
                    }
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
                    if(iv.header == true){
                        return iv.mhinvoicetaxtotal_sum;
                    }
                })
            }
        },
        methods:{
            expander(index,item){
                if(!item.expanded){
                    $('#loading_modal').modal('toggle');
                    Axios.get('/admin-api/salesreport/detail/'+item.mhinvoicedate)
                    .then( res => {
                        item.expanded = true;
                        item.expand_length = res.data.length;
                        for(let i=1;i<=res.data.length;i++){
                            console.log(res.data[i-1]);
                            this.sales.splice(index+i,0,res.data[i-1]);
                        }
                        $('#loading_modal').modal('toggle');
                    })
                    .catch(err => {

                    })
                } else {
                    this.sales.splice(index+1,item.expand_length);
                    item.expanded = false;
                    item.expand_length = 0;
                }
            },
            expandAll(){
                for(let i=0;i<this.sales.length;i++){
                    console.log('expand');
                    if(this.sales[i].header == true){
                        this.expander(i,this.sales[i]);
                    }
                }
            },
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
                        self.compname = res.data.msyscompname;
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
                        for(let i=0;i<res.data.length;i++){
                            res.data[i].expanded = false;
                        }
                        self.sales = res.data;
                        if(self.expand_all == true){
                            self.expandAll()
                        }
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
                // window.open('/admin-nano/reports/salesreport/export/print?wh='+this.selected_warehouse+'&goods='+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
                let data = base64.encode(JSON.stringify(this.sales));
                window.open('/admin-nano/reports/salesreport/export/print?wh='+this.selected_warehouse+'&goods='+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&data='+data);
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
