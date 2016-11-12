var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';

$('#edit-msyscomptaxable').on('change',function(event){
  console.log(event);
  if($('#edit-msyscomptaxable').is(':checked')){
    $('#edit-msyscomptaxabledate').prop('disabled',false);
    $('#edit-msyscomptaxablenumber').prop('disabled',false);

  } else {
    $('#edit-msyscomptaxabledate').prop('disabled',true);
    $('#edit-msyscomptaxablenumber').prop('disabled',true);
  }
});

$(document).ready(function(){

  $('.datepicker').datepicker({
    format: "yyyy-mm-dd",
    defaultViewDate: { year: 2016, month: 01, day: 01 }
  });

  // $('.nice-toggle').bootstrapSwitch({
  //   size: 'mini',
  //   onText: "Yes",
  //   offText: "No"
  // });
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
        $('#edit-msyscomptaxable').attr('checked',true);
        $('#edit-msyscomptaxabledate').prop('disabled',false);
        $('#edit-msyscomptaxablenumber').prop('disabled',false);
        
      } else {
        
         $('#edit-msyscomptaxable').removeAttr('checked');
         $('#edit-msyscomptaxabledate').prop('disabled',true);
        $('#edit-msyscomptaxablenumber').prop('disabled',true);

      }
      $('#edit-msyscomptaxabledate').val(response.msyscomptaxabledate);
      $('#edit-msyscomptaxablenumber').val(response.msyscomptaxablenumber);
      $('#edit-msyscompklu').val(response.msyscompklu);
      $('#edit-msyscomptaxpayeridaddress').val(response.msyscomptaxpayeridaddress);

      if(response.msysgenmanufacturingacc == true){
         $('#edit-msysgenmanufacturingacc').attr('checked',true);
      } else {
        $('#edit-msysgenmanufacturingacc').removeAttr('checked');
      }
      if(response.msysgenmultibranch == true){
        $('#edit-msysgenmultibranch').attr('checked',true);
      } else {
         $('#edit-msysgenmultibranch').removeAttr('checked');
      }
      if(response.msysgenmulticurrency == true){
        
         $('#edit-msysgenmulticurrency').attr('checked',true);
      } else {
        $('#edit-msysgenmulticurrency').removeAttr('checked');
      }
      if(response.msysgenapproval == true){
        $('#edit-msysgenapproval').attr('checked',true);
      } else {
         $('#edit-msysgenapproval').removeAttr('checked');
      }
      if(response.msysgendefaulttax == true){
        $('#edit-msysgendefaulttax').attr('checked',true);
      } else {
        $('#edit-msysgendefaulttax').removeAttr('checked');
      }
      if(response.msysgenfixedasset == true){
        $('#edit-msysgenfixedasset').attr('checked',true);
      } else {
         $('#edit-msysgenfixedasset').removeAttr('checked');
      }

      $('#edit-msysgenrounddec').val(response.msysgenrounddec).change();

      $('#edit-msysnumseparator').val(response.msysnumseparator).change();
      if(response.msysnumseparatorset == 1){
        $('#edit-msysnumseparator').attr('disabled',true);
      }
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
      // Example Form
      $('#edit-msysprefixgoodsexample').text(response.msysprefixgoods+response.msysprefixgoodslastcount);
      $('#edit-msysprefixsupplierexample').text(response.msysprefixsupplier+response.msysprefixsupplierlastcount);
      $('#edit-msysprefixcustomerexample').text(response.msysprefixcustomer+response.msysprefixcustomerlastcount);
      $('#edit-msysprefixemployeeexample').text(response.msysprefixemployee+response.msysprefixemployeelastcount);
      $('#edit-msysprefixinvquotationexample').text(response.msysprefixinvquotation+response.msysprefixinvquotationlastcount);
      $('#edit-msysprefixinvorderexample').text(response.msysprefixinvorder+response.msysprefixinvorderlastcount);
      $('#edit-msysprefixinvoiceexample').text(response.msysprefixinvoice+response.msysprefixinvoicelastcount);
      $('#edit-msysprefixpurchrequestexample').text(response.msysprefixpurchrequest+response.msysprefixpurchrequestlastcount);
      $('#edit-msysprefixpurchorderexample').text(response.msysprefixpurchorder+response.msysprefixpurchorderlastcount);
      $('#edit-msysprefixpurchinvexample').text(response.msysprefixpurchinv+response.msysprefixpurchinvlastcount);
      $('#edit-msysprefixedassetexample').text(response.msysprefixedasset+response.msysprefixedassetlastcount);
      $('#edit-msysprefixcashreceiptexample').text(response.msysprefixcashreceipt+response.msysprefixcashreceiptlastcount);
      $('#edit-msysprefixcashoutexample').text(response.msysprefixcashout+response.msysprefixcashoutlastcount);
      $('#edit-msysprefixbankreconexample').text(response.msysprefixbankrecon+response.msysprefixbankreconlastcount);

      $('#msysstreet').val(response.msysstreet);
      $('#msyscity').val(response.msyscity);
      $('#msyszipcode').val(response.msyszipcode);
      $('#msysprovince').val(response.msysprovince);
      $('#msyscountry').val(response.msyscountry);
    }
  });
}

function update_params(){
  $('#insert-wrapper').parsley().validate();
  if($('#insert-wrapper').parsley().isValid()){

    var detail_address = $('#msysstreet').val()+" "+$('#msyscity').val()+" "+$('#msyszipcode').val()+" "+$('#msysprovince').val()+" "+$('#msyscountry').val();

    var data = {
      msyscompname: $('#edit-msyscompname').val(),
      msyscompphone: $('#edit-msyscompphone').val(),
      msyscompfax: $('#edit-msyscompfax').val(),
      msyscompemail: $('#edit-msyscompemail').val(),
      msyscompwebsite: $('#edit-msyscompwebsite').val(),
      msyscompstartdate: $('#edit-msyscompstartdate').val(),
      msyscompcurrency: $('#edit-msyscompcurrency').val(),
      msyscompaddress: detail_address,
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
      msysprefixbankrecon: $('#edit-msysprefixbankrecon').val(),
      msysstreet: $('#msysstreet').val(),
      msyscity: $('#msyscity').val(),
      msyszipcode: $('#msyszipcode').val(),
      msysprovince: $('#msysprovince').val(),
      msyscountry: $('#msyscountry').val(),
      msysnumseparator: $('#edit-msysnumseparator').val(),
      msysnumseparatorset: 1
    };
    $.ajax({
      method: 'PUT',
      url: API_URL+"/mconfig",
      dataType: "json",
      data: data,
      success: function(response){
        console.log(response);
        window.location.href="sysparam";
        swal({
          title: "Konfigurasi Di Simpan!",
          type: "success",
          timer: 1000
        });
      },
      error: function(response){
        console.log(response);
      }
    });
  } else {
    if($('#menu1').find('ul.parsley-errors-list li').length > 0){
      $('.nav-tabs a[href="#menu1"]').tab('show')
    } else if($('#menu2').find('ul.parsley-errors-list li').length > 0){
      $('.nav-tabs a[href="#menu2"]').tab('show')
    } else if($('#menu3').find('ul.parsley-errors-list li').length > 0){
      $('.nav-tabs a[href="#menu3"]').tab('show')
    } else {

    }
  }

}
