<template>
    <div>
        <div class="row" v-show="mode != 'insert'" v-on:click="toInsertMode">
            <button class="btn btn-default pull-right" style="margin-right:4%">Kembali</button>
        </div>
        <br>
        <div class="row form form-horizontal">
            <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-2 control-label">Dari Akun</label>
                  <div class="col-md-10">
                      <select v-bind:id="from_account_id" v-selecttwo="account_label" v-model="from_account" class="col-md-10 form-control" v-bind:disabled="disable_from">
                          <option></option>
                          <option v-if="cashtype == 'income' || cashtype == 'transfer'" v-for="cb in accounts" :value="cb.mcoacode">{{ cb.mcoacode }} - {{ cb.mcoaname }}</option>
                          <option v-if="cashtype == 'outcome'" v-for="cb in cashbankaccounts" :value="cb.mcoacode">{{ cb.mcoacode }} - {{ cb.mcoaname }}</option>
                      </select>
                      <label style="color: #0288D1" v-if="cashtype == 'income'">Debit</label><br>
                      <label style="color: #0288D1" v-if="cashtype != 'income'">Kredit</label><br>
                      <label v-if="from_alert" style="color:rgb(212, 103, 82)!important">Akun ini tidak bisa kosong</label>
                  </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-2 control-label">No Jurnal</label>
                  <div class="col-md-10">
                    <input type="text" placeholder="Autogenerate" class="form-control" disabled="" v-model="transaction_no">
                  </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row form form-horizontal">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-2 control-label">Tanggal</label>
                  <div class="col-md-10">
                    <input type="text" v-dpicker class="col-md-8 form-control" v-model="transaction_date" v-bind:disabled="!notview">
                  </div>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row form form-horizontal">
            <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-12">
                      <select v-bind:disabled="!notview" v-bind:id="to_account_id" v-selecttwo="account_label" v-model="selected_detail_code" class="col-md-8 form-control">
                          <option></option>
                          <option v-for="cb in accounts" :value="cb.mcoacode">{{cb.mcoacode }} - {{ cb.mcoaname }}</option>
                      </select>
                      <label style="color: #0288D1" v-if="cashtype == 'income'">Kredit</label><br>
                      <label style="color: #0288D1" v-if="cashtype != 'income'">Debit</label><br>
                  </div>
                </div>
            </div>
            <div class="col-md-6">
                <button v-if="mode == 'insert'" class="btn btn-primary pull-right" v-on:click="saveTransaction">Proses</button>
                <button v-if="mode == 'edit'" class="btn btn-primary pull-right" v-on:click="updateTransaction">Update</button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width:10%;">Tanggal</th>
                      <th style="width:10%;">Dari Akun</th>
                      <th style="width:10%;">Ke Akun</th>
                      <th style="width:10%;">Jumlah</th>
                      <th style="width:15%;">Keterangan</th>
                      <th v-if="notview" style="width:10%;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in transaction_items">
                        <td>{{ transaction_date }}</td>
                        <td>{{ transaction_from_account.mcoacode }} / {{ transaction_from_account.mcoaname }}</td>
                        <td>{{ item.mcoacode }} / {{ item.mcoaname }}</td>
                        <td>{{ item.amount }}</td>
                        <td>{{ item.description }}</td>
                        <td v-if="notview"><a v-on:click="editItem(item.id)"><span style="color:lightblue">Edit</span></a> <a v-on:click="deleteTransactionItem(item.id)"><span style="color:red">Hapus</span></a></td>
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
        <br>
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
                        <h4 v-if="cashtype == 'income'">Penerimaan Kas/Bank</h4>
                        <h4 v-if="cashtype == 'outcome'">Pengeluaran Kas/Bank</h4>
                        <h4 v-if="cashtype == 'transfer'">Transfer Kas/Bank</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-md-2">Ke Akun</label>
                                <div class="col-md-8">
                                    <select v-bind:id="detail_account_id" v-bind:disabled="disable_detail_account_id" v-selecttwo="account_label" v-model="detail_coa" class="form-control">
                                        <option></option>
                                        <option v-if="cashtype == 'income'" v-for="cb in cashbankaccounts" :value="cb.mcoacode">{{ cb.mcoaname }}</option>
                                        <option v-if="cashtype == 'outcome' || cashtype == 'transfer'" v-for="cb in accounts" :value="cb.mcoacode">{{ cb.mcoaname }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Jumlah</label>
                                <div class="col-md-8">
                                    <input autofocus v-bind:id="amount_id" class="form-control forminput" type="text" v-model="transaction_detail.amount" v-priceformatcash="num_format" style="text-align:right"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Pajak (jika ada)</label>
                                <div class="col-md-8">
                                    <input class="form-control forminput" type="text" v-model="transaction_detail.tax" v-priceformattax="num_format" style="text-align:right"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Departement (opsional)</label>
                                <div class="col-md-8">
                                    <select class="form-control" type="text" v-model="selected_department" v-selecttwo="department_label" v-bind:id="department_id">
                                        <option></option>
                                        <option v-for="d in departments" :value="d.id">{{ d.departement_name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Keterangan</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" v-model="transaction_detail.description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button v-on:click="dismissModal" type="button" class="btn btn-default" data-dismiss="modal">
                            Cancel
                        </button>
                        <button v-if="detail_state == 'insert'" type="button" class="btn btn-primary" v-on:click="addToTransaction">
                            Lanjut
                        </button>
                        <button v-if="detail_state == 'edit'" type="button" class="btn btn-primary" v-on:click="updateTransactionItem">
                            Simpan
                        </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios'
    import moment from 'moment'
    import _ from 'lodash'
    import swal from 'sweetalert'
    export default {
        props:['mode','cashtype'],
        data(){
            return {
                edittransactionid:"",
                cashbankaccounts:[],
                accounts:[],
                transaction_no:"",
                from_account:"",
                transaction_date: moment().format('L'),
                selected_detail_code:"",
                detail_state:"",
                transaction_from_account:{},
                transaction_items:[],
                transaction_detail:{
                    id: "",
                    mcoacode:"",
                    mcoaname:"",
                    amount: "",
                    date: "",
                    description:"",
                    tax: "",
                    department: 0
                },
                detail_coa:"",
                num_format:"0,0",
                disable_from: false,
                disable_detail_account_id: false,
                from_alert: false,
                tax_index: -1,
                departments: [],
                selected_department:0
            }
        },
        computed: {
            department_id(){
              return this.mode+"_departments";
            },
            department_label(){
                return "pilih departmen (opsional)";
            },
            notview(){
                return this.mode != "view"
            },
            account_label(){
                return "Pilih Akun"
            },
            loading_id(){
                return this.mode+"_loading"
            },
            modal_id(){
                return this.mode+"_modal_detail"
            },
            to_account_id(){
                return this.mode+"_to_account"
            },
            from_account_id(){
                return this.mode+"_from_account"
            },
            detail_account_id(){
                return this.mode+"_detail_account"
            },
            amount_id(){
                return this.mode+"_amount"
            },
            total_tax(){
              return _.sumBy(this.transaction_items, (item) => {
                 return item.tax;
              })
            }
        },
        methods: {
            fetchDepartments(){
                let url = '/admin-api/mdepartment/datalist';
                Axios.get(url).then((res) => {
                    this.departments = res.data;
                });
            },
            fetchBanks(){

                let url = '/admin-api/coadata'

                Axios.get(url).then((res) => {
                    this.cashbankaccounts = res.data;
                });
            },
            fetchAllAccounts(){

                let url = '/admin-api/coadata/all'

                Axios.get(url).then((res) => {
                    this.accounts = res.data;
                });
            },
            dismissModal(){
                this.transaction_detail = {
                    mcoacode:"",
                    mcoaname:"",
                    to_account:{},
                    amount: 0,
                    description:""
                }
                this.selected_detail_code = ""
                $("#"+this.modal_id).modal('toggle')
                $("#"+this.to_account_id).val('')
                $("#"+this.to_account_id).trigger('change')
            },
            openDetail(){
                let to_acc = _.find(this.accounts,{ mcoacode: this.selected_detail_code})
                this.detail_coa = to_acc.mcoacode
                this.transaction_detail.mcoacode = to_acc.mcoacode
                this.transaction_detail.mcoaname = to_acc.mcoaname
                this.transaction_detail.date = this.transaction_date
                this.transaction_detail.id = to_acc.id
                this.transaction_detail.description = to_acc.description
                this.selected_department = to_acc.description;
                console.log('#'+this.department_id);
                $('#'+this.department_id).val(this.selected_department).trigger("change");
                let already_added = false;
                this.transaction_items.map( item => {
                  if(item.mcoacode == this.transaction_detail.mcoacode){
                    already_added = true
                  }
                })

                if(already_added){
                    swal({
                        title: "Oops!",
                        text: "Akun sudah di tambahkan",
                        type: "error",
                        timer: 1000
                    });
                } else {
                    console.log(to_acc.mcoacode);
                    $("#"+this.modal_id).modal('toggle')
                    $("#"+this.detail_account_id).val(to_acc.mcoacode)
                    $("#"+this.detail_account_id).trigger('change')
                    this.disable_detail_account_id = true
                    setTimeout(function () {
                        $('#'+this.amount_id).select();
                    }, 20);
                }
            },
            editItem(idx){
                this.detail_state = "edit"
                console.log(idx);
                let edit_acc = _.find(this.transaction_items,{ id: idx})
                this.transaction_detail.mcoacode = edit_acc.mcoacode
                this.transaction_detail.mcoaname = edit_acc.mcoaname
                this.transaction_detail.date = this.transaction_date
                this.transaction_detail.amount = edit_acc.amount
                this.transaction_detail.description = edit_acc.description
                this.transaction_detail.id = edit_acc.id
                this.selected_department = edit_acc.department;
                console.log(edit_acc.mcoacode);
                $("#"+this.modal_id).modal('toggle')
                $("#"+this.detail_account_id).val(edit_acc.mcoacode)
                $("#"+this.detail_account_id).trigger('change')
                this.transaction_detail.description = edit_acc.description
                this.selected_department = edit_acc.department;
                console.log('#'+this.department_id);
                $('#'+this.department_id).val(this.selected_department).trigger("change");
                this.disable_detail_account_id = false
                setTimeout(function () {
                    $('#'+this.amount_id).focus().select();
                    $("#"+this.detail_account_id).val(edit_acc.mcoacode)
                    $("#"+this.detail_account_id).trigger('change')
                }, 20);
            },
            addToTransaction(){
                if(this.from_account == ""){
                    swal({
                      title: "Oops!",
                      text: "Dari akun belum dipilih",
                      type: "error",
                      timer: 1000
                    });
                    this.from_alert = true
                } else {

                    this.transaction_detail.amount = numeral(this.transaction_detail.amount).format(this.num_format)
                    this.transaction_detail.tax = numeral(this.transaction_detail.tax).format(this.num_format)
                    this.transaction_detail.department = this.selected_department
                    if(this.transaction_detail.description == undefined){
                        this.transaction_detail.description = ""
                    }

                    let tax = numeral().unformat(this.transaction_detail.tax);
                    this.transaction_items.push(this.transaction_detail)
                    console.log('tax',tax);
                    if(tax != 0){
                      console.log('idx',this.tax_index);
                      if(this.tax_index == -1){
                        let tax_detail = {};
                        if(this.cashtype == 'income'){
                            tax_detail = {
                                id: "",
                                mcoacode:"2102.01",
                                mcoaname:"Hutang Pajak Penjualan (PPn Keluaran)",
                                amount: this.transaction_detail.tax,
                                date: this.transaction_detail.date,
                                description:"",
                                department: this.selected_department,
                                tax: ""
                            };
                        } else {
                            tax_detail = {
                                id: "",
                                mcoacode:"1107.01",
                                mcoaname:"Piutang Pajak Pembelian (PPn Masukan)",
                                amount: this.transaction_detail.tax,
                                date: this.transaction_detail.date,
                                description:"",
                                department: this.selected_department,
                                tax: ""
                            };
                        }

                        this.transaction_items.push(tax_detail)
                        this.tax_index = this.transaction_items.length -1;
                      } else {
                        console.log('pretax',this.transaction_items[this.tax_index].amount);
                        let pretax = numeral().unformat(this.transaction_items[this.tax_index].amount);
                        console.log('pretax',pretax);
                        tax += pretax;
                        console.log(tax);
                        let tax_detail = {
                            id: "",
                            mcoacode:"2102.01",
                            mcoaname:"Hutang Pajak Penjualan (PPn Keluaran)",
                            amount: numeral(tax).format(this.num_format),
                            date: this.transaction_detail.date,
                            description:"",
                            tax: ""
                        };
                        this.$set(this.transaction_items,this.tax_index,tax_detail);
                      }
                    }
                    this.disable_from = true
                }
                this.dismissModal()
            },
            updateTransactionItem(){
                let index = _.findIndex(this.transaction_items,{id: this.transaction_detail.id})
                // if(typeof this.transaction_detail.amount == 'string'){
                //     this.transaction_detail.amount = numeral().unformat(this.transaction_detail.amount)
                // }
                // if(typeof this.transaction_detail.tax == 'string'){
                //     this.transaction_detail.tax = numeral().unformat(this.transaction_detail.tax)
                // }
                this.transaction_detail.amount = numeral(this.transaction_detail.amount).format(this.num_format)
                this.transaction_detail.tax = numeral(this.transaction_detail.tax).format(this.num_format)
                this.transaction_detail.department = this.selected_department;
                this.$set(this.transaction_items,index,this.transaction_detail)
                this.dismissModal()
            },
            deleteTransactionItem(idx){
                let index = _.findIndex(this.transaction_items,{ id: idx})
                // this.transaction_items.splice(index,1)
                this.$delete(this.transaction_items,index);
            },
            saveTransaction(){
                let transaction_data = {
                    date: this.transaction_date,
                    from_account: this.transaction_from_account,
                    to_accounts: this.transaction_items
                }
                let action_url = ""
                if(this.cashtype == "income"){
                    action_url = "/admin-api/cashbank/income"
                }
                if(this.cashtype == "outcome"){
                    action_url = "/admin-api/cashbank/outcome"
                }
                if(this.cashtype == "transfer"){
                    action_url = "/admin-api/cashbank/transfer"
                }

                for(let i=0;i<this.transaction_items.length;i++){
                  this.transaction_items[i].amount = numeral().unformat(this.transaction_items[i].amount);
                  // this.transaction_items[i].tax = numeral().unformat(this.transaction_items[i].tax);
                }

                Axios.post(action_url,transaction_data)
                .then((res) => {
                    swal({
                      title: "Success!",
                      text: "Transaksi Berhasil",
                      type: "success",
                      timer: 1000
                    });
                    $('.tableapi').DataTable().ajax.reload();
                    this.resetTransaction()
                })
                .catch((err) => {
                    swal({
                      title: "Oops!",
                      text: "Transaksi Gagal",
                      type: "error",
                      timer: 1000
                    });
                    this.resetTransaction()
                });
            },
            fetchTransaction(journalid){
                let action_url = ""
                if(this.cashtype == "income"){
                    action_url = "/admin-api/cashbank/income/header/"
                }
                if(this.cashtype == "outcome"){
                    action_url = "/admin-api/cashbank/outcome/header/"
                }
                if(this.cashtype == "transfer"){
                    action_url = "/admin-api/cashbank/transfer/header/"
                }

                $("#"+this.loading_id).modal('toggle')
                this.edittransactionid = journalid
                Axios.get(action_url+journalid)
                .then((res) => {
                    console.log(res.data);
                    this.from_account = res.data.mjournalcoa
                    $("#"+this.from_account_id).val(res.data.mjournalcoa)
                    $("#"+this.from_account_id).trigger('change')
                    this.transaction_no = res.data.mjournalid
                    this.transaction_date = moment(res.data.mjournaldate).format('L')
                    this.fetchTransactionDetail(journalid)
                })
                .catch((err) => {

                });
            },
            fetchTransactionDetail(journalid){
                this.transaction_items = []
                let action_url = ""
                if(this.cashtype == "income"){
                    action_url = "/admin-api/cashbank/detailincome/"
                }
                if(this.cashtype == "outcome"){
                    action_url = "/admin-api/cashbank/detailoutcome/"
                }
                if(this.cashtype == "transfer"){
                    action_url = "/admin-api/cashbank/detailtransfer/"
                }

                Axios.get(action_url+journalid)
                .then((res) => {
                    console.log(res.data);
                    for(let i=0;i<res.data.length;i++){

                        let coa_id = _.find(this.accounts,{ mcoacode: res.data[i].mjournalcoa }).id

                        let obj = {
                            amount:res.data[i].mjournaldebit,
                            date: moment(res.data[i].mjournaldate).format('L'),
                            description: res.data[i].mjournalremark,
                            id:coa_id,
                            department: res.data[i].mjournaldepartmentid+"",
                            mcoacode:res.data[i].mjournalcoa,
                            mcoaname:_.find(this.accounts,{mcoacode: res.data[i].mjournalcoa }).mcoaname
                        }

                        if(this.cashtype == "outcome" || this.cashtype == "transfer"){
                            obj.amount = res.data[i].mjournaldebit
                        } else {
                            obj.amount = res.data[i].mjournalcredit
                        }

                        this.transaction_items.push(obj)
                    }
                    for(let i=0;i<this.transaction_items.length;i++){
                      this.transaction_items[i].amount = numeral(this.transaction_items[i].amount).format(this.num_format)
                      this.transaction_items[i].tax = numeral(this.transaction_items[i].tax).format(this.num_format)
                    }
                    $("#"+this.loading_id).modal('toggle')
                })
                .catch((err) => {
                    $("#"+this.loading_id).modal('toggle')
                });
            },
            updateTransaction(){
                $("#"+this.loading_id).modal('toggle')

                let transaction_data = {
                    date: this.transaction_date,
                    from_account: this.transaction_from_account,
                    to_accounts: this.transaction_items
                }

                for(let i=0;i<this.transaction_items.length;i++){
                  this.transaction_items[i].amount = numeral().unformat(this.transaction_items[i].amount);
                  this.transaction_items[i].tax = numeral().unformat(this.transaction_items[i].tax);
                }

                console.log(transaction_data);

                let action_url = ""
                if(this.cashtype == "income"){
                    action_url = "/admin-api/cashbank/income/"
                }
                if(this.cashtype == "outcome"){
                    action_url = "/admin-api/cashbank/outcome/"
                }
                if(this.cashtype == "transfer"){
                    action_url = "/admin-api/cashbank/transfer/"
                }

                Axios.put(action_url+this.edittransactionid,transaction_data)
                .then((res) => {
                    $("#"+this.loading_id).modal('toggle')
                    swal({
                      title: "Success!",
                      text: "Transaksi Berhasil",
                      type: "success",
                      timer: 1000
                    });
                    $('.tableapi').DataTable().ajax.reload();
                    this.toInsertMode()
                })
                .catch((err) => {
                    console.log(err);
                    swal({
                      title: "Oops!",
                      text: "Transaksi Gagal",
                      type: "error",
                      timer: 1000
                    });
                    this.toInsertMode()
                    $("#"+this.loading_id).modal('toggle')
                });
            },
            resetTransaction(){
                this.transaction_no = ""
                this.edittransactionid = ""
                this.from_account=""
                this.transaction_date= moment().format('L')
                this.selected_detail_code=""
                this.detail_state=""
                this.transaction_from_account={}
                this.transaction_items=[]
                this.transaction_detail = {
                    id: "",
                    mcoacode:"",
                    mcoaname:"",
                    amount: 0,
                    date: "",
                    description:""
                },
                this.detail_coa="",
                this.disable_from= false,
                this.disable_detail_account_id= false,
                this.from_alert= false

                $("#"+this.from_account_id).val('')
                $("#"+this.from_account_id).trigger('change')
            },
            toInsertMode(){
                this.resetTransaction();
                $('#forminput').show();
        		$('#formview').hide();
        		$('#formedit').hide();
        		window.location.href="#forminput";
            }
        },
        watch: {
            selected_detail_code(){
                if(this.selected_detail_code != ""){
                    this.detail_state = "insert"
                    this.openDetail()
                }
            },
            from_account(){
                this.transaction_from_account = _.find(this.accounts,{mcoacode: this.from_account})
                if(this.from_account != ""){
                    this.from_alert = false
                }
            },
            detail_coa(){
                let coa = _.find(this.accounts,{mcoacode: this.detail_coa})
                if(coa != undefined){
                    this.transaction_detail.mcoacode = coa.mcoacode
                    this.transaction_detail.mcoaname = coa.mcoaname
                }

            },
            transaction_date(){
                let tmp_items = this.transaction_items.map( item => {
                    item.date = this.transaction_date;
                });
            }
        },
        mounted(){
            this.fetchDepartments();
            this.fetchBanks()
            this.fetchAllAccounts()
            if(this.mode == 'edit'){
                this.$parent.$on('edit-selected',(journalid) => {
                  this.editinvoiceid = journalid;
                  this.fetchTransaction(journalid);
                });
            }
            if(this.mode == 'view'){
                this.$parent.$on('view-selected',(journalid) => {
                    this.disable_from = true
                  this.editinvoiceid = journalid;
                  this.fetchTransaction(journalid);
                });
            }
        }
    }
</script>
