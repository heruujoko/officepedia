import Vue from 'vue/dist/vue.js'
import Axios from 'axios'
import Invoice from './components/payapconcept.vue'
import ElementUI from 'element-ui'

Vue.use(ElementUI);

Vue.config.devtools = true

var typingTimerCash;
var typingTimerBank;
var doneTypingInterval = 1000;

Vue.directive('selecttwo',{
  inserted(el,binding,vnode){
      let self = this;
  },
  update(el,binding,vnode){
    $(el).select2({
        width: "100%",
        placeholder: binding.value
    }).on('change',(evt) => {
        let modelName = vnode.data.directives.find(function(o) {
            return o.name === 'model';
        }).expression;
        vnode.context[modelName] = evt.target.value;
    });
  }
});

Vue.directive('priceformatcash',{
  inserted(el,binding){
    let formatted = numeral($(el).val()).format(binding.value);
    $(el).val(formatted);
  },
  update(el,binding){
    clearTimeout(typingTimerCash);
    typingTimerCash = setTimeout(() => {
        let formatted = numeral(numeral().unformat($(el).val())).format(binding.value);
        $(el).val(formatted);
        if($(el).is(':focus')){
            $(el).select();
        }

    }, doneTypingInterval);
  },
});

Vue.directive('priceformatbank',{
  inserted(el,binding){
    let formatted = numeral($(el).val()).format(binding.value);
    $(el).val(formatted);
  },
  update(el,binding){
    clearTimeout(typingTimerBank);
    typingTimerBank = setTimeout(() => {
        let formatted = numeral(numeral().unformat($(el).val())).format(binding.value);
        $(el).val(formatted);
        if($(el).is(':focus')){
            $(el).select();
        }

    }, doneTypingInterval);
  },
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
  },
  componentUpdated(el,binding){
    let num = numeral().unformat($(el).context.textContent);
    $(el).html(numeral(num).format(binding.value))
  }
});

const payapp = new Vue({
    el: '#main',
    components: {
      invoice: Invoice
    },
    created(){
      console.log('purchase app ready');
    }
})

//add vue to globals
window.payapp = payapp;
