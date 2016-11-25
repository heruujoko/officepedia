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

const arreport = new Vue({
    el:"#report",
    data: {
        num_format:"0,0.00",
        ars:[],
        branches:[],
        customers:[],
        sorts:[
            {id:"marcarddate",label:"Days of Aging"},
            {id:"marcarddate",label:"Tgl Invoice"},
            {id:"marcardduedate",label:"Tgl Jatuh Tempo"},
            {id:"marcardcustomername",label:"Nama Customer"}
        ],
        selected_branch:"",
        selected_sort:"",
        selected_customer:"",
        invoice_date_start:moment().format('L'),
        invoice_date_end:moment().format('L')
    },
    methods:{
        fetchArs(){
            var self = this;
            Axios.get('/admin-api/arreport?start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&cust='+this.selected_customer)
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
            window.open('/admin-nano/reports/arreport/export/print?br='+this.selected_branch+'&cust='+this.selected_customer+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
        },
        pdfTable(){
            window.open('/admin-nano/reports/arreport/export/pdf?br='+this.selected_branch+'&cust='+this.selected_customer+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
        },
        excelTable(){
            window.open('/admin-nano/reports/arreport/export/excel?br='+this.selected_branch+'&cust='+this.selected_customer+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
        },
        csvTable(){
            window.open('/admin-nano/reports/arreport/export/csv?br='+this.selected_branch+'&cust='+this.selected_customer+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end,'_blank');
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
        this.fetchCustomers();
        this.fetchArs();
    }
});
