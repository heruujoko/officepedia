var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';

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

      if(response.msysinvquotation == true){
        $('#edit-msysinvquotation').attr('checked',true);
      } else {

         $('#edit-msysinvquotation').removeAttr('checked');
      }
      if(response.msysinvproformainvoice == true){
        $('#edit-msysinvproformainvoice').attr('checked',true);
      } else {

         $('#edit-msysinvproformainvoice').removeAttr('checked');
      }
      if(response.msysinvsellinginvoice == true){
        $('#edit-msysinvsellinginvoice').attr('checked',true);
      } else {

         $('#edit-msysinvsellinginvoice').removeAttr('checked');
      }
      if(response.msysinvlocksellingprice == true){
        $('#edit-msysinvlocksellingprice').attr('checked',true);
      } else {

         $('#edit-msysinvlocksellingprice').removeAttr('checked');
      }
      if(response.msysinvcreditlimit == true){
        $('#edit-msysinvcreditlimit').attr('checked',true);
      } else {

         $('#edit-msysinvcreditlimit').removeAttr('checked');
      }
      if(response.msysinvspbelowcog == true){
        $('#edit-msysinvspbelowcog').attr('checked',true);
      } else {

         $('#edit-msysinvspbelowcog').removeAttr('checked');
      }
      if(response.msysinvprintinvmorethanonce == true){
        $('#edit-msysinvprintinvmorethanonce').attr('checked',true);
      } else {

         $('#edit-msysinvprintinvmorethanonce').removeAttr('checked');
      }
      if(response.msysinvprintdomorethanonce == true){
        $('#edit-msysinvprintdomorethanonce').attr('checked',true);
      } else {

         $('#edit-msysinvprintdomorethanonce').removeAttr('checked');
      }
      if(response.msysinvprintordmorethanonce == true){
        $('#edit-msysinvprintordmorethanonce').attr('checked',true);
      } else {

         $('#edit-msysinvprintordmorethanonce').removeAttr('checked');
      }

       if(response.msysinvlptdirectprinting == true){
        $('#edit-msysinvlptdirectprinting').attr('checked',true);
      } else {

         $('#edit-msysinvlptdirectprinting').removeAttr('checked');
      }

      if(response.msyspurchorder == true){
        $('#edit-msyspurchorder').attr('checked',true);
      } else {

         $('#edit-msyspurchorder').removeAttr('checked');
      }
      if(response.msyspurchinvoice == true){
        $('#edit-msyspurchinvoice').attr('checked',true);
      } else {

         $('#edit-msyspurchinvoice').removeAttr('checked');
      }
      if(response.msyspurchcreditlimit == true){
        $('#edit-msyspurchcreditlimit').attr('checked',true);
      } else {

         $('#edit-msyspurchcreditlimit').removeAttr('checked');
      }
      if(response.msysinventmultiwarehouse == true){
        $('#edit-msysinventmultiwarehouse').attr('checked',true);
      } else {

         $('#edit-msysinventmultiwarehouse').removeAttr('checked');
      }
      if(response.msysinventmultiuom == true){
        $('#edit-msysinventmultiuom').attr('checked',true);
      } else {

         $('#edit-msysinventmultiuom').removeAttr('checked');
      }
      if(response.msysinventuseserial == true){
        $('#edit-msysinventuseserial').attr('checked',true);
      } else {

         $('#edit-msysinventuseserial').removeAttr('checked');
      }
      if(response.msysbankminus == true){
        $('#edit-msysbankminus').attr('checked',true);
      } else {

         $('#edit-msysbankminus').removeAttr('checked');
      }

      if(response.msysinventallowminus == true){
        $('#edit-msysinventallowminus').attr('checked',true);
      } else {

         $('#edit-msysinventallowminus').removeAttr('checked');
      }
      if(response.msysinventslabprice == true){
        $('#edit-msysinventslabprice').attr('checked',true);
      } else {

         $('#edit-msysinventslabprice').removeAttr('checked');
      }



       if(response.msyspurchrequest == true){
        $('#edit-msyspurchrequest').attr('checked',true);
      } else {

         $('#edit-msyspurchrequest').removeAttr('checked');
      }



      $('#edit-msysinvinvfootnote').val(response.msysinvinvfootnote);
      $('#edit-msysinvsellingfootnote').val(response.msysinvsellingfootnote);
      $('#edit-msysinvdefaultcreditlimit').val(response.msysinvdefaultcreditlimit);

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
      $('#edit-msyspayaraccount').val(response.msyspayaraccount).change();
      $('#edit-msyspayapaccount').val(response.msyspayapaccount).change();
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
      msyspayapaccount: $('#edit-msyspayapaccount').val(),
      msyspayaraccount: $('#edit-msyspayaraccount').val(),

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
        window.location.href="sysfeature";
        swal({
          title: "Input Berhasil!",
          type: "success",
          timer: 1000
        });
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
