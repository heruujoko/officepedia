<template>
    <div>
        <br>
        <div class="row">
            <p class="col-md-1 report-label">Periode Awal</p>
            <input v-dpicker v-model="report_date_start" type="text" class="small-date form-control" />
        </div>
        <div class="row">
            <p class="col-md-1 report-label">Periode Akhir</p>
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
        <div style="padding: 20px">
            <div class="row" v-for="journal in journals">
                <h6>Tanggal : {{ journal.date }}</h6>
                <h6>Tipe Transaksi : {{ journal.type }}</h6>
                <h6>No Transaksi : {{ journal.trans }}</h6>
                <br>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Akun</th>
                            <th>Nama Akun</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="tr in journal.transactions">
                            <td>{{ tr.mjournalcoa }}</td>
                            <td v-if="tr.mjournalcredit != 0" style="text-align: center">
                                {{ tr.mjournalcoaname }}
                            </td>
                            <td v-else>
                                {{ tr.mjournalcoaname }}
                            </td>
                            <td style="text-align: right" v-priceformatlabel="num_format">{{ tr.mjournaldebit }}</td>
                            <td style="text-align: right" v-priceformatlabel="num_format">{{ tr.mjournalcredit }}</td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th style="text-align: right" v-priceformatlabel="num_format">{{ journal.sum_debit }}</th>
                            <th style="text-align: right" v-priceformatlabel="num_format">{{ journal.sum_credit }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    import moment from 'moment'
    import axios from 'axios'
    export default {
        props:['mode'],
        data(){
            return {
                report_date_start: moment().format('L'),
                report_date_end: moment().format('L'),
                journals: [],
                num_format: "0,0"
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
              });
            },
            fetchJournals(){
                $('#loading_modal').modal('toggle');

                let endpoint = ""
                if(this.mode == 'purchase'){
                    endpoint = "/admin-api/purchasejournal/"
                } else {
                    endpoint = "/admin-api/salesjournal/"
                }

                axios.get(endpoint+"?start="+this.report_date_start+"&end="+this.report_date_end)
                .then( res => {
                    this.journals = res.data;
                    $('#loading_modal').modal('toggle');
                })
                .catch( err => {
                    $('#loading_modal').modal('toggle');
                });
            },
            printTable(){
                window.open('/admin-nano/reports/'+this.mode+'journal/export/print?start='+this.report_date_start+"&end="+this.report_date_end,'_blank');
            },
            pdfTable(){
                window.open('/admin-nano/reports/'+this.mode+'journal/export/pdf?start='+this.report_date_start+"&end="+this.report_date_end,'_blank');
            },
            excelTable(){
                window.open('/admin-nano/reports/'+this.mode+'journal/export/excel?start='+this.report_date_start+"&end="+this.report_date_end,'_blank');
            },
            csvTable(){
                window.open('/admin-nano/reports/'+this.mode+'journal/export/csv?start='+this.report_date_start+"&end="+this.report_date_end,'_blank');
            }
        },
        created(){
            this.fetchJournals();
        }
    }
</script>
