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

const cogshistoryapp = new Vue({
    el: "#cogshistoryapp",
    data: {
        histories:[],
        goods:[],
        num_format: "0,0.00",
        invoice_date_end: moment().format('L'),
        selected_goods:""
    },
    computed:{
        label_goods(){
            let self = this;
            if(self.selected_goods != ""){
                let g =  _.find(this.goods,(wh) => {
                    return wh.mgoodscode == self.selected_goods;
                });
                return g.mgoodscode+" "+g.mgoodsname;
            } else {
                return "Semua"
            }
        }
    },
    methods:{
        fetchGoods(){
          Axios.get('/admin-api/barang/datalist')
          .then((res) => {
            this.goods = res.data;
          });
        },
        fetchHistories(){
          $('#loading_modal').modal('toggle');
          Axios.get('/admin-api/cogshistory?goods='+this.selected_goods+"&end="+this.invoice_date_end)
          .then((res) => {
            $('#loading_modal').modal('toggle');
            this.histories = res.data;
            });
        },
        printTable(){
            window.open('/admin-nano/reports/cogshistory/export/print?goods='+this.selected_goods+"&end="+this.invoice_date_end);
        },
        pdfTable(){
            window.open('/admin-nano/reports/cogshistory/export/pdf?goods='+this.selected_goods+"&end="+this.invoice_date_end);
        },
        excelTable(){
            window.open('/admin-nano/reports/cogshistory/export/excel?goods='+this.selected_goods+"&end="+this.invoice_date_end);
        },
        csvTable(){
            window.open('/admin-nano/reports/cogshistory/export/csv?goods='+this.selected_goods+"&end="+this.invoice_date_end);
        }
    },
    created(){
        this.fetchGoods();
        this.fetchHistories();
    }
});
