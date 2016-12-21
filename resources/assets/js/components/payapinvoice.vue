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
            <div class="col-md-6">
              <select v-bind:disabled="!notview" class="form-control" id="insert-selectaps" v-selecttwo="ap_label" v-model="selected_aps">
                  <option></option>
                <option v-for="ap in aps" :value="ap.id">{{ ap.mapcardtransno }} <span v-priceformatlabel="num_format">{{ ap.mapcardoutstanding }}</span></option>
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
                <tr v-for="item in invoice_aps">
                  <td>{{ item.mapcardtransno }}</td>
                  <td>{{ item.mapcardtdate }}</td>
                  <td v-priceformatlabel="num_format">{{ item.mapcardtotalinv }}</td>
                  <td v-priceformatlabel="num_format">{{ item.mapcardoutstanding }}</td>
                  <td v-priceformatlabel="num_format">{{ item.payamount }}</td>
                  <td>0</td>
                  <td v-if="notview"><a v-on:click="editAps(item.id)"><span style="color:lightblue">Edit</span></a> <a v-on:click="removeAps(item.id)"><span style="color:red">Hapus</span></a></td>
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
                        <input class="form-control forminput" disabled type="text" v-model="detail_ap.mapcardtransno"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2">Total</label>
                      <div class="col-md-8">
                        <input class="form-control forminput" disabled type="text" v-model="detail_ap.mapcardtotalinv" v-priceformat="num_format" style="text-align:right" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-2">Terhutang</label>
                      <div class="col-md-8">
                        <input class="form-control forminput" disabled type="text" v-model="detail_ap.mapcardoutstanding" v-priceformat="num_format" style="text-align:right"/>
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
                    <button v-if="detail_state == 'insert'" type="button" class="btn btn-primary" v-on:click="addToAPS">
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
                selected_aps:"",
                ap_remark:"",
                edit_index:0,
                aps:[],
                suppliers:[],
                banks:[],
                num_format:"0,0.00"
            }
        },
        computed:{
            supplier_label(){
                return "Pilih Supplier"
            },
            ap_label(){
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
                for(let i=0;i<this.invoice_aps.length;i++){
                    amount += parseInt(this.invoice_aps[i].mapcardoutstanding);
                }
                return amount;
            },
            total_pay_amount(){
                let amount=0;
                for(let i=0;i<this.invoice_aps.length;i++){
                    amount += parseInt(this.invoice_aps[i].payamount);
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
                Axios.get('/admin-api/payap/'+id)
                .then((res) => {
                    let spl = _.find(this.suppliers, { id: res.data.supplier_id});
                    self.invoice_supplier = spl.id+"";
                    self.invoice_bank = ""+res.data.mhpayapbank;
                    self.invoice_date = moment(res.data.mhpayapdate).format('L');
                    this.fetchDetailData(res.data.mhpayapno);
                })
            },
            fetchDetailData(invoice_no){
                Axios.get('/admin-api/payap/details/'+invoice_no)
                .then((res) => {
                    this.invoice_aps = [];
                    for(let i=0;i<res.data.length;i++){
                        res.data[i].payamount = res.data[i].mdpayapinvoicepayamount;
                        res.data[i].mapcardtdate = res.data[i].mdpayapinvoicedate;
                        res.data[i].mapcardtotalinv = res.data[i].mdpayapinvoicetotal;
                        res.data[i].mapcardoutstanding = res.data[i].mdpayapinvoiceoutstanding;
                        res.data[i].mapcardtransno = res.data[i].mdpayaptransno;
                        this.invoice_aps.push(res.data[i]);
                    }
                });
            },
            fetchSuppliers(){
                Axios.get('/admin-api/msupplier/datalist').then((res) => {
                    this.suppliers = res.data;
                });
            },
            fetchAps(){
                Axios.get('/admin-api/apdata').then((res) => {
                    this.aps = res.data;
                });
            },
            fetchBanks(){
                Axios.get('/admin-api/coadata').then((res) => {
                    this.banks = res.data;
                });
            },
            detailAP(){
                this.detail_state = "insert";
                if(this.selected_aps != "" || this.selected_aps != '-'){
                  this.canAddSingle(this.selected_aps);
                }
            },
            canAddSingle(idx){
              var already = _.find(this.invoice_aps,{id: parseInt(idx)});
              if(already == undefined){
                  this.fetchAPSingle(idx);
              } else {
                swal({
                  title: "Oops!",
                  text: "Item sudah di tambahkan. Klik edit untuk merubah",
                  type: "error",
                  timer: 1000
                });
              }

            },
            fetchAPSingle(id){
                this.detail_ap = _.find(this.aps,{ id: parseInt(this.selected_aps)});
                $('#'+this.modal_id).modal('toggle');
                this.detail_state = "insert";
                let self = this;
                setTimeout(function () { $('#'+self.pay_id).select(); }, 1);
            },
            addToAPS(){
                let proceed = this.checkFields();

                if(proceed){
                    let newAP = this.detail_ap;
                    newAP.payamount = numeral().unformat(this.detail_pay);
                    this.invoice_aps.push(newAP);
                    this.resetDetail();
                    this.dismissModal();
                } else {
                    this.dismissModal();
                }
            },
            editAps(id){
                this.detail_ap = _.find(this.invoice_aps,{ id: parseInt(id)});
                this.detail_state = "edit";
                this.edit_index = _.indexOf(this.invoice_aps,this.detail_ap);
                $('#'+this.modal_id).modal('toggle');
                this.detail_pay = this.detail_ap.payamount;
                let self = this;
                setTimeout(function () { $('#'+self.pay_id).select(); console.log('#'+self.pay_id); }, 1);
            },
            updateDetail(id){
                let editedAps = this.detail_ap;
                editedAps.payamount = numeral().unformat(this.detail_pay);
                Vue.set(this.invoice_aps,this.edit_index,editedAps);
                this.dismissModal();
            },
            removeAps(idx){
                let ap = _.find(this.invoice_aps,  {id: parseInt(idx)});
                this.invoice_aps = this.invoice_aps.filter( (a) => {
                    return a.id !== idx
                });
            },
            resetDetail(){
                this.detail_pay = 0;
            },
            toInsertMode(){},
            saveInvoice(){
                let invoice_data = {
                    invoice_auto : this.invoice_auto,
                    invoice_supplier : this.invoice_supplier,
                    invoice_bank : this.invoice_bank,
                    invoice_date: this.invoice_date,
                    invoice_ref_no: this.invoice_ref_no,
                    invoice_check_no: this.invoice_check_no,
                    total_pay: this.total_pay_amount,
                    total_invoice: this.total_invoice,
                    over_pay: this.lebih_bayar,
                    discount: 0,
                    aps: this.invoice_aps
                }
                $('#'+this.loading_id).modal('toggle');
                console.log(invoice_data);
                Axios.post('/admin-api/payap',invoice_data)
                .then((res) => {
                    $('#'+this.loading_id).modal('toggle');
                    swal({
                      title: "Input Berhasil!",
                      type: "success",
                      timer: 1000
                    });
                    this.resetInvoice();
                    this.fetchAps();
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
            updateInvoice(){
                let invoice_data = {
                    invoice_auto : this.invoice_auto,
                    invoice_supplier : this.invoice_supplier,
                    invoice_bank : this.invoice_bank,
                    invoice_date: this.invoice_date,
                    invoice_ref_no: this.invoice_ref_no,
                    invoice_check_no: this.invoice_check_no,
                    total_pay: this.total_pay_amount,
                    total_invoice: this.total_invoice,
                    over_pay: this.lebih_bayar,
                    discount: 0,
                    aps: this.invoice_aps
                }
                $('#'+this.loading_id).modal('toggle');
                console.log(invoice_data);
                Axios.put('/admin-api/payap/'+this.editinvoiceid,invoice_data)
                .then((res) => {
                    $('#'+this.loading_id).modal('toggle');
                    swal({
                      title: "Input Berhasil!",
                      type: "success",
                      timer: 1000
                    });
                    this.resetInvoice();
                    this.fetchAps();
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
                this.selected_aps = "-";
            },
            resetInvoice(){
                this.invoice_no = "";
                this.invoice_supplier = {};
                this.invoice_bank = {};
                this.invoice_check_no = "";
                this.invoice_ref_no = "";
                this.invoice_date = moment().format('L');
                this.invoice_pay_amount = 0;
                this.invoice_type = "Pembarayan Hutang";
                this.invoice_aps = [];
                this.disable_supplier =  false;
                this.supplier_alert =  false;
                this.disable_bank =  false;
                this.bank_alert =  false;
                this.detail_ap = {};
                this.detail_state = "insert";
            },
            checkFields(){
                let data_message = "Field"
                let need_alert = false;
                if(typeof(this.invoice_supplier) == 'object' || this.invoice_supplier == ""){
                    data_message += " Supplier";
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
            }
        },
        watch:{
            selected_aps(){
                if(this.selected_aps != '-' && this.selected_aps != ''){
                    console.log('proceed');
                    this.detailAP();
                }
            },
        },
        mounted(){
            this.fetchSuppliers();
            this.fetchAps();
            this.fetchBanks();
            if(this.mode == "edit"){
              this.$parent.$on('edit-selected',(id) => {
                  console.log(id+"edit");
                this.editinvoiceid = id;
                this.fetchInvoiceData(id);
              });
            }
        }
    }

</script>
