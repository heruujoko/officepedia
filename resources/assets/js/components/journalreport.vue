<template>
    <div>
        <br>
        <div class="row">
            <p class="col-md-1 report-label">Per</p>
            <input v-dpicker v-model="report_date_end" type="text" class="small-date form-control" />
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
                <table class="table table-bordered" id="tableapi">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>No Transaksi</th>
                            <th>Tipe</th>
                            <th>Akun</th>
                            <th>Debet</th>
                            <th>Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="j in journals">
                            <td>{{ j.mjournaldate }}</td>
                            <td>{{ j.mjournaltransno }}</td>
                            <td>{{ j.mjournaltranstype }}</td>
                            <td v-if="j.mjournaldebit != 0">{{ j.akun.mcoacode }} - {{ j.akun.mcoaname }}</td>
                            <td v-if="j.mjournalcredit != 0" style="text-align: center">{{ j.akun.mcoacode }} - {{ j.akun.mcoaname }}</td>
                            <td style="text-align:right" v-priceformatlabel="num_format">{{ j.mjournaldebit }}</td>
                            <td style="text-align:right" v-priceformatlabel="num_format">{{ j.mjournalcredit }}</td>
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
    import Axios from 'axios'
    import _ from 'lodash'
    import moment from 'moment'
    export default {
        props:['username'],
        data(){
            return {
                company_name: "",
                report_date_end : moment().format('L'),
                report_print_date: moment().format('L'),
                num_format:"0.0",
                journals:[]
            }
        },
        methods:{
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
                Axios.get('/admin-api/journal?end='+this.report_date_end)
                .then((res) => {
                  this.journals = res.data;
                });
            },
            printTable(){
                window.open('/admin-nano/reports/journal/export/print?end='+this.report_date_end,'_blank');
            },
            pdfTable(){
                window.open('/admin-nano/reports/journal/export/pdf?end='+this.report_date_end,'_blank');
            },
            excelTable(){
                window.open('/admin-nano/reports/journal/export/excel?end='+this.report_date_end,'_blank');
            },
            csvTable(){
                window.open('/admin-nano/reports/journal/export/csv?end='+this.report_date_end,'_blank');
            }
        },
        mounted(){
            this.fetchConfig();
            this.fetchJournals();
        }
    }
</script>
