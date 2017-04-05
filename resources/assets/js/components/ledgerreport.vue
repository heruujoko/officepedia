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
        <br>
        <div class="row">
            <div class="col-md-3">
                <button class="dt-button pull-left" v-on:click="toAccountMode">Pilih Akun</button>
                <button class="dt-button pull-left" v-on:click="toTableMode">Filter</button>
            </div>
            <div class="col-md-3 col-md-offset-6">
                <button class="dt-button pull-right" v-on:click="printTable">Print</button>
                <button class="dt-button pull-right" v-on:click="pdfTable">PDF</button>
                <button class="dt-button pull-right" v-on:click="excelTable">Excel</button>
                <button class="dt-button pull-right" v-on:click="csvTable">CSV</button>
            </div>
        </div>
        <hr>
        <ledgeraccount v-if="view_mode == 'account'" v-bind:num="num_format"></ledgeraccount>
        <div v-if="view_mode == 'table'">
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <h4 class="text-center">{{ company_name }}</h4>
                    <h4 class="text-center">Laporan Buku Besar</h4>
                    <h4 class="text-center">Periode {{ report_date_start }} - {{ report_date_end }}</h4>
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
                    <div v-for="journal in journals">
                    <h6>Kode Perkiraan : {{ journal.mcoacode }}</h6>
                    <h6>Nama : {{ journal.mcoacode }} - {{ journal.mcoaname }}</h6>
                    <table style="table-layout: fixed;" class="table table-bordered" id="tableapi">
                        <thead>
                            <tr>
                                <th style="width: 10%">Tanggal</th>
                                <th>Akun</th>
                                <th>Keterangan</th>
                                <th>Tipe Transaksi</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td colspan="3">Saldo Sebelumnya</td>
                                <td colspan="2" v-priceformatlabel="num_format" style="text-align: right">{{ journal.last_saldo }}</td>
                            </tr>
                            <tr v-for="tr in journal.transactions">
                                <td>{{ tr.mjournaldate }}</td>
                                <td>{{ tr.mjournalcoa }} - {{ tr.coaname }}</td>
                                <td></td>
                                <td>{{ tr.mjournaltranstype }}</td>
                                <td v-priceformatlabel="num_format" style="text-align: right">{{ tr.mjournaldebit }}</td>
                                <td v-priceformatlabel="num_format" style="text-align: right">{{ tr.mjournalcredit }}</td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <td colspan="4" style="text-align: center;vertical-align: middle">TOTAL</td>
                                <td v-priceformatlabel="num_format" style="text-align: right">{{ lodash.sumBy(journal.transactions , (jt) => { return jt.mjournaldebit } )}}</td>
                                <td v-priceformatlabel="num_format" style="text-align: right">{{ lodash.sumBy(journal.transactions , (jt) => { return jt.mjournalcredit } )}}</td>
                            </tr>
                        </thead>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</template>

<script>
    import moment from 'moment'
    import Axios from 'axios'
    import _ from 'lodash'
    import base64 from 'base-64'

    import ledgeraccount from './ledgeraccount.vue'
    export default {
        props:['username'],
        components: {
            ledgeraccount: ledgeraccount
        },
        data(){
            return {
                banks:[],
                journals:[],
                num_format:"0,0",
                company_name:"",
                report_print_date:moment().format('L'),
                report_date_start: moment().format('L'),
                report_date_end: moment().format('L'),
                report_bank:"Semua",
                lodash : _,
                view_mode: "account",
                selected_account: []
            }
        },
        computed:{
            bank_label(){
                return "Pilih Akun"
            }
        },
        methods: {
            toAccountMode(){
                this.view_mode = 'account';
            },
            toTableMode(){
                this.view_mode = 'table';
                this.fetchJournals();
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
            fetchBanks(){
                Axios.get('/admin-api/coaledger').then((res) => {
                    this.banks = res.data;
                    this.$forceUpdate();
                });
            },
            fetchJournals(){
                $('#loading_modal').modal('toggle');
                let accs = base64.encode(JSON.stringify(this.selected_account));
                Axios.get('/admin-api/ledgers?end='+this.report_date_end+"&coa="+accs+"&start="+this.report_date_start)
                .then((res) => {
                    $('#loading_modal').modal('toggle');
                    this.journals = res.data;
                }).catch(err => {
                    $('#loading_modal').modal('toggle');
                    console.log(err);
                });
            },
            printTable(){
                let accs = base64.encode(JSON.stringify(this.selected_account));
                window.open('/admin-nano/reports/ledger/export/print?end='+this.report_date_end+"&coa="+accs+"&start="+this.report_date_start,'_blank');
            },
            pdfTable(){
                let accs = base64.encode(JSON.stringify(this.selected_account));
                window.open('/admin-nano/reports/ledger/export/pdf?end='+this.report_date_end+"&coa="+accs+"&start="+this.report_date_start,'_blank');
            },
            excelTable(){
                let accs = base64.encode(JSON.stringify(this.selected_account));
                window.open('/admin-nano/reports/ledger/export/excel?end='+this.report_date_end+"&coa="+accs+"&start="+this.report_date_start,'_blank');
            },
            csvTable(){
                let accs = base64.encode(JSON.stringify(this.selected_account));
                window.open('/admin-nano/reports/ledger/export/csv?end='+this.report_date_end+"&coa="+accs+"&start="+this.report_date_start,'_blank');
            }
        },
        mounted(){
            // this.fetchBanks();
            // this.fetchJournals();
            this.$on('selection',( data ) => {
                console.log('selection',data);
                this.selected_account = data;
                console.log(this.selected_account);
            })
        }
    }
</script>
