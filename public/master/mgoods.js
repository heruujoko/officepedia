$('#formedit').hide();
$('#formview').hide();
var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';


$(document).ready(function(){

  $('#autogenmgoods').attr('checked',true);
  document.getElementById('insert-mgoodscode').disabled = $('#autogenmgoods').is(':checked');

  if(document.getElementById('autogenmgoods')){
    document.getElementById('autogenmgoods').onchange = function() {
        document.getElementById('insert-mgoodscode').disabled = this.checked;
        if($('#autogenmgoods').is(':checked')){
          $('#insert-mgoodscode').removeAttr('required');
          $('#insert-wrapper').parsley().validate();
        } else{
          $('#insert-mgoodscode').attr('required','true');
          $('#insert-wrapper').parsley().validate();
        }
    };
  }

  $( document ).ready(function() {
  $.ajax({
    url : API_URL+'/barang/pkp',
    type : 'GET',
    success : function(response){
      if (response.msyscomptaxable==true) {
        $('#insert-mgoodstaxable').attr('checked',true);
        $('#insert-mgoodstaxppn').removeAttr('disabled');
        $('#insert-mgoodstaxppnbm').removeAttr('disabled');
        }
      else{
        $('#insert-mgoodstaxable').attr('checked',false);
      }

    }

});

  });

  // $('.active-toggle').bootstrapSwitch({
  //   size: 'mini',
  //   onText: "Aktif",
  //   offText: "Nonaktif",
  //   handleWidth: 54
  // });

  // $('.active-toggle').bootstrapToggle({
  //   on: 'Enabled',
  //   off: 'Disabled'
  // });
  //
  // $('.tab1-toggle').bootstrapSwitch({
  //   size: 'mini',
  //   onText: "Yes",
  //   offText: "No",
  //   handleWidth: 54,
  //   labelWidth: 50
  // });
  //
  // $('.nice-toggle').bootstrapSwitch({
  //   size: 'mini',
  //   onText: "Yes",
  //   offText: "No",
  //   handleWidth: 50,
  //   labelWidth: 40
  // });
  $('#insert-mgoodsname').focus();
});
//MGoods Script
function insertmgoods(){
   $('#insert-wrapper').parsley().validate();
   console.log($('#insert-wrapper').parsley().isValid());
    if($('#insert-wrapper').parsley().isValid()){

      var data = {
        mgoodscode: $('#insert-mgoodscode').val(),
        mgoodsbarcode: $('#insert-mgoodsbarcode').val(),
        mgoodsname: $('#insert-mgoodsname').val(),
        mgoodscategory: $('#insert-mgoodscategory').val(),
        mgoodstype: $('#insert-mgoodstype').val(),
        mgoodssubtype: $('#insert-mgoodssubtype').val(),
        mgoodsbrand: $('#insert-mgoodsbrand').val(),
        mgoodsalias: $('#insert-mgoodsalias').val(),
        mgoodsremark: $('#insert-mgoodsremark').val(),
        mgoodsmultiunit: $('#insert-mgoodsmultiunit').is(":checked"),
        mgoodsunit: $('#insert-mgoodsunit').val(),
        mgoodsunit2: $('#insert-mgoodsunit2').val(),
        mgoodsunit2conv: $('#insert-mgoodsunit2conv').val(),
        mgoodsunit3: $('#insert-mgoodsunit3').val(),
        mgoodsunit3conv: $('#insert-mgoodsunit3conv').val(),
        mgoodsbranches: $('#insert-mgoodsbranches').is(':checked'),
        mgoodsuniquetransaction: $('#insert-mgoodsuniquetransaction').is(':checked'),
        mgoodsactive: $('#insert-mgoodsactive').is(':checked'),
        mgoodspricein: $('#insert-mgoodspricein').val(),
        mgoodsunitsin: $('#insert-mgoodsunitsin').val(),
        mgoodsminimumin: $('#insert-mgoodsminimunin').val(),
        mgoodspriceout: $('#insert-mgoodspriceout').val(),
        mgoodssetmaxdisc: $('#insert-mgoodssetmaxdisc').is(':checked'),
        mgoodsmaxdisc: $('#insert-mgoodsmaxdisc').val(),
        mgoodscogs: $('#insert-mgoodscogs').val(),

        mgoodssuppliercode: $('#insert-mgoodssuppliercode').val(),
        mgoodssuppliername: $('#insert-mgoodssuppliername').val(),
        mgoodspicture: $('#insert-mgoodspicture').val(),

        mgoodstaxable: $('#insert-mgoodstaxable').is(':checked'),
        mgoodstaxppn: $('#insert-mgoodstaxppn').val(),
        mgoodstaxppnbm: $('#insert-mgoodstaxppnbm').val(),
        autogen : $('#autogenmgoods').is(':checked')

      }
      if($('#insert-mgoodsmultiunit3').is(':checked')){
        data.mgoodsmultiunit = true;
      }
      console.log(data);
      $.ajax({
        type: "POST",
        url: API_URL+"/barang",
        data: data,
        success: function(response){
          table.ajax.reload();
          swal({
            title: "Input Berhasil!",
            type: "success",
            timer: 1000
          });
          resetmgoods();
          window.location = "#tableapi";
        },
        error: function(response){
            console.log(response);
          var err_msg = response.responseJSON.errorInfo[2];
          swal({
            title: "Input Gagal!",
            type: "error",
            text: err_msg,
            timer: 2000
          });
        }
      });
    }
    }


function editmgoods(id){
  $.ajax({
    url : API_URL+'/barang/'+id,
    type : 'GET',
    success : function(response){
      $('#edit-idmgoodscodeid').val(response.id);
      $('#edit-mgoodscode').val(response.mgoodscode);
      $('#edit-mgoodsbarcode').val(response.mgoodsbarcode);
      $('#edit-mgoodsname').val(response.mgoodsname);
      $('#edit-mgoodsalias').val(response.mgoodsalias);
      $('#edit-mgoodsremark').val(response.mgoodsremark);
      $('#edit-mgoodsunit').val(response.mgoodsunit).change();
      $('#edit-mgoodsunit2').val(response.mgoodsunit2).change();
      $('#edit-mgoodsunit3').val(response.mgoodsunit3).change();
      $('#edit-mgoodsactive').val(response.mgoodsactive);
      $('#edit-mgoodspricein').val(response.mgoodspricein);
      $('#edit-mgoodspriceout').val(response.mgoodspriceout);
      $('#edit-mgoodsmaxdisc').val(response.mgoodsmaxdisc);
      $('#edit-mgoodstype').val(response.mgoodstype).change();
      $('#edit-mgoodssubtype').val(response.mgoodssubtype).change();
      $('#edit-mgoodsbrand').val(response.mgoodsbrand).change();
      $('#edit-mgoodsgroup1').val(response.mgoodsgroup1);
      $('#edit-mgoodsgroup2').val(response.mgoodsgroup2);
      $('#edit-mgoodsgroup3').val(response.mgoodsgroup3);
      $('#edit-mgoodssuppliercode').val(response.mgoodssuppliercode).change();
      $('#edit-mgoodsbranches').val(response.mgoodsbranches).change();
      $('#edit-mgoodsuniquetransaction').val(response.mgoodsuniquetransaction);
      $('#edit-mgoodspicture').val(response.mgoodspicture);
      $('#edit-mgoodscoapurchasing').val(response.mgoodscoapurchasing).change();
      $('#edit-mgoodscoapurchasingname').val(response.mgoodscoapurchasingname);
      $('#edit-mgoodscoacogs').val(response.mgoodscoacogs).change();
      $('#edit-mgoodscoacogsname').val(response.mgoodscoacogsname);
      $('#edit-mgoodscoaselling').val(response.mgoodscoaselling).change();
      $('#edit-mgoodscoasellingname').val(response.mgoodscoasellingname);
      $('#edit-mgoodscoareturnofselling').val(response.mgoodscoareturnofselling).change();
      $('#edit-mgoodscoareturnofsellingname').val(response.mgoodscoareturnofsellingname);
      $('#edit-mgoodscogs').val(response.mgoodscogs);
      $('#edit-mgoodsunit2conv').val(response.mgoodsunit2conv);
      $('#edit-mgoodsunit3conv').val(response.mgoodsunit3conv);
      $('#edit-mgoodstaxppn').val(response.mgoodstaxppn).change();
      $('#edit-mgoodstaxppnbm').val(response.mgoodstaxppnbm).change();
      $('#forminput').hide();
      $('#formview').hide();
      $('#formedit').show();
      setTimeout(function(){
          $("#mgoodsname").focus();
          $('.bootstrap-switch-label').css('width','62px');
          $('.bootstrap-switch-id-edit-mgoodsmultiunit span.bootstrap-switch-label').css('width',50);
          $('.bootstrap-switch-id-edit-mgoodsbranches span.bootstrap-switch-label').css('width',50);
          $('.bootstrap-switch-id-edit-mgoodsuniquetransaction span.bootstrap-switch-label').css('width',50);
      },100);
      console.log(response);
      if(response.mgoodsactive == 1){
        $('#edit-mgoodsactive').attr('checked',true);
      } else {
        $('#edit-mgoodsactive').removeAttr('checked');
      }

      if(response.mgoodsmultiunit == 1){
        console.log(response.mgoodsunit3conv);
        if(response.mgoodsunit3conv != 0){
          $('#edit-mgoodsmultiunit3').attr('checked',true);
          $('#edit-mgoodsunit3').removeAttr('disabled');
          $('#edit-mgoodsunit3conv').removeAttr('disabled');
        } else {
          $('#edit-mgoodsmultiunit').attr('checked',true);
        }
        $('#edit-mgoodsunit2').removeAttr('disabled');
        $('#edit-mgoodsunit2conv').removeAttr('disabled');
      } else {
        $('#edit-mgoodsmultiunit').removeAttr('checked');
      }

      if(response.mgoodsbranches == 1){
        $('#edit-mgoodsbranches').attr('checked',true);
      } else {
        $('#edit-mgoodsbranches').removeAttr('checked');
      }

      if(response.mgoodsuniquetransaction == 1){
        $('#edit-mgoodsuniquetransaction').attr('checked',true);
      } else {
        $('#edit-mgoodsuniquetransaction').removeAttr('checked');
      }

      if(response.mgoodssetmaxdisc == 1){
        $('#edit-mgoodssetmaxdisc').attr('checked',true);
        $('#edit-mgoodsmaxdiscrp').removeAttr('disabled');
        $('#edit-mgoodsmaxdisc').removeAttr('disabled');
        var percent = $('#edit-mgoodsmaxdisc').val();
        var rp = (percent/100) * response.mgoodspriceout;
        $('#edit-mgoodsmaxdiscrp').val(rp);
      } else {
        $('#edit-mgoodsmaxdiscrp').attr('disabled',true);
        $('#edit-mgoodsmaxdisc').attr('disabled',true);
      }

      if(response.mgoodstaxable == 1){
        $('#edit-mgoodstaxable').attr('checked',true);
        $('#edit-mgoodstaxppn').removeAttr('disabled');
        $('#edit-mgoodstaxppnbm').removeAttr('disabled');
      } else {
        $('#edit-mgoodstaxable').removeAttr('checked');
        $('#edit-mgoodstaxppn').attr('disabled',true);
        $('#edit-mgoodstaxppnbm').attr('disabled',true);
        $('#edit-mgoodstaxppn').val(2).change();
        $('#edit-mgoodstaxppnbm').val(2).change();
      }
    resetmgoods();
    }

});
  window.location = "#main";
}

function updatemgoods(){
  $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
    var updateid = $('#edit-idmgoodscodeid').val();
    var data = {
      mgoodscode: $('#edit-mgoodscode').val(),
      mgoodsbarcode: $('#edit-mgoodsbarcode').val(),
      mgoodsname: $('#edit-mgoodsname').val(),
      mgoodscategory: $('#edit-mgoodscategory').val(),
      mgoodstype: $('#edit-mgoodstype').val(),
      mgoodssubtype: $('#edit-mgoodssubtype').val(),
      mgoodsbrand: $('#edit-mgoodsbrand').val(),
      mgoodsalias: $('#edit-mgoodsalias').val(),
      mgoodsremark: $('#edit-mgoodsremark').val(),
      mgoodsmultiunit: $('#edit-mgoodsmultiunit').is(":checked"),
      mgoodsunit: $('#edit-mgoodsunit').val(),
      mgoodsunit2: $('#edit-mgoodsunit2').val(),
      mgoodsunit2conv: $('#edit-mgoodsunit2conv').val(),
      mgoodsunit3: $('#edit-mgoodsunit3').val(),
      mgoodsunit3conv: $('#edit-mgoodsunit3conv').val(),
      mgoodsbranches: $('#edit-mgoodsbranches').is(':checked'),
      mgoodsuniquetransaction: $('#edit-mgoodsuniquetransaction').is(':checked'),
      mgoodsactive: $('#edit-mgoodsactive').is(':checked'),
      mgoodspricein: $('#edit-mgoodspricein').val(),
      mgoodsunitsin: $('#edit-mgoodsunitsin').val(),
      mgoodsminimumin: $('#edit-mgoodsminimumin').val(),
      mgoodspriceout: $('#edit-mgoodspriceout').val(),
      mgoodssetmaxdisc: $('#edit-mgoodssetmaxdisc').is(':checked'),
      mgoodsmaxdisc: $('#edit-mgoodsmaxdisc').val(),
      mgoodscogs: $('#edit-mgoodscogs').val(),

      mgoodssuppliercode: $('#edit-mgoodssuppliercode').val(),
      mgoodssuppliername: $('#edit-mgoodssuppliername').val(),
      mgoodspicture: $('#edit-mgoodspicture').val(),

      mgoodstaxable: $('#edit-mgoodstaxable').is(':checked'),
      mgoodstaxppn: $('#edit-mgoodstaxppn').val(),
      mgoodstaxppnbm: $('#edit-mgoodstaxppnbm').val(),
      autogen : $('#autogenmgoods').is(':checked')

    }
    if($('#edit-mgoodsmultiunit3').is(':checked')){
      data.mgoodsmultiunit = true;
    }
  console.log(data);
   $.ajax({
        type: "PUT",
        url: API_URL+"/barang/"+updateid,
        data: data,
        success: function(response){
          console.log(response);
          table.ajax.reload();
          window.location = "#tableapi";
          swal({
            title: "Pengubahan Berhasil!",
            type: "success",
            timer: 1000
          });
          $('#forminput').show();
          $('#formview').hide();
          $('#formedit').hide();
          resetmgoods();
        },
        error: function(response){
          var err_msg = response.responseJSON.errorInfo[2];
          swal({
            title: "Pengubahan Gagal!",
            type: "error",
            text: err_msg,
            timer: 2000
          });
          resetmgoods();
        }
      });
    }

  }
  function viewmgoods(id){
  $('#tablewrapper').css('margin-top','45px');
  $.ajax({
    url : API_URL+'/barang/'+id,
    type : 'GET',
    success : function(response){
      console.log(response);
      $('#view-idmgoodscodeid').val(response.id);
      $('#view-mgoodscode').val(response.mgoodscode);
      $('#view-mgoodsbarcode').val(response.mgoodsbarcode);
      $('#view-mgoodsname').val(response.mgoodsname);
      $('#view-mgoodsalias').val(response.mgoodsalias);
      $('#view-mgoodsremark').val(response.mgoodsremark);
      $('#view-mgoodsunit').val(response.mgoodsunit).trigger("chosen:updated");
      $('#view-mgoodsunit2').val(response.mgoodsunit2).trigger("chosen:updated");
      $('#view-mgoodsunit3').val(response.mgoodsunit3).trigger("chosen:updated");
      $('#view-mgoodspricein').val(response.mgoodspricein);
      $('#view-mgoodspriceout').val(response.mgoodspriceout);
      $('#view-mgoodsmaxdisc').val(response.mgoodsmaxdisc);
      $('#view-mgoodstype').val(response.mgoodstype).change();
      $('#view-mgoodssubtype').val(response.mgoodssubtype).change();
      $('#view-mgoodsbrand').val(response.mgoodsbrand).change();
      $('#view-mgoodsgroup1').val(response.mgoodsgroup1);
      $('#view-mgoodsgroup2').val(response.mgoodsgroup2);
      $('#view-mgoodsgroup3').val(response.mgoodsgroup3);
      $('#view-mgoodssuppliercode').val(response.mgoodssuppliercode).change();
      $('#view-mgoodssuppliername').val(response.mgoodssuppliername).change();
      $('#view-mgoodsbranches').val(response.mgoodsbranches).change();
      $('#view-mgoodsuniquetransaction').val(response.mgoodsuniquetransaction);
      $('#view-mgoodspicture').val(response.mgoodspicture);
      $('#view-mgoodscoapurchasing').val(response.mgoodscoapurchasing).change();
      $('#view-mgoodscoapurchasingname').val(response.mgoodscoapurchasingname);
      $('#view-mgoodscoacogs').val(response.mgoodscoacogs).change();
      $('#view-mgoodscoacogsname').val(response.mgoodscoacogsname);
      $('#view-mgoodscoaselling').val(response.mgoodscoaselling).change();
      $('#view-mgoodscoasellingname').val(response.mgoodscoasellingname);
      $('#view-mgoodscoareturnofselling').val(response.mgoodscoareturnofselling).change();
      $('#view-mgoodscoareturnofsellingname').val(response.mgoodscoareturnofsellingname);
      $('#view-mgoodscogs').val(response.mgoodscogs);
      $('#view-mgoodsunit2conv').val(response.mgoodsunit2conv);
      $('#view-mgoodsunit3conv').val(response.mgoodsunit3conv);
      $('#view-mgoodstaxppn').val(response.mgoodstaxppn).change();
      $('#view-mgoodstaxppnbm').val(response.mgoodstaxppnbm).change();
      $('#forminput').hide();
      $('#formedit').hide();
      $('#formview').show();
      setTimeout(function(){
        $('.bootstrap-switch-label').css('width','62px');
        $('.bootstrap-switch-id-view-mgoodsmultiunit span.bootstrap-switch-label').css('width',53);
        $('.bootstrap-switch-id-view-mgoodsbranches span.bootstrap-switch-label').css('width',50);
        $('.bootstrap-switch-id-view-mgoodsuniquetransaction span.bootstrap-switch-label').css('width',50);
      },100);
      console.log(response.mgoodsactive);
      if(response.mgoodsactive == 1){
        $('#view-mgoodsactive').attr('checked',true);
      } else {
        $('#view-mgoodsactive').removeAttr('checked');
      }

      if(response.mgoodsmultiunit == 1){
        console.log(response.mgoodsunit3conv);
        if(response.mgoodsunit3conv != 0){
          $('#view-mgoodsmultiunit3').attr('checked',true);
        } else {
          $('#view-mgoodsmultiunit').attr('checked',true);
        }
      } else {
        $('#view-mgoodsmultiunit').removeAttr('checked');
      }

      if(response.mgoodsbranches == 1){
        $('#view-mgoodsbranches').attr('checked',true);
      }else {
        $('#view-mgoodsbranches').removeAttr('checked');
      }
      if(response.mgoodsuniquetransaction == 1){
        $('#view-mgoodsuniquetransaction').attr('checked',true);
      } else {
        $('#view-mgoodsuniquetransaction').removeAttr('checked');
      }

      if(response.mgoodssetmaxdisc == 1){
        $('#view-mgoodssetmaxdisc').attr('checked',true);
        var percent = $('#view-mgoodsmaxdisc').val();
        var rp = (percent/100) * response.mgoodspriceout;
        $('#view-mgoodsmaxdiscrp').val(rp);
      }

      setTimeout(function(){
          $("#mgoodsname").focus();
      },100);

      resetmgoods();
      console.log(response);
    }

});
  window.location = "#main";
}

//observe mgoodsmultiunit

$('#insert-mgoodsmultiunit').on('change',function(e){
  var check = $('#insert-mgoodsmultiunit').is(':checked');
  var satuan3 = $('#insert-mgoodsmultiunit3').is(':checked');
  if(satuan3){
    $('#insert-mgoodsmultiunit3').removeAttr('checked');
    $('#insert-mgoodsunit3').attr('disabled',true).trigger("chosen:updated");
    $('#insert-mgoodsunit3conv').attr('disabled',true);
    $('#insert-mgoodsunit3conv').val('');
  }
  if(check){
    $('#insert-mgoodsunit2').removeAttr('disabled').trigger("chosen:updated");
    $('#insert-mgoodsunit2conv').removeAttr('disabled');
    $('#insert-mgoodsunit2conv').val(12);
  } else {
    $('#insert-mgoodsunit2').attr('disabled',true).trigger("chosen:updated");
    $('#insert-mgoodsunit2conv').attr('disabled',true);
    $('#insert-mgoodsunit2conv').val('');
  }
});

$('#insert-mgoodsmultiunit3').on('change',function(e){
  var check = $('#insert-mgoodsmultiunit3').is(':checked');
  var satuan2 = $('#insert-mgoodsmultiunit').is(':checked');
  if(satuan2){
    $('#insert-mgoodsmultiunit').removeAttr('checked');
  }
  if(check){
    $('#insert-mgoodsunit2').removeAttr('disabled').trigger("chosen:updated");
    $('#insert-mgoodsunit2conv').removeAttr('disabled');
    $('#insert-mgoodsunit3').removeAttr('disabled').trigger("chosen:updated");
    $('#insert-mgoodsunit3conv').removeAttr('disabled');
    $('#insert-mgoodsunit3conv').val(144);
    $('#insert-mgoodsunit2conv').val(12);
  } else {
    $('#insert-mgoodsunit2').attr('disabled',true).trigger("chosen:updated");
    $('#insert-mgoodsunit2conv').attr('disabled',true);
    $('#insert-mgoodsunit3').attr('disabled',true).trigger("chosen:updated");
    $('#insert-mgoodsunit3conv').attr('disabled',true);
    $('#insert-mgoodsunit3conv').val('');
    $('#insert-mgoodsunit2conv').val('');
  }
});

$('#edit-mgoodsmultiunit').on('change',function(e){
  var check = $('#edit-mgoodsmultiunit').is(':checked');
  var satuan3 = $('#edit-mgoodsmultiunit3').is(':checked');
  if(satuan3){
    $('#edit-mgoodsmultiunit3').removeAttr('checked');
    $('#edit-mgoodsunit3').attr('disabled',true).trigger("chosen:updated");
    $('#edit-mgoodsunit3conv').attr('disabled',true);
    $('#edit-mgoodsunit3conv').val('');
  }
  if(check){
    $('#edit-mgoodsunit2').removeAttr('disabled').trigger("chosen:updated");
    $('#edit-mgoodsunit2conv').removeAttr('disabled');
    $('#edit-mgoodsunit2conv').val(12);
  } else {
    $('#edit-mgoodsunit2').attr('disabled',true).trigger("chosen:updated");
    $('#edit-mgoodsunit2conv').attr('disabled',true);
    $('#edit-mgoodsunit2conv').val('');
  }
});

$('#edit-mgoodsmultiunit3').on('change',function(e){
  var check = $('#edit-mgoodsmultiunit').is(':checked');
  var satuan2 = $('#edit-mgoodsmultiunit').is(':checked');
  if(satuan2){
    $('#edit-mgoodsmultiunit').removeAttr('checked');
  }
  if(check){
    $('#edit-mgoodsunit2').removeAttr('disabled').trigger("chosen:updated");
    $('#edit-mgoodsunit2conv').removeAttr('disabled');
    $('#edit-mgoodsunit3').removeAttr('disabled').trigger("chosen:updated");
    $('#edit-mgoodsunit3conv').removeAttr('disabled');
    $('#edit-mgoodsunit3conv').val(144);
    $('#edit-mgoodsunit2conv').val(12);
  } else {
    $('#edit-mgoodsunit2').attr('disabled',true).trigger("chosen:updated");
    $('#edit-mgoodsunit2conv').attr('disabled',true);
    $('#edit-mgoodsunit3').attr('disabled',true).trigger("chosen:updated");
    $('#edit-mgoodsunit3conv').attr('disabled',true);
    $('#edit-mgoodsunit3conv').val('');
    $('#edit-mgoodsunit2conv').val('');
  }
});

// observe diskon

$('#insert-mgoodsmaxdisc').on('click',function(){
  if($('#insert-mgoodspriceout').val() == ''){
    swal({
      title: "Oops!",
      type: "error",
      text: "Harap untuk mengisi harga jual terlebih dahulu",
      timer: 2000
    });
  }
});

$('#insert-mgoodsmaxdiscrp').on('click',function(){
  if($('#insert-mgoodspriceout').val() == ''){
    swal({
      title: "Oops!",
      type: "error",
      text: "Harap untuk mengisi harga jual terlebih dahulu",
      timer: 2000
    });
  }
});

$('#edit-mgoodsmaxdisc').on('click',function(){
  if($('#edit-mgoodspriceout').val() == ''){
    swal({
      title: "Oops!",
      type: "error",
      text: "Harap untuk mengisi harga jual terlebih dahulu",
      timer: 2000
    });
  }
});

$('#edit-mgoodsmaxdiscrp').on('click',function(){
  if($('#edit-mgoodspriceout').val() == ''){
    swal({
      title: "Oops!",
      type: "error",
      text: "Harap untuk mengisi harga jual terlebih dahulu",
      timer: 2000
    });
  }
});

$('#insert-mgoodsmaxdisc').on('keyup',function(){
  var now = $('#insert-mgoodsmaxdisc').val();
  var convertedrp = (now/100) * $('#insert-mgoodspriceout').val();
  $('#insert-mgoodsmaxdiscrp').val(convertedrp);
});

$('#insert-mgoodsmaxdiscrp').on('keyup',function(){
  var now = $('#insert-mgoodsmaxdiscrp').val();
  var convertedpercent = (now/$('#insert-mgoodspriceout').val()) * 100;
  $('#insert-mgoodsmaxdisc').val(convertedpercent);
});

$('#edit-mgoodsmaxdisc').on('keyup',function(){
  var now = $('#edit-mgoodsmaxdisc').val();
  var convertedrp = (now/100) * $('#edit-mgoodspriceout').val();
  $('#edit-mgoodsmaxdiscrp').val(convertedrp);
});

$('#edit-mgoodsmaxdiscrp').on('keyup',function(){
  var now = $('#edit-mgoodsmaxdiscrp').val();
  var convertedpercent = (now/$('#edit-mgoodspriceout').val()) * 100;
  $('#edit-mgoodsmaxdisc').val(convertedpercent);
});

$('#insert-mgoodssetmaxdisc').on('change',function(){
  if($('#insert-mgoodssetmaxdisc').is(':checked')){
    $('#insert-mgoodsmaxdiscrp').removeAttr('disabled');
    $('#insert-mgoodsmaxdisc').removeAttr('disabled');
  } else {
    $('#insert-mgoodsmaxdiscrp').attr('disabled',true);
    $('#insert-mgoodsmaxdisc').attr('disabled',true);
  }
});

$('#edit-mgoodssetmaxdisc').on('change',function(){
  if($('#edit-mgoodssetmaxdisc').is(':checked')){
    $('#edit-mgoodsmaxdiscrp').removeAttr('disabled');
    $('#edit-mgoodsmaxdisc').removeAttr('disabled');
  } else {
    $('#edit-mgoodsmaxdiscrp').attr('disabled',true);
    $('#edit-mgoodsmaxdisc').attr('disabled',true);
  }
});


// observe taxable

$('#insert-mgoodstaxable').on('change',function(){
  if($('#insert-mgoodstaxable').is(':checked')){
    $('#insert-mgoodstaxppn').removeAttr('disabled');
    $('#insert-mgoodstaxppnbm').removeAttr('disabled');
    $('#insert-mgoodstaxppn').val(1).change();
  } else {
    $('#insert-mgoodstaxppn').attr('disabled',true);
    $('#insert-mgoodstaxppnbm').attr('disabled',true);
    $('#insert-mgoodstaxppn').val(2).change();
    $('#insert-mgoodstaxppnbm').val(2).change();
  }
});

$('#edit-mgoodstaxable').on('change',function(){
  if($('#edit-mgoodstaxable').is(':checked')){
    $('#edit-mgoodstaxppn').removeAttr('disabled');
    $('#edit-mgoodstaxppnbm').removeAttr('disabled');
    $('#insert-mgoodstaxppn').val(1).change();
  } else {
    $('#edit-mgoodstaxppn').attr('disabled',true);
    $('#edit-mgoodstaxppnbm').attr('disabled',true);
    $('#edit-mgoodstaxppn').val(2).change();
    $('#edit-mgoodstaxppnbm').val(2).change();
  }
});

function resetmgoods(){
        $('#insert-mgoodscode').val(''),
        $('#insert-mgoodsbarcode').val(''),
        $('#insert-mgoodsname').val(''),
        $('#insert-mgoodsalias').val(''),
        $('#insert-mgoodsremark').val(''),
        // $('#insert-mgoodsunit').val(''),
        // $('#insert-mgoodsunit2').val(''),
        // $('#insert-mgoodsunit3').val(''),
        $('#insert-mgoodsactive').is(':checked'),
        $('#insert-mgoodspricein').val(''),
        $('#insert-mgoodspriceout').val(''),
        $('#insert-mgoodstype').val(''),
        $('#insert-mgoodsbrand').val(''),
        $('#insert-mgoodsgroup1').val(''),
        $('#insert-mgoodsgroup2').val(''),
        $('#insert-mgoodsgroup3').val(''),
        // $('#insert-mgoodssuppliercode').val(''),
        // $('#insert-mgoodssuppliername').val(''),
        $('#insert-mgoodsbranches').is(':checked'),
        $('#insert-mgoodsuniquetransaction').is(':checked'),
        $('#insert-mgoodspicture').val(''),
        $('#insert-mgoodscoapurchasing').val(''),
        $('#insert-mgoodscoapurchasingname').val(''),
        $('#insert-mgoodscoacogs').val(''),
        $('#insert-mgoodscoacogsname').val(''),
        $('#insert-mgoodscoaselling').val(''),
        $('#insert-mgoodscoasellingname').val(''),
        $('#insert-mgoodscoareturnofselling').val(''),
        $('#insert-mgoodscoareturnofsellingname').val(''),
        $('#insert-mgoodscogs').val('')
        $('#insert-wrapper').parsley().reset();
        $('#edit-wrapper').parsley().reset();
  }
function reseteditmgoods(){
        $('#edit-mgoodscode').val(''),
        $('#edit-mgoodsbarcode').val(''),
        $('#edit-mgoodsname').val(''),
        $('#edit-mgoodsalias').val(''),
        $('#edit-mgoodsremark').val(''),
        $('#edit-mgoodsunit').val(''),
        $('#edit-mgoodsunit2').val(''),
        $('#edit-mgoodsunit3').val(''),
        $('#edit-mgoodsactive').is(':checked'),
        $('#edit-mgoodspricein').val(''),
        $('#edit-mgoodspriceout').val(''),
        $('#edit-mgoodstype').val(''),
        $('#edit-mgoodsbrand').val(''),
        $('#edit-mgoodsgroup1').val(''),
        $('#edit-mgoodsgroup2').val(''),
        $('#edit-mgoodsgroup3').val(''),
        $('#edit-mgoodssuppliercode').val(''),
        $('#edit-mgoodssuppliername').val(''),
        $('#edit-mgoodsbranches').is(':checked'),
        $('#edit-mgoodsuniquetransaction').is(':checked'),
        $('#edit-mgoodspicture').val(''),
        $('#edit-mgoodscoapurchasing').val(''),
        $('#edit-mgoodscoapurchasingname').val(''),
        $('#edit-mgoodscoacogs').val(''),
        $('#edit-mgoodscoacogsname').val(''),
        $('#edit-mgoodscoaselling').val(''),
        $('#edit-mgoodscoasellingname').val(''),
        $('#edit-mgoodscoareturnofselling').val(''),
        $('#edit-mgoodscoareturnofsellingname').val(''),
        $('#edit-mgoodscogs').val('')
        $('#edit-wrapper').parsley().reset();
        $('#edit-wrapper').parsley().reset();
}

function backmgoods(){
  resetmgoods();
  reseteditmgoods();
  $('#forminput').show();
  $('#formedit').hide();
  $('#formview').hide();
  $('#tablewrapper').css('margin-top','0px');
  window.location.href="#main";
}
