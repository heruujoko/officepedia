var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';

var currency = "";
var subtotal_summary = 0;
var current_subtotal =0; //without discount and tax
var tax_summary = 0;
var discount_summary = 0;
var current_discount = 0;
var current_item_tax_percent = 0;
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

function fetch_current_tax(id){
  $.ajax({
    url: API_URL+'/mtax/'+id,
    method: "GET",
    success: function(response){
      current_item_tax_percent = parseInt(response.mtaxtpercentage);
    },
    error: function(response){

    }
  })
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
        if(response.mgoodsunit3conv != '0'){
          $('#insertdetailgoodsunit').append('<option>'+response.mgoodsunit3+'</option>');
          insert_units[response.mgoodsunit2] = response.mgoodsunit2conv;
        }
        $('#insertdetailgoodsunit').select2({ width: "100%"});
        insert_units[response.mgoodsunit3] = response.mgoodsunit3conv;
      } else {
        $('#insertdetailgoodsunit').append('<option>Unit</option>');
        $('#insertdetailgoodsunit').select2({ width: "100%"});
      }

      //check tax
      if(response.mgoodstaxable == "1"){
        $('#insertdetailgoodstax').attr('disabled',true);
        fetch_current_tax(response.mgoodstaxppn);
      } else {
        $('#insertdetailgoodstax').attr('disabled',true);
        $('#insertdetailgoodstax').val('').change();
      }
      $('#insert_detail_modal').modal('toggle');
      $('#loading_modal').modal('toggle');
    },
    error: function(response){
      console.log(response);
    }
  });
}

function insert_add_item(){
  var selected = current_item_insert;
  var unit_str = $('#insertdetailgoodsunit').val();
  selected.grandtotal = numeral().unformat($('#insertdetailgoodstotal').val());
  selected.subtotal = current_subtotal;
  selected.usestock = numeral().unformat($('#insertdetailgoodsqty').val()) * parseInt(insert_units[unit_str]);
  add_to_stack(selected);
}

function add_to_stack(obj){
  insert_stack.push(obj);
  push_to_table_insert();
}

function push_to_table_insert(){
  var htmls = "<tr><td>"+current_item_insert.mgoodsname+"</td><td>"+current_item_insert.mgoodscode+"</td><td style='text-align:right'>"+numeral(current_item_insert.grandtotal).format(currency)+"</td></tr>";
  $('#insertdetailtable > tbody:last-child').append(htmls);
  $('#insert_detail_modal').modal('toggle');
  update_insert_summary(current_item_insert.subtotal);
}

function insert_recount_unit_price(){
  var base_price = numeral().unformat($('#insertdetailgoodsprice').val());
  var unit_str = $('#insertdetailgoodsunit').val();
  var count = numeral().unformat($('#insertdetailgoodsqty').val());
  console.log($('#insertdetailgoodsprice').val());
  console.log(base_price);
  var new_price = base_price * parseInt(insert_units[unit_str]) * count;
  current_subtotal = new_price;
  var new_price = new_price - numeral().unformat($('#insert-detailgoodsdiscrp').val());
  new_price = numeral(new_price).format(currency);
  $('#insertdetailgoodstotal').val(new_price);

}

$('#insert-selectgoods').on('select2:select',function(evt){
  fetch_goods_data($(this).val());
  $('#loading_modal').modal('toggle');
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

    //discount

    current_discount = numeral().unformat($('#insert-detailgoodsdiscrp').val());
    discount_summary += current_discount;
    $('#insertdisc').html(numeral(discount_summary).format(currency));
    // tax

    tax_summary += (current_item_tax_percent/100) * subtotal_summary;
    $('#insertppn').html(numeral(tax_summary).format(currency));


    $('#inserttotal').html(numeral(subtotal_summary+tax_summary-discount_summary).format(currency));
    reset_insert_detail_vars();
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

function reset_insert_detail_vars(){
    current_item_tax_percent = 0;
    current_item_insert = {};
}

function reset_insert_summary_vars(){
  subtotal_summary =0;
  tax_summary =0;
  discount_summary =0;
}


// General Form

function insert_invoice(){
  var data = {
    customer: $('#insertinvoicecustomer').val(),
    date: $('#insertinvoicedate').val(),
    type: $('#insertinvoicetype').val(),
    goods: insert_stack,
    subtotal: subtotal_summary,
    tax: tax_summary,
    discount: discount_summary
  };

  console.log(data);

  $.ajax({
    url: API_URL+"/salesinvoice",
    method: "POST",
    data: data,
    success: function(response){
      console.log(response);
      swal({
        title: "Input Berhasil!",
        type: "success",
        timer: 1000
      });
      reset_insert_summary_vars();
    },
    error: function(response){
      console.log('err');
      console.log(response);
    }
  })
}
