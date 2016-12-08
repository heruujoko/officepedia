import Vue from 'vue/dist/vue.js'
import Axios from 'axios'
import numeral from 'numeral'
import _ from 'lodash'
import moment from 'moment'

Vue.config.devtools = true

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


const purchasereportapp = new Vue({
    el: "#purchasereportapp",
    data:{
        purchases:[],
        goods:[],
        branches:[],
        suppliers:[],
        warehouses:[],
        sorts:[],
        selected_branch:"",
        selected_supplier:"",
        selected_goods:"",
        selected_warehouse:"",
        selected_sort:""
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
        }
    },
    methods:{
        printTable(){
            window.open('/admin-nano/reports/purchasereport/export/print?goods='+this.selected_goods+'&wh='+this.selected_warehouse+'&spl='+this.selected_supplier);
        },
        pdfTable(){
            window.open('/admin-nano/reports/purchasereport/export/pdf?goods='+this.selected_goods+'&wh='+this.selected_warehouse+'&spl='+this.selected_supplier);
        },
        excelTable(){
            window.open('/admin-nano/reports/purchasereport/export/excel?goods='+this.selected_goods+'&wh='+this.selected_warehouse+'&spl='+this.selected_supplier);
        },
        csvTable(){
            window.open('/admin-nano/reports/purchasereport/export/csv?goods='+this.selected_goods+'&wh='+this.selected_warehouse+'&spl='+this.selected_supplier);
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
        fetchWarehouses(){
            var self = this;
			Axios.get('/admin-api/mwarehouse/datalist').then(function(res){
				self.warehouses = res.data;
			})
			.catch(function(){
				console.log(err);
			});
        },
        fetchPurchases(){
            var self = this;
			Axios.get('/admin-api/purchasereport?goods='+this.selected_goods+'&wh='+this.selected_warehouse+'&spl='+this.selected_supplier).then(function(res){
                $('#loading_modal').modal('toggle');
				self.purchases = res.data;
			})
			.catch(function(){
				console.log(err);
			})
        }
    },
    watch:{
        selected_goods(){
            $('#loading_modal').modal('toggle');
            this.fetchPurchases();
        },
        selected_supplier(){
            $('#loading_modal').modal('toggle');
            this.fetchPurchases();
        },
        selected_warehouse(){
            $('#loading_modal').modal('toggle');
            this.fetchPurchases();
        },
        selected_branch(){
            $('#loading_modal').modal('toggle');
            this.fetchPurchases();
        }
    },
    created(){
        $('#loading_modal').modal('toggle');
        this.fetchBranches();
        this.fetchSuppliers();
        this.fetchGoods();
        this.fetchWarehouses();
        this.fetchPurchases();
    }
});
