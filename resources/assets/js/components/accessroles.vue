<template>
    <div>
        <div class="row" v-show="mode != 'insert'" v-on:click="toInsertMode">
            <button class="btn btn-default pull-right" style="margin-right:4%">Kembali</button>
        </div>
        <br>
    </div>
</template>

<script>
    export default {
        props: ['mode'],
        data(){
            return {

            }
        },
        methods: {
            toInsertMode(){}
        }

    }
</script>
