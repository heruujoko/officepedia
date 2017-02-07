import Vue from 'vue/dist/vue.js'
import Changer from './components/changebranch.vue'

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

const changebranch = new Vue({
    el: '#branchswitcher',
    components: {
        'changer': Changer
    }
})
