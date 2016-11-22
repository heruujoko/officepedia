import Vue from 'vue/dist/vue.js'
import Axios from 'axios'
import numeral from 'numeral'
import _ from 'lodash'

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
        sales: [],
        warehouses:[],
        goods:[],
        sorts:[
            { id: "mhinvoicedate", label: "Tanggal Invoice"},
            { id: "mwarehouse", label: "Gudang"},
            { id: "mbranch", label: "Cabang"},
            { id: "retur", label: "Total Retur"},
            { id: "mhinvoicecustomername", label: "Nama Customer"}
        ]
    },
    methods:{
        fetchSales(){
            var self = this;
            Axios.get('/admin-api/salesreport?wh='+this.selected_warehouse+'&goods='+this.selected_goods)
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
            window.open('export/print?wh='+this.selected_warehouse+'&goods='+this.selected_goods,'_blank');
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
        }
    },
    created(){
        $('#loading_modal').modal('toggle');
        this.fetchSales();
        this.fetchWarehouses();
        this.fetchGoods();
    }
})
