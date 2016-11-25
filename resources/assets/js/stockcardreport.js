import Vue from 'vue/dist/vue.js'
import Axios from 'axios'
import moment from 'moment'

Vue.config.devtools = true

const stockcardreport = new Vue({
	el: '#stockcardreport',
	data: {
		stocks: [],
		warehouses: [],
		goods: [],
		mstockcardgoodsid: "",
		mstockcardwhouse: "",
		invoice_date_start:moment().format('L'),
        invoice_date_end:moment().format('L'),
	
	},
		
	methods: {
		fetchStocks(){
			var self = this;
			Axios.get('/admin-api/mstockcardreport?start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&mstockcardgoodsid='+this.mstockcardgoodsid+'&mstockcardwhouse='+this.mstockcardwhouse).then(function(res){
				$('#loading_modal').modal('toggle');
				self.stocks = res.data;
				

			})
			.catch(function(err){
				console.log(err);
			});
		},
		fetchWarehouse(){
			var self = this;
			Axios.get('/admin-api/mwarehouse/datalist').then(function(res){
				$('#loading_modal').modal('toggle');
				self.warehouses = res.data;
				
				
			})
			.catch(function(err){
				console.log(err);
			});
		},
		fetchGoods(){
			var self = this;
			Axios.get('/admin-api/barang/datalist').then(function(res){
				$('#loading_modal').modal('toggle');
				self.goods = res.data;
				console.log(res.data);
			})
			.catch(function(){
				console.log(err);
			});
		}
	},
	watch:{
		invoice_date_start(){
            $('#loading_modal').modal('toggle');
            this.fetchStocks();
        },
        invoice_date_end(){
            $('#loading_modal').modal('toggle');
            this.fetchStocks();
        },
        mstockcardgoodsid(){
        	$('#loading_modal').modal('toggle');
            this.fetchStocks();
        },
        mstockcardwhouse(){
        	$('#loading_modal').modal('toggle');
            this.fetchStocks();
        }
	},
	created(){
		$('#loading_modal').modal('toggle');
		this.fetchStocks();
		this.fetchWarehouse();
		this.fetchGoods();
	}

});
