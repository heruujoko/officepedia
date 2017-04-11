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
        <div class="row">
            <p class="col-md-1 report-label">Aged By</p>
            <select v-selecttwo class="col-md-2" v-model="invoice_aged_by">
                <option value="duedate">Tanggal Jatuh Tempo</option>
                <option value="invoice">Tanggal Invoice</option>
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
                            <th>Jatuh Tempo</th>
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
                            <td v-if="ar.footer == false" style="text-align: right" >{{ ar.marcardtotalinv }}</td>
                            <td v-if="ar.footer == true"></td>
                            <td v-if="ar.footer == false" style="text-align: right" >{{ ar.marcardoutstanding }}</td>
                            <td v-if="ar.footer == true"></td>
                            <td><span v-if="ar.data == true">{{ ar.marcarddate }}</span></td>
                            <td><span v-if="ar.data == true">{{ ar.marcardduedate }}</span></td>
                            <td><span v-if="ar.data == true">{{ ar.aging }}</span></td>
                            <td style="text-align: right"><span v-if="ar.footer == false"><span>{{ ar.has_due }}</span></span></td>
                            <td v-if="ar.footer == false" style="text-align: right" >{{ ar['1w'] }}</td><td v-if="ar.footer == true"></td>
                            <td v-if="ar.footer == false" style="text-align: right" >{{ ar['2w'] }}</td><td v-if="ar.footer == true"></td>
                            <td v-if="ar.footer == false" style="text-align: right" >{{ ar['3w'] }}</td><td v-if="ar.footer == true"></td>
                            <td v-if="ar.footer == false" style="text-align: right" >{{ ar['4w'] }}</td><td v-if="ar.footer == true"></td>
                            <td v-if="ar.footer == false" style="text-align: right" >{{ ar['1m'] }}</td><td v-if="ar.footer == true"></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="2">TOTAL</th>
                            <th></th>
                            <th></th>
                            <th style="text-align: right">{{ invoice_total }}</th>
                            <th style="text-align: right">{{ outstanding_total }}</th>
                            <th colspan="2"></th>
                            <th></th>
                            <th style="text-align: right">{{ has_due_total }}</th>
                            <th style="text-align: right">{{ one_w_total }}</th>
                            <th style="text-align: right">{{ two_w_total }}</th>
                            <th style="text-align: right">{{ three_w_total }}</th>
                            <th style="text-align: right">{{ four_w_total }}</th>
                            <th style="text-align: right">{{ one_m_total }}</th>
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
    import numeral from 'numeral'

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
                num_format:"0,0",
                selected_branch:"",
                selected_customer:"",
                invoice_date_start: moment().format('L'),
                invoice_date_end: moment().format('L'),
                invoice_aged_by: "duedate",
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
                let amount =  _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return numeral().unformat(ar.marcardoutstanding);
                    }
                });
                return numeral(amount).format(this.num_format);
            },
            invoice_total(){
                let amount = _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return numeral().unformat(ar.marcardtotalinv);
                    }
                });
                return numeral(amount).format(this.num_format);
            },
            one_w_total(){
                let amount = _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return numeral().unformat(ar['1w']);
                    }
                });
                return numeral(amount).format(this.num_format);
            },
            two_w_total(){
                let amount =  _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return numeral().unformat(ar['2w']);
                    }
                });
                return numeral(amount).format(this.num_format);
            },
            three_w_total(){
                let amount =  _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return numeral().unformat(ar['3w']);
                    }
                });
                return numeral(amount).format(this.num_format);
            },
            four_w_total(){
                let amount =  _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return numeral().unformat(ar['4w']);
                    }
                });
                return numeral(amount).format(this.num_format);
            },
            one_m_total(){
                let amount =  _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return numeral().unformat(ar['1m']);
                    }
                });
                return numeral(amount).format(this.num_format);
            },
            has_due_total(){
                let amount =  _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return numeral().unformat(ar.has_due);
                    }
                });
                return numeral(amount).format(this.num_format);
            }
        },
        methods:{
            expander(ar,index){
                console.log('chk',ar.checked);
                let rest_of_the_list = [];
                let tmp_ars = this.ars;
                for(let r=index+1;r<this.ars.length;r++){
                  rest_of_the_list.push(this.ars[r]);
                }
                this.ars = [];
                for(let l=0;l<=index;l++){
                  this.ars.push(tmp_ars[l]);
                }
                ar = this.ars[index];
                if(!ar.checked){
                    $("#loading_modal").modal('toggle');
                    Axios.get('/admin-api/arcustreport/details/'+ar.marcardcustomerid+"?end="+this.invoice_date_end+"&age="+this.invoice_aged_by)
                    .then( res => {
                        ar.checked = true;
                        ar.expand_length = res.data.length;
                        for(let i=0;i<res.data.length;i++){
                            res.data[i].marcardtotalinv = numeral(res.data[i].marcardtotalinv).format(self.num_format);
                            res.data[i].marcardoutstanding = numeral(res.data[i].marcardoutstanding).format(self.num_format);
                            res.data[i]['1w'] = numeral(res.data[i]['1w']).format(self.num_format);
                            res.data[i]['2w'] = numeral(res.data[i]['2w']).format(self.num_format);
                            res.data[i]['3w'] = numeral(res.data[i]['3w']).format(self.num_format);
                            res.data[i]['4w'] = numeral(res.data[i]['4w']).format(self.num_format);
                            res.data[i]['1m'] = numeral(res.data[i]['1m']).format(self.num_format);
                            res.data[i].has_due = numeral(res.data[i].has_due).format(self.num_format);
                            this.ars.push(res.data[i]);
                        }
                        for(let r=0;r<rest_of_the_list.length;r++){
                          this.ars.push(rest_of_the_list[r]);
                        }

                        $("#loading_modal").modal('toggle');
                    })
                    .catch( err => {
                        $("#loading_modal").modal('toggle');
                    })
                } else {
                    // this.ars.splice(index+1,ar.expand_length);
                    for(let r=0;r<rest_of_the_list.length;r++){
                        this.ars.push(rest_of_the_list[r]);
                    }
                    for(let off=0;off<ar.expand_length;off++){
                        this.$delete(this.ars,index+1);
                    }
                    ar.checked = false;
                    ar.expand_length = 0;
                }
                // this.$set(this.ars,tmp_ars);
            },
            expandAll: async function (){
                let tmp_ars = this.ars;
                this.ars = [];
                for(let i=0;i<tmp_ars.length;i++){
                    if(tmp_ars[i].header == true){
                        try {
                            let res = await Axios.get('/admin-api/arcustreport/details/'+tmp_ars[i].marcardcustomerid+"?end="+this.invoice_date_end+"&age="+this.invoice_aged_by)
                            tmp_ars[i].checked = true;
                            tmp_ars[i].expand_length = res.data.length;
                            for(let j=1;j<=res.data.length;j++){
                                res.data[j-1].marcardtotalinv = numeral(res.data[j-1].marcardtotalinv).format(self.num_format);
                                res.data[j-1].marcardoutstanding = numeral(res.data[j-1].marcardoutstanding).format(self.num_format);
                                res.data[j-1]['1w'] = numeral(res.data[j-1]['1w']).format(self.num_format);
                                res.data[j-1]['2w'] = numeral(res.data[j-1]['2w']).format(self.num_format);
                                res.data[j-1]['3w'] = numeral(res.data[j-1]['3w']).format(self.num_format);
                                res.data[j-1]['4w'] = numeral(res.data[j-1]['4w']).format(self.num_format);
                                res.data[j-1]['1m'] = numeral(res.data[j-1]['1m']).format(self.num_format);
                                res.data[j-1].has_due = numeral(res.data[j-1].has_due).format(self.num_format);
                                console.log(res.data[j-1]);
                                tmp_ars.splice(i+j,0,res.data[j-1]);
                            }
                        } catch(err){
                            console.log(err);
                        }
                    }
                }
                this.ars = tmp_ars;
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
                this.ars = [];
                Axios.get('/admin-api/arcustreport?br='+this.selected_branch+'&cust='+this.selected_customer+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end+"&age="+this.invoice_aged_by)
                .then(function(res){
                    $('#loading_modal').modal('toggle');
                    for(let i=0;i<res.data.length;i++){
                        res.data[i].checked = false;
                        res.data[i].expand_length = 0;
                        res.data[i].marcardtotalinv = numeral(res.data[i].marcardtotalinv).format(self.num_format);
                        res.data[i].marcardoutstanding = numeral(res.data[i].marcardoutstanding).format(self.num_format);
                        res.data[i]['1w'] = numeral(res.data[i]['1w']).format(self.num_format);
                        res.data[i]['2w'] = numeral(res.data[i]['2w']).format(self.num_format);
                        res.data[i]['3w'] = numeral(res.data[i]['3w']).format(self.num_format);
                        res.data[i]['4w'] = numeral(res.data[i]['4w']).format(self.num_format);
                        res.data[i]['1m'] = numeral(res.data[i]['1m']).format(self.num_format);
                        res.data[i].has_due = numeral(res.data[i].has_due).format(self.num_format);
                        console.log(i,res.data[i].marcardtotalinv);
                        self.$set(self.ars,i,res.data[i]);
                    }
                    // self.ars = res.data;
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
                window.open('/admin-nano/reports/arcustreport/export/print?start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&cust='+this.selected_customer+'&br='+this.selected_branch+"&data="+data+"&age="+this.invoice_aged_by,'_blank');
            },
            pdfTable(){
                let data = base64.encode(JSON.stringify(this.expand_headers));
                window.open('/admin-nano/reports/arcustreport/export/pdf?start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&cust='+this.selected_customer+'&br='+this.selected_branch+"&data="+data+"&age="+this.invoice_aged_by,'_blank');
            },
            excelTable(){
                let data = base64.encode(JSON.stringify(this.expand_headers));
                window.open('/admin-nano/reports/arcustreport/export/excel?start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&cust='+this.selected_customer+'&br='+this.selected_branch+"&data="+data+"&age="+this.invoice_aged_by,'_blank');
            },
            csvTable(){
                let data = base64.encode(JSON.stringify(this.expand_headers));
                window.open('/admin-nano/reports/arcustreport/export/csv?start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&cust='+this.selected_customer+'&br='+this.selected_branch+"&data="+data+"&age="+this.invoice_aged_by,'_blank');
            }
        },
        watch:{
            selected_sort(){
                this.sortData();
            },
            invoice_aged_by(){
                this.fetchArs();
            }
        },
        created(){
            this.fetchConfig();
            this.fetchArs();
            this.fetchCustomers();
        }
    }
</script>
