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
                            <td><span v-if="ar.header">{{ ar.marcardcustomername }}</span></td>
                            <td><span v-if="ar.data">{{ ar.marcarddate }}</span></td>
                            <td><span v-if="ar.data">{{ ar.marcardtransno }}</span></td>
                            <td><span v-if="ar.data">{{ ar.inv_date }}</span></td>
                            <td><span v-if="ar.data">{{ ar.marcardduedate }}</span></td>
                            <td style="text-align:right"><span v-if="ar.footer == false" >{{ ar.marcardtotalinv }}</span></td>
                            <td style="text-align:right"><span v-if="ar.footer == false" >{{ ar.marcardpayamount }}</span></td>
                            <td style="text-align:right"><span v-if="ar.footer == false" >{{ ar.outs }}</span></td>
                            <td><span v-if="ar.data">{{ ar.aging }}</span></td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="6">TOTAL</th>
                            <th style="text-align:right" >{{ total_inv }}</th>
                            <th style="text-align:right" >{{ total_pay }}</th>
                            <th style="text-align:right" >{{ total_outs }}</th>
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
    import numeral from 'numeral'
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
                num_format:"0,0",
                opens:[]
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
                let amount = _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return numeral().unformat(ar.marcardtotalinv);
                    }
                });
                return numeral(amount).format(this.num_format);
            },
            total_pay(){
                let amount = _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return numeral().unformat(ar.marcardpayamount);
                    }
                });
                return numeral(amount).format(this.num_format);
            },
            total_outs(){
                let amount = _.sumBy(this.ars,(ar) => {
                    if(ar.header == true){
                        return numeral().unformat(ar.outs);
                    }
                });
                return numeral(amount).format(this.num_format);
            }
        },
        methods: {
            expander(ar,index){

                let rest_of_the_list = [];
                let tmp_ars = this.ars;

                for(let r=index+1;r<this.ars.length;r++){
                    rest_of_the_list.push(this.ars[r]);
                }
                this.ars = [];
                for(let ar=0;ar<=index;ar++){
                    this.ars.push(tmp_ars[ar]);
                }
                ar = this.ars[index];
                if(!ar.checked){
                    $("#loading_modal").modal('toggle');
                    Axios.get('/admin-api/arbook/details/'+ar.marcardcustomerid)
                    .then( res => {
                        ar.checked = true;
                        ar.expand_length = res.data.length;
                        for(let i=0;i<res.data.length;i++){
                            let outs = res.data[i].marcardtotalinv - res.data[i].marcardpayamount;
                            res.data[i].marcardtotalinv = numeral(res.data[i].marcardtotalinv).format(this.num_format);
                            res.data[i].marcardpayamount = numeral(res.data[i].marcardpayamount).format(this.num_format);
                            res.data[i].outs = numeral(outs).format(this.num_format);
                            this.ars.push(res.data[i]);
                        }
                        for(let r=0;r<rest_of_the_list.length;r++){
                            this.ars.push(rest_of_the_list[r]);
                        }
                        this.opens.push(index);
                        $("#loading_modal").modal('toggle');
                    })
                    .catch( err => {
                        $("#loading_modal").modal('toggle');
                    })
                } else {
                    let removed = _.remove(this.opens,(n) => {
                        return n != index;
                    });
                    console.log('leng',this.ars.length);
                    for(let rs=(index+1+ar.expand_length);rs<tmp_ars.length;rs++){
                        this.ars.push(tmp_ars[rs]);
                    }


                    this.opens = removed;
                    ar.checked = false;
                    ar.expand_length = 0;
                }
            },
            expandAll: async function(){
                let tmp_ars = this.ars;
                this.ars = [];
                for(let i=0;i<tmp_ars.length;i++){
                    if(tmp_ars[i].header == true){
                        try{

                            let res = await Axios.get('/admin-api/arbook/details/'+tmp_ars[i].marcardcustomerid)
                            tmp_ars[i].checked = true;
                            this.opens.push(i);
                            tmp_ars[i].expand_length = res.data.length;
                            for(let j=1;j<=res.data.length;j++){
                                console.log(res.data[j-1]);
                                tmp_ars.splice(i+j,0,res.data[j-1]);
                            }

                        } catch(err){
                            console.log(err);
                        }
                    }
                }

                tmp_ars.map(item => {
                    let outs = item.marcardtotalinv - item.marcardpayamount;
                    item.marcardtotalinv = numeral(item.marcardtotalinv).format(this.num_format);
                    item.marcardpayamount = numeral(item.marcardpayamount).format(this.num_format);
                    if(item.data) {
                        item.outs = numeral(outs).format(this.num_format);
                    }

                });

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
                this.opens = [];
                Axios.get('/admin-api/arbook?customer='+this.selected_customer)
                .then(res => {

                    for(let i=0;i<res.data.length;i++){
                        let outs = res.data[i].marcardtotalinv - res.data[i].marcardpayamount;
                        res.data[i].outs = numeral(outs).format(this.num_format);
                        res.data[i].checked = false;
                        res.data[i].marcardtotalinv = numeral(res.data[i].marcardtotalinv).format(this.num_format);
                        res.data[i].marcardpayamount = numeral(res.data[i].marcardpayamount).format(this.num_format);

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
                let data = base64.encode(JSON.stringify(this.opens));
                window.open('/admin-nano/reports/arbook/export/print?customer='+this.selected_customer+"&br="+this.label_branch+"&data="+data,'_blank');
            },
            pdfTable(){
                let data = base64.encode(JSON.stringify(this.opens));
                window.open('/admin-nano/reports/arbook/export/pdf?customer='+this.selected_customer+"&br="+this.label_branch+"&data="+data,'_blank');
            },
            excelTable(){
                let data = base64.encode(JSON.stringify(this.opens));
                window.open('/admin-nano/reports/arbook/export/excel?customer='+this.selected_customer+"&br="+this.label_branch+"&data="+data,'_blank');
            },
            csvTable(){
                let data = base64.encode(JSON.stringify(this.opens));
                window.open('/admin-nano/reports/arbook/export/csv?customer='+this.selected_customer+"&br="+this.label_branch+"&data="+data,'_blank');
            }
        },
        created(){
            this.fetchConfig();
            this.fetchCustomers();
            this.fetchArs();
        }
    }
</script>
