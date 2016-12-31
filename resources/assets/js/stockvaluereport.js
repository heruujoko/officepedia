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
    //   let num = numeral().unformat($(el).context.textContent);
    //   console.log(num);
    //   $(el).html(numeral(num).format(binding.value))
  },
  componentUpdated(el,binding){
    if($(el).context.textContent != ""){
        let num = numeral().unformat($(el).context.textContent);
        $(el).html(numeral(num).format(binding.value))
    } else {
        $(el).html("");
    }

  }
});

const stockvaluereport = new Vue({
    el: "#stockvalueapp",
    data: {
        branches:[],
        suppliers: [],
        goods:[],
        warehouses:[],
        stockvalues:[],
        sorts:[],
        selected_branch:"",
        selected_supplier:"",
        selected_goods:"",
        selected_warehouse:"",
        selected_sort:"",
        num_format:"0,0.00",
        invoice_date_end:moment().format('L')
    },
    computed:{
        label_branch(){
            return "Semua";
        },
        label_supplier(){
            if(this.selected_supplier != ""){
                let spl = _.find(this.suppliers,{msupplierid: this.selected_supplier});
                return spl.msuppliername;
            } else {
                return "Semua";
            }
        },
        label_goods(){
            if(this.selected_goods != ""){
                let spl = _.find(this.goods,{mgoodscode: this.selected_goods});
                return spl.mgoodsname;
            } else {
                return "Semua";
            }
        },
        label_warehouse(){
            if(this.selected_warehouse != ""){
                let wh = _.find(this.warehouses,(w) => {
                    return w;
                });
                return wh.mwarehousename;
            } else {
                return "Semua";
            }
        },
        sum_stockvalues(){
            let sums = _.sumBy(this.stockvalues,(o) => {
                return o.stock * o.cogs;
            });
            return sums;
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
        fetchBranches(){

        },
        fetchSuppliers(){
            Axios.get('/admin-api/msupplier/datalist').then((res) => {
                this.suppliers = res.data;
            });
        },
        fetchGoods(){
			var self = this;
			Axios.get('/admin-api/barang/datalist').then(function(res){
				self.goods = res.data;
			})
			.catch(function(){
				console.log(err);
			});
		},
        fetchStockValues(){
            $('#loading_modal').modal('toggle');
            var self = this;
			Axios.get('/admin-api/stockvalues?goods='+this.selected_goods+"&spl="+this.selected_supplier+"&end="+this.invoice_date_end).then(function(res){
				$('#loading_modal').modal('toggle');
				self.stockvalues = res.data;
			})
			.catch(function(){
				console.log(err);
			});
        },
        fetchWarehouses(){
            var self = this;
			Axios.get('/admin-api/mwarehouse/datalist').then(function(res){
				self.warehouses = res.data;
			})
			.catch(function(){
				console.log(err);
			});
        },
        printTable(){
            window.open('/admin-nano/reports/stockvalue/export/print?goods='+this.selected_goods+"&spl="+this.selected_supplier+"&end="+this.invoice_date_end);
        },
        pdfTable(){
            window.open('/admin-nano/reports/stockvalue/export/pdf?goods='+this.selected_goods+"&spl="+this.selected_supplier+"&end="+this.invoice_date_end);
        },
        excelTable(){
            window.open('/admin-nano/reports/stockvalue/export/excel?goods='+this.selected_goods+"&spl="+this.selected_supplier+"&end="+this.invoice_date_end);
        },
        csvTable(){
            window.open('/admin-nano/reports/stockvalue/export/csv?goods='+this.selected_goods+"&spl="+this.selected_supplier+"&end="+this.invoice_date_end);
        }
    },
    created(){
        // $('#loading_modal').modal('toggle');
        this.fetchConfig();
        this.fetchSuppliers();
        this.fetchGoods();
        this.fetchWarehouses();
        this.fetchStockValues();
    }
});
