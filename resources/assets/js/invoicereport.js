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

const invoicereport = new Vue({
    el: "#report",
    data:{
        num_format: "0,0.00",
        branches:[],
        warehouses:[],
        selected_branch:"",
        selected_goods:"",
        selected_warehouse:"",
        invoice_date_start: moment().format('L'),
        invoice_date_end: moment().format('L'),
        goods:[],
        returs:[
            "Tanpa Retur",
            "Di Potong Retur"
        ],
        inv:"",
        invoices:[]
    },
    methods:{
        fetchInvoices(){
            var self = this;
            Axios.get('/admin-api/invoicereport?br='+this.selected_branch+"&wh="+this.selected_warehouse+"&goods="+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end)
            .then(function(res){
                console.log(res.data);
                self.invoices = res.data;
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
        printTable(){
            window.open('/admin-nano/reports/invoicereport/export/print?wh='+this.selected_warehouse+'&goods='+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
        },
        pdfTable(){
            window.open('/admin-nano/reports/invoicereport/export/pdf?wh='+this.selected_warehouse+'&goods='+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
        },
        excelTable(){
            window.open('/admin-nano/reports/invoicereport/export/excel?wh='+this.selected_warehouse+'&goods='+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
        },
        csvTable(){
            window.open('/admin-nano/reports/invoicereport/export/csv?wh='+this.selected_warehouse+'&goods='+this.selected_goods+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
        }
    },
    watch:{
        selected_goods(){
            $('#loading_modal').modal('toggle');
            this.fetchInvoices();
        },
        selected_warehouse(){
            $('#loading_modal').modal('toggle');
            this.fetchInvoices();
        },
        invoice_date_start(){
            $('#loading_modal').modal('toggle');
            this.fetchInvoices();
        },
        invoice_date_end(){
            $('#loading_modal').modal('toggle');
            this.fetchInvoices();
        }
    },
    created(){
        $('#loading_modal').modal('toggle');
        this.fetchInvoices();
        this.fetchWarehouses();
        this.fetchGoods();
    }
})
