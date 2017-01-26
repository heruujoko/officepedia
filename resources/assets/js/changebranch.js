import Vue from 'vue/dist/vue.js'
import Axios from 'axios'

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
    data: {
        branch_label: "Pilih Cabang",
        selected_branch: "",
        branches: [],
        default_done: false
    },
    methods:{
        fetchBranches(){
            Axios.get('/admin-api/profile/branch')
            .then(res => {
                this.branches = res.data
            });
        },
        fetchDefaultBranches(){
            Axios.get('/admin-api/profile/defaultbranch')
            .then(res => {
                console.log('------');
                console.log(res.data);
                if(res.data != ""){
                    console.log('fetchDefaultBranches');
                    console.log(res.data);
                    this.selected_branch = res.data.id
                    $('#branch_switch').val(res.data.id);
                    $('#branch_switch').trigger('change');
                } else {
                    this.selected_branch = res.data
                }

            });
        },
        updateBranch(){
            let data = {
                branch: this.selected_branch
            }

            Axios.post('/admin-api/profile/defaultbranch',data)
            .then(res => {
                this.fetchDefaultBranches()
            });
        }
    },
    watch: {
        selected_branch(){
            if(this.selected_branch != ""){
                this.updateBranch();
            }
        }
    },
    created(){
        this.default_done = false;
        console.log('changebranch component');
        this.fetchBranches()
        this.fetchDefaultBranches()
    }
})
