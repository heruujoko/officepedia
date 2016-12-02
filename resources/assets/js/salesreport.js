import Vue from 'vue/dist/vue.js'
import Axios from 'axios'
import numeral from 'numeral'
import _ from 'lodash'
import moment from 'moment'

Vue.config.devtools = true

Vue.directive('dpicker',{
  inserted(el,binding,vnode){
      let self = this;
      $(el).datepicker({

      }).on('change',(evt) => {
        let modelName = vnode.data.directives.find(function(o) {
            return o.name === 'model';
        }).expression;
        vnode.context[modelName] = evt.target.value;
      });
  },
  update(el,binding,vnode){

  }
});

Vue.directive('selecttwo',{
  inserted(el,binding,vnode){
      let self = this;
  },
  update(el,binding,vnode){
    $(el).select2({
        placeholder: binding.value
    }).on('change',(evt) => {
        let modelName = vnode.data.directives.find(function(o) {
            return o.name === 'model';
        }).expression;
        vnode.context[modelName] = evt.target.value;
    });
  }
});

Vue.directive('priceformatlabel',{
  inserted(el,binding){
    let num = $(el).context.textContent;
    $(el).html(numeral(num).format(binding.value))
  },
  update(el,binding){
  },
  componentUpdated(el,binding){
    let num = numeral().unformat($(el).context.textContent);
    $(el).html(numeral(num).format(binding.value))
  }
});

const stockreport = new Vue({
    el: '#report',
    data: {
        num_format: "0,0.00",
        selected_goods:"",
        selected_warehouse:"",
        selected_sorts:"mhinvoicedate",
        invoice_date_start: moment().format('L'),
        invoice_date_end:moment().format('L'),
        sales: [],
        warehouses:[],
        goods:[],
        brands:[],
        types:[],
        sorts:[
            { id: "mhinvoicedate", label: "Tanggal Invoice"},
            { id: "mwarehouse", label: "Gudang"},
            { id: "mbranch", label: "Cabang"},
            { id: "retur", label: "Total Retur"},
            { id: "mhinvoicecustomername", label: "Nama Customer"}
        ]
    },
    computed:{
        label_warehouse(){
            let self = this;
            if(this.selected_warehouse != ""){
                return _.find(this.warehouses,(wh) => {
                    return wh.id == self.selected_warehouse;
                }).mwarehousename;
            } else {
                return "Semua"
            }
        },
        label_goods(){
            let self = this;
            if(this.selected_goods != ""){
                return _.find(this.goods,(wh) => {
                    return wh.mgoodscode == self.selected_goods;
                }).mgoodsname;
            } else {
                return "Semua"
            }
        },
        invoice_count_total(){
            return _.sumBy(this.sales, (iv) => {
                return iv.detail_count;
            })
        },
        sales_total(){
            return _.sumBy(this.sales, (iv) => {
                return iv.mhinvoicesubtotal_sum;
            })
        },
        free_total(){
            return 0;
        },
        discount_total(){
            return _.sumBy(this.sales, (iv) => {
                return iv.mhinvoicediscounttotal_sum;
            })
        },
        tax_total(){
            return _.sumBy(this.sales, (iv) => {
                return iv.mhinvoicetaxtotal_sum;
            })
        }
    },
    methods:{
        fetchConfig(){
            var self = this;
            Axios.get('/admin-api/mconfig')
                .then(function(res){
                    let separator = res.data.msysnumseparator
                    let decimals = res.data.msysgenrounddec
                    console.log(separator +" "+decimals);
                    if(separator == ',' && decimals == 2){
                        self.num_format = "0,0.00"
                    } else if(separator == ',' && decimals == 0){
                        self.num_format = "0,0"
                    } else if(separator == '.' && decimals == 2){
                        self.num_format = "0.0,00"
                    } else {
                        self.num_format = "0.0"
                    }
                })
                .catch(function(err){
                    console.log(err);
                });
        },
        fetchSales(){
            var self = this;
            Axios.get('/admin-api/salesreport?wh='+this.selected_warehouse+'&goods='+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end)
                .then(function(res){
                    console.log(res.data);
                    self.sales = res.data;
                    $('#loading_modal').modal('toggle');
                })
                .catch(function(err){
                    console.log(err);
                    $('#loading_modal').modal('toggle');
                });
        },
        fetchWarehouses(){
            var self = this;
            Axios.get('/admin-api/mwarehouse/datalist')
            .then(function(res){
                console.log(res.data);
                self.warehouses = res.data;
            })
            .catch(function(err){
                console.log(err);
            });
        },
        fetchGoods(){
            var self = this;
            Axios.get('/admin-api/barang/datalist')
            .then(function(res){
                console.log(res.data);
                self.goods = res.data;
            })
            .catch(function(err){
                console.log(err);
            });
        },
        sortData(){
            var self = this;
            this.sales = _.sortBy(this.sales,function(sl){
                return sl[self.selected_sorts];
            });
        },
        printTable(){
            window.open('/admin-nano/reports/salesreport/export/print?wh='+this.selected_warehouse+'&goods='+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
        },
        pdfTable(){
            window.open('/admin-nano/reports/salesreport/export/pdf?wh='+this.selected_warehouse+'&goods='+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
        },
        excelTable(){
            window.open('/admin-nano/reports/salesreport/export/excel?wh='+this.selected_warehouse+'&goods='+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
        },
        csvTable(){
            window.open('/admin-nano/reports/salesreport/export/csv?wh='+this.selected_warehouse+'&goods='+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
        }
    },
    watch:{
        selected_goods(){
            $('#loading_modal').modal('toggle');
            this.fetchSales();
        },
        selected_warehouse(){
            $('#loading_modal').modal('toggle');
            this.fetchSales();
        },
        selected_sorts(){
            this.sortData();
        },
        invoice_date_start(){
            $('#loading_modal').modal('toggle');
            this.fetchSales();
        },
        invoice_date_end(){
            $('#loading_modal').modal('toggle');
            this.fetchSales();
        }
    },
    created(){
        $('#loading_modal').modal('toggle');
        this.fetchConfig();
        this.fetchSales();
        this.fetchWarehouses();
        this.fetchGoods();
    }
})
