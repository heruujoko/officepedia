<template>
    <div>
        <br>
        <div class="row">
            <p class="col-md-2 report-label">Periode Awal</p>
            <input v-dpicker v-model="report_date_start" type="text" class="small-date form-control" />
        </div>
        <div class="row">
            <p class="col-md-2 report-label">Periode Akhir</p>
            <input v-dpicker v-model="report_date_end" type="text" class="small-date form-control" />
        </div>
        <br>
        <div class="row">
            <p class="col-md-2 report-label">Hanya akun yang saldo tidak 0 </p>
            <input type="checkbox" v-model="not_zero" />
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <button class="dt-button pull-left" v-on:click="fetchBalance">Filter</button>
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
                <h4 class="text-center">Neraca Saldo</h4>
                <h4 class="text-center">Periode {{ report_date_start}} - {{ report_date_end }}</h4>
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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Akun</th>
                    <th>Nama Akun</th>
                    <th>Debet</th>
                    <th>Credit</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="j in journals">
                    <td>{{ j.mcoacode }}</td>
                    <td>{{ j.mcoaname }}</td>
                    <td style="text-align: right" v-priceformatlabel="num_format">{{ j.sum_debit }}</td>
                    <td style="text-align: right" v-priceformatlabel="num_format">{{ j.sum_credit }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    import moment from 'moment'
    import axios from 'axios'
    export default {
        props:['username'],
        data(){
            return {
                report_date_start: moment().format('L'),
                report_date_end: moment().format('L'),
                report_print_date: moment().format('L'),
                not_zero: false,
                journals: [],
                num_format: "0,0",
                company_name: ""
            }
        },
        methods: {
            fetchConfig(){
              axios.get('/admin-api/mconfig')
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
            printTable(){
                window.open('/admin-nano/reports/cashbalance/export/print?start='+this.report_date_start+"&end="+this.report_date_end+"&notzero="+this.not_zero,'_blank')
            },
            pdfTable(){
                window.open('/admin-nano/reports/cashbalance/export/pdf?start='+this.report_date_start+"&end="+this.report_date_end+"&notzero="+this.not_zero,'_blank')
            },
            excelTable(){
                window.open('/admin-nano/reports/cashbalance/export/excel?start='+this.report_date_start+"&end="+this.report_date_end+"&notzero="+this.not_zero,'_blank')
            },
            csvTable(){
                window.open('/admin-nano/reports/cashbalance/export/csv?start='+this.report_date_start+"&end="+this.report_date_end+"&notzero="+this.not_zero,'_blank')
            },
            fetchBalance(){
                $('#loading_modal').modal('toggle');
                axios.get('/admin-api/cashbalance?start='+this.report_date_start+"&end="+this.report_date_end+"&notzero="+this.not_zero)
                .then( res => {
                    this.journals = res.data;
                    $('#loading_modal').modal('toggle');
                })
                .catch( err => {
                    $('#loading_modal').modal('toggle');
                })
            }
        },
        created(){
            this.fetchConfig()
            this.fetchBalance()
        }
    }
</script>
