<template>
    <div>
        <br>
        <div class="row">
            <p class="col-md-1 report-label">Per Posisi</p>
            <input v-dpicker v-model="invoice_date_end" type="text" class="small-date form-control" />
        </div>
        <br>
        <div class="row">
            <p class="col-md-1 report-label">Customer</p>
            <select v-selecttwo class="col-md-2" v-model="selected_customer">
                <option value="">Semua</option>
                <option v-for="c in customers" :value="c.mcustomerid">{{ c.mcustomername }}</option>
            </select>
        </div>
        <div class="row">
            <p class="col-md-1 report-label">Sort By</p>
            <select v-selecttwo class="col-md-2" v-model="selected_sort">
                <option value="">Semua</option>
                <option v-for="s in sorts" :value="s.id">{{ s.label }}</option>
            </select>
        </div>
        <br>
        <div class="row">
            <p class="col-md-1 report-label">Expand All</p>
            <input type="checkbox" v-model="expand_all"/>
        </div>
        <div class="row">
            <div class="col-md-3">
                <button class="dt-button pull-left" v-on:click="fetchArs">Filter</button>
            </div>
            <div class="col-md-3 col-md-offset-6">
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
                <h4 class="text-center">Laporan Piutang</h4>
                <h4 class="text-center">Per Posisi {{ invoice_date_end }}</h4>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <p>Cabang : {{ label_branch }}</p>
                <p>Customer : {{ label_customer }}</p>
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
                            <th>Kode Customer</th>
                            <th>Nama Customer</th>
                            <th>Total Nota</th>
                            <th>No Invoice</th>
                            <th>Nilai Invoice</th>
                            <th>Outstanding</th>
                            <th>Tgl Invoice</th>
                            <th>Tgl Jatuh Tempo</th>
                            <th>Aging</th>
                            <th>1 - 7 Hari</th>
                            <th>7 - 14 Hari</th>
                            <th>14 - 21 Hari</th>
                            <th>21 - 30 Hari</th>
                            <th>> 1 Bulan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(ar,index) in ars" v-bind:class="{ foot: ar.footer }">
                            <td>
                                <span v-if="ar.header == true">
                                    <input type="checkbox" :checked="ar.checked" style="margin-top: -5px" @click="expander(ar,index)"/>
                                    <span class="pull-right" v-if="ar.header == true">{{ ar.marcardcustomerid }}</span>
                                </span>
                            </td>
                            <td><span v-if="ar.header == true">{{ ar.marcardcustomername }}</span></td>
                            <td><span v-if="ar.header == true">{{ ar.numoftrans }}</span></td>
                            <td><span v-if="ar.data == true">{{ ar.marcardtransno }}</span></td>
                            <td v-if="ar.footer == false" style="text-align: right" v-priceformatlabel="num_format">{{ ar.marcardtotalinv }}</td>
                            <td v-if="ar.footer == true"></td>
                            <td v-if="ar.footer == false" style="text-align: right" v-priceformatlabel="num_format">{{ ar.marcardoutstanding }}</td>
                            <td v-if="ar.footer == true"></td>
                            <td><span v-if="ar.data == true">{{ ar.marcarddate }}</span></td>
                            <td><span v-if="ar.data == true">{{ ar.marcardduedate }}</span></td>
                            <td><span v-if="ar.data == true">{{ ar.aging }}</span></td>
                            <td v-if="ar.footer == false" style="text-align: right" v-priceformatlabel="num_format">{{ ar['1w'] }}</td><td v-if="ar.footer == true"></td>
                            <td v-if="ar.footer == false" style="text-align: right" v-priceformatlabel="num_format">{{ ar['2w'] }}</td><td v-if="ar.footer == true"></td>
                            <td v-if="ar.footer == false" style="text-align: right" v-priceformatlabel="num_format">{{ ar['3w'] }}</td><td v-if="ar.footer == true"></td>
                            <td v-if="ar.footer == false" style="text-align: right" v-priceformatlabel="num_format">{{ ar['4w'] }}</td><td v-if="ar.footer == true"></td>
                            <td v-if="ar.footer == false" style="text-align: right" v-priceformatlabel="num_format">{{ ar['1m'] }}</td><td v-if="ar.footer == true"></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="2">TOTAL</th>
                            <th></th>
                            <th></th>
                            <th style="text-align: right" v-priceformatlabel="num_format">{{ invoice_total }}</th>
                            <th style="text-align: right" v-priceformatlabel="num_format">{{ outstanding_total }}</th>
                            <th colspan="2"></th>
                            <th></th>
                            <th style="text-align: right" v-priceformatlabel="num_format">{{ one_w_total }}</th>
                            <th style="text-align: right" v-priceformatlabel="num_format">{{ two_w_total }}</th>
                            <th style="text-align: right" v-priceformatlabel="num_format">{{ three_w_total }}</th>
                            <th style="text-align: right" v-priceformatlabel="num_format">{{ four_w_total }}</th>
                            <th style="text-align: right" v-priceformatlabel="num_format">{{ one_m_total }}</th>
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
    import base64 from 'base-64'

    export default {
        props: ['username'],
        data(){
            return {
                expand_all: false,
                print_date: moment().format('L'),
                compname: "",
                branches:[],
                customers:[],
                ars:[],
                num_format:"0,0.00",
                selected_branch:"",
                selected_customer:"",
                invoice_date_start: moment().format('L'),
                invoice_date_end: moment().format('L'),
                sorts:[
                    { id: "marcarddate", label: "Tanggal Invoice"}
                ],
                selected_sort:"marcarddate"
            }
        },
        computed:{
            expand_headers(){
                let exp = [];
                this.ars.map(item => {
                    if(item.header == true){
                        if(item.checked == true){
                            exp.push(item.id);
                        }
                    }
                });
                return exp;
            },
            label_branch(){
                let self = this;
                if(this.selected_branch != ""){
                    return _.find(this.branches,(wh) => {
                        return wh.id == self.selected_branch;
                    }).mbranchname;
                } else {
                    return "Semua"
                }
            },
            label_customer(){
                let self = this;
                if(this.selected_customer != ""){
                    return _.find(this.customers,(wh) => {
                        return wh.mcustomerid == self.selected_customer;
                    }).mcustomername;
                } else {
                    return "Semua"
                }
            },
            outstanding_total(){
                return _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return ar.marcardoutstanding;
                    }
                });
            },
            invoice_total(){
                return _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return ar.marcardtotalinv;
                    }
                });
            },
            one_w_total(){
                return _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return ar['1w'];
                    }
                });
            },
            two_w_total(){
                return _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return ar['2w'];
                    }
                });
            },
            three_w_total(){
                return _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return ar['3w'];
                    }
                });
            },
            four_w_total(){
                return _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return ar['4w'];
                    }
                });
            },
            one_m_total(){
                return _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return ar['1m'];
                    }
                });
            }
        },
        methods:{
            expander(ar,index){
                console.log('chk',ar.checked);
                if(!ar.checked){
                    $("#loading_modal").modal('toggle');
                    Axios.get('/admin-api/arcustreport/details/'+ar.marcardcustomerid+"?end="+this.invoice_date_end)
                    .then( res => {
                        ar.checked = true;
                        ar.expand_length = res.data.length;
                        for(let i=1;i<=res.data.length;i++){
                            console.log(res.data[i-1]);
                            this.ars.splice(index+i,0,res.data[i-1]);
                        }
                        $("#loading_modal").modal('toggle');
                    })
                    .catch( err => {
                        $("#loading_modal").modal('toggle');
                    })
                } else {
                    this.ars.splice(index+1,ar.expand_length);
                    ar.checked = false;
                    ar.expand_length = 0;
                }
            },
            expandAll: async function (){
                for(let i=0;i<this.ars.length;i++){
                    if(this.ars[i].header == true){
                        try {
                            let res = await Axios.get('/admin-api/arcustreport/details/'+this.ars[i].marcardcustomerid+"?end="+this.invoice_date_end)
                            this.ars[i].checked = true;
                            this.ars[i].expand_length = res.data.length;
                            for(let j=1;j<=res.data.length;j++){
                                console.log(res.data[j-1]);
                                this.ars.splice(i+j,0,res.data[j-1]);
                            }
                        } catch(err){
                            console.log(err);
                        }
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
                        self.compname = res.data.msyscompname
                    })
                    .catch(function(err){
                        console.log(err);
                    });
            },
            fetchArs(){
                $('#loading_modal').modal('toggle');
                var self = this;
                Axios.get('/admin-api/arcustreport?br='+this.selected_branch+'&cust='+this.selected_customer+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end)
                .then(function(res){
                    $('#loading_modal').modal('toggle');
                    for(let i=0;i<res.data.length;i++){
                        res.data[i].checked = false;
                        res.data[i].expand_length = 0;
                    }
                    self.ars = res.data;
                    if(self.expand_all == true){
                        self.expandAll()
                    }
                })
                .catch(function(err){
                    $('#loading_modal').modal('toggle');
                    console.log(err);
                });
            },
            fetchCustomers(){
                var self = this;
                Axios.get('/admin-api/pelanggan/datalist')
                .then(function(res){
                    self.customers = res.data;
                })
                .catch(function(err){
                    console.log(err);
                });
            },
            sortData(){
                var self = this;
                this.ars = _.sortBy(this.ars,function(sl){
                    return sl[self.selected_sort];
                });
            },
            printTable(){
                let data = base64.encode(JSON.stringify(this.expand_headers));
                window.open('/admin-nano/reports/arcustreport/export/print?start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&cust='+this.selected_customer+'&br='+this.selected_branch+"&data="+data,'_blank');
            },
            pdfTable(){
                let data = base64.encode(JSON.stringify(this.expand_headers));
                window.open('/admin-nano/reports/arcustreport/export/pdf?start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&cust='+this.selected_customer+'&br='+this.selected_branch+"&data="+data,'_blank');
            },
            excelTable(){
                let data = base64.encode(JSON.stringify(this.expand_headers));
                window.open('/admin-nano/reports/arcustreport/export/excel?start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&cust='+this.selected_customer+'&br='+this.selected_branch+"&data="+data,'_blank');
            },
            csvTable(){
                let data = base64.encode(JSON.stringify(this.expand_headers));
                window.open('/admin-nano/reports/arcustreport/export/csv?start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&cust='+this.selected_customer+'&br='+this.selected_branch+"&data="+data,'_blank');
            }
        },
        watch:{
            selected_sort(){
                this.sortData();
            }
        },
        created(){
            this.fetchConfig();
            this.fetchArs();
            this.fetchCustomers();
        }
    }
</script>
