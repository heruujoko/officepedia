<template>
    <div>
        <br>
        <div class="row">
            <p class="col-md-1 report-label">Periode Awal</p>
            <input v-dpicker v-model="report_date_start" type="text" class="small-date form-control" />
        </div>
        <br>
        <div class="row">
            <p class="col-md-1 report-label">Periode Akhir</p>
            <input v-dpicker v-model="report_date_end" type="text" class="small-date form-control" />
        </div>
        <div class="row">
            <p class="col-md-1 report-label">Tipe Transaksi</p>
            <select v-selecttwo class="col-md-2" v-model="selected_type">
                <option value="">Semua</option>
                <option v-for="s in journal_types" :value="s">{{ s }}</option>
            </select>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <button class="dt-button pull-left" v-on:click="fetchJournals">Filter</button>
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
                <h4 class="text-center">{{ company_name }}</h4>
                <h4 class="text-center">Jurnal</h4>
                <h4 class="text-center">Per {{ report_date_end }}</h4>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="pull-right" style="padding-right:20px;">
                <p>User : {{ this.username }}</p>
                <p>Tgl Cetak : {{ report_print_date }}</p>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div v-for="j in journals">
                    <h6>Tanggal {{ j.date }}</h6>
                    <h6>Tipe Transaksi {{ j.type }}</h6>
                    <h6>No Jurnal {{ j.mjournalid }}</h6>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>No Transaksi</th>
                                <th>Tipe</th>
                                <th style="width: 2%">Akun</th>
                                <th>Debet</th>
                                <th>Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="tr in j.transactions">
                                <td>{{ tr.mjournaldate }}</td>
                                <td>{{ tr.mjournaltransno }}</td>
                                <td>{{ tr.mjournaltranstype }}</td>
                                <td v-if="tr.mjournaldebit == 0 && tr.mjournalcredit != 0"><span style="margin-left: 40px">{{ tr.mjournalcoa }} - {{ tr.mjournalcoaname }}</span></td>
                                <td v-else><span>{{ tr.mjournalcoa }} - {{ tr.mjournalcoaname }}</span></td>
                                <td style="text-align: right" v-priceformatlabel="num_format">{{ tr.mjournaldebit }}</td>
                                <td style="text-align: right" v-priceformatlabel="num_format">{{ tr.mjournalcredit }}</td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <td colspan="4"></td>
                                <td style="text-align: right" v-priceformatlabel="num_format">{{ j.sum_debit }}</td>
                                <td style="text-align: right" v-priceformatlabel="num_format">{{ j.sum_credit }}</td>
                            </tr>
                        </thead>
                    </table>
                    <br>
                </div>
            </div>
        </div>
        <br>
    </div>
</template>

<script>
    import Axios from 'axios'
    import _ from 'lodash'
    import moment from 'moment'

    export default {
        props:['username'],
        data(){
            return {
                company_name: "",
                report_date_start : moment().format('L'),
                report_date_end : moment().format('L'),
                report_print_date: moment().format('L'),
                num_format:"0.0",
                journals:[],
                journal_types:[
                  "Pembelian",
                  "Pembelian",
                  "Pemasukan",
                  "Pengeluaran",
                  "Transfer",
                  "Umum"
                ],
                selected_type: ""
            }
        },
        methods:{
            fetchTypes(){
              Axios.get('/admin-api/journal/types')
              .then( res => {
                this.journal_types = res.data;
              })
              .catch(err => {
                console.log(err);
              });
            },
            fetchConfig(){
              Axios.get('/admin-api/mconfig')
              .then((res) => {
                let conf = res.data;
                if(conf.msysnumseparator == ',' && conf.msysgenrounddec == '2'){
                  this.num_format = "0,0.00";
                } else if(conf.msysnumseparator == ',' && conf.msysgenrounddec == '0'){
                  this.num_format = "0,0";
                } else if(conf.msysnumseparator == '.' && conf.msysgenrounddec == '2'){
                  this.num_format = "0.0,00";
                } else {
                  this.num_format = "0.0";
                }
                this.company_name = conf.msyscompname;
              });
            },
            fetchJournals(){
                let self = this;
                self.journals = [];
                $("#loading_modal").modal('toggle');
                Axios.get('/admin-api/journal?end='+this.report_date_end+"&start="+this.report_date_start+"&type="+this.selected_type)
                .then((res) => {
                    self.journals = res.data;
                    $("#loading_modal").modal('toggle');
                })
                .catch(err => {
                    console.log(err);
                    console.log('let it err');
                    $("#loading_modal").modal('toggle');
                });
            },
            printTable(){
                window.open('/admin-nano/reports/journal/export/print?end='+this.report_date_end+"&start="+this.report_date_start+"&type="+this.selected_type,'_blank');
            },
            pdfTable(){
                window.open('/admin-nano/reports/journal/export/pdf?end='+this.report_date_end+"&start="+this.report_date_start+"&type="+this.selected_type,'_blank');
            },
            excelTable(){
                window.open('/admin-nano/reports/journal/export/excel?end='+this.report_date_end+"&start="+this.report_date_start+"&type="+this.selected_type,'_blank');
            },
            csvTable(){
                window.open('/admin-nano/reports/journal/export/csv?end='+this.report_date_end+"&start="+this.report_date_start+"&type="+this.selected_type,'_blank');
            }
        },
        created(){
            this.fetchConfig();
            this.fetchJournals();
            this.fetchTypes();
        }
    }
</script>
