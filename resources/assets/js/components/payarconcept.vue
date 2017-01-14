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
                  <select v-bind:id="select_customer" v-bind:disabled="disable_customer" v-selecttwo="customer_label" v-model="invoice_customer">
                    <option></option>
                    <option v-for="cus in customers" :value="cus.id">{{ cus.mcustomername }}</option>
                  </select>
                  <label v-if="customer_alert" style="color:rgb(212, 103, 82)!important">Supplier tidak bisa kosong</label>
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
                      <th style="width:5%;"></th>
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
                    <tr v-for="item in ars">
                      <td><input v-on:click="validateChekedItem(item.id)" :checked="item.checked" type="checkbox" class="form-control" style="height:15px;margin-top:-2px;" ></td>
                      <td>{{ item.marcardtransno }}</td>
                      <td>{{ item.marcarddate }}</td>
                      <td>{{ item.marcardduedate }}</td>
                      <td v-priceformatlabel="num_format">{{ item.marcardtotalinv }}</td>
                      <td v-priceformatlabel="num_format">{{ item.paid_total }}</td>
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
                                          <input class="form-control" type="text" v-model="detail_cash_pay" v-priceformatcash="num_format" style="text-align:right">
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
                                  <div class="form form-horizontal">
                                      <div class="form-group">
                                        <label class="col-md-2 control-label">Akun</label>
                                        <div class="col-md-8">
                                          <select v-bind:id="select_bank_id" v-selecttwo="coa_label" v-model="detail_bank_coa">
                                            <option></option>
                                            <option v-for="ca in banks" :value="ca.mcoacode">{{ ca.mcoacode }} - {{ ca.mcoaname }}</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="col-md-2 control-label">Bayar</label>
                                        <div class="col-md-8">
                                          <input class="form-control" type="text" v-model="detail_bank_pay" v-priceformatbank="num_format" style="text-align:right">
                                        </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="col-md-2 control-label">Keterangan</label>
                                          <div class="col-md-8">
                                              <input type="text" class="form-control" v-model="detail_bank_bank_name">
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <br>
                  <div class="row well">
                      <div class="col-md-6">
                          <p>Customer : {{ detail_ar.marcardcustomername }}</p>
                          <p>Tanggal : {{ detail_ar.marcarddate }}</p>
                          <p>Jatuh Tempo : {{ detail_ar.marcardduedate }}</p>
                      </div>
                      <div class="col-md-6">
                          <p>Terhutang : {{ numeral(detail_ar.outstanding_total).format(num_format) }} </p>
                          <p>Terbayar : {{ numeral(detail_ar.paid_total).format(num_format) }}</p>
                          <p>Total Transaksi : {{ numeral(detail_ar.marcardtotalinv).format(num_format) }}</p>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                    <div class="row">
                        <button v-on:click="dismissModal" type="button" class="btn btn-default" data-dismiss="modal">
                              Cancel
                        </button>
                        <button v-if="detail_ar.checked" type="button" class="btn btn-default" @click="clearPaymentDetail">
                              Hapus
                        </button>
                        <button v-if="detail_state == 'insert'" type="button" class="btn btn-primary" @click="addPaymentDetail">
                              Lanjut
                        </button>
                        <button v-if="detail_state == 'edit'" type="button" class="btn btn-primary" @click="updatePaymentDetail">
                              Simpan
                        </button>
                    </div>
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
                numeral: numeral,
                editinvoiceid:0,
                invoice_auto:true,
                invoice_no:"",
                invoice_customer:{},
                invoice_bank:{},
                invoice_check_no:"",
                invoice_ref_no:"",
                invoice_date:moment().format('L'),
                invoice_pay_amount:0,
                invoice_type:"Pembarayan Piutang",
                invoice_ars:[],
                disable_customer: false,
                customer_alert: false,
                disable_bank: false,
                bank_alert: false,
                detail_ar:{},
                detail_state:"",
                detail_pay:0,
                detail_cash_coa:"",
                detail_cash_pay:0,
                detail_bank_coa:"",
                detail_bank_bank_name:"",
                detail_bank_pay:0,
                selected_ars:"",
                ar_remark:"",
                edit_index:0,
                ars:[],
                customers:[],
                banks:[],
                cash:[],
                num_format:"0,0"
            }
        },
        computed:{
            notview(){
                return this.mode != "view";
            },
            loading_id(){
                return this.mode+"_loading_modal";
            },
            select_customer(){
                return this.mode+"_select_customer";
            },
            select_cash_id(){
                return this.mode+"_select_cash";
            },
            select_bank_id(){
                return this.mode+"_select_bank";
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
            customer_label(){
                return "Pilih Customer"
            },
            notview(){
                return this.mode != "view";
            },
            total_invoice(){
                let amount=0;
                for(let i=0;i<this.ars.length;i++){
                    if(this.ars[i].checked){
                        amount += parseInt(this.ars[i].outstanding_total);
                    }
                }
                return amount;
            },
            total_pay_amount(){
                let amount=0;
                for(let i=0;i<this.ars.length;i++){
                    if(this.ars[i].checked){
                        amount += parseInt(this.ars[i].payamount);
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
                this.resetInvoice();
                $('#forminput').show();
        		$('#formview').hide();
        		$('#formedit').hide();
        		window.location.href="#forminput";
            },
            resetInvoice(){
                this.editinvoiceid=0
                this.invoice_auto=true
                this.invoice_no=""
                this.invoice_supplier={}
                this.invoice_bank={}
                this.invoice_check_no=""
                this.invoice_ref_no=""
                this.invoice_date=moment().format('L')
                this.invoice_pay_amount=0
                this.invoice_ars=[]
                this.disable_customer= false
                this.customer_alert= false
                this.disable_bank= false
                this.bank_alert= false
                this.detail_ar={}
                this.detail_state=""
                this.detail_pay=0
                this.detail_cash_coa=""
                this.detail_cash_pay=0
                this.detail_bank_coa=""
                this.detail_bank_pay=0
                this.selected_ars=""
                this.ar_remark=""
                this.edit_index=0
                this.ars=[]
            },
            transaksi_label(){},
            fetchCustomers(){
                Axios.get('/admin-api/pelanggan/datalist').then((res) => {
                    this.customers = res.data;
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
            fetchCustomerAR(){
                Axios.get('/admin-api/arcustomer/'+this.invoice_customer).then((res) => {
                    for(let i=0;i<res.data.length;i++){
                        res.data[i].checked = false;
                    }
                    this.ars = res.data;
                    if(this.mode == "insert"){
                        $('#'+this.loading_id).modal('toggle');
                    }
                })
                .catch(() => {
                    if(this.mode == "insert"){
                        $('#'+this.loading_id).modal('toggle');
                    }
                });
            },
            openDialog(id){
                let ap = _.find(this.ars,{id: parseInt(id)});
                let index = _.findIndex(this.ars,{id: parseInt(id)});
                this.detail_ar = ap;
                this.detail_state = "insert"
                $('#'+this.modal_id).modal('toggle');
            },
            editDialog(id){
                console.log("open "+id);
                let ap = _.find(this.invoice_ars,{ars_id: parseInt(id)});
                this.detail_ar = ap;
                this.detail_ar.checked = true;
                $('#'+this.modal_id).modal('toggle');
                console.log(this.detail_ar.payments.cash.coa);
                this.detail_cash_coa = this.detail_ar.payments.cash.coa;
                this.detail_bank_coa = this.detail_ar.payments.bank.coa;
                this.detail_cash_pay = ap.payments.cash.amount;
                this.detail_bank_pay = ap.payments.bank.amount;
                this.detail_bank_bank_name = ap.payments.bank.bank_name;
                this.detail_state = "edit"
                $('#'+this.select_cash_id).val(this.detail_cash_coa);
                $('#'+this.select_cash_id).trigger('change');
                $('#'+this.select_bank_id).val(this.detail_bank_coa);
                $('#'+this.select_bank_id).trigger('change');
            },
            validateChekedItem(id){
                let ap = _.find(this.ars,{id: parseInt(id)});
                console.log(ap);
                console.log('cheked '+ap.checked);
                if(ap.checked == true){
                    this.editDialog(id);
                } else {
                    this.openDialog(id);
                }
            },
            dismissModal(){
                this.detail_ar = {}
                this.detail_cash_coa = ""
                this.detail_cash_pay = 0
                this.detail_bank_coa = ""
                this.detail_bank_pay = 0
                $('#'+this.modal_id).modal('toggle');
            },
            addPaymentDetail(){
                let payment = this.detail_ar;
                payment['payments'] = {
                    cash: {
                        coa: this.detail_cash_coa,
                        amount: numeral().unformat(this.detail_cash_pay)
                    },
                    bank: {
                        coa: this.detail_bank_coa,
                        bank_name: this.detail_bank_bank_name,
                        amount: numeral().unformat(this.detail_bank_pay)
                    }
                };
                console.log(payment.payments);
                let ars = _.find(this.ars,{id: parseInt(this.detail_ar.id)});
                let index = _.findIndex(this.ars,{ id: parseInt(this.detail_ar.id)});
                ars.checked = true;
                ars.payamount = payment.payments.cash.amount + payment.payments.bank.amount
                this.invoice_ars.push(payment);
                this.$set(this.ars,index,ars);
                this.dismissModal()
            },
            updatePaymentDetail(){
                let payment = this.detail_ar;
                payment['payments'] = {
                    cash: {
                        coa: this.detail_cash_coa,
                        amount: numeral().unformat(this.detail_cash_pay)
                    },
                    bank: {
                        coa: this.detail_bank_coa,
                        bank_name: this.detail_bank_bank_name,
                        amount: numeral().unformat(this.detail_bank_pay)
                    }
                };
                let ars
                let index
                if(this.mode == "edit"){
                     ars = _.find(this.ars,{id: parseInt(this.detail_ar.ars_id)});
                     index = _.findIndex(this.ars,{ id: parseInt(this.detail_ar.ars_id)});
                } else {
                    ars = _.find(this.ars,{id: parseInt(this.detail_ar.id)});
                    index = _.findIndex(this.ars,{ id: parseInt(this.detail_ar.id)});
                }
                ars.checked = true;
                ars.payamount = payment.payments.cash.amount + payment.payments.bank.amount
                payment.payamount = ars.payamount
                console.log(payment.payments.cash.amount);
                let index_invoice_ars = _.findIndex(this.invoice_ars,{id: parseInt(this.detail_ar.id)});
                this.invoice_ars[index_invoice_ars] = payment

                this.$set(this.ars,index,ars);
                this.dismissModal()

            },
            clearPaymentDetail(){
                let index_invoice_ars = _.findIndex(this.invoice_ars,{id: parseInt(this.detail_ar.id)});
                // remove at index_invoice_ars
                this.invoice_ars.splice(index_invoice_ars,1);
                let ars = _.find(this.ars,{id: parseInt(this.detail_ar.id)});
                let index = _.findIndex(this.ars,{ id: parseInt(this.detail_ar.id)});

                ars.checked = false;
                ars.payamount = 0;
                this.$set(this.ars,index,ars);
                this.dismissModal()
                this.detail_ar = {}
                this.detail_cash_pay = 0;
                this.detail_cash_coa = "";
                this.detail_bank_pay = 0;
                this.detail_bank_coa = "";
                this.detail_bank_bank_name = "";
            },
            saveInvoice(){
                // save header and detail to api

                let invoice = {
                    invoice_auto: this.invoice_auto,
                    invoice_customer: this.invoice_customer,
                    invoice_date: this.invoice_date,
                    invoice_ref_no: this.invoice_ref_no,
                    invoice_check_no: this.invoice_check_no,
                    total_pay: this.total_pay_amount,
                    discount: 0,
                    total_invoice: this.total_invoice,
                    ars: this.invoice_ars
                };

                console.log(invoice);

                $('#'+this.loading_id).modal('toggle');
                Axios.post('/admin-api/payar',invoice)
                .then((res) => {
                    $('#'+this.loading_id).modal('toggle');
                    swal({
                      title: "Input Berhasil!",
                      type: "success",
                      timer: 1000
                    });
                    $('.tableapi').DataTable().ajax.reload();
                    window.location.href="#formtable";
                    this.toInsertMode()
                }).
                catch((res) => {
                    $('#'+this.loading_id).modal('toggle');
                    swal({
                      title: "Oops!",
                      text: "Transaksi gagal, periksa kembali input",
                      type: "error",
                      timer: 1000
                    });
                    this.toInsertMode()
                })
            },
            fetchInvoiceData(id){
                Axios.get('/admin-api/payar/'+id)
                .then((res) => {
                    this.invoice_date = res.data.mhpayardate
                    this.invoice_ref_no = res.data.mhpayarrefno
                    this.invoice_check_no = res.data.mhpayarcheckno
                    this.invoice_no = res.data.mhpayarno
                    let customer_id = _.find(this.customers,{mcustomerid: res.data.mhpayarcustomerno}).id;
                    this.invoice_customer = customer_id
                    console.log('firts');
                    this.fetchDetailData(res.data.mhpayarno);
                })
                .catch((res) => {
                    console.log('errx');
                    console.log(res);
                })
            },
            fetchDetailData(invoice_no){
                console.log('detail');
                Axios.get('/admin-api/payar/details/'+invoice_no)
                .then((res) => {
                    $('#'+this.loading_id).modal('toggle');
                    this.invoice_ars = [];
                    for(let i=0;i<res.data.length;i++){
                        if(res.data[i].void == 0){
                            res.data[i].payamount = res.data[i].mdpayarinvoicepayamount;
                            res.data[i].marcarddate = res.data[i].mdpayarinvoicedate;
                            res.data[i].marcardtotalinv = res.data[i].mdpayarinvoicetotal;
                            res.data[i].marcardoutstanding = res.data[i].mdpayarinvoiceoutstanding;
                            res.data[i].marcardtransno = res.data[i].mdpayartransno;
                            res.data[i].payments = {
                                cash: {
                                    amount: res.data[i].mdpayarcashamount,
                                    coa: res.data[i].mdpayarcashcoa
                                },
                                bank: {
                                    amount: res.data[i].mdpayarbankamount,
                                    bank_name: res.data[i].mdpayarbankbankname,
                                    coa: res.data[i].mdpayarbankcoa
                                }
                            };

                            let ar;
                            if(this.ars.length < 1){
                                setTimeout(() => {
                                    ar = _.find(this.ars,{ marcardtransno: res.data[i].marcardtransno});
                                    let index = _.findIndex(this.ars,{ marcardtransno: res.data[i].marcardtransno});
                                    console.log(index);
                                    console.log(res.data[i].marcardtransno);
                                    ar.checked = true;
                                    res.data[i].ars_id = ar.id
                                    ar.payamount = res.data[i].payamount;
                                    this.$set(this.ars,index,ar);

                                },1000);
                            } else {
                                ar = _.find(this.ars,{ marcardtransno: res.data[i].marcardtransno});
                                let index = _.findIndex(this.ars,{ marcardtransno: res.data[i].marcardtransno});
                                ar.checked = true;
                                res.data[i].ars_id = ar.id
                                ar.payamount = res.data[i].payamount;
                                this.$set(this.ars,index,ar);
                                this.$forceUpdate();
                            }
                            this.invoice_ars.push(res.data[i]);
                        }
                    }
                })
                .catch((res) => {
                    $('#'+this.loading_id).modal('toggle');
                    console.log('err detail');
                    console.log(res);
                });
            },
            updateInvoice(){
                // update header and detail to api

                let invoice = {
                    invoice_auto: this.invoice_auto,
                    invoice_customer: this.invoice_customer,
                    invoice_date: this.invoice_date,
                    invoice_ref_no: this.invoice_ref_no,
                    invoice_check_no: this.invoice_check_no,
                    total_pay: this.total_pay_amount,
                    discount: 0,
                    total_invoice: this.total_invoice,
                    ars: this.invoice_ars
                };

                console.log(invoice);

                $('#'+this.loading_id).modal('toggle');
                Axios.put('/admin-api/payar/'+this.editinvoiceid,invoice)
                .then((res) => {
                    $('#'+this.loading_id).modal('toggle');
                    swal({
                      title: "Update Berhasil!",
                      type: "success",
                      timer: 1000
                    });
                    $('.tableapi').DataTable().ajax.reload();
                    window.location.href="#formtable";
                    this.toInsertMode()
                })
                .catch((res) => {
                    $('#'+this.loading_id).modal('toggle');
                    swal({
                      title: "Oops!",
                      text: "Transaksi gagal, periksa kembali input",
                      type: "error",
                      timer: 1000
                    });
                    this.toInsertMode()
                })
            },
            resetChecked(){
                for(let i=0;i<this.ars.length;i++){
                    this.ars[i].checked = false;
                }
                console.log('reset checked');
            }
        },
        watch:{
            invoice_customer(){
                if(this.mode == "insert"){
                    $('#'+this.loading_id).modal('toggle');
                }
                this.fetchCustomerAR()
            }
        },
        created(){
            this.fetchCash()
            this.fetchBanks()
            this.fetchCustomers()
            if(this.mode == "edit"){
                this.$parent.$on('edit-selected',(id) => {
                console.log(id+"edit");
                this.resetChecked();
                this.editinvoiceid = id;
                $('#'+this.loading_id).modal('toggle');
                this.fetchInvoiceData(id);
              });
            }
            if(this.mode == "view"){
                this.$parent.$on('view-selected',(id) => {
                    console.log(id+" view");
                    this.resetChecked();
                    this.editinvoiceid = id;
                    $('#'+this.loading_id).modal('toggle');
                    this.fetchInvoiceData(id);
              });
            }
        }
    }
</script>
