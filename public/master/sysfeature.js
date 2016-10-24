var API_URL = '/public/admin-api';
var WEB_URL = '/public/admin-nano';

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
  fetch_feature();
});

function fetch_feature(){
  $.ajax({
    method: "GET",
    url: API_URL+"/mconfig",
    success: function(response){
      console.log(response);
      $('#edit-msysinvquotation').bootstrapSwitch('state',response.msysinvquotation);
      $('#edit-msysinvproformainvoice').bootstrapSwitch('state',response.msysinvproformainvoice);
      $('#edit-msysinvsellinginvoice').bootstrapSwitch('state',response.msysinvsellinginvoice);
      $('#edit-msysinvlocksellingprice').bootstrapSwitch('state',response.msysinvlocksellingprice);
      $('#edit-msysinvcreditlimit').bootstrapSwitch('state',response.msysinvcreditlimit);
      $('#edit-msysinvinvfootnote').val(response.msysinvinvfootnote);
      $('#edit-msysinvsellingfootnote').val(response.msysinvsellingfootnote);
      $('#edit-msysinvspbelowcog').bootstrapSwitch('state',response.msysinvspbelowcog);
      $('#edit-msysinvprintinvmorethanonce').bootstrapSwitch('state',response.msysinvprintinvmorethanonce);
      $('#edit-msysinvprintdomorethanonce').bootstrapSwitch('state',response.msysinvprintdomorethanonce);
      $('#edit-msysinvprintordmorethanonce').bootstrapSwitch('state',response.msysinvprintordmorethanonce);
      $('#edit-msysinvdefaultcreditlimit').val(response.msysinvdefaultcreditlimit);
      $('#edit-msysinvlptdirectprinting').bootstrapSwitch('state',response.msysinvlptdirectprinting);

      $('#edit-msyspurchrequest').bootstrapSwitch('state',response.msyspurchrequest);
      $('#edit-msyspurchorder').bootstrapSwitch('state',response.msyspurchorder);
      $('#edit-msyspurchinvoice').bootstrapSwitch('state',response.msyspurchinvoice);
      $('#edit-msyspurchcreditlimit').bootstrapSwitch('state',response.msyspurchcreditlimit);
      $('#edit-msyspurchinvfootnote').val(response.msyspurchinvfootnote);
      $('#edit-msyspurchorderfootnote').val(response.msyspurchorderfootnote);

      $('#edit-msysacccogmethod').val(response.msysacccogmethod).change();
      $('#edit-msysaccstock').val(response.msysaccstock).change();
      $('#edit-msysaccinv').val(response.msysaccinv).change();
      $('#edit-msysaccreturninv').val(response.msysaccreturninv).change();
      $('#edit-msysaccinvdisc').val(response.msysaccinvdisc).change();
      $('#edit-msysaccsentgoods').val(response.msysaccsentgoods).change();
      $('#edit-msysaccsellingexpense').val(response.msysaccsellingexpense).change();
      $('#edit-msysaccreturnpurchase').val(response.msysaccreturnpurchase).change();
      $('#edit-msysaccar').val(response.msysaccar).change();
      $('#edit-msysaccpaidcapital').val(response.msysaccpaidcapital).change();
      $('#edit-msysaccretainedearning').val(response.msysaccretainedearning).change();

      $('#edit-msysbankminus').bootstrapSwitch('state',response.msysbankminus);

      $('#edit-msysinventmultiwarehouse').bootstrapSwitch('state',response.msysinventmultiwarehouse);
      $('#edit-msysinventmultiuom').bootstrapSwitch('state',response.msysinventmultiuom);
      $('#edit-msysinventuseserial').bootstrapSwitch('state',response.msysinventuseserial);
      $('#edit-msysinventallowminus').bootstrapSwitch('state',response.msysinventallowminus);
      $('#edit-msysinventslabprice').bootstrapSwitch('state',response.msysinventslabprice);

    }
  });
}

function update_feature(){
  $('#insert-wrapper').parsley().validate();
  if($('#insert-wrapper').parsley().isValid()){

    var data = {
      msysinvquotation: $('#edit-msysinvquotation').is(":checked"),
      msysinvproformainvoice: $('#edit-msysinvproformainvoice').is(":checked"),
      msysinvsellinginvoice: $('#edit-msysinvsellinginvoice').is(":checked"),
      msysinvlocksellingprice: $('#edit-msysinvlocksellingprice').is(":checked"),
      msysinvcreditlimit: $('#edit-msysinvcreditlimit').is(":checked"),
      msysinvinvfootnote: $('#edit-msysinvinvfootnote').val(),
      msysinvsellingfootnote: $('#edit-msysinvsellingfootnote').val(),
      msysinvspbelowcog: $('#edit-msysinvspbelowcog').is(":checked"),
      msysinvprintinvmorethanonce: $('#edit-msysinvprintinvmorethanonce').is(":checked"),
      msysinvprintdomorethanonce: $('#edit-msysinvprintdomorethanonce').is(":checked"),
      msysinvprintordmorethanonce: $('#edit-msysinvprintordmorethanonce').is(":checked"),
      msysinvdefaultcreditlimit: $('#edit-msysinvdefaultcreditlimit').val(),
      msysinvlptdirectprinting: $('#edit-msysinvlptdirectprinting').is(":checked"),

      msyspurchrequest: $('#edit-msyspurchrequest').is(":checked"),
      msyspurchorder: $('#edit-msyspurchorder').is(":checked"),
      msyspurchinvoice: $('#edit-msyspurchinvoice').is(":checked"),
      msyspurchcreditlimit: $('#edit-msyspurchcreditlimit').is(":checked"),
      msyspurchinvfootnote: $('#edit-msyspurchinvfootnote').val(),
      msyspurchorderfootnote: $('#edit-msyspurchorderfootnote').val(),

      msysacccogmethod: $('#edit-msysacccogmethod').val(),
      msysaccstock: $('#edit-msysaccstock').val(),
      msysaccinv: $('#edit-msysaccinv').val(),
      msysaccreturninv: $('#edit-msysaccreturninv').val(),
      msysaccinvdisc: $('#edit-msysaccinvdisc').val(),
      msysaccsentgoods: $('#edit-msysaccsentgoods').val(),
      msysaccsellingexpense: $('#edit-msysaccsellingexpense').val(),
      msysaccreturnpurchase: $('#edit-msysaccreturnpurchase').val(),
      msysaccar: $('#edit-msysaccar').val(),
      msysaccpaidcapital: $('#edit-msysaccpaidcapital').val(),
      msysaccretainedearning: $('#edit-msysaccretainedearning').val(),

      msysbankminus: $('#edit-msysbankminus').is(":checked"),

      msysinventmultiwarehouse: $('#edit-msysinventmultiwarehouse').is(":checked"),
      msysinventmultiuom: $('#edit-msysinventmultiuom').is(":checked"),
      msysinventuseserial: $('#edit-msysinventuseserial').is(":checked"),
      msysinventallowminus: $('#edit-msysinventallowminus').is(":checked"),
      msysinventslabprice: $('#edit-msysinventslabprice').is(":checked")
    }
    console.log(data);
    $.ajax({
      method: "PUT",
      url: API_URL+"/mconfig/feature",
      dataType: "json",
      data: data,
      success: function(response){
        swal({
          title: "Input Berhasil!",
          type: "success",
          timer: 1000
        });
        window.location.href="#forminput";
      },
      error: function(err){
        console.log(err);
      }
    });
  } else {
    if($('#menu1').find('ul.parsley-errors-list li').length > 0){
      $('.nav-tabs a[href="#menu1"]').tab('show')
    } else if($('#menu2').find('ul.parsley-errors-list li').length > 0){
      $('.nav-tabs a[href="#menu2"]').tab('show')
    } else {

    }
  }

}
