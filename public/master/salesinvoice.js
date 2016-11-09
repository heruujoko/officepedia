var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';

var currency = "";
var subtotal_summary = 0;
var tax_summary = 0;
var insert_stack = [];
var insert_units = [];
var current_item_insert = {};
insert_units['Unit'] = 1;

$(document).ready(function(){
  fetch_currency_config();
});

function fetch_currency_config(){
  $.ajax({
    url: API_URL+'/mconfig',
    type: 'GET',
    success: function(response){
      var separator = response.msysnumseparator;
      var decimals = parseInt(response.msysgenrounddec);

      if(separator == "," && decimals == 0){
        currency = "0,0";
      } else if(separator == "," && decimals == 2){
        currency = "0,0.00";
      } else if(separator == "." && decimals == 0){
        currency = "0.0";
      } else {
        currency = "0.0,00";
      }
    },
    error: function(){

    }
  });
}

function fetch_goods_data(id){
  $.ajax({
    url : API_URL+'/barang/'+id,
    type : 'GET',
    success: function(response){
      current_item_insert = response;
      $('#insertdetailgoodsname').val(response.mgoodsname);
      $('#insertdetailgoodsprice').val(numeral(response.mgoodspriceout).format(currency));
      $('#insertdetailgoodstotal').val(numeral(response.mgoodspriceout).format(currency));
      $('#insert-detailgoodsdisc').val(0);
      $('#insert-detailgoodsdiscrp').val(0);
      $('#insertdetailgoodsunit').empty();
      $('#insertdetailgoodsunit').select2('destroy');
      //check units
      if(response.mgoodsmultiunit == "1"){
        $('#insertdetailgoodsunit').append('<option>Unit</option>');
        $('#insertdetailgoodsunit').append('<option>'+response.mgoodsunit2+'</option>');
        if(response.mgoodsunit3 !== ''){
          $('#insertdetailgoodsunit').append('<option>'+response.mgoodsunit3+'</option>');
          insert_units[response.mgoodsunit2] = response.mgoodsunit2conv;
        }
        $('#insertdetailgoodsunit').select2({ width: "100%"});
        insert_units[response.mgoodsunit3] = response.mgoodsunit3conv;
      } else {
        $('#insertdetailgoodsunit').append('<option>Unit</option>');
        $('#insertdetailgoodsunit').select2({ width: "100%"});
      }

    },
    error: function(response){
      console.log(response);
    }
  });
}

function insert_add_item(){
  var selected = current_item_insert;
  selected.grandtotal = numeral().unformat($('#insertdetailgoodstotal').val());
  add_to_stack(selected);
}

function add_to_stack(obj){
  insert_stack.push(obj);
  console.log(insert_stack);
  push_to_table_insert();
}

function push_to_table_insert(){
  var htmls = "<tr><td>"+current_item_insert.mgoodsname+"</td><td>"+current_item_insert.mgoodscode+"</td><td style='text-align:right'>"+numeral(current_item_insert.grandtotal).format(currency)+"</td></tr>";
  $('#insertdetailtable > tbody:last-child').append(htmls);
  $('#insert_detail_modal').modal('toggle');
  update_insert_summary(current_item_insert.grandtotal);
}

function insert_recount_unit_price(){
  var base_price = numeral().unformat($('#insertdetailgoodsprice').val());
  var unit_str = $('#insertdetailgoodsunit').val();
  var count = numeral().unformat($('#insertdetailgoodsqty').val());
  console.log($('#insertdetailgoodsprice').val());
  console.log(base_price);
  var new_price = base_price * parseInt(insert_units[unit_str]) * count;
  var new_price = new_price - numeral().unformat($('#insert-detailgoodsdiscrp').val());
  new_price = numeral(new_price).format(currency);
  $('#insertdetailgoodstotal').val(new_price);

}

$('#insert-selectgoods').on('select2:select',function(evt){
  console.log($(this).val());
  $('#insert_detail_modal').modal('toggle');
  fetch_goods_data($(this).val());
});

function convert_to_rp(base_price,disc){
  return (base_price/100) * disc;
}

function convert_to_disc(base_price,rp){
  return (rp/base_price) *100;
}

function insert_validate_discount(){
  var base_price = numeral().unformat($('#insertdetailgoodsprice').val());
  var unit_str = $('#insertdetailgoodsunit').val();
  var count = numeral().unformat($('#insertdetailgoodsqty').val());
  base_price = base_price * parseInt(insert_units[unit_str]) * count;
  var rp = convert_to_rp(base_price,$('#insert-detailgoodsdisc').val());
  $('#insert-detailgoodsdiscrp').val(numeral(rp).format(currency));
  insert_recount_unit_price();
}

function update_insert_summary(subtotal){
    subtotal_summary += subtotal;
    $('#insertsubtotal').html(numeral(subtotal_summary).format(currency));
    $('#inserttotal').html(numeral(subtotal_summary-tax_summary).format(currency));

}

// watcher

$('#insertdetailgoodsqty').on('keyup',function(){
  insert_recount_unit_price();
  insert_validate_discount();
});

$('#insertdetailgoodsunit').on('select2:select',function(){
  insert_recount_unit_price();
  insert_validate_discount();
});

$('#insert-detailgoodsdisc').on('keyup',function(){
    insert_validate_discount();
});

$('#insert-detailgoodsdiscrp').on('keyup',function(){
  var base_price = numeral().unformat($('#insertdetailgoodsprice').val());
  var unit_str = $('#insertdetailgoodsunit').val();
  var count = numeral().unformat($('#insertdetailgoodsqty').val());
  base_price = base_price * parseInt(insert_units[unit_str]) * count;
  $('#insert-detailgoodsdisc').val(convert_to_disc(base_price,$('#insert-detailgoodsdiscrp').val()));
  insert_recount_unit_price();
});
