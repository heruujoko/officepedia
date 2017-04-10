import Vue from 'vue/dist/vue.js'
import numeral from 'numeral'

import ARBook from './components/arbookreport.vue'

Vue.config.devtools = true

const arcustreport = new Vue({
    el:"#report",
    components: {
        arbook: ARBook
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
  bind(){
    Vue.nextTick(arcustreport);
  },
  inserted(el,binding){
      console.log('oinit');
    let num = $(el).context.textContent;
    $(el).html(numeral(num).format(binding.value))
  },
  update(el,binding){
      // let num = numeral().unformat($(el).context.textContent);
      // console.log('update lib',num);
      // $(el).html(numeral(num).format(binding.value))
  },
  componentUpdated(el,binding){
    if($(el).context.textContent != ""){
        let num = numeral().unformat($(el).context.textContent);
        console.log('update lib 2',num);
        $(el).html(numeral(num).format(binding.value))
        Vue.nextTick(() => {
            let num = numeral().unformat($(el).context.textContent);

            console.log('update lib 2 next',$(el));
        });
    } else {
        $(el).html("");
    }

  }
});
