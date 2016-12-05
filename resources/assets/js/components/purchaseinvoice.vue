<template>
  <div>

    <div class="row">
      <div class="form form-horizontal" style="margin-top:20px">
        <div class="col-md-8">
          <div class="form-group">
            <label class="col-md-2 control-label">Supplier</label>
            <div class="col-md-8">
              <select v-bind:disabled="!notview" v-selecttwo="supplier_label" v-model="invoice_supplier">
                <option></option>
                <option v-for="sp in suppliers" :value="sp.id">{{ sp.msuppliername }}</option>
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
                <option>Pembelian</option>
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
                  <option></option>
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
                  <th style="width:10%;">Harga Beli</th>
                  <th style="width:10%;">Diskon</th>
                  <th style="width:10%;">Jumlah</th>
                  <th v-if="notview" style="width:10%;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in invoice_goods">
                  <td>{{ item.goods.mgoodscode }}</td>
                  <td>{{ item.goods.mgoodsname }}</td>
                  <td v-priceformatlabel="num_format">{{ item.goods.mgoodspriceout }}</td>
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
                  <div class="form-group">
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
                    <div class="col-md-8 col-md-offset-2">
                      <div class="input-group">
                        <input v-bind:id="conv_1_id" class="form-control forminput" v-bind:placeholder="detail_goods_unit1_label" type="text" v-model="detail_goods_unit1">
                        <span class="input-group-addon" id="sizing-addon2" style="font-size:11px;">{{ detail_goods_unit1_label }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-2">Total Qty</label>
                    <div class="col-md-8">
                      <input placeholder="Kuantitas" class="form-control forminput" value="1" type="text" id="insertdetailgoodsqty" v-model="detail_qty"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-2">Harga Satuan</label>
                    <div class="col-md-8">
                      <input v-priceformat="num_format" class="form-control pricelabel" disabled type="text" id="insertdetailgoodsprice" v-model="detail_goods.mgoodspriceout"/>
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
                        <input v-priceformattype="num_format" v-bind:id="rp_id" v-model="rp" class="form-control forminput pricelabel" placeholder="Rupiah" type="text">
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
                      <select v-selecttwo :disabled="detail_goods.mgoodstaxable == 0" class="form-control" id="insertdetailgoodstax">
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
            suppliers: [],
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
            detail_tax:0,
            detail_warehouse: 0,
            num_format: "0,0.00",
            unit_label: "Pilih Unit",
            barang_label: "Pilih Barang",
            transaksi_label: "Pilih Tipe Transaksi",
            supplier_label: "Pilih Suppplier",
            invoice_supplier:{},
            selected_supplier: {},
            invoice_goods:[],
            invoice_type:"Pembelian",
            invoice_date:moment().format('L'),
            invoice_due_date:"",
            invoice_subtotal:0,
            invoice_disc:0,
            invoice_tax:0,
            invoice_no:"",
            invoice_auto: true
          }
        },
        computed:{
          invoice_grandtotal(){
            return numeral(this.invoice_subtotal - this.invoice_disc + this.invoice_tax).format(this.num_format);
          },
          format_subtotal(){
            return numeral(this.invoice_subtotal).format(this.num_format);
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
          conv_3_id(){
              return this.mode+"_conv3";
          },
          conv_2_id(){
              return this.mode+"_conv2";
          },
          conv_1_id(){
              return this.mode+"_conv1";
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
          }
      },
    watch:{
        invoice_supplier(){
            console.log('change supplier');
            this.selected_supplier = _.find(this.suppliers,  {id: parseInt(this.invoice_supplier)});
            console.log(this.selected_supplier.msupplierdefaultar);
            this.invoice_due_date = moment(this.invoice_date).add(this.selected_supplier.msupplierdefaultar,'day').format('L');
        },
        invoice_date(){
            this.invoice_due_date = moment(this.invoice_date).add(this.selected_supplier.msupplierdefaultar,'day').format('L');
        },
        selected_goods(){
            this.detailGoods();
        },
        detail_goods_unit3(){
            this.convertUnits();
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
        }
    },
    methods: {
        fetchSuppliers(){
            Axios.get('/admin-api/msupplier/datalist').then((res) => {
                this.suppliers = res.data;
            });
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
          });
        },
        fetchWareHouses(){
          Axios.get('/admin-api/mwarehouse/datalist')
          .then((res) => {
            this.warehouses = res.data;
            this.detail_warehouse = res.data[0].id;
          });
        },
        fetchGoods(){
          Axios.get('/admin-api/barang/datalist')
          .then((res) => {
            this.goods = res.data;
          });
        },
        detailGoods(){
            this.detail_state = "insert";
            if(this.selected_goods != ""){
              this.canAddSingle(this.selected_goods);
            }
        },
        canAddSingle(idx){
          var already = _.find(this.invoice_goods,{id: parseInt(idx)});
          if(already == undefined){
              if(this.mode == 'edit'){
                  $('#edit_loading_modal').modal('toggle');
              } else {
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
        countDetailTotal(){
          if(isNaN(this.rp)){
            this.rp = 0;
          }
          this.unit = 1;
          console.log("detail_price "+this.detail_goods.mgoodspriceout);
          this.detail_total = (this.detail_goods.mgoodspriceout * parseInt(this.detail_qty) * parseInt(this.unit)) - parseInt(this.rp);
          console.log("detail_total "+this.detail_total);
          console.log("detail_price "+this.detail_goods.mgoodspriceout);
          console.log("detail_unit "+this.unit);
          console.log("detail_rp "+this.rp);
          console.log("detail_qty "+this.detail_qty);
        },
        countRp(){
          this.rp = (parseInt(this.percentage) / 100) * this.detail_total;
        },
        countPercent(){
          console.log(numeral().unformat(this.rp));
          this.percentage = (numeral().unformat(this.rp)/this.detail_total) * 100;
          console.log(this.detail_total);
          console.log(this.percentage);
          if(isNaN(this.percentage)){
            this.percentage = 0;
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
        predictTax(){
          if(this.detail_goods.mgoodstaxable == 1){
            this.detail_tax = _.find(this.taxes, {id: this.detail_goods.mgoodstaxppn});
          } else {
            this.detail_tax = 0;
          }
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
                this.invoice_tax += (this.detail_tax.mtaxtpercentage /100) * this.detail_total;
                just_tax = (this.detail_tax.mtaxtpercentage /100) * this.detail_total;
            } else {
              this.invoice_tax += 0;
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
              disc: this.rp,
              subtotal: this.detail_total,
              goods: this.detail_goods,
              tax: just_tax,
              warehouse: parseInt(this.detail_warehouse),
              saved_unit: this.unit //for editing purpose only
            };
            this.invoice_goods.push(newGoods);
            this.selected_goods = "";
            this.resetDetail();
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
          console.log('1');
          console.log(this.detail_goods.mgoodspriceout);
          this.countDetailTotal();
          this.countPercent();
          console.log('2');
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
                this.invoice_tax += (this.detail_tax.mtaxtpercentage /100) * this.detail_total;
                just_tax = (this.detail_tax.mtaxtpercentage /100) * this.detail_total;
            } else {
              this.invoice_tax += 0;
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
              disc: this.rp,
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
        removeGoods(idx){
          let good = _.find(this.invoice_goods,  {id: idx});
          this.invoice_subtotal = this.invoice_subtotal - good.subtotal;
          this.invoice_tax = this.invoice_tax - good.tax;
          this.invoice_disc = this.invoice_disc - good.disc;
          this.invoice_goods = this.invoice_goods.filter((g) => {
            return g.id !== idx
          });
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
        saveInvoice(){
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
              msupplierid: this.selected_supplier.msupplierid,
              msuppliername: this.selected_supplier.msuppliername,
              type: this.invoice_type,
              no: this.invoice_no,
              autogen: this.invoice_auto
            }
            console.log(invoice_data);
            Axios.post('/admin-api/purchaseinvoice',invoice_data)
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
        resetInvoice(){
          this.invoice_goods = [];
          this.invoice_disc =0;
          this.invoice_subtotal =0;
          this.invoice_tax =0;
          this.detail_goods = {};
      },
      fetchInvoiceData(id){
          let self = this;
          this.resetDetail();
          this.resetInvoice();
          Axios.get('/admin-api/purchaseinvoice/'+id)
          .then((res) => {
            let data = res.data;
            this.invoice_date = moment(data.mhpurchasedate).format('L');
            //find suppliers
            let spl = _.find(this.suppliers, { msupplierid: data.mhpurchasesupplierid});
            self.invoice_supplier = spl.id+"";
            this.fetchDetailData(data.mhpurchaseno);
          });
      },
      fetchDetailData(inv){
        Axios.get('/admin-api/purchaseinvoice/details/'+inv)
        .then((res) => {
            console.log(res.data);
          for(var i=0;i<res.data.length;i++){
            var item = {
              id: _.find(this.goods,{ mgoodscode: res.data[i].mdpurchasegoodsid}).id,
              subtotal: 0,
              disc: res.data[i].mdpurchasegoodsdiscount,
              goods: _.find(this.goods,{ mgoodscode: res.data[i].mdpurchasegoodsid}),
            //   tax: res.data[i].mdpurchasegoodstax,
                tax: 0,
              warehouse: 0,
              saved_unit: res.data[i].saved_unit+""
            };

            // converted units
            item.detail_goods_unit3 = res.data[i].mdpurchasegoodsunit3;
            item.detail_goods_unit3_conv = res.data[i].mdpurchasegoodsunit3conv;
            item.detail_goods_unit3_label = res.data[i].mdpurchasegoodsunit3label;
            item.detail_goods_unit2 = res.data[i].mdpurchasegoodsunit2;
            item.detail_goods_unit2_conv = res.data[i].mdpurchasegoodsunit2conv;
            item.detail_goods_unit2_label = res.data[i].mdpurchasegoodsunit2label;
            item.detail_goods_unit1 = res.data[i].mdpurchasegoodsunit1;
            item.detail_goods_unit1_conv = res.data[i].mdpurchasegoodsunit1conv;
            item.detail_goods_unit1_label = res.data[i].mdpurchasegoodsunit1label;

            item.usage = res.data[i].mdpurchasegoodsqty;
            item.goods.mgoodsname = res.data[i].mdpurchasegoodsname;
            item.goods.mgoodscode = res.data[i].mdpurchasegoodsid;
            item.goods.mgoodspriceout = this.goodsPrice(res.data[i].mdpurchasegoodsid);
            item.subtotal = parseInt(item.goods.mgoodspriceout) * parseInt(item.usage);
            this.invoice_goods.push(item);
            this.invoice_subtotal += item.subtotal;
            this.invoice_disc += item.disc;
            this.invoice_tax += item.tax;
          }
        });
      },
      goodsPrice(code){
        console.log(code);
        let g = _.find(this.goods,{ mgoodscode: code});
        return parseInt(g.mgoodspriceout);
      },
      updateInvoice(){
        if(this.mode == 'edit'){
            $('#edit_loading_modal').modal('toggle');
        } else {
            $('#insert_loading_modal').modal('toggle');
        }
        let invoice_data = {
          date: this.invoice_date,
          subtotal: this.invoice_subtotal,
          discount: this.invoice_disc,
          tax: this.invoice_tax,
          goods: this.invoice_goods,
          msupplierid: this.selected_supplier.msupplierid,
          msuppliername: this.selected_supplier.msuppliername,
          type: this.invoice_type
        }
        console.log(invoice_data);
        Axios.put('/admin-api/purchaseinvoice/'+this.editinvoiceid,invoice_data)
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
      }
    },
    created(){
        this.fetchGoods();
        this.fetchConfig();
        this.fetchSuppliers();
        this.fetchTax();
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
            this.fetchInvoiceData(id);
          });
        }
    }
}

</script>
