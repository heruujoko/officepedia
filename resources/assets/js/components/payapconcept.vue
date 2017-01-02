<template>
    <div>
        <div class="row" v-show="mode != 'insert'" v-on:click="toInsertMode">
            <button class="btn btn-default pull-right" style="margin-right:4%">Kembali</button>
        </div>

        <div class="row">
          <div class="form form-horizontal" style="margin-top:20px">
            <div class="col-md-8">
              <div class="form-group">
                <label class="col-md-2 control-label">Supplier</label>
                <div class="col-md-8">
                  <select id="select_supplier" v-bind:disabled="disable_supplier" v-selecttwo="supplier_label" v-model="invoice_supplier">
                    <option></option>
                    <option v-for="sp in suppliers" :value="sp.id">{{ sp.msuppliername }}</option>
                  </select>
                  <label v-if="supplier_alert" style="color:rgb(212, 103, 82)!important">Supplier tidak bisa kosong</label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">Tanggal</label>
                <div class="col-md-8">
                  <input v-bind:disabled="!notview" v-dpicker v-model="invoice_date" type="text" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">No Bukti</label>
                <div class="col-md-8">
                  <input v-bind:disabled="!notview" v-model="invoice_ref_no" placeholder="No Bukti" type="text" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 control-label">No Cek</label>
                <div class="col-md-8">
                  <input v-bind:disabled="!notview" v-model="invoice_check_no" placeholder="No Cek" type="text" class="form-control" />
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-md-3 control-label">No Invoice</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input v-bind:disabled="invoice_auto" v-model="invoice_no" class="form-control forminput" placeholder="AUTO GENERATE" type="text">
                        <span class="input-group-addon" style="background: none;">
                            <input v-model="invoice_auto" type="checkbox" name="autogen" rel="tooltip" title="" data-original-title="ON/OFF auto generate kode transaksi" data-parsley-multiple="autogen" checked="checked">
                        </span>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Type</label>
                <div class="col-md-8">
                  <select disabled v-selecttwo="transaksi_label" class="form-control">
                    <option>Pembayaran Hutang</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row" style="margin-top:20px;">
          <!--  detail inv -->
          <div class="container">
            <div class="well" style="margin-bottom:20px;">
              <div class="row">
                <div class="col-md-12">
                  <button v-if="this.mode == 'insert'" class="pull-right btn btn-primary" v-on:click="saveInvoice">Proses</button>
                  <button v-if="this.mode == 'edit'" class="pull-right btn btn-primary" v-on:click="updateInvoice">Proses Update</button>
                </div>
              </div>
              <div class="row">
                <br><br>
                <table id="insertdetailtable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th v-if="notview" style="width:5%;"></th>
                      <th style="width:10%;">No Faktur</th>
                      <th style="width:10%;">Tanggal</th>
                      <th style="width:10%;">Due Date</th>
                      <th style="width:10%;">Nilai Faktur</th>
                      <th style="width:10%;">Terbayar</th>
                      <th style="width:10%;">Terhutang</th>
                      <th style="width:10%;">Bayar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in aps">
                      <td><input v-on:click="validateChekedItem(item.id)" :checked="item.checked" type="checkbox" class="form-control" style="height:15px;margin-top:-2px;" ></td>
                      <td>{{ item.mapcardtransno }}</td>
                      <td>{{ item.mapcardtdate }}</td>
                      <td>{{ item.mapcardduedate }}</td>
                      <td v-priceformatlabel="num_format">{{ item.mapcardtotalinv }}</td>
                      <td v-priceformatlabel="num_format">{{ item.paid }}</td>
                      <td v-priceformatlabel="num_format">{{ item.outstanding_total }}</td>
                      <td v-priceformatlabel="num_format">{{ item.payamount }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row" style="color:white;">
                <br>
                <div class="col-md-2 well bg-color-greenLight">
                  <h5>Nilai Pembayaran</h5>
                  <p v-priceformatlabel="num_format">{{ total_invoice }}</p>
                </div>
                <div class="col-md-2 col-md-offset-2 well bg-color-magenta">
                  <h5>Faktur Dibayar</h5>
                  <p v-priceformatlabel="num_format">{{ total_pay_amount }}</p>
                </div>
                <div class="col-md-2 well bg-color-blue">
                  <h5>Discount</h5>
                  <p v-priceformatlabel="num_format">{{  }}</p>
                </div>
                <div class="col-md-2 well well bg-color-orangeDark">
                  <h5>Lebih Bayar</h5>
                  <p v-priceformatlabel="num_format">{{ lebih_bayar }}</p>
                </div>
                <div class="col-md-2 well bg-color-redLight">
                  <h5>Total</h5>
                  <p v-priceformatlabel="num_format">{{  total_pay_amount - this.lebih_bayar }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-bind:id="modal_id" class="modal" style="top: 15%;" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                <h4>Detail Hutang</h4>
                    </div>
              <div class="modal-body">
                  <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" v-bind:href="htab1_id">Tunai</a></li>
                    <li><a data-toggle="tab" v-bind:href="htab2_id">Transfer</a></li>
                    <li><a data-toggle="tab" v-bind:href="htab2_id">Cek</a></li>
                    <li><a data-toggle="tab" v-bind:href="htab2_id">Giro</a></li>
                    <li><a data-toggle="tab" v-bind:href="htab2_id">Credit</a></li>
                  </ul>
                  <div class="tab-content">
                      <div v-bind:id="tab1_id" class="tab-pane fade in active">
                          <br>
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form form-horizontal">
                                      <div class="form-group">
                                        <label class="col-md-2 control-label">Akun</label>
                                        <div class="col-md-8">
                                            <select v-bind:id="select_cash_id" v-selecttwo="coa_label" v-model="detail_cash_coa">
                                              <option></option>
                                              <option v-for="ca in cash" :value="ca.mcoacode">{{ ca.mcoacode }} - {{ ca.mcoaname }}</option>
                                            </select>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="col-md-2 control-label">Bayar</label>
                                        <div class="col-md-8">
                                          <input class="form-control" type="text" v-model="detail_cash_pay" v-priceformatsatuan="num_format" style="text-align:right">
                                        </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div v-bind:id="tab2_id" class="tab-pane">
                          <br>
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                    <label class="col-md-2 control-label">Akun</label>
                                    <div class="col-md-8">
                                      <select id="select_cash" v-selecttwo="coa_label" v-model="detail_bank_coa">
                                        <option></option>
                                        <option v-for="ca in banks" :value="ca.mcoacode">{{ ca.mcoacode }} - {{ ca.mcoaname }}</option>
                                      </select>
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                        <button v-on:click="dismissModal" type="button" class="btn btn-default" data-dismiss="modal">
                              Cancel
                        </button>
                        <button v-if="detail_state == 'insert'" type="button" class="btn btn-primary" @click="AddPaymentDetail">
                              Lanjut
                        </button>
                        <button v-if="detail_state == 'edit'" type="button" class="btn btn-primary" >
                              Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-bind:id="loading_id" class="modal" style="top: 20%;" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        	<div class="modal-dialog">
        		<div class="modal-content">
        			<div class="modal-header" style="text-align: center">
        				<h3>Loading Data</h3>
        				<img src="/master/ajax-loader.gif">
        			</div>
        		</div>
        	</div>
        </div>

    </div>
</template>

<script>
    import Axios from 'axios'
    import numeral from 'numeral'
    import _ from 'lodash'
    import swal from 'sweetalert'
    import moment from 'moment'
    import Vue from 'vue'

    export default {
        props:['mode'],
        data(){
            return {
                editinvoiceid:0,
                invoice_auto:true,
                invoice_no:"",
                invoice_supplier:{},
                invoice_bank:{},
                invoice_check_no:"",
                invoice_ref_no:"",
                invoice_date:moment().format('L'),
                invoice_pay_amount:0,
                invoice_type:"Pembarayan Hutang",
                invoice_aps:[],
                disable_supplier: false,
                supplier_alert: false,
                disable_bank: false,
                bank_alert: false,
                detail_ap:{},
                detail_state:"",
                detail_pay:0,
                detail_cash_coa:"",
                detail_cash_pay:0,
                detail_bank_coa:"",
                detail_bank_pay:0,
                selected_aps:"",
                ap_remark:"",
                edit_index:0,
                aps:[],
                suppliers:[],
                banks:[],
                cash:[],
                num_format:"0,0"
            }
        },
        computed:{
            loading_id(){
                return this.mode+"_loading_modal";
            },
            select_cash_id(){
                return this.mode+"_select_cash";
            },
            coa_label(){
                return "Pilih Akun";
            },
            modal_id(){
                return this.mode+"_detail_modal";
            },
            tab1_id(){
              return this.mode+"_tab1";
            },
            tab2_id(){
              return this.mode+"_tab2";
            },
            htab1_id(){
              return "#"+this.mode+"_tab1";
            },
            htab2_id(){
              return "#"+this.mode+"_tab2";
            },
            supplier_label(){
                return "Pilih Supplier"
            },
            notview(){
                return this.mode != "view";
            },
            total_invoice(){
                let amount=0;
                for(let i=0;i<this.aps.length;i++){
                    if(this.aps[i].checked){
                        amount += parseInt(this.aps[i].outstanding_total);
                    }
                }
                return amount;
            },
            total_pay_amount(){
                let amount=0;
                for(let i=0;i<this.aps.length;i++){
                    if(this.aps[i].checked){
                        amount += parseInt(this.aps[i].payamount);
                    }
                }
                return amount;
            },
            lebih_bayar(){
                console.log(this.total_pay_amount > this.total_invoice);
                if(this.total_pay_amount > this.total_invoice){
                    return (this.total_pay_amount - this.total_invoice);
                } else {
                    return 0;
                }
            }
        },
        methods:{
            toInsertMode(){

            },
            transaksi_label(){},
            fetchSuppliers(){
                Axios.get('/admin-api/msupplier/datalist').then((res) => {
                    this.suppliers = res.data;
                }).catch(() => {

                });
            },
            fetchBanks(){
                Axios.get('/admin-api/coadata/1102.00').then((res) => {
                    this.banks = res.data;
                }).catch(() => {

                });
            },
            fetchCash(){
                Axios.get('/admin-api/coadata/1101.00').then((res) => {
                    this.cash = res.data;
                }).catch(() => {

                });
            },
            fetchSupplierAP(){
                Axios.get('/admin-api/apsupplier/'+this.invoice_supplier).then((res) => {
                    for(let i=0;i<res.data.length;i++){
                        res.data[i].checked = false;
                    }
                    this.aps = res.data;
                    $('#'+this.loading_id).modal('toggle');
                })
                .catch(() => {
                    $('#'+this.loading_id).modal('toggle');
                });
            },
            openDialog(id){
                let ap = _.find(this.aps,{id: parseInt(id)});
                let index = _.findIndex(this.aps,{id: parseInt(id)});
                this.detail_ap = ap;
                this.detail_state = "insert"
                $('#'+this.modal_id).modal('toggle');
            },
            editDialog(id){
                let ap = _.find(this.invoice_aps,{id: parseInt(id)});
                this.detail_ap = ap;
                $('#'+this.modal_id).modal('toggle');
                console.log(this.detail_ap.payments.cash.coa);
                this.detail_cash_coa = this.detail_ap.payments.cash.coa;
                console.log("nih");
                console.log(this.detail_cash_coa);
                this.detail_cash_pay = ap.payments.cash.amount;
                this.detail_state = "edit"
                $('#'+this.select_cash_id).val(this.detail_cash_coa);
                $('#'+this.select_cash_id).trigger('change');
            },
            validateChekedItem(id){
                let ap = _.find(this.aps,{id: parseInt(id)});
                if(ap.checked){
                    this.editDialog(id);
                } else {
                    this.openDialog(id);
                }
            },
            dismissModal(){
                this.detail_ap = {}
                this.detail_cash_coa = ""
                this.detail_cash_pay = 0
                this.detail_bank_coa = ""
                this.detail_bank_pay = 0
                $('#'+this.modal_id).modal('toggle');
            },
            AddPaymentDetail(){
                let payment = this.detail_ap;
                payment['payments'] = {
                    cash: {
                        coa: this.detail_cash_coa,
                        amount: this.detail_cash_pay
                    },
                    bank: {
                        coa: this.detail_bank_coa,
                        amount: this.detail_bank_pay
                    }
                };
                let aps = _.find(this.aps,{id: parseInt(this.detail_ap.id)});
                let index = _.findIndex(this.aps,{ id: parseInt(this.detail_ap.id)});
                aps.checked = true;
                aps.payamount = parseInt(this.detail_cash_pay) + parseInt(this.detail_bank_pay)
                this.invoice_aps.push(payment);
                this.$set(this.aps,index,aps);
                this.dismissModal()
            },
            updateInvoice(){},
            saveInvoice(){}
        },
        watch:{
            invoice_supplier(){
                $('#'+this.loading_id).modal('toggle');
                this.fetchSupplierAP()
            }
        },
        mounted(){
            this.fetchCash()
            this.fetchBanks()
            this.fetchSuppliers()
        }
    }
</script>
