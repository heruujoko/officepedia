<template>
  <div>

    <div class="row">
      <div class="form form-horizontal" style="margin-top:20px">
        <div class="col-md-8">
          <div class="form-group">
            <label class="col-md-2 control-label">Pelanggan</label>
            <div class="col-md-8">
              <select v-selecttwo="pelanggan_label" v-model="invoice_customer">
                <option v-for="c in customers" :value="c.id">{{ c.mcustomername }}</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label">Tanggal</label>
            <div class="col-md-8">
              <input v-dpicker v-model="invoice_date" type="text" class="form-control" id="insertinvoicedate" />
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label class="col-md-2 control-label">Type</label>
            <div class="col-md-8">
              <select v-selecttwo="transaksi_label" class="form-control" v-model="invoice_type">
                <option>Penjualan</option>
                <option>Retur Penjualan</option>
                <option>Pembelian</option>
                <option>Retur Pembelian</option>
                <option>Pembatalan</option>
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
              <select class="form-control" id="insert-selectgoods" v-selecttwo="barang_label" v-model="selected_goods">
                <option v-for="g in goods" :value="g.id">{{ g.mgoodsname }}</option>
              </select>
            </div>
            <div class="col-md-6">
              <button class="pull-right btn btn-primary" v-on:click="saveInvoice">Proses</button>
            </div>
          </div>
          <div class="row">
            <br><br>
            <table id="insertdetailtable" class="table table-bordered">
              <thead>
                <tr>
                  <th style="width:55%;">Nama Biaya</th>
                  <th style="width:15%;">Kode</th>
                  <th style="width:25%;">Jumlah</th>
                  <th style="width:5%;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in invoice_goods">
                  <td>{{ item.goods.mgoodsname }}</td>
                  <td>{{ item.goods.mgoodscode }}</td>
                  <td>{{ item.usage }}</td>
                  <td><a v-on:click="removeGoods(item.goods.id)"><span style="color:red">Hapus</span></a></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="row">
            <br>
            <div class="col-md-2 col-md-offset-4">
              <h5>Sub Total</h5>
              <p id="insertsubtotal"  >{{ format_subtotal }}</p>
            </div>
            <div class="col-md-2">
              <h5>Discount</h5>
              <p id="insertdisc"  >{{ format_disc }}</p>
            </div>
            <div class="col-md-2">
              <h5>PPN 10%</h5>
              <p id="insertppn" >{{ format_tax }}</p>
            </div>
            <div class="col-md-2">
              <h5>Total</h5>
              <p>{{ invoice_grandtotal }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="loading_modal" class="modal" style="top: 20%;" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    	<div class="modal-dialog">
    		<div class="modal-content">
    			<div class="modal-header" style="text-align: center">
    				<h3>Loading Data</h3>
    				<img src="/master/ajax-loader.gif">
    			</div>
    		</div>
    	</div>
    </div>

    <div id="insert_detail_modal" class="modal" style="top: 15%;" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
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
                  <div class="form-group">
                    <label class="control-label col-md-2">Kuantitas</label>
                    <div class="col-md-4">
                      <input placeholder="Kuantitas" class="form-control forminput" value="1" type="text" id="insertdetailgoodsqty" v-model="detail_qty"/>
                    </div>
                    <div class="col-md-4">
                      <select v-selecttwo v-model="unit">
                        <option selected :value="1">Unit</option>
                        <option v-if="detail_goods.mgoodsmultiunit" :value="detail_goods.mgoodsunit2conv">{{ detail_goods.mgoodsunit2 }}</option>
                        <option v-if="detail_goods.mgoodsunit3conv != 0" :value="detail_goods.mgoodsunit3conv">{{ detail_goods.mgoodsunit3 }}</option>
                      </select>
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
                        <input id="detail_percent" v-model="percentage" class="form-control forminput" placeholder="Persentase" type="text">
                        <span class="input-group-addon" id="sizing-addon2" style="font-size:8px;">%</span>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon" id="sizing-addon2" style="font-size:8px;">Rp</span>
                        <input id="detail_rp" v-model="rp" class="form-control forminput pricelabel" placeholder="Rupiah" type="text">
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
    				<button type="button" class="btn btn-primary" v-on:click="addToGoods">
    				      Lanjut
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

  export default {
    data(){
      return {
        warehouses: [],
        customers: [],
        goods: [],
        taxes: [],
        selected_goods: "",
        detail_goods: {},
        unit: 1,
        detail_qty:1,
        percentage: 0,
        rp:0,
        detail_total: 0,
        detail_tax:0,
        detail_warehouse: 0,
        num_format: "0,0.00",
        barang_label: "Pilih Barang",
        transaksi_label: "Pilih Tipe Transaksi",
        pelanggan_label: "Pilih Pelanggan",
        invoice_customer:{},
        selected_customer: {},
        invoice_goods:[],
        invoice_type:"",
        invoice_date:"",
        invoice_subtotal:0,
        invoice_disc:0,
        invoice_tax:0
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
      }
    },
    methods: {
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
        });
      },
      fetchCustomers(){
        Axios.get('/admin-api/pelanggan/datalist')
        .then((res) => {
          console.log('ajax done');
          this.customers = res.data;
        });
      },
      fetchGoods(){
        Axios.get('/admin-api/barang/datalist')
        .then((res) => {
          console.log('ajax done');
          this.goods = res.data;
        });
      },
      fetchGoodsSingle(id){
        Axios.get('/admin-api/barang/'+id)
        .then((res) => {
          console.log('ajax done');
          this.detail_goods = res.data;
          let self = this;
          console.log(res.data);
          $('#loading_modal').modal('toggle');
          $('#insert_detail_modal').modal('toggle');
          $('#detail_rp').on('keyup',function(){
            self.countPercent();
            self.countDetailTotal();
          });
          $('#detail_percent').on('keyup',function(){
            self.countRp();
            self.countDetailTotal();
          });
          this.countDetailTotal();
          this.predictTax();
        });
      },
      detailGoods(){
        $('#loading_modal').modal('toggle');
        this.fetchGoodsSingle(this.selected_goods);
      },
      countDetailTotal(){
        if(isNaN(this.rp)){
          this.rp = 0;
        }
        this.detail_total = (this.detail_goods.mgoodspriceout * parseInt(this.detail_qty) * parseInt(this.unit)) - parseInt(this.rp);
      },
      countRp(){
        this.rp = (parseInt(this.percentage) / 100) * this.detail_total;
      },
      countPercent(){
        this.percentage = (this.rp/this.detail_total) * 100;
      },
      addToGoods(){
        $('#insert_detail_modal').modal('toggle');
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
          usage: parseInt(this.detail_qty) * parseInt(this.unit),
          disc: this.rp,
          subtotal: this.detail_total,
          goods: this.detail_goods,
          tax: just_tax,
          warehouse: parseInt(this.detail_warehouse)
        };
        this.invoice_goods.push(newGoods);
      },
      predictTax(){
        console.log('predicting tax');
        if(this.detail_goods.mgoodstaxable == 1){
          this.detail_tax = _.find(this.taxes, {id: this.detail_goods.mgoodstaxppn});
        } else {
          this.detail_tax = 0;
        }
      },
      saveInvoice(){
        let invoice_data = {
          date: this.invoice_date,
          subtotal: this.invoice_subtotal,
          discount: this.invoice_disc,
          tax: this.invoice_tax,
          goods: this.invoice_goods,
          mcustomerid: this.selected_customer.mcustomerid,
          mcustomername: this.selected_customer.mcustomername,
          type: this.invoice_type
        }
        console.log(invoice_data);
        Axios.post('/admin-api/salesinvoice',invoice_data)
        .then((res) => {
          console.log(res);
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
          console.log(err);
          swal({
            title: "Oops!",
            text: "Transaksi gagal, periksa kembali input",
            type: "error",
            timer: 1000
          });
        })
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
      resetInvoice(){
        this.invoice_goods = [];
        this.invoice_disc =0;
        this.invoice_subtotal =0;
        this.invoice_tax =0;
        this.detail_goods = {};
      }
    },
    watch: {
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
        this.selected_customer = _.find(this.customers,  {id: parseInt(this.invoice_customer)});
      }
    },
    created(){
      this.fetchConfig();
      this.fetchTax();
      this.fetchCustomers();
      this.fetchGoods();
      this.fetchWareHouses();
    }
  }
</script>
