<template>
  <div>
    <div class="row" v-show="mode != 'insert'" v-on:click="toInsertMode">
        <button class="btn btn-default pull-right" style="margin-right:4%">Kembali</button>
    </div>
    <div class="row">
      <div class="form form-horizontal" style="margin-top:20px">
        <div class="col-md-8">
          <div class="form-group">
            <label class="col-md-2 control-label">Customer</label>
            <div class="col-md-8">
              <select id="select_customer" v-bind:disabled="disable_customer" v-selecttwo="customer_label" v-model="invoice_customer">
                <option></option>
                <option v-for="sp in customers" :value="sp.id">{{ sp.mcustomername }}</option>
              </select>
              <label v-if="supplier_alert" style="color:rgb(212, 103, 82)!important">Supplier tidak bisa kosong</label>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Bank</label>
            <div class="col-md-8">
              <select id="select_supplier" v-bind:disabled="disable_bank" v-selecttwo="bank_label" v-model="invoice_bank">
                <option></option>
                <option v-for="bank in banks" :value="bank.id">{{ bank.mcoaname }}</option>
              </select>
              <label v-if="bank_alert" style="color:rgb(212, 103, 82)!important">Supplier tidak bisa kosong</label>
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
                <option>Pembayaran Piutang Penjualan</option>
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
            <div class="col-md-6">
              <select v-bind:disabled="!notview" class="form-control" id="insert-selectaps" v-selecttwo="ar_label" v-model="selected_ars">
                  <option></option>
                <option v-for="ar in ars" :value="ar.id">{{ ar.marcardtransno }} <span v-priceformatlabel="num_format">{{ ar.marcardoutstanding }}</span></option>
              </select>
            </div>
            <div class="col-md-6">
              <button v-if="this.mode == 'insert'" class="pull-right btn btn-primary" v-on:click="saveInvoice">Proses</button>
              <button v-if="this.mode == 'edit'" class="pull-right btn btn-primary" v-on:click="updateInvoice">Proses Update</button>
            </div>
          </div>
          <div class="row">
            <br><br>
            <table id="insertdetailtable" class="table table-bordered">
              <thead>
                <tr>
                  <th style="width:10%;">No Faktur</th>
                  <th style="width:45%;">Tanggal</th>
                  <th style="width:10%;">Total</th>
                  <th style="width:10%;">Terhutang</th>
                  <th style="width:10%;">Bayar</th>
                  <th style="width:10%;">Diskon</th>
                  <th v-if="notview" style="width:10%;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in invoice_ars">
                  <td>{{ item.marcardtransno }}</td>
                  <td>{{ item.marcarddate }}</td>
                  <td v-priceformatlabel="num_format">{{ item.marcardtotalinv }}</td>
                  <td v-priceformatlabel="num_format">{{ item.marcardoutstanding }}</td>
                  <td v-priceformatlabel="num_format">{{ item.payamount }}</td>
                  <td>0</td>
                  <td v-if="notview"><a v-on:click="editArs(item.id)"><span style="color:lightblue">Edit</span></a> <a v-on:click="removeArs(item.id)"><span style="color:red">Hapus</span></a></td>
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
    <div v-bind:id="modal_id" class="modal" style="top: 15%;" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="text-align: center">
            <h4>Detail Hutang</h4>
                </div>
          <div class="modal-body">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" v-bind:href="htab1_id">Detail Hutang</a></li>
              <li><a data-toggle="tab" v-bind:href="htab2_id">Keterangan</a></li>
            </ul>
            <div class="tab-content">
              <div v-bind:id="tab1_id" class="tab-pane fade in active">
                <div class="form form-horizontal" style="margin-top:10px;">
                    <div class="form-group">
                      <label class="control-label col-md-2">No Invoice</label>
                      <div class="col-md-8">
                        <input class="form-control forminput" disabled type="text" v-model="detail_ar.marcardtransno"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2">Total</label>
                      <div class="col-md-8">
                        <input class="form-control forminput" disabled type="text" v-model="detail_ar.marcardtotalinv" v-priceformat="num_format" style="text-align:right" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2">Terhutang</label>
                      <div class="col-md-8">
                        <input class="form-control forminput" disabled type="text" v-model="detail_ar.marcardoutstanding" v-priceformat="num_format" style="text-align:right"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2">Bayar</label>
                      <div class="col-md-8">
                        <input class="form-control forminput" v-bind:id="pay_id" type="text" v-model="detail_pay" v-priceformatsatuan="num_format" style="text-align:right"/>
                      </div>
                    </div>
                </div>
              </div>
              <div v-bind:id="tab2_id" class="tab-pane">
                <div class="form form-horizontal" style="margin-top:10px;">
                  <div class="form-group">
                    <label class="control-label col-md-2">Keterangan</label>
                    <div class="col-md-8">
                      <textarea class="form-control" placeholder="Keterangan" v-model="ap_remark"></textarea>
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
                    <button v-if="detail_state == 'insert'" type="button" class="btn btn-primary" v-on:click="addToARS">
                          Lanjut
                    </button>
            <button v-if="detail_state == 'edit'" type="button" class="btn btn-primary" v-on:click="updateDetail">
                          Simpan
                    </button>
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
        props: ['mode'],
        data(){
            return {
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
                supplier_alert: false,
                disable_bank: false,
                bank_alert: false,
                detail_ar:{},
                detail_state:"",
                detail_pay:0,
                selected_ars:"",
                ap_remark:"",
                edit_index:0,
                ars:[],
                customers:[],
                banks:[],
                num_format:"0,0.00"
            }
        },
        computed:{
            customer_label(){
                return "Pilih Customer"
            },
            ar_label(){
                return "Pilih Invoice"
            },
            bank_label(){
                return "Pilih Akun Bank"
            },
            notview(){
                return this.mode != "view";
            },
            transaksi_label(){},
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
            modal_id(){
                return this.mode+"_modal";
            },
            loading_id(){
                return this.mode+"_loading_modal";
            },
            pay_id(){
                return this.mode+"_pay";
            },
            total_invoice(){
                let amount=0;
                for(let i=0;i<this.invoice_ars.length;i++){
                    amount += parseInt(this.invoice_ars[i].marcardoutstanding);
                }
                return amount;
            },
            total_pay_amount(){
                let amount=0;
                for(let i=0;i<this.invoice_ars.length;i++){
                    amount += parseInt(this.invoice_ars[i].payamount);
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
            fetchInvoiceData(id){
                let self = this;
                Axios.get('/admin-api/payar/'+id)
                .then((res) => {
                    let cust = _.find(this.customers, { id: res.data.customer_id});
                    self.invoice_customer = cust.id+"";
                    self.invoice_bank = ""+res.data.mhpayarbank;
                    self.invoice_date = moment(res.data.mhpayardate).format('L');
                    this.fetchDetailData(res.data.mhpayarno);
                })
            },
            fetchDetailData(invoice_no){
                Axios.get('/admin-api/payar/details/'+invoice_no)
                .then((res) => {
                    this.invoice_ars = [];
                    for(let i=0;i<res.data.length;i++){
                        res.data[i].payamount = res.data[i].mdpayarinvoicepayamount;
                        res.data[i].marcarddate = res.data[i].mdpayarinvoicedate;
                        res.data[i].marcardtotalinv = res.data[i].mdpayarinvoicetotal;
                        res.data[i].marcardoutstanding = res.data[i].mdpayarinvoiceoutstanding;
                        res.data[i].marcardtransno = res.data[i].mdpayartransno;
                        this.invoice_ars.push(res.data[i]);
                    }
                });
            },
            fetchCustomers(){
                Axios.get('/admin-api/pelanggan/datalist').then((res) => {
                    this.customers = res.data;
                });
            },
            fetchArs(){
                Axios.get('/admin-api/ardata?spl=').then((res) => {
                    this.ars = res.data;
                });
            },
            fetchBanks(){
                Axios.get('/admin-api/coadata').then((res) => {
                    this.banks = res.data;
                });
            },
            detailAP(){
                this.detail_state = "insert";
                if(this.selected_ars != "" || this.selected_ars != '-'){
                  this.canAddSingle(this.selected_ars);
                }
            },
            canAddSingle(idx){
              var already = _.find(this.invoice_ars,{id: parseInt(idx)});
              if(already == undefined){
                  this.fetchARSingle(idx);
              } else {
                swal({
                  title: "Oops!",
                  text: "Item sudah di tambahkan. Klik edit untuk merubah",
                  type: "error",
                  timer: 1000
                });
              }

            },
            fetchARSingle(id){
                this.detail_ar = _.find(this.ars,{ id: parseInt(this.selected_ars)});
                $('#'+this.modal_id).modal('toggle');
                this.detail_state = "insert";
                let self = this;
                setTimeout(function () { $('#'+self.pay_id).select(); }, 1);
            },
            addToARS(){
                let proceed = this.checkFields();

                if(proceed){
                    let newAR = this.detail_ar;
                    newAR.payamount = numeral().unformat(this.detail_pay);
                    this.invoice_ars.push(newAR);
                    this.resetDetail();
                    this.dismissModal();
                } else {
                    this.dismissModal();
                }
            },
            editArs(id){
                this.detail_ar = _.find(this.invoice_ars,{ id: parseInt(id)});
                this.detail_state = "edit";
                this.edit_index = _.indexOf(this.invoice_ars,this.detail_ar);
                $('#'+this.modal_id).modal('toggle');
                this.detail_pay = this.detail_ar.payamount;
                let self = this;
                setTimeout(function () { $('#'+self.pay_id).select(); console.log('#'+self.pay_id); }, 1);
            },
            updateDetail(id){
                let editedArs = this.detail_ar;
                editedArs.payamount = numeral().unformat(this.detail_pay);
                Vue.set(this.invoice_ars,this.edit_index,editedArs);
                this.dismissModal();
            },
            removeArs(idx){
                let ap = _.find(this.invoice_ars,  {id: parseInt(idx)});
                this.invoice_ars = this.invoice_ars.filter( (a) => {
                    return a.id !== idx
                });
            },
            resetDetail(){
                this.detail_pay = 0;
            },
            saveInvoice(){
                let invoice_data = {
                    invoice_auto : this.invoice_auto,
                    invoice_customer : this.invoice_customer,
                    invoice_bank : this.invoice_bank,
                    invoice_date: this.invoice_date,
                    invoice_ref_no: this.invoice_ref_no,
                    invoice_check_no: this.invoice_check_no,
                    total_pay: this.total_pay_amount,
                    total_invoice: this.total_invoice,
                    over_pay: this.lebih_bayar,
                    discount: 0,
                    ars: this.invoice_ars
                }
                $('#'+this.loading_id).modal('toggle');
                console.log(invoice_data);
                Axios.post('/admin-api/payar',invoice_data)
                .then((res) => {
                    $('#'+this.loading_id).modal('toggle');
                    swal({
                      title: "Input Berhasil!",
                      type: "success",
                      timer: 1000
                    });
                    this.resetInvoice();
                    this.fetchArs();
                    $('.tableapi').DataTable().ajax.reload();
                    window.location.href="#formtable";
                })
                .catch((err) => {
                    $('#'+this.loading_id).modal('toggle');
                    console.log(err);
                    swal({
                      title: "Oops!",
                      text: "Transaksi gagal, periksa kembali input",
                      type: "error",
                      timer: 1000
                    });
                });
            },
            updateInvoice(){
                let invoice_data = {
                    invoice_auto : this.invoice_auto,
                    invoice_customer : this.invoice_customer,
                    invoice_bank : this.invoice_bank,
                    invoice_date: this.invoice_date,
                    invoice_ref_no: this.invoice_ref_no,
                    invoice_check_no: this.invoice_check_no,
                    total_pay: this.total_pay_amount,
                    total_invoice: this.total_invoice,
                    over_pay: this.lebih_bayar,
                    discount: 0,
                    ars: this.invoice_ars
                }
                $('#'+this.loading_id).modal('toggle');
                console.log(invoice_data);
                Axios.put('/admin-api/payar/'+this.editinvoiceid,invoice_data)
                .then((res) => {
                    $('#'+this.loading_id).modal('toggle');
                    swal({
                      title: "Input Berhasil!",
                      type: "success",
                      timer: 1000
                    });
                    this.resetInvoice();
                    this.fetchArs();
                    $('.tableapi').DataTable().ajax.reload();
                    window.location.href="#formtable";
                })
                .catch((err) => {
                    $('#'+this.loading_id).modal('toggle');
                    swal({
                      title: "Oops!",
                      text: "Transaksi gagal, periksa kembali input",
                      type: "error",
                      timer: 1000
                    });
                });
            },
            dismissModal(){
                $('#'+this.modal_id).modal('toggle');
                this.selected_ars = "-";
            },
            resetInvoice(){
                this.invoice_no = "";
                this.invoice_supplier = {};
                this.invoice_bank = {};
                this.invoice_check_no = "";
                this.invoice_ref_no = "";
                this.invoice_date = moment().format('L');
                this.invoice_pay_amount = 0;
                this.invoice_type = "Pembarayan Piutang Penjualan";
                this.invoice_ars = [];
                this.disable_supplier =  false;
                this.supplier_alert =  false;
                this.disable_bank =  false;
                this.bank_alert =  false;
                this.detail_ar = {};
                this.detail_state = "insert";
            },
            checkFields(){
                let data_message = "Field"
                let need_alert = false;
                if(typeof(this.invoice_customer) == 'object' || this.invoice_customer == ""){
                    data_message += " Customer";
                    need_alert = true;
                }
                if(typeof(this.invoice_bank) == 'object' || this.invoice_bank == ""){
                    need_alert = true;
                    if(typeof(this.invoice_supplier) == 'object'){
                        data_message += " & Bank";
                    } else {
                        data_message += " Bank";
                    }
                }
                data_message += " harus di isi."
                if(need_alert){
                    swal({
                      title: "Oops!",
                      text: data_message,
                      type: "error",
                      timer: 1000
                    });
                    return false;
                } else {
                    return true;
                }
            },
            toInsertMode(){
                this.resetDetail();
                this.resetInvoice();
                $('#forminput').show();
        		$('#formview').hide();
        		$('#formedit').hide();
                window.location.href = '#forminput';
            }
        },
        watch:{
            selected_ars(){
                if(this.selected_ars != '-' && this.selected_ars != ''){
                    console.log('proceed');
                    this.detailAP();
                }
            },
        },
        mounted(){
            this.fetchCustomers();
            this.fetchArs();
            this.fetchBanks();

            this.$parent.$on('refresh-pay',() => {
                
            });

            if(this.mode == "edit"){
              this.$parent.$on('edit-selected',(id) => {
                  console.log(id+"edit");
                this.editinvoiceid = id;
                this.fetchInvoiceData(id);
              });
            }
            if(this.mode == "view"){
              this.$parent.$on('edit-selected',(id) => {
                  console.log(id+"view");
                this.disable_supplier = true;
                this.disable_bank = true;
                this.editinvoiceid = id;
                this.fetchInvoiceData(id);
              });
            }
        }
    }

</script>
