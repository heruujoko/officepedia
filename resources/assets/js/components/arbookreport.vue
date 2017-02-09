<template>
    <div>
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
                <h4 class="text-center">Laporan Buku Piutang</h4>
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
                            <th>Tanggal Pelunasan</th>
                            <th>No Invoice</th>
                            <th>Tgl Invoice</th>
                            <th>Tgl Jatuh Tempo</th>
                            <th>Nilai Invoice</th>
                            <th>Nilai Bayar</th>
                            <th>Outstanding</th>
                            <th>Aging</th>
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
                            <td><span v-if="ar.header">{{ ar.marcardcustomername }}<span></td>
                            <td><span v-if="ar.data">{{ ar.marcarddate }}<span></td>
                            <td><span v-if="ar.data">{{ ar.marcardtransno }}<span></td>
                            <td><span v-if="ar.data">{{ ar.inv_date }}<span></td>
                            <td><span v-if="ar.data">{{ ar.marcardduedate }}<span></td>
                            <td style="text-align:right"><span v-if="ar.footer == false" v-priceformatlabel="num_format">{{ ar.marcardtotalinv }}</span></td>
                            <td style="text-align:right"><span v-if="ar.footer == false" v-priceformatlabel="num_format">{{ ar.marcardpayamount }}</span></td>
                            <td style="text-align:right"><span v-if="ar.footer == false" v-priceformatlabel="num_format">{{ ar.marcardoutstanding }}</span></td>
                            <td><span v-if="ar.data">{{ ar.aging }}<span></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="6">TOTAL</th>
                            <th style="text-align:right" v-priceformatlabel="num_format">{{ total_inv }}</th>
                            <th style="text-align:right" v-priceformatlabel="num_format">{{ total_pay }}</th>
                            <th style="text-align:right" v-priceformatlabel="num_format">{{ total_outs }}</th>
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
    import base64 from 'base-64'

    export default {
        props: ['username'],
        data(){
            return {
                selected_customer: "",
                customers: [],
                selected_sort: "",
                sorts: [],
                expand_all: false,
                compname: "",
                print_date: moment().format('L'),
                ars: [],
                num_format:"0,0"
            }
        },
        computed: {
            label_branch(){
                return "Semua"
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
            total_inv(){
                return _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return ar.marcardtotalinv;
                    }
                });
            },
            total_pay(){
                return _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return ar.marcardpayamount;
                    }
                });
            },
            total_outs(){
                return _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return ar.marcardoutstanding;
                    }
                });
            }
        },
        methods: {
            expander(ar,index){
                if(!ar.checked){
                    $("#loading_modal").modal('toggle');
                    Axios.get('/admin-api/arbook/details/'+ar.marcardcustomerid)
                    .then( res => {
                        ar.checked = true;
                        ar.expand_length = res.data.length;
                        for(let i=1;i<=res.data.length;i++){
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
            expandAll: async function(){
                for(let i=0;i<this.ars.length;i++){
                    if(this.ars[i].header == true){
                        try{

                            let res = await Axios.get('/admin-api/arbook/details/'+this.ars[i].marcardcustomerid)
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
            fetchArs(){
                $('#loading_modal').modal('toggle');
                let self = this;
                Axios.get('/admin-api/arbook?customer='+this.selected_customer)
                .then(res => {

                    for(let i=0;i<res.data.length;i++){
                        res.data[i].checked = false;
                    }

                    self.ars = res.data;

                    if(this.expand_all == true){
                        this.expandAll();
                    }

                    $('#loading_modal').modal('toggle');
                })
                .catch(err => {
                    $('#loading_modal').modal('toggle');
                })
            },
            printTable(){
                let data = base64.encode(JSON.stringify(this.ars));
                window.open('/admin-nano/reports/arbook/export/print?customer='+this.label_customer+"&br="+this.label_branch+"&data="+data,'_blank');
            },
            pdfTable(){
                let data = base64.encode(JSON.stringify(this.ars));
                window.open('/admin-nano/reports/arbook/export/pdf?customer='+this.label_customer+"&br="+this.label_branch+"&data="+data,'_blank');
            },
            excelTable(){
                let data = base64.encode(JSON.stringify(this.ars));
                window.open('/admin-nano/reports/arbook/export/excel?customer='+this.label_customer+"&br="+this.label_branch+"&data="+data,'_blank');
            },
            csvTable(){
                let data = base64.encode(JSON.stringify(this.ars));
                window.open('/admin-nano/reports/arbook/export/csv?customer='+this.label_customer+"&br="+this.label_branch+"&data="+data,'_blank');
            }
        },
        created(){
            this.fetchConfig();
            this.fetchCustomers();
            this.fetchArs();
        }
    }
</script>
