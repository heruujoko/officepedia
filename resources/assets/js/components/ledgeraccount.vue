<template>
    <div>
        <table class="table table-bordered" id="tableacc">
            <thead>
                <tr>
                    <th>No Akun</th>
                    <th>Nama Akun</th>
                    <th>Tipe Akun</th>
                    <th>Balance</th>
                    <th>Saldo</th>
                    <th>Buku Besar</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(acc,index) in accounts">
                    <td style="width: 5%" v-if="acc.type == 'gp'">{{ acc.mcoagrandparentcode }}</td>
                    <td style="width: 5%" v-if="acc.type == 'p'">
                        <span v-if="acc.mcoaparentcode == '1103.00' " style="margin-left: 25px"><a href="/admin-nano/reports/arbook">{{ acc.mcoaparentcode }}</a></span>
                        <span v-else style="margin-left: 25px">{{ acc.mcoaparentcode }}</span>
                    </td>
                    <td style="width: 5%" v-if="acc.type == 'coa'">
                        <span v-if="acc.mcoaparentcode == '1103.00' " style="margin-left: 55px"><a href="/admin-nano/reports/arbook">{{ acc.mcoacode }}</a></span>
                        <span v-else style="margin-left: 55px">{{ acc.mcoacode }}</span>
                    </td>
                    <td style="width: 10%" v-if="acc.type == 'gp'">{{ acc.mcoagrandparentname }}</td>
                    <td style="width: 10%" v-if="acc.type == 'p'">
                        <span v-if="acc.mcoaparentcode == '1103.00' "><a href="/admin-nano/reports/arbook">{{ acc.mcoaparentname }}</a></span>
                        <span v-else>{{ acc.mcoaparentname }}</span>
                    </td>
                    <td style="width: 10%" v-if="acc.type == 'coa'">
                        <span v-if="acc.mcoaparentcode == '1103.00' "><a href="/admin-nano/reports/arbook">{{ acc.mcoaname }}</a></span>
                        <span v-else>{{ acc.mcoaname }}</span>
                    </td>
                    <td style="width: 5%">Aktifa / Aset</td>
                    <td style="width: 2%" v-if="acc.saldo >= 0">D</td>
                    <td style="width: 2%" v-if="acc.saldo < 0">K</td>
                    <td style="text-align: right;width: 5%"><span v-priceformatlabel="num">{{ acc.saldo }}</span></td>
                    <td style="width: 1%" v-if="acc.type == 'coa'">
                        <input type="checkbox" @click="select_account(index)">
                    </td>
                    <td style="width: 1%" v-else></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    import Axios from 'axios'
    export default {
        props: ['num'],
        data(){
            return {
                accounts: [],
                selected_account:[]
            }
        },
        methods:{
            fetchAccounts(){
                $('#loading_modal').modal('toggle');
                Axios.get('/admin-api/coaledger')
                .then( res => {
                    $('#loading_modal').modal('toggle');
                    this.accounts = res.data;
                })
                .catch( err => {
                    $('#loading_modal').modal('toggle');
                    console.log(err);
                })
            },
            select_account(index){
                let mcoacode = this.accounts[index].mcoacode;

                let idx = this.selected_account.indexOf(mcoacode);

                if(idx < 0){
                    this.selected_account.push(mcoacode);
                } else {
                    this.selected_account.splice(idx,1);
                }

                console.log(this.selected_account);
                this.$parent.$emit('selection',this.selected_account);

            }
        },
        created(){
            this.fetchAccounts();
        }

    }
</script>
