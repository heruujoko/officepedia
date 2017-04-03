<template>
  <div>
    <div class="row">
      <div class="form form-horizontal" style="margin-top:20px">
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-md-2 control-label">No Transaksi</label>
            <div class="col-md-8">
                <div class="input-group">
                    <input v-bind:disabled="asset_auto" v-model="asset_no" class="form-control forminput" placeholder="AUTO GENERATE" type="text">
                    <span class="input-group-addon" style="background: none;">
                        <input v-model="asset_auto" type="checkbox" name="autogen" rel="tooltip" title="" data-original-title="ON/OFF auto generate kode transaksi" data-parsley-multiple="autogen" checked="checked">
                    </span>
                </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">Nama Aset</label>
            <div class="col-md-8">
              <input type="text" class="form-control" v-model="asset_name"/>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">Tanggal Pembelian</label>
            <div class="col-md-8">
              <input type="text" class="form-control" v-dpicker v-model="asset_date"/>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label col-md-2">Kategori Aset</label>
            <div class="col-md-8">
              <select v-selecttwo="categories_label" class="col-md-2" v-model="asset_categories" placeholder="Pilih Kategori">
                  <option v-for="c in categories" :value="c.id">{{ c.mcategoryfixedassetgroupname }}</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">Bewujud</label>
            <div class="col-md-8">
              <input type="checkbox" class="form-control check-control" v-model="asset_real" v-bind:checked="asset_real"/>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2">Harga Aset</label>
            <div class="col-md-8">
              <input type="text" class="form-control" v-model="asset_price" v-priceformatsatuan="num_format"/>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-8 col-md-offset-2">
              <button class="btn btn-primary" @click="openPaymentDetail">Pilih Pembayaran</button>
              <button class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <table class="table table-stripped">
        <thead>
          <tr>
            <th>Kode Jurnal</th>
            <th>Tanggal</th>
            <th>Akun</th>
            <th>Debit</th>
            <th>Kredit</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="j in asset_journals">
            <td>{{ j.mdpurchasefixedassetjournalcode }}</td>
            <td>{{ j.mdpurchasefixedassetdate }}</td>
            <td>{{ j.mdpurchasefixedassetcoacode }} - {{ j.mdpurchasefixedassetcoaname }}</td>
            <td><span>{{ j.mdpurchasefixedassetdebit }}</span></td>
            <td><span>{{ j.mdpurchasefixedassetcredit }}</span></td>
            <td><a @click="editJournal(j.mdpurchasefixedassetcoacode)">Edit</a> <a @click="renoveJournal(j.mdpurchasefixedassetcoacode)">Hapus</a></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-bind:id="modal_id" class="modal" style="top: 15%;" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="text-align: center">
            <h4>Detail Pembayaran</h4>
          </div>
          <div class="modal-body">
            <div class="form form-horizontal">
              <div class="form-group">
                <label class="control-label col-md-2">Akun</label>
                <div class="col-md-8">
                  <select v-selecttwo="accounts_label" class="col-md-2" v-model="detail_account" placeholder="Pilih Kategori">
                      <option v-for="coa in accounts" :value="coa.mcoacode">{{ coa.mcoacode }} - {{ coa.mcoaname }}</option>
                  </select>
                  <span>Kredit</span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-2">Nominal</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" v-priceformatdiskon="num_format" v-model="detail_amount" />
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button v-on:click="dismissModal" type="button" class="btn btn-default" data-dismiss="modal">
                  Cancel
            </button>
            <button v-if="detail_state == 'insert'" type="button" class="btn btn-primary" v-on:click="addToJournals">
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
  import swal from 'sweetalert'
  import numeral from 'numeral'
  import _ from 'lodash'

  export default {
    props: ['mode'],
    data(){
      return {
        asset_auto: true,
        asset_no: "",
        asset_name: "",
        asset_date: "",
        asset_real: true,
        asset_price: "",
        asset_journals: [],
        asset_categories: "",
        detail_payment: {
          mdpurchasefixedassetjournalcode: "",
          mdpurchasefixedassetcoa: "",
          mdpurchasefixedassetdebit: "",
          mdpurchasefixedassetcredit: "",
          mdpurchasefixedassetdate: ""
        },
        detail_account: "",
        detail_amount: 0,
        categories: [],
        accounts: [],
        num_format: "",
        detail_state: "insert"
      };
    },
    methods: {
      fetchCategories(){
        var self = this;
        Axios.get('/admin-api/mcategoryfixedassets/data')
        .then((res) => {
          console.log('ok',res.data);
          self.categories = res.data
        })
        .catch(err => {
          console.log('err');
        });
      },
      fetchAccounts(){
        Axios.get('/admin-api/coadata/all')
        .then(res => {
          this.accounts = res.data
        })
        .catch(err => {
          console.log(err);
        })
      },
      openPaymentDetail(){
        if(this.asset_name != "" && this.asset_date != "" && this.asset_categories != "" && this.asset_price != 0){
          $("#"+this.modal_id).modal('toggle');
        } else {
          swal({
            title: "Oops!",
            text: "Lengkapi data pembelian terlebih dahulu",
            type: "error",
            timer: 1000
          });
        }
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
        });
      },
      addToJournals(){
        console.log('addd');
        if(this.asset_journals.length < 1){
          this.addAssetJournal();
        }

        let coa = _.find(this.accounts,{ mcoacode: this.detail_account});

        let payment = {
          mdpurchasefixedassetjournalcode: "",
          mdpurchasefixedassetcoacode: coa.mcoacode,
          mdpurchasefixedassetcoaname: coa.mcoaname,
          mdpurchasefixedassetdebit: 0,
          mdpurchasefixedassetcredit: numeral(this.detail_amount).format(this.num_format),
          mdpurchasefixedassetdate: this.asset_date
        };

        this.asset_journals.push(payment);

        $("#"+this.modal_id).modal('toggle');
        this.resetDetail();
      },
      addAssetJournal(){

        Axios.get('/admin-api/mcategoryfixedassets/'+this.asset_categories)
        .then(res => {

          let coa = _.find(this.accounts,{ mcoacode: res.data.mcategoryfixedassetcoaasset});

          let asset = {
            mdpurchasefixedassetjournalcode: "",
            mdpurchasefixedassetcoacode: coa.mcoacode,
            mdpurchasefixedassetcoaname: coa.mcoaname,
            mdpurchasefixedassetdebit: numeral(this.asset_price).format(this.num_format),
            mdpurchasefixedassetcredit: 0,
            mdpurchasefixedassetdate: this.asset_date
          };

          let new_journals = [];
          new_journals.push(asset);
          new_journals.push(this.asset_journals[0]);
          console.log(new_journals);
          this.asset_journals = [];
          this.asset_journals = new_journals;

        })
        .catch(err => {
          console.log(err);
        });
      },
      updateDetail(){},
      dismissModal(){},
      editJournal(mcoacode){
        $("#"+this.modal_id).modal('toggle');
      },
      removeJournal(mcoacode){

      },
      resetDetail(){
        this.detail_account = ""
        this.detail_amount= 0
      }
    },
    computed: {
      select_categories(){
        return this.mode+"_select_category";
      },
      categories_label(){
        return "Pilih Kategori";
      },
      accounts_label(){
        return "Pilih Akun";
      },
      modal_id(){
        return this.mode+"_modal";
      }
    },
    created(){
      this.fetchCategories();
      this.fetchAccounts();
      this.fetchConfig();
    }
  }
</script>
