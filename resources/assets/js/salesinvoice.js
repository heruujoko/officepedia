import Vue from 'vue';
import axios from 'axios';
import Header from './components/salesinvoiceheader.vue'

Vue.config.devtools = true;

Vue.directive('selecttwo',{
  bind: function () {
        var vm = this.vm;
        var key = this.expression;

        var select = $(this.el);
        console.log(select);
        select.select2({
          width: "100%",
        });

        // select.on('change', function () {
        //     vm.$set(key, select.val());
        // });
    },
    update(){

    }
})

var vm = new Vue({
  el: '#salesinvoiceapp',
  components: {
    'invheader': Header
  },
  data: {
    customers: {}
  },
  methods: {
    test(){
      console.log('testing');
    },
    custchange(){
      console.log('change');
    }
  }
});
