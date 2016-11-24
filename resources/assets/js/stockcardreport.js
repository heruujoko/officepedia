import Vue from 'vue/dist/vue.js'
import Axios from 'axios'

Vue.config.devtools = true

const stockcardreport = new Vue({
	el: '#stockcardreport',
	data: {
		stocks: [],
		warehouses: [],
		goods: [],
	
	},
	methods: {
		fetchStocks(){
			var self = this;
			Axios.get('/admin-api/mstockcardreport').then(function(res){
				self.stocks = res.data;
				

			})
			.catch(function(err){
				console.log(err);
			});
		},
		fetchWarehouse(){
			var self = this;
			Axios.get('/admin-api/mwarehouse/datalist').then(function(res){
				self.warehouses = res.data;
				
				
			})
			.catch(function(err){
				console.log(err);
			});
		},
		fetchGoods(){
			var self = this;
			Axios.get('/admin-api/barang/datalist').then(function(res){
				self.goods = res.data;
				console.log(res.data);
			})
			.catch(function(){
				console.log(err);
			});
		}
	},
	created(){
		this.fetchStocks();
		this.fetchWarehouse();
		this.fetchGoods();
	}

});
