import Vue from 'vue/dist/vue.js'
import Axios from 'axios'
import moment from 'moment'
import numeral from 'numeral'
import _ from 'lodash';

Vue.config.devtools = true

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
	inserted(el,binding){
		let num = $(el).context.textContent;
		$(el).html(numeral(num).format(binding.value))
	},
	update(el,binding){
	},
	componentUpdated(el,binding){
		let num = numeral().unformat($(el).context.textContent);
		$(el).html(numeral(num).format(binding.value))
	}
});

Vue.directive('numberformatlabel',{
	inserted(el,binding){
		let num = $(el).context.textContent;
		$(el).html(numeral(num).format("0,0"))
	},
	update(el,binding){
	},
	componentUpdated(el,binding){
		let num = numeral().unformat($(el).context.textContent);
		$(el).html(numeral(num).format("0,0"))
	}
});

const stockcardreport = new Vue({
	el: '#stockcardreport',
	data: {
		stocks: [],
		warehouses: [],
		goods: [],
		mstockcardgoodsid: "",
		mstockcardwhouse: "",
		num_format: "0,0.00",
		invoice_date_start:moment().format('L'),
        invoice_date_end:moment().format('L'),

	},
    computed:{
        label_warehouse(){
            let self = this;
            if(this.mstockcardwhouse != ""){
                let wh = _.find(this.warehouses,(wh) => {
                    return wh.id == self.mstockcardwhouse;
                });
                return wh.mwarehousename;
            } else {
                return "Semua"
            }
        },
        label_goods(){
            let self = this;
            if(this.mstockcardgoodsid != ""){
                let g =  _.find(this.goods,(wh) => {
                    return wh.mgoodscode == self.mstockcardgoodsid;
                });
                return g.mgoodscode+" "+g.mgoodsname;
            } else {
                return "Semua"
            }
        }
    },
	methods: {
		fetchStocks(){
            $('#loading_modal').modal('toggle');
			var self = this;
			self.stocks = [];
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
                $('#stockwhouse').trigger('change');
			})
			.catch(function(err){
				console.log(err);
			});
		},
        updateWarehouse(){
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
				$('#loading_modal').modal('toggle');
				self.goods = res.data;
				console.log(res.data);
			})
			.catch(function(){
				console.log(err);
			});
		},
		printTable(){
            window.open('/admin-nano/reports/stockreport/export/print?wh='+this.mstockcardwhouse+'&goods='+this.mstockcardgoodsid+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&mstockcardwhouse='+this.mstockcardwhouse,'_blank');
        },
        pdfTable(){
            window.open('/admin-nano/reports/stockreport/export/pdf?wh='+this.mstockcardwhouse+'&goods='+this.mstockcardgoodsid+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&mstockcardwhouse='+this.mstockcardwhouse,'_blank');
        },
        excelTable(){
            window.open('/admin-nano/reports/stockreport/export/excel?wh='+this.mstockcardwhouse+'&goods='+this.mstockcardgoodsid+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&mstockcardwhouse='+this.mstockcardwhouse,'_blank');
        },
        csvTable(){
            window.open('/admin-nano/reports/stockreport/export/csv?wh='+this.mstockcardwhouse+'&goods='+this.mstockcardgoodsid+'&start='+this.invoice_date_start+'&end='+this.invoice_date_end+'&mstockcardwhouse='+this.mstockcardwhouse,'_blank');
        }
	},
	created(){
		this.fetchStocks();
		this.fetchWarehouse();
		this.fetchGoods();
        this.$on('update-warehouses', () => {
            this.updateWarehouse();
        })
	}

});

window.stockcardreport = stockcardreport;
