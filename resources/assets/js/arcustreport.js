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

const arcustreport = new Vue({
    el:"#report",
    data: {
        branches:[],
        customers:[],
        ars:[],
        selected_branch:"",
        selected_customer:"",
        invoice_date_start: moment().format('L'),
        invoice_date_end: moment().format('L'),
        sorts:[
            { id: "marcarddate", label: "Tanggal Invoice"}
        ],
        selected_sort:"marcarddate"
    },
    methods:{
        fetchArs(){
            var self = this;
            Axios.get('/admin-api/arcustreport?br='+this.selected_branch+'&cust='+this.selected_customer+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end)
            .then(function(res){
                $('#loading_modal').modal('toggle');
                self.ars = res.data;
            })
            .catch(function(err){
                $('#loading_modal').modal('toggle');
                console.log(err);
            });
        },
        fetchCustomers(){
            var self = this;
            Axios.get('/admin-api/pelanggan/datalist')
            .then(function(res){
                self.customers = res.data;
            })
            .catch(function(err){
                console.log(err);
            });
        },
        sortData(){
            var self = this;
            this.ars = _.sortBy(this.ars,function(sl){
                return sl[self.selected_sort];
            });
        },
        printTable(){
            window.open('/admin-nano/reports/arcustreport/export/print?start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&cust='+this.selected_customer+'&br='+this.selected_branch,'_blank');
        },
        pdfTable(){
            window.open('/admin-nano/reports/arcustreport/export/pdf?start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&cust='+this.selected_customer+'&br='+this.selected_branch,'_blank');
        },
        excelTable(){
            window.open('/admin-nano/reports/arcustreport/export/excel?start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&cust='+this.selected_customer+'&br='+this.selected_branch,'_blank');
        },
        csvTable(){
            window.open('/admin-nano/reports/arcustreport/export/csv?start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&cust='+this.selected_customer+'&br='+this.selected_branch,'_blank');
        }
    },
    watch:{
        invoice_date_start(){
            $('#loading_modal').modal('toggle');
            this.fetchArs();
        },
        invoice_date_end(){
            $('#loading_modal').modal('toggle');
            this.fetchArs();
        },
        selected_customer(){
            $('#loading_modal').modal('toggle');
            this.fetchArs();
        },
        selected_sort(){
            this.sortData();
        }
    },
    created(){
        $('#loading_modal').modal('toggle');
        this.fetchArs();
        this.fetchCustomers();
    }
});
