var API_URL = '/nano/public/admin-api';
var WEB_URL = '/nano/public/admin-nano';

$(document).ready(function(){

  $('.datepicker').datepicker({
    format: "yyyy-mm-dd",
    defaultViewDate: { year: 2016, month: 01, day: 01 }
  });

  $('.nice-toggle').bootstrapSwitch({
    size: 'mini',
    onText: "Yes",
    offText: "No"
  });
  $('.nice-toggle').change(function(){
  });
  fetch_params_data();
});

function fetch_params_data(){
  $.ajax({
    method: "GET",
    url: API_URL+"/mconfig",
    contentType: "application/json",
    dataType: 'json',
    success: function(response){
      console.log(response);
      $('#edit-msyscompname').val(response.msyscompname);
      $('#edit-msyscompphone').val(response.msyscompphone);
      $('#edit-msyscompfax').val(response.msyscompfax);
      $('#edit-msyscompemail').val(response.msyscompemail);
      $('#edit-msyscompwebsite').val(response.msyscompwebsite);
      $('#edit-msyscompstartdate').val(response.msyscompstartdate);
      $('#edit-msyscompcurrency').val(response.msyscompcurrency);
      $('#edit-msyscompaddress').val(response.msyscompaddress);
      $('#edit-msyscomplogo').val(response.msyscomplogo);
      $("#logoimageid").attr('src', response.msyscomplogo);
      $('#edit-msyscomptaxpayeridnumber').val(response.msyscomptaxpayeridnumber);
      if(response.msyscomptaxable == true){
        $('#edit-msyscomptaxable').bootstrapSwitch('state',true);
      } else {
        $('#edit-msyscomptaxable').bootstrapSwitch('state',false);
      }
      $('#edit-msyscomptaxabledate').val(response.msyscomptaxabledate);
      $('#edit-msyscomptaxablenumber').val(response.msyscomptaxablenumber);
      $('#edit-msyscompklu').val(response.msyscompklu);
      $('#edit-msyscomptaxpayeridaddress').val(response.msyscomptaxpayeridaddress);

      if(response.msysgenmanufacturingacc == true){
        $('#edit-msysgenmanufacturingacc').bootstrapSwitch('state',true);
      } else {
        $('#edit-msysgenmanufacturingacc').bootstrapSwitch('state',false);
      }
      if(response.msysgenmultibranch == true){
        $('#edit-msysgenmultibranch').bootstrapSwitch('state',true);
      } else {
        $('#edit-msysgenmultibranch').bootstrapSwitch('state',false);
      }
      if(response.msysgenmulticurrency == true){
        $('#edit-msysgenmulticurrency').bootstrapSwitch('state',true);
      } else {
        $('#edit-msysgenmulticurrency').bootstrapSwitch('state',false);
      }
      if(response.msysgenapproval == true){
        $('#edit-msysgenapproval').bootstrapSwitch('state',true);
      } else {
        $('#edit-msysgenapproval').bootstrapSwitch('state',false);
      }
      if(response.msysgendefaulttax == true){
        $('#edit-msysgendefaulttax').bootstrapSwitch('state',true);
      } else {
        $('#edit-msysgendefaulttax').bootstrapSwitch('state',false);
      }
      if(response.msysgenfixedasset == true){
        $('#edit-msysgenfixedasset').bootstrapSwitch('state',true);
      } else {
        $('#edit-msysgenfixedasset').bootstrapSwitch('state',false);
      }
      $('#edit-msysgenrounddec').val(response.msysgenrounddec).change();

      $('#edit-msysprefixgoods').val(response.msysprefixgoods);
      $('#edit-msysprefixgoodslastcount').val(response.msysprefixgoodslastcount);
      $('#edit-msysprefixsupplier').val(response.msysprefixsupplier);
      $('#edit-msysprefixsupplierlastcount').val(response.msysprefixsupplierlastcount);
      $('#edit-msysprefixcustomer').val(response.msysprefixcustomer);
      $('#edit-msysprefixcustomerlastcount').val(response.msysprefixcustomerlastcount);
      $('#edit-msysprefixemployee').val(response.msysprefixemployee);
      $('#edit-msysprefixemployeelastcount').val(response.msysprefixemployeelastcount);
      $('#edit-msysprefixinvquotation').val(response.msysprefixinvquotation);
      $('#edit-msysprefixinvquotationlastcount').val(response.msysprefixinvquotationlastcount);
      $('#edit-msysprefixinvorder').val(response.msysprefixinvorder);
      $('#edit-msysprefixinvorderlastcount').val(response.msysprefixinvorderlastcount);
      $('#edit-msysprefixinvoice').val(response.msysprefixinvoice);
      $('#edit-msysprefixinvoicelastcount').val(response.msysprefixinvoicelastcount);
      $('#edit-msysprefixpurchrequest').val(response.msysprefixpurchrequest);
      $('#edit-msysprefixpurchrequestlastcount').val(response.msysprefixpurchrequestlastcount);
      $('#edit-msysprefixpurchrequest').val(response.msysprefixpurchrequest);
      $('#edit-msysprefixpurchrequestlastcount').val(response.msysprefixpurchrequestlastcount);
      $('#edit-msysprefixpurchorder').val(response.msysprefixpurchorder);
      $('#edit-msysprefixpurchorderlastcount').val(response.msysprefixpurchorderlastcount);
      $('#edit-msysprefixpurchinv').val(response.msysprefixpurchinv);
      $('#edit-msysprefixpurchinvlastcount').val(response.msysprefixpurchinvlastcount);
      $('#edit-msysprefixedasset').val(response.msysprefixedasset);
      $('#edit-msysprefixedassetlastcount').val(response.msysprefixedassetlastcount);
      $('#edit-msysprefixcashreceipt').val(response.msysprefixcashreceipt);
      $('#edit-msysprefixcashreceiptlastcount').val(response.msysprefixcashreceiptlastcount);
      $('#edit-msysprefixcashout').val(response.msysprefixcashout);
      $('#edit-msysprefixcashoutlastcount').val(response.msysprefixcashoutlastcount);
      $('#edit-msysprefixbankrecon').val(response.msysprefixbankrecon);
      $('#edit-msysprefixbankreconlastcount').val(response.msysprefixbankreconlastcount);
    }
  });
}

function update_params(){

  var data = {
    msyscompname: $('#edit-msyscompname').val(),
    msyscompphone: $('#edit-msyscompphone').val(),
    msyscompfax: $('#edit-msyscompfax').val(),
    msyscompemail: $('#edit-msyscompemail').val(),
    msyscompwebsite: $('#edit-msyscompwebsite').val(),
    msyscompstartdate: $('#edit-msyscompstartdate').val(),
    msyscompcurrency: $('#edit-msyscompcurrency').val(),
    msyscompaddress: $('#edit-msyscompaddress').val(),
    msyscomplogo: $('#edit-msyscomplogo').val(),
    msyscomptaxpayeridnumber: $('#edit-msyscomptaxpayeridnumber').val(),
    msyscomptaxable: $('#edit-msyscomptaxable').is(':checked'),
    msyscomptaxabledate: $('#edit-msyscomptaxabledate').val(),
    msyscomptaxablenumber: $('#edit-msyscomptaxablenumber').val(),
    msyscompklu: $('#edit-msyscompklu').val(),
    msyscomptaxpayeridaddress: $('#edit-msyscomptaxpayeridaddress').val(),
    msysgenmanufacturingacc: $('#edit-msysgenmanufacturingacc').is(':checked'),
    msysgenmultibranch: $('#edit-msysgenmultibranch').is(':checked'),
    msysgenmulticurrency: $('#edit-msysgenmulticurrency').is(':checked'),
    msysgendefaulttax: $('#edit-msysgendefaulttax').is(':checked'),
    msysgenapproval: $('#edit-msysgenapproval').is(':checked'),
    msysgenfixedasset: $('#edit-msysgenfixedasset').is(':checked'),
    msysgenrounddec: $('#edit-msysgenrounddec').val(),
    msysprefixgoods: $('#edit-msysprefixgoods').val(),
    msysprefixsupplier: $('#edit-msysprefixsupplier').val(),
    msysprefixcustomer: $('#edit-msysprefixcustomer').val(),
    msysprefixemployee: $('#edit-msysprefixemployee').val(),
    msysprefixinvquotation: $('#edit-msysprefixinvquotation').val(),
    msysprefixinvorder: $('#edit-msysprefixinvorder').val(),
    msysprefixinvoice: $('#edit-msysprefixinvoice').val(),
    msysprefixpurchrequest: $('#edit-msysprefixpurchrequest').val(),
    msysprefixpurchorder: $('#edit-msysprefixpurchorder').val(),
    msysprefixpurchinv: $('#edit-msysprefixpurchinv').val(),
    msysprefixedasset: $('#edit-msysprefixedasset').val(),
    msysprefixcashreceipt: $('#edit-msysprefixcashreceipt').val(),
    msysprefixcashout: $('#edit-msysprefixcashout').val(),
    msysprefixbankrecon: $('#edit-msysprefixbankrecon').val()
  };
  $.ajax({
    method: 'PUT',
    url: API_URL+"/mconfig",
    dataType: "json",
    data: data,
    success: function(response){
      console.log(response);
      window.location.href="#forminput";
      swal({
        title: "Input Berhasil!",
        type: "success",
        timer: 1000
      });
    },
    error: function(response){
      console.log(response);
    }
  })
}
