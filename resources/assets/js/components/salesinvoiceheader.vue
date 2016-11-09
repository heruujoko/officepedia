<template>
  <div class="form form-horizontal" style="margin-top:20px">
    <div class="col-md-8">
      <div class="form-group">
        <label class="col-md-2 control-label">Pelanggan</label>
        <div class="col-md-8">
          <select v-selecttwo url="/admin-api/pelanggan/datalist">
            <option>sadhasfdh</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">Tanggal</label>
        <div class="col-md-8">
          <input type="text" class="form-control datepicker" />
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label class="col-md-2 control-label">Type</label>
        <div class="col-md-8">
          <select class="select2 form-control">
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
</template>
<script>
  import axios from 'axios'
  import vSelect from 'vue-select'

  export default {
    data(){
      return {
        customers: []
      }
    },
    components: {vSelect},
    methods:{
      fetchCustomerData(){
        axios.get('/admin-api/pelanggan/datalist').then((response) => {
          this.customers = response.data;
        });
      }
    },
    ready(){
      this.fetchCustomerData();
    }
  }
</script>
