import Vue from 'vue/dist/vue.js'
import Axios from 'axios'
import Invoice from './components/invoicecomponent.vue'

Vue.config.devtools = true

Vue.directive('selecttwo',{
  inserted(el,binding,vnode){
      let self = this;
  },
  update(el,binding,vnode){

    $(el).select2({
        width: "100%"
    }).on('change',(evt) => {
        let modelName = vnode.data.directives.find(function(o) {
            return o.name === 'model';
        }).expression;
        vnode.context[modelName] = evt.target.value;
    });
  }
});

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

Vue.directive('priceformat',{
  inserted(el,binding){
    let formatted = numeral($(el).val()).format(binding.value);
    $(el).val(formatted);
  },
  update(el,binding){
    let formatted = numeral($(el).val()).format(binding.value);
    $(el).val(formatted);
  },
});

Vue.directive('priceformatlabel',{
  inserted(el,binding){
    let num = $(el).context.textContent;
    $(el).html(numeral(num).format(binding.value))
  },
  update(el,binding){
    // let num = $(el).context.textContent;
    // $(el).html(numeral(num).format(binding.value))
  },
  componentUpdated(el,binding){
    let num = $(el).context.textContent;
    $(el).html(numeral(num).format(binding.value))
  }
});

const invoiceapp = new Vue({
  el: '#main',
  components: {
    invoice: Invoice
  },
  created(){
    console.log('invoice app ready');
  }
});
