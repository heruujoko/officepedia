<template>
    <div>
        <div class="row" v-show="mode != 'insert'" v-on:click="toInsertMode">
            <button class="btn btn-default pull-right" style="margin-right:4%">Kembali</button>
        </div>
        <div class="row form form-horizontal">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-2 control-label">Tanggal</label>
                    <div class="col-md-10">
                        <input type="text" v-dpicker class="form-control" v-model="transaction_date">
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
        <br><br>
        <div class="row form form-horizontal">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="col-md-12">
                        <select v-bind:disabled="!notview" v-bind:id="to_account_id" v-selecttwo="account_label" v-model="selected_detail_code" class="col-md-8 form-control">
                            <option></option>
                            <option v-for="cb in accounts" :value="cb.mcoacode">{{ cb.mcoaname }}</option>
                        </select>
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
                        <th style="width:10%;">Akun</th>
                        <th style="width:10%;">Debet</th>
                        <th style="width:10%;">Kredit</th>
                        <th v-if="notview" style="width:5%;">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in transaction_items">
                        <td>{{ item.date }}</td>
                        <td>{{ item.mcoacode }} / {{ item.mcoaname }}</td>
                        <td v-priceformatlabel="num_format">{{ item.debit }}</td>
                        <td v-priceformatlabel="num_format">{{ item.credit }}</td>
                        <td v-if="notview"><a v-on:click="editItem(item.general_journal_detail_id)"><span style="color:lightblue">Edit</span></a> <a v-on:click="deleteTransactionItem(item.general_journal_detail_id)"><span style="color:red">Hapus</span></a></td>
                    </tr>
                    </tbody>
                </table>
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
                        <h4>Jurnal Umum</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-md-2">Akun</label>
                                <div class="col-md-8">
                                    <select v-bind:disabled="disable_detail_account" v-bind:id="detail_account_id" v-selecttwo="account_label" v-model="detail_account" class="col-md-8 form-control">
                                        <option></option>
                                        <option v-for="cb in accounts" :value="cb.mcoacode">{{ cb.mcoaname }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Tipe</label>
                                <label class="control-label col-md-2"><input type="radio" v-model="transaction_detail.type" value="debit"> Debit</label>
                                <label class="control-label col-md-2"><input type="radio" v-model="transaction_detail.type" value="credit"> Credit</label>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Jumlah</label>
                                <div class="col-md-8">
                                    <input autofocus v-bind:id="amount_id" class="form-control forminput" type="text" v-model="transaction_detail.amount" v-priceformatcash="num_format" style="text-align:right"/>
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
</template>
<style>
    body{
        background-color:#ff0000;
    }
</style>
<script>
    import moment from 'moment'
    import Axios from 'axios'
    import _ from 'lodash'
    import numeral from 'numeral'
    import shortid from 'shortid'
    import swal from 'sweetalert'

    export default{
        props: ['mode'],
        data(){
            return{
                transaction_no: "",
                transaction_date: moment().format('L'),
                transaction_items: [],
                transaction_detail: {
                    amount:0,
                    debit:0,
                    credit:0,
                    type:"debit",
                    date:"",
                    mcoacode:"",
                    mcoaname:"",
                    general_journal_detail_id:""
                },
                detail_account:"",
                num_format:"0,0",
                accounts: [],
                selected_detail_code:"",
                disable_detail_account: true,
                detail_state:""
            }
        },
        computed: {
            detail_account_id(){
                return this.mode+"_detail_account_select"
            },
            to_account_id(){
              return this.mode+"_account_select"
            },
            loading_id(){
                return this.mode+"_loading"
            },
            modal_id(){
                return this.mode+"_modal_detail"
            },
            amount_id(){
                return this.mode+"_modal_amount"
            },
            notview(){
              return this.mode != 'view';
            },
            account_label(){
                return "Pilih Akun";
            },
            total_debit(){
                let debit = 0;
                for(let i=0;i<this.transaction_items.length;i++){
                    debit += this.transaction_items[i].debit;
                }
                return debit;
            },
            total_credit(){
                let credit = 0;
                for(let i=0;i<this.transaction_items.length;i++){
                    credit += this.transaction_items[i].credit;
                }
                return credit;
            }
        },
        methods:{
          toInsertMode(){

          },
          dismissModal(){
              $("#"+this.modal_id).modal('toggle');
              this.transaction_detail = {
                  amount:0,
                          debit:0,
                          credit:0,
                          type:"debit",
                          date:"",
                          mcoacode:"",
                          mcoaname:"",
                          general_journal_detail_id:""
              }
              this.selected_detail_code = ""
              $("#"+this.to_account_id).val("")
              $("#"+this.to_account_id).trigger('change')
          },
          fetchAccounts(){
              let url = '/admin-api/coadata/all'
              Axios.get(url).then((res) => {
                  this.accounts = res.data;
              });
          },
          openDetail(){
              this.detail_state = 'insert'
              $("#"+this.modal_id).modal('toggle');
              this.detail_account = this.selected_detail_code
              this.transaction_detail.mcoacode = this.selected_detail_code
              $("#"+this.detail_account_id).val(this.selected_detail_code)
              $("#"+this.detail_account_id).trigger('change')
              let account = _.find(this.accounts , {mcoacode: this.selected_detail_code})
              this.transaction_detail.mcoaname = account.mcoaname
              this.transaction_detail.id = account.id
          },
          addToTransaction(){
                this.transaction_detail.amount = numeral().unformat(this.transaction_detail.amount)
                if(this.transaction_detail.type == 'debit'){
                    this.transaction_detail.debit = this.transaction_detail.amount
                } else {
                    this.transaction_detail.credit = this.transaction_detail.amount
                }
                this.transaction_detail.date = this.transaction_date
                this.transaction_detail.general_journal_detail_id = shortid.generate()
                this.transaction_items.push(this.transaction_detail)
                this.dismissModal()
          },
          editItem(key){
              this.disable_detail_account = false
              this.detail_state = "edit"
              let item = _.find(this.transaction_items,{general_journal_detail_id: key})
              $("#"+this.modal_id).modal('toggle');
              this.transaction_detail.mcoacode = item.mcoacode
              $("#"+this.detail_account_id).val(item.mcoacode)
              $("#"+this.detail_account_id).trigger('change')
              this.transaction_detail.amount = item.amount
              this.transaction_detail.type = item.type
              this.transaction_detail.date = item.date
              this.transaction_detail.general_journal_detail_id = item.general_journal_detail_id
          },
          saveTransaction(){
              if(this.total_credit != this.total_debit){
                  swal({
                      title: "Oops!",
                      text: "Total debit & kredit tidak seimbang",
                      type: "error",
                      timer: 1000
                  });
              }
          },
          updateTransactionItem(){
              let index = _.findIndex(this.transaction_items,{general_journal_detail_id: this.transaction_detail.general_journal_detail_id})
              this.transaction_detail.amount = numeral().unformat(this.transaction_detail.amount)
              this.transaction_detail.mcoacode = this.detail_account
              this.transaction_detail.mcoaname = _.find(this.accounts,{mcoacode: this.transaction_detail.mcoacode}).mcoaname
              if(this.transaction_detail.type == 'debit'){
                  this.transaction_detail.debit = this.transaction_detail.amount
              } else {
                  this.transaction_detail.credit = this.transaction_detail.amount
              }
              this.$set(this.transaction_items,index,this.transaction_detail)
              this.dismissModal()
          },
          deleteTransactionItem(key){
              let index_item = _.findIndex(this.transaction_items,{general_journal_detail_id: key});
              // remove at index_invoice_aps
              console.log(this.transaction_items.length);
              this.transaction_items.splice(index_item,1);
          },
          updateTransaction(){

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
                if(conf.msysinvlocksellingprice == 1){
                    this.lock_sell_price = true;
                } else {
                    this.lock_sell_price = false;
                }
            });
          }
        },
        watch: {
            selected_detail_code(){
                if(this.selected_detail_code != ""){
                    this.openDetail()
                }
            }
        },
        created(){
            this.fetchConfig()
            this.fetchAccounts()
        }
    }
</script>
