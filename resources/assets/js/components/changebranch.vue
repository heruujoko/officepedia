<template>
    <div>
        <label for="" style="color:white;font-size: 12px;">Cabang</label>
        <select v-model="selected_branch" v-selecttwo="branch_label" id="branch_switch">
            <option v-for="branch in branches" :value="branch.id">{{ branch.mbranchname}}</option>
        </select>
    </div>
</template>

<script>
    import Axios from 'axios'
    export default {
        props: ['active'],
        data(){
            return {
                branch_label: "Pilih Cabang",
                selected_branch: "",
                branches: [],
                default_done: false
            };
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
                    let self = this;
                    setTimeout(function(){
                        $('.tableapi').DataTable().ajax.reload();
                        console.log('wh0 '+self.active);
                        if(self.active == 'stockcardreport'){
                            refreshWarehouses();
                        }
                        if(self.active == 'payap' || self.active == 'payar'){
                            refreshPayment();
                        }
                    },500);
                }
            }
        },
        created(){
            this.default_done = false;
            console.log('changebranch component');
            this.fetchBranches()
            this.fetchDefaultBranches()
        }
    }
</script>
