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

const apreportapp = new Vue({
    el: "#apreportapp",
    data: {
        branches:[],
        suppliers: [],
        aps:[],
        sorts:[],
        selected_branch:"",
        selected_supplier:"",
        selected_sort:"",
        num_format:"0,0.00",
        invoice_date_end: moment().format('L')
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
        fetchAps(){
            Axios.get('/admin-api/apreport?br='+this.selected_branch+'&spl='+this.selected_supplier+"&end="+this.invoice_date_end).then((res) => {
                $('#loading_modal').modal('toggle');
                this.aps = res.data;
            });
        },
        printTable(){
            window.open('/admin-nano/reports/apreport/export/print?br='+this.selected_branch+'&spl='+this.selected_supplier);
        },
        pdfTable(){
            window.open('/admin-nano/reports/apreport/export/pdf?br='+this.selected_branch+'&spl='+this.selected_supplier);
        },
        excelTable(){
            window.open('/admin-nano/reports/apreport/export/excel?br='+this.selected_branch+'&spl='+this.selected_supplier);
        },
        csvTable(){
            window.open('/admin-nano/reports/apreport/export/csv?br='+this.selected_branch+'&spl='+this.selected_supplier);
        }
    },
    watch:{
        selected_supplier(){
            $('#loading_modal').modal('toggle');
            this.fetchAps();
        },
        selected_branch(){
            $('#loading_modal').modal('toggle');
            this.fetchAps();
        },
        invoice_date_end(){
            $('#loading_modal').modal('toggle');
            this.fetchAps();
        }
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
        total_invs(){
            let sums = 0;
            if(this.aps.length > 0){
                for(var i=0;i<this.aps.length;i++){
                    if(this.aps[i].mapcardtotalinv != undefined){
                        sums += this.aps[i].mapcardtotalinv;
                    }
                }
            }
            return sums;
        },
        total_outs(){
            let sums = 0;
            if(this.aps.length > 0){
                for(var i=0;i<this.aps.length;i++){
                    // if(this.aps[i].mapcardoutstanding != undefined){
                    //     sums += this.aps[i].mapcardoutstanding;
                    // }
                    if((this.aps[i].mapcardpayamount > 0) && this.aps[i].mapcardpayamount != undefined){
                        console.log(" - "+this.aps[i].mapcardpayamount);
                        sums -= this.aps[i].mapcardpayamount;
                    } else if((this.aps[i].mapcardpayamount <= 0) && this.aps[i].mapcardpayamount != undefined) {
                        console.log(" + "+this.aps[i].mapcardoutstanding);
                        sums += this.aps[i].mapcardoutstanding;
                    } else {
                        console.log('else');
                    }
                }
            }
            return sums;
        }
    },
    created(){
        $('#loading_modal').modal('toggle');
        this.fetchConfig();
        this.fetchBranches();
        this.fetchSuppliers();
        this.fetchAps();
    }
});
