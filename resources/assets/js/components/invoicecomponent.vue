<template>
  <div>
      <div class="row" v-show="mode != 'insert'" v-on:click="toInsertMode">
          <button class="btn btn-default pull-right" style="margin-right:4%">Kembali</button>
      </div>
    <div class="row">
      <div class="form form-horizontal" style="margin-top:20px">
        <div class="col-md-8">
          <div class="form-group">
            <label class="col-md-2 control-label">Pelanggan</label>
            <div class="col-md-8">
              <select v-bind:disabled="disable_customer" v-selecttwo="pelanggan_label" v-model="invoice_customer">
                <option v-for="c in customers" :value="c.id">{{ c.mcustomername }}</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Tanggal</label>
            <div class="col-md-8">
              <input v-bind:disabled="!notview" v-dpicker v-model="invoice_date" type="text" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Jatuh Tempo</label>
            <div class="col-md-8">
              <input disabled v-model="invoice_due_date" type="text" class="form-control" />
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
              <select disabled v-selecttwo="transaksi_label" class="form-control" v-model="invoice_type">
                <option>Penjualan</option>
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
              <select v-bind:disabled="!notview" class="form-control" id="insert-selectgoods" v-selecttwo="barang_label" v-model="selected_goods">
                <option v-for="g in goods" :value="g.id">{{ g.mgoodscode }} {{ g.mgoodsname }}</option>
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
                  <th style="width:10%;">Kode</th>
                  <th style="width:45%;">Nama</th>
                  <th style="width:10%;">Harga Jual</th>
                  <th style="width:10%;">QTY</th>
                  <th style="width:10%;">Jumlah Satuan</th>
                  <th style="width:10%;">Subtotal</th>
                  <th style="width:10%;">Diskon</th>
                  <th style="width:10%;">Jumlah</th>
                  <th v-if="notview" style="width:10%;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in invoice_goods">
                  <td>{{ item.goods.mgoodscode }}</td>
                  <td>{{ item.goods.mgoodsname }}</td>
                  <td v-priceformatlabel="num_format">{{ item.sell_price }}</td>
                  <td>{{ item.usage }}</td>
                  <td>{{ item.usage_label }}</td>
                  <td v-priceformatlabel="num_format">{{ item.usage * item.sell_price }}</td>
                  <td v-priceformatlabel="num_format">{{ item.disc }}</td>
                  <td v-priceformatlabel="num_format">{{ item.subtotal }}</td>
                  <td v-if="notview"><a v-on:click="editGoods(item.goods.id)"><span style="color:lightblue">Edit</span></a> <a v-on:click="removeGoods(item.goods.id)"><span style="color:red">Hapus</span></a></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="row" style="color:white;">
            <br>
            <div class="col-md-2 well bg-color-greenLight">
              <h5>Total Item</h5>
              <p>{{ invoice_goods.length }}</p>
            </div>
            <div class="col-md-2 col-md-offset-2 well bg-color-magenta">
              <h5>Sub Total</h5>
              <p id="insertsubtotal"  >{{ format_subtotal }}</p>
            </div>
            <div class="col-md-2 well bg-color-blue">
              <h5>Discount</h5>
              <p id="insertdisc"  >{{ format_disc }}</p>
            </div>
            <div class="col-md-2 well well bg-color-orangeDark">
              <h5>PPN 10%</h5>
              <p id="insertppn" >{{ format_tax }}</p>
            </div>
            <div class="col-md-2 well bg-color-redLight">
              <h5>Total</h5>
              <p>{{ invoice_grandtotal }}</p>
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
            <h4>Detail Barang</h4>
    			</div>
          <div class="modal-body">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#insertdetailmenu1">Detail Barang</a></li>
              <li><a data-toggle="tab" href="#insertdetailmenu2">Keterangan</a></li>
            </ul>
            <div class="tab-content">
              <div id="insertdetailmenu1" class="tab-pane fade in active">
                <div class="form form-horizontal" style="margin-top:10px;">
                  <div class="form-group">
                    <label class="control-label col-md-2">Nama barang</label>
                    <div class="col-md-8">
                      <input class="form-control forminput" disabled type="text" id="insertdetailgoodsname" v-model="detail_goods.mgoodsname"/>
                    </div>
                  </div>
                  <div class="form-group" v-if="detail_goods_unit3_conv != 0">
                    <label class="control-label col-md-2">Kuantitas</label>
                    <div class="col-md-8">
                      <div class="input-group">
                        <input v-bind:id="conv_3_id" class="form-control forminput" v-bind:placeholder="detail_goods_unit3_label" type="text" v-model="detail_goods_unit3">
                        <span class="input-group-addon" id="sizing-addon2" style="font-size:11px;">{{ detail_goods_unit3_label }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" v-if="detail_goods_unit2_conv != 0">
                    <label v-if="detail_goods_unit3_conv == 0" class="control-label col-md-2">Kuantitas</label>
                    <div class="col-md-2" v-if="detail_goods_unit3_conv != 0"></div>
                    <div class="col-md-8">
                      <div class="input-group">
                        <input v-bind:id="conv_2_id" class="form-control forminput" v-bind:placeholder="detail_goods_unit2_label" type="text" v-model="detail_goods_unit2">
                        <span class="input-group-addon" id="sizing-addon2" style="font-size:11px;">{{ detail_goods_unit2_label }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label v-if="detail_goods_unit2_conv == 0" class="control-label col-md-2">Kuantitas</label>
                    <div class="col-md-2" v-if="detail_goods_unit2_conv != 0"></div>
                    <div class="col-md-8">
                      <div class="input-group">
                        <input v-bind:id="conv_1_id" class="form-control forminput" v-bind:placeholder="detail_goods_unit1_label" type="text" v-model="detail_goods_unit1">
                        <span class="input-group-addon" id="sizing-addon2" style="font-size:11px;">{{ detail_goods_unit1_label }}</span>
                      </div>
                    </div>
                  </div>
                  <input placeholder="Kuantitas" class="form-control forminput" value="1" type="hidden" id="insertdetailgoodsqty" v-model="detail_qty"/>
                  <div class="form-group">
                    <label class="control-label col-md-2">Harga Satuan</label>
                    <div class="col-md-8">
                      <input v-bind:disabled="lock_sell_price" v-priceformatsatuan="num_format" class="form-control pricelabel" type="text" id="insertdetailgoodsprice" v-model="sell_price"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-2">Diskon</label>
                    <div class="col-md-4">
                      <div class="input-group">
                        <input v-bind:id="percent_id" v-model="percentage" class="form-control forminput" placeholder="Persentase" type="text">
                        <span class="input-group-addon" id="sizing-addon2" style="font-size:8px;">%</span>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2" style="font-size:8px;">Rp</span>
                        <input v-priceformatdiskon="num_format" v-bind:id="rp_id" v-model="rp" class="form-control forminput pricelabel" placeholder="Rupiah" type="text">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-2">Total Harga</label>
                    <div class="col-md-8">
                      <input v-priceformat="num_format" class="form-control pricelabel" disabled type="text" v-model="detail_total"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-2">Pajak</label>
                    <div class="col-md-8">
                      <select v-selecttwo :disabled="detail_goods.mgoodstaxable == 0" class="form-control" id="insertdetailgoodstax" v-model="detail_tax">
                        <option v-for="t in taxes" :value="t.id">{{ t.mtaxtdesc }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-2">Gudang</label>
                    <div class="col-md-8">
                      <select class="form-control" id="insert-detailwarehouses" v-selecttwo v-model="detail_warehouse">
                        <option v-for="g in warehouses" :value="g.id">{{ g.mwarehousename }}</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div id="insertdetailmenu2" class="tab-pane">
                <div class="form form-horizontal" style="margin-top:10px;">
                  <div class="form-group">
                    <label class="control-label col-md-2">Keterangan</label>
                    <div class="col-md-8">
                      <textarea class="form-control" placeholder="Keterangan"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
    			</div>
          <div class="modal-footer">
    				<button type="button" class="btn btn-default" data-dismiss="modal">
    				      Cancel
    				</button>
    				<button v-if="detail_state == 'insert'" type="button" class="btn btn-primary" v-on:click="addToGoods">
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
        warehouses: [],
        customers: [],
        goods: [],
        taxes: [],
        selected_goods: "",
        detail_goods_unit3_conv:0,
        detail_goods_unit3_label:0,
        detail_goods_unit3:0,
        detail_goods_unit2_conv:0,
        detail_goods_unit2_label:0,
        detail_goods_unit2:0,
        detail_goods_unit1_conv:0,
        detail_goods_unit1_label:0,
        detail_goods_unit1:0,
        detail_goods: {},
        unit: 1,
        detail_qty:1,
        percentage: 0,
        rp:"",
        edit_index: 0,
        detail_state: "insert",
        detail_total: 0,
        detail_tax:"2",
        detail_warehouse: 0,
        num_format: "0,0.00",
        unit_label: "Pilih Unit",
        barang_label: "Pilih Barang",
        transaksi_label: "Pilih Tipe Transaksi",
        pelanggan_label: "Pilih Pelanggan",
        invoice_customer:{},
        selected_customer: {},
        invoice_goods:[],
        sell_price:0,
        invoice_type:"Penjualan",
        invoice_date:moment().format('L'),
        invoice_due_date:"",
        invoice_subtotal:0,
        invoice_disc:0,
        invoice_tax:0,
        invoice_no:"",
        invoice_auto: true,
        lock_sell_price: false,
        disable_customer: false
      }
    },
    computed:{
      invoice_grandtotal(){
        return numeral(this.invoice_subtotal + this.invoice_tax).format(this.num_format);
      },
      format_subtotal(){
        return numeral(this.invoice_subtotal + this.invoice_disc).format(this.num_format);
      },
      format_tax(){
        return numeral(this.invoice_tax).format(this.num_format);
      },
      format_disc(){
        return numeral(this.invoice_disc).format(this.num_format);
      },
      modal_id(){
        return this.mode+"_detail_modal";
      },
      rp_id(){
        return this.mode+"_detail_rp";
      },
      percent_id(){
        return this.mode+"_detail_percentage";
      },
      loading_id(){
        return this.mode+"_loading_modal";
      },
      notview(){
        return this.mode != "view";
    },
    conv_3_id(){
        return this.mode+"_conv3";
    },
    conv_2_id(){
        return this.mode+"_conv2";
    },
    conv_1_id(){
        return this.mode+"_conv1";
    },
    },
    methods: {
        disableCustomer(){
            if(this.selected_customer != ""){
                this.disable_customer = true;
            }
        },
        toInsertMode(){
            this.resetDetail();
            this.resetInvoice();
            $('#forminput').show();
    		$('#formview').hide();
    		$('#formedit').hide();
            window.location.href = '#forminput';
        },
      fetchTax(){
        Axios.get('/admin-api/mtax/datalist')
        .then((res) => {
          this.taxes = res.data;
        });
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
      },
      fetchWareHouses(){
        Axios.get('/admin-api/mwarehouse/datalist')
        .then((res) => {
          this.warehouses = res.data;
          this.detail_warehouse = res.data[0].id;
        });
      },
      fetchCustomers(){
        Axios.get('/admin-api/pelanggan/datalist')
        .then((res) => {
          this.customers = res.data;
        });
      },
      fetchGoods(){
        Axios.get('/admin-api/barang/datalist')
        .then((res) => {
          this.goods = res.data;
        });
      },
      fetchInvoiceData(id){
        this.resetDetail();
        this.resetInvoice();
        Axios.get('/admin-api/salesinvoice/'+id)
        .then((res) => {
          console.log(res.data);
          let data = res.data;
          this.invoice_date = moment(data.mhinvoicedate).format('L');
          //find customers
          let cust = _.find(this.customers, { mcustomerid: data.mhinvoicecustomerid});
          this.invoice_customer = cust.id+"";
          this.fetchDetailData(data.mhinvoiceno);
          this.invoice_subtotal = parseInt(res.data.mhinvoicesubtotal) - parseInt(res.data.mhinvoicediscounttotal);
          this.invoice_disc = res.data.mhinvoicediscounttotal;
          this.invoice_tax = res.data.mhinvoicetaxtotal;
        });
      },
      fetchDetailData(inv){
        Axios.get('/admin-api/salesinvoice/details/'+inv)
        .then((res) => {
          for(var i=0;i<res.data.length;i++){
            var item = {
              id: _.find(this.goods,{ mgoodscode: res.data[i].mdinvoicegoodsid}).id,
              subtotal: 0,
              disc: res.data[i].mdinvoicegoodsdiscount,
              goods: _.find(this.goods,{ mgoodscode: res.data[i].mdinvoicegoodsid}),
              tax: res.data[i].mdinvoicegoodstax,
              warehouse: 0,
              saved_unit: res.data[i].saved_unit+""
            };

            // converted units
            item.detail_goods_unit3 = res.data[i].mdinvoiceunit3;
            item.detail_goods_unit3_conv = res.data[i].mdinvoiceunit3conv;
            item.detail_goods_unit3_label = res.data[i].mdinvoiceunit3label;
            item.detail_goods_unit2 = res.data[i].mdinvoiceunit2;
            item.detail_goods_unit2_conv = res.data[i].mdinvoiceunit2conv;
            item.detail_goods_unit2_label = res.data[i].mdinvoiceunit2label;
            item.detail_goods_unit1 = res.data[i].mdinvoiceunit1;
            item.detail_goods_unit1_conv = res.data[i].mdinvoiceunit1conv;
            item.detail_goods_unit1_label = res.data[i].mdinvoiceunit1label;

            this.sell_price = res.data[i].mgoodspriceout;

            let usage_label = ""
            if(item.detail_goods_unit3 != 0){
                usage_label += item.detail_goods_unit3 +" "+item.detail_goods_unit3_label;
            }
            if(item.detail_goods_unit2 != 0){
                usage_label += item.detail_goods_unit2 +" "+item.detail_goods_unit2_label;
            }
            if(item.detail_goods_unit1 != 0){
                usage_label += item.detail_goods_unit1 +" "+item.detail_goods_unit1_label;
            }

            item.usage_label = usage_label;

            // find goods price
            let gds = _.find(this.goods,{ mgoodscode: res.data[i].mdinvoicegoodsid});
            item.sell_price = gds.mgoodspriceout;

            item.usage = res.data[i].mdinvoicegoodsqty;
            item.goods.mgoodsname = res.data[i].mdinvoicegoodsname;
            item.goods.mgoodscode = res.data[i].mdinvoicegoodsid;
            item.goods.mgoodspriceout = this.goodsPrice(res.data[i].mdinvoicegoodsid);
            item.subtotal = parseInt(item.goods.mgoodspriceout) * parseInt(item.usage);
            this.invoice_goods.push(item);
            // this.invoice_subtotal += item.subtotal;
            // this.invoice_disc += item.disc;
            // this.invoice_tax += item.tax;
          }
        });
      },
      goodsPrice(code){
        let g = _.find(this.goods,{ mgoodscode: code});
        return parseInt(g.mgoodspriceout);
      },
      canAddSingle(idx){
        var already = _.find(this.invoice_goods,{id: parseInt(idx)});
        if(already == undefined){
            if(this.mode == 'edit'){
                console.log('disini');
                $('#edit_loading_modal').modal('toggle');
            } else {
                console.log('disini');
                $('#insert_loading_modal').modal('toggle');
            }
            this.fetchGoodsSingle(idx);
        } else {
          swal({
            title: "Oops!",
            text: "Item sudah di tambahkan. Klik edit untuk merubah",
            type: "error",
            timer: 1000
          });
        }

      },
      fetchGoodsSingle(id){
        this.resetDetail();
        Axios.get('/admin-api/barang/'+id)
        .then((res) => {
          this.detail_goods = res.data;
          let self = this;
          if(this.mode == 'edit'){
              $('#edit_loading_modal').modal('toggle');
              $('#edit_detail_modal').modal('toggle');
          } else {
              $('#insert_loading_modal').modal('toggle');
              $('#insert_detail_modal').modal('toggle');
          }
        //   this.detail_qty = 1;

          // isi konveris multi unit
          this.detail_goods_unit3_conv = res.data.mgoodsunit3conv;
          this.detail_goods_unit3_label = res.data.mgoodsunit3;
          this.detail_goods_unit2_conv = res.data.mgoodsunit2conv;
          this.detail_goods_unit2_label = res.data.mgoodsunit2;
          this.detail_goods_unit1_conv = 1;
          this.detail_goods_unit1_label = res.data.mgoodsunit;

          // autofocus mode
          if(this.detail_goods_unit3_conv != 0){
              setTimeout(function () { $('#'+self.conv_3_id).focus(); }, 1);
          }
          if(this.detail_goods_unit2_conv != 0 && this.detail_goods_unit3_conv == 0){
              setTimeout(function () { $('#'+self.conv_2_id).focus(); }, 1);
          }
          if(this.detail_goods_unit1_conv != 0 && this.detail_goods_unit2_conv == 0){
              setTimeout(function () { $('#'+self.conv_1_id).focus(); }, 1);
          }

          this.sell_price = res.data.mgoodspriceout;

          if(this.mode == 'edit'){
            $('#edit_detail_rp').on('keyup',function(){
                self.countPercent();
                self.countDetailTotal();
            });
            $('#edit_detail_percentage').on('keyup',function(evt){
              // diskon yg di input lebih besar
              if(res.data.mgoodssetmaxdisc == 1){
                if(evt.target.value > res.data.mgoodsmaxdisc){
                  self.percentage = res.data.mgoodsmaxdisc;
                  swal({
                    title: "Oops!",
                    text: "Maksimal diskon item ini tidak bisa melebihi "+res.data.mgoodsmaxdisc+"%",
                    type: "error",
                    timer: 1000
                  });
                }
              }
              self.countRp();
              self.countDetailTotal();
            });
          } else {
            self.countRp();
            self.countDetailTotal();
            $('#insert_detail_rp').on('keyup',function(){
              self.countPercent();
              self.countDetailTotal();
            });
            $('#insert_detail_percentage').on('keyup',function(evt){
              // diskon yg di input lebih besar
              if(res.data.mgoodssetmaxdisc == 1){
                if(evt.target.value > res.data.mgoodsmaxdisc){
                  self.percentage = res.data.mgoodsmaxdisc;
                  swal({
                    title: "Oops!",
                    text: "Maksimal diskon item ini tidak bisa melebihi "+res.data.mgoodsmaxdisc+"%",
                    type: "error",
                    timer: 1000
                  });
                }
              }
              self.countRp();
              self.countDetailTotal();
            });
          }

          this.countDetailTotal();
          this.predictTax();
        });
      },
      detailGoods(){
        this.detail_state = "insert";
        if(this.selected_goods != ""){
          this.canAddSingle(this.selected_goods);
        }
      },
      countDetailTotal(){
        if(isNaN(this.rp)){
          this.rp = 0;
        }
        this.unit = 1;
        this.detail_total = (numeral().unformat(this.sell_price) * parseInt(this.detail_qty) * parseInt(this.unit)) - parseInt(this.rp);
      },
      countRp(){
        this.sell_price = numeral().unformat(this.sell_price);
        this.rp = (parseInt(this.percentage) / 100) * (this.sell_price * this.detail_qty);
      },
      countPercent(){
        this.sell_price = numeral().unformat(this.sell_price);
        this.percentage = (numeral().unformat(this.rp)/(this.sell_price * this.detail_qty)) * 100;
        if(isNaN(this.percentage)){
          this.percentage = 0;
        }
      },
      addToGoods(){
        if(this.mode == 'edit'){
            $('#edit_detail_modal').modal('toggle');
        } else {
            $('#insert_detail_modal').modal('toggle');
        }
        this.invoice_subtotal += this.detail_total;
        this.invoice_disc += this.rp;
        let just_tax =0;
        if(this.detail_goods.mgoodstaxable == 1){
            let tax_obj = _.find(this.taxes, { id: parseInt(this.detail_tax) });
            // count taxes
            this.invoice_tax += (tax_obj.mtaxtpercentage /100) * (this.detail_qty * this.detail_goods.mgoodspriceout);
            just_tax = (tax_obj.mtaxtpercentage /100) * (this.detail_qty * this.detail_goods.mgoodspriceout);
        } else {
          this.invoice_tax += 0;
        }

        let usage_label = ""
        if(this.detail_goods_unit3 != 0){
            usage_label += this.detail_goods_unit3 +" "+this.detail_goods_unit3_label;
        }
        if(this.detail_goods_unit2 != 0){
            usage_label += this.detail_goods_unit2 +" "+this.detail_goods_unit2_label;
        }
        if(this.detail_goods_unit1 != 0){
            usage_label += this.detail_goods_unit1 +" "+this.detail_goods_unit1_label;
        }

        let newGoods = {
          id: this.detail_goods.id,
          detail_goods_unit3: parseInt(this.detail_goods_unit3),
          detail_goods_unit3_conv: this.detail_goods_unit3_conv,
          detail_goods_unit3_label: this.detail_goods_unit3_label,
          detail_goods_unit2: parseInt(this.detail_goods_unit2),
          detail_goods_unit2_conv: this.detail_goods_unit2_conv,
          detail_goods_unit2_label: this.detail_goods_unit2_label,
          detail_goods_unit1: parseInt(this.detail_goods_unit1),
          detail_goods_unit1_conv: this.detail_goods_unit1_conv,
          detail_goods_unit1_label: this.detail_goods_unit1_label,
          usage: parseInt(this.detail_qty) * parseInt(this.unit),
          usage_label: usage_label,
          sell_price: this.sell_price,
          disc: this.rp,
          subtotal: this.detail_total,
          goods: this.detail_goods,
          tax: just_tax,
          warehouse: parseInt(this.detail_warehouse),
          saved_unit: this.unit //for editing purpose only
        };
        this.invoice_goods.push(newGoods);
        this.selected_goods = "";
        this.disableCustomer();
        this.resetDetail();
      },
      predictTax(){
        if(this.detail_goods.mgoodstaxable == 1){
          this.detail_tax = "1";
        } else {
          this.detail_tax = "2";
        }
      },
      updateInvoice(){
        if(this.mode == 'edit'){
            $('#edit_loading_modal').modal('toggle');
        } else {
            $('#insert_loading_modal').modal('toggle');
        }
        let invoice_data = {
          date: this.invoice_date,
          duedate: this.invoice_due_date,
          subtotal: this.invoice_subtotal,
          discount: this.invoice_disc,
          tax: this.invoice_tax,
          goods: this.invoice_goods,
          mcustomerid: this.selected_customer.mcustomerid,
          mcustomername: this.selected_customer.mcustomername,
          type: this.invoice_type
        }
        Axios.put('/admin-api/salesinvoice/'+this.editinvoiceid,invoice_data)
        .then((res) => {
          if(this.mode == 'edit'){
              $('#edit_loading_modal').modal('toggle');
          } else {
              $('#insert_loading_modal').modal('toggle');
          }
          swal({
            title: "Input Berhasil!",
            type: "success",
            timer: 1000
          });
          this.resetInvoice();
          $('.tableapi').DataTable().ajax.reload();
          window.location.href="#formtable";
        })
        .catch((err) => {
          if(this.mode == 'edit'){
              $('#edit_loading_modal').modal('toggle');
          } else {
              $('#insert_loading_modal').modal('toggle');
          }
          var status_message ="";
          if(err.response.status == 500){
            status_message = "Transaksi gagal, periksa kembali input";
          } else {
            status_message = "Stok tidak bisa minus";
          }
          swal({
            title: "Oops!",
            text: status_message,
            type: "error",
            timer: 1000
          });
        });
      },
      saveInvoice(){
        if(this.mode == 'edit'){
            $('#insert_loading_modal').modal('toggle');
        } else {
            $('#insert_loading_modal').modal('toggle');
        }
        let invoice_data = {
          date: this.invoice_date,
          duedate: this.invoice_due_date,
          subtotal: this.invoice_subtotal,
          discount: this.invoice_disc,
          tax: this.invoice_tax,
          goods: this.invoice_goods,
          mcustomerid: this.selected_customer.mcustomerid,
          mcustomername: this.selected_customer.mcustomername,
          type: this.invoice_type,
          no: this.invoice_no,
          autogen: this.invoice_auto
        }
        console.log(invoice_data);
        Axios.post('/admin-api/salesinvoice',invoice_data)
        .then((res) => {
          if(this.mode == 'edit'){
              $('#edit_loading_modal').modal('toggle');
          } else {
              $('#insert_loading_modal').modal('toggle');
          }
          swal({
            title: "Input Berhasil!",
            type: "success",
            timer: 1000
          });
          this.resetInvoice();
          $('.tableapi').DataTable().ajax.reload();
          window.location.href="#formtable";
        })
        .catch((err) => {
          if(this.mode == 'edit'){
              $('#edit_loading_modal').modal('toggle');
          } else {
              $('#insert_loading_modal').modal('toggle');
          }
          var status_message ="";
          if(err.response.status == 500){
            status_message = "Transaksi gagal, periksa kembali input";
          } else {
            status_message = "Stok tidak bisa minus";
          }
          swal({
            title: "Oops!",
            text: status_message,
            type: "error",
            timer: 1000
          });
        });
      },
      removeGoods(idx){
        let good = _.find(this.invoice_goods,  {id: idx});
        this.invoice_subtotal = this.invoice_subtotal - good.subtotal;
        this.invoice_tax = this.invoice_tax - good.tax;
        this.invoice_disc = this.invoice_disc - good.disc;
        this.invoice_goods = this.invoice_goods.filter((g) => {
          return g.id !== idx
        });
      },
      editGoods(idx){
        this.resetDetail();
        this.detail_state = "edit";
        let current = _.find(this.invoice_goods,{id: idx});
        this.edit_index = _.indexOf(this.invoice_goods,current);
        this.detail_goods = current.goods;

        // cenverted unit
        this.detail_goods_unit3 = current.detail_goods_unit3;
        this.detail_goods_unit3_conv = current.detail_goods_unit3_conv;
        this.detail_goods_unit3_label = current.detail_goods_unit3_label;

        this.detail_goods_unit2 = current.detail_goods_unit2;
        this.detail_goods_unit2_conv = current.detail_goods_unit2_conv;
        this.detail_goods_unit2_label = current.detail_goods_unit2_label;

        this.detail_goods_unit1 = current.detail_goods_unit1;
        this.detail_goods_unit1_conv = current.detail_goods_unit1_conv;
        this.detail_goods_unit1_label = current.detail_goods_unit1_label;

        this.sell_price = current.sell_price

        // autofocus mode
        if(this.detail_goods_unit3_conv != 0){
            setTimeout(function () { $('#'+self.conv_3_id).focus(); }, 1);
        }
        if(this.detail_goods_unit2_conv != 0 && this.detail_goods_unit3_conv == 0){
            setTimeout(function () { $('#'+self.conv_2_id).focus(); }, 1);
        }
        if(this.detail_goods_unit1_conv != 0 && this.detail_goods_unit2_conv == 0){
            setTimeout(function () { $('#'+self.conv_1_id).focus(); }, 1);
        }

        this.rp = current.disc;
        this.unit = current.saved_unit+"";
        this.detail_qty = parseInt(current.usage) / parseInt(current.saved_unit);
        // this.countDetailTotal();
        this.countPercent();
        this.countDetailTotal();
        this.$nextTick(function(){
          if(this.mode == 'edit'){
              $('#edit_detail_modal').modal('toggle');
          } else {
              $('#insert_detail_modal').modal('toggle');
          }
        });

        let self = this;
        if(this.mode == "edit"){
          $('#edit_detail_rp').on('keyup',function(){
            self.countPercent();
            self.countDetailTotal();
          });
          $('#edit_detail_percentage').on('keyup',function(evt){
            // diskon yg di input lebih besar
            if(current.goods.mgoodssetmaxdisc == 1){
              if(evt.target.value > current.goods.mgoodsmaxdisc){
                self.percentage = current.goods.mgoodsmaxdisc;
                swal({
                  title: "Oops!",
                  text: "Maksimal diskon item ini tidak bisa melebihi "+current.goods.mgoodsmaxdisc+"%",
                  type: "error",
                  timer: 1000
                });
              }
            }
            self.countRp();
            self.countDetailTotal();
          });
        }
      },
      updateDetail(){
        let just_tax =0;
        if(this.detail_goods.mgoodstaxable == 1){
            let tax_obj = _.find(this.taxes, { id: parseInt(this.detail_tax) });
            // count taxes
            this.invoice_tax += (tax_obj.mtaxtpercentage /100) * (this.detail_qty * this.detail_goods.mgoodspriceout);
            just_tax = (tax_obj.mtaxtpercentage /100) * (this.detail_qty * this.detail_goods.mgoodspriceout);
        } else {
          this.invoice_tax += 0;
        }

        let usage_label = ""
        if(this.detail_goods_unit3 != 0){
            usage_label += this.detail_goods_unit3 +" "+this.detail_goods_unit3_label;
        }
        if(this.detail_goods_unit2 != 0){
            usage_label += this.detail_goods_unit2 +" "+this.detail_goods_unit2_label;
        }
        if(this.detail_goods_unit1 != 0){
            usage_label += this.detail_goods_unit1 +" "+this.detail_goods_unit1_label;
        }

        let editedGoods = {
          id: this.detail_goods.id,
          detail_goods_unit3: parseInt(this.detail_goods_unit3),
          detail_goods_unit3_conv: this.detail_goods_unit3_conv,
          detail_goods_unit3_label: this.detail_goods_unit3_label,
          detail_goods_unit2: parseInt(this.detail_goods_unit2),
          detail_goods_unit2_conv: this.detail_goods_unit2_conv,
          detail_goods_unit2_label: this.detail_goods_unit2_label,
          detail_goods_unit1: parseInt(this.detail_goods_unit1),
          detail_goods_unit1_conv: this.detail_goods_unit1_conv,
          detail_goods_unit1_label: this.detail_goods_unit1_label,
          usage: parseInt(this.detail_qty) * parseInt(this.unit),
          usage_label: usage_label,
          disc: this.rp,
          sell_price: this.sell_price,
          subtotal: this.detail_total,
          goods: this.detail_goods,
          tax: just_tax,
          warehouse: parseInt(this.detail_warehouse),
          saved_unit: this.unit //for editing purpose only
        };
        // this.invoice_goods[this.edit_index] = editedGoods;
        Vue.set(this.invoice_goods,this.edit_index,editedGoods);
        this.reEvaluateInvoice();
        if(this.mode == 'edit'){
            $('#edit_detail_modal').modal('toggle');
        } else {
            $('#insert_detail_modal').modal('toggle');
        }
      },
      reEvaluateInvoice(){
        let subs = 0;
        let discs = 0;
        let taxs = 0;

        for(var i=0;i<this.invoice_goods.length;i++){
          subs += this.invoice_goods[i].subtotal;
          discs += this.invoice_goods[i].disc;
          taxs += this.invoice_goods[i].tax;
        }
        this.invoice_subtotal = subs;
        this.invoice_disc = discs;
        this.invoice_tax = taxs;
      },
      resetInvoice(){
          this.disable_customer = false;
          this.invoice_customer = [];
          this.invoice_date = moment().format('L');
          this.invoice_due_date = "";
          this.invoice_no = "";
          this.autogen = true;
        this.invoice_goods = [];
        this.invoice_disc =0;
        this.invoice_subtotal =0;
        this.invoice_tax =0;
        this.detail_goods = {};
      },
      resetDetail(){
          this.detail_goods = {};
          this.rp = 0;
          this.percentage =0;
          this.detail_qty = 0;
          this.unit = "1";
          this.detail_goods_unit3 =0;
          this.detail_goods_unit3_conv =0;
          this.detail_goods_unit3_label ="";
          this.detail_goods_unit2 =0;
          this.detail_goods_unit2_conv =0;
          this.detail_goods_unit2_label ="";
          this.detail_goods_unit1 =0;
          this.detail_goods_unit1_conv =0;
          this.detail_goods_unit1_label ="";
      },
      convertUnits(){
          let unit3 =0;
          let unit2 =0;
          let unit1 =0;
          if(this.detail_goods_unit3_conv != 0){
              unit3 = this.detail_goods_unit3 * this.detail_goods_unit3_conv;
          }
          if(this.detail_goods_unit2_conv != 0){
              unit2 = this.detail_goods_unit2 * this.detail_goods_unit2_conv;
          }
          unit1 = parseInt(this.detail_goods_unit1);
          this.detail_qty = unit3 + unit2 + unit1;

      }
    },
    watch: {
        sell_price(){
            this.countDetailTotal();
        },
        detail_goods_unit2(){
            this.convertUnits();
        },
        detail_goods_unit1(){
            this.convertUnits();
        },
        selected_goods(){
            this.detailGoods();
        },
        detail_qty(){
            this.countDetailTotal();
        },
        unit(){
            this.countDetailTotal();
        },
        invoice_customer(){
            if(this.invoice_customer != ""){
                this.selected_customer = _.find(this.customers,  {id: parseInt(this.invoice_customer)});
                this.invoice_due_date = moment(this.invoice_date).add(this.selected_customer.mcustomerdefaultar,'day').format('L');
            }
        },
        invoice_date(){
            this.invoice_due_date = moment(this.invoice_date).add(this.selected_customer.mcustomerdefaultar,'day').format('L');
        },
        detail_goods_unit3(){
            this.convertUnits();
        }
    },
    created(){
      this.fetchConfig();
      this.fetchTax();
      this.fetchCustomers();
      this.fetchGoods();
      this.fetchWareHouses();
      if(this.mode == "edit"){
        this.$parent.$on('edit-selected',(id) => {
          this.editinvoiceid = id;
          this.fetchInvoiceData(id);
        });
      }
      if(this.mode == "view"){
        this.$parent.$on('edit-selected',(id) => {
          this.editinvoiceid = id;
          this.disableCustomer();
          this.fetchInvoiceData(id);
        });
      }

    }
  }
</script>
