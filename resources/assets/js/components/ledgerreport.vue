<template>
    <div>
        <br>
        <div class="row">
            <p class="col-md-1 report-label">Sampai</p>
            <input v-dpicker v-model="report_date_end" type="text" class="small-date form-control" />
        </div>
        <br>
        <div class="row">
            <p class="col-md-1 report-label">Akun</p>
            <select class="col-md-4" id="select_supplier" v-selecttwo="bank_label" v-model="report_bank">
                <option></option>
                <option>Semua</option>
                <option v-for="bank in banks" :value="bank.id">{{ bank.mcoaname }}</option>
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
                <h4 class="text-center">Laporan Buku Besar</h4>
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
                <table class="table table-bordered" id="tableapi">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Akun</th>
                            <th>Tipe Transaksi</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="j in journals">
                            <td class="tbl-footer" v-if="j.data == false && j.summary == false" colspan="3" rowspan="2">Saldo</td>
                            <td v-if="j.data == true">{{ j.mjournaldate }}</td>
                            <td v-if="j.data == true">{{ j.akun.mcoaname }}</td>
                            <td v-if="j.data == true">{{ j.mjournaltranstype }}</td>
                            <td v-if="j.data == true" style="text-align:right" v-priceformatlabel="num_format">{{ j.mjournaldebit}}</td>
                            <td v-if="j.data == true" style="text-align:right" v-priceformatlabel="num_format">{{ j.mjournalcredit }}</td>
                            <td class="tbl-footer" v-if="j.data == false" style="text-align:right" v-priceformatlabel="num_format">{{ j.debit}}</td>
                            <td class="tbl-footer" v-if="j.data == false" style="text-align:right" v-priceformatlabel="num_format">{{ j.credit }}</td>
                        </tr>
                    </tbody>
                    <thead>

                    </thead>
                </table>
            </div>
        </div>
        <br>
    </div>
</template>

<script>
    import moment from 'moment'
    import Axios from 'axios'
    export default {
        props:['username'],
        data(){
            return {
                banks:[],
                journals:[],
                num_format:"0,0",
                company_name:"",
                report_print_date:moment().format('L'),
                report_date_end: moment().format('L'),
                report_bank:"",
            }
        },
        computed:{
            bank_label(){
                return "Pilih Akun"
            }
        },
        methods: {
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
                Axios.get('/admin-api/ledgers?end='+this.report_date_end+"&bank="+this.report_bank).then((res) => {
                    this.journals = res.data;
                });
            },
            printTable(){
                this.fetchJournals();
                window.open('/admin-nano/reports/ledger/export/print?end='+this.report_date_end+"&bank="+this.report_bank,'_blank');
            },
            pdfTable(){
                this.fetchJournals();
                window.open('/admin-nano/reports/ledger/export/pdf?end='+this.report_date_end+"&bank="+this.report_bank,'_blank');
            },
            excelTable(){
                this.fetchJournals();
                window.open('/admin-nano/reports/ledger/export/excel?end='+this.report_date_end+"&bank="+this.report_bank,'_blank');
            },
            csvTable(){
                this.fetchJournals();
                window.open('/admin-nano/reports/ledger/export/csv?end='+this.report_date_end+"&bank="+this.report_bank,'_blank');
            }
        },
        mounted(){
            this.fetchBanks();
            this.fetchJournals();
        }
    }
</script>
