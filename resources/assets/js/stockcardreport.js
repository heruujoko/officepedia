import Vue from 'vue/dist/vue.js'
import Axios from 'axios'

Vue.config.devtools = true

const stockcardreport = new Vue({
	el: '#stockcardreport',
	data: {
		stocks: [],

	},
	methods: {
		fetchStocks(){
			console.log('test');
		}
	},
	created(){
		this.fetchStocks();
	}

});
