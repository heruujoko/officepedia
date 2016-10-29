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

  $('.active-toggle').bootstrapSwitch({
    size: 'mini',
    onText: "Aktif",
<<<<<<< HEAD
    offText: "Nonaktif"
=======
    offText: "Nonaktif",
    handleWidth: 54
  });

  $('.tab1-toggle').bootstrapSwitch({
    size: 'mini',
    onText: "Yes",
    offText: "No",
    handleWidth: 54,
    labelWidth: 50
>>>>>>> e46a5c3d7cc260a382fd38a62f2fc12940024e3e
  });

  $('.nice-toggle').bootstrapSwitch({
    size: 'mini',
    onText: "Yes",
    offText: "No",
    handleWidth: 50,
    labelWidth: 40
  });

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
        mgoodsalias: $('#insert-mgoodsalias').val(),
        mgoodsremark: $('#insert-mgoodsremark').val(),
        mgoodsunit: $('#insert-mgoodsunit').val(),
        mgoodsunit2: $('#insert-mgoodsunit2').val(),
        mgoodsunit3: $('#insert-mgoodsunit3').val(),
        mgoodsactive: $('#insert-mgoodsactive').is(':checked'),
        mgoodspricein: $('#insert-mgoodspricein').val(),
        mgoodspriceout: $('#insert-mgoodspriceout').val(),
        mgoodstype: $('#insert-mgoodstype').val(),
        mgoodsbrand: $('#insert-mgoodsbrand').val(),
        mgoodsgroup1: $('#insert-mgoodsgroup1').val(),
        mgoodsgroup2: $('#insert-mgoodsgroup2').val(),
        mgoodsgroup3: $('#insert-mgoodsgroup3').val(),
        mgoodssuppliercode: $('#insert-mgoodssuppliercode').val(),
        mgoodssuppliername: $('#insert-mgoodssuppliername').val(),
        mgoodsbranches: $('#insert-mgoodsbranches').is(':checked'),
        mgoodsuniquetransaction: $('#insert-mgoodsuniquetransaction').is(':checked'),
        mgoodspicture: $('#insert-mgoodspicture').val(),
        mgoodscoapurchasing: $('#insert-mgoodscoapurchasing').val(),
        mgoodscoapurchasingname: $('#insert-mgoodscoapurchasingname').val(),
        mgoodscoacogs: $('#insert-mgoodscoacogs').val(),
        mgoodscoacogsname: $('#insert-mgoodscoacogsname').val(),
        mgoodscoaselling: $('#insert-mgoodscoaselling').val(),
        mgoodscoasellingname: $('#insert-mgoodscoasellingname').val(),
        mgoodscoareturnofselling: $('#insert-mgoodscoareturnofselling').val(),
        mgoodscoareturnofsellingname: $('#insert-mgoodscoareturnofsellingname').val(),
        mgoodscogs: $('#insert-mgoodscogs').val(),
        mgoodsmultiunit: $('#insert-mgoodsmultiunit').val(),
        mgoodsunit2conv: $('#insert-mgoodsunit2conv').val(),
        mgoodsunit3conv: $('#insert-mgoodsunit3conv').val(),
        mgoodstaxppn: $('#insert-mgoodstaxppn').val(),
        mgoodstaxppnbm: $('#insert-mgoodstaxppnbm').val(),
        autogen : $('#autogenmgoods').is(':checked')
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
          resetbarang();
          window.location = "#tableapi";
        },
        error: function(response){
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
      $('#edit-mgoodstype').val(response.mgoodstype).change();
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
      },100);
      console.log(response.mgoodsactive);
      if(response.mgoodsactive == 1){
        $('#edit-mgoodsactive').bootstrapSwitch('state',true);
      } else {
        $('#edit-mgoodsactive').bootstrapSwitch('state',false);
      }

      if(response.mgoodsmultiunit == 1){
        $('#edit-mgoodsmultiunit').bootstrapSwitch('state',true);
      } else {
        $('#edit-mgoodsmultiunit').bootstrapSwitch('state',false);
      }

      if(response.mgoodsbranches == 1){
        $('#edit-mgoodsbranches').bootstrapSwitch('state',true);
      } else {
        $('#edit-mgoodsbranches').bootstrapSwitch('state',false);
      }
      if(response.mgoodsuniquetransaction == 1){
        $('#edit-mgoodsuniquetransaction').bootstrapSwitch('state',true);
      } else {
        $('#edit-mgoodsuniquetransaction').bootstrapSwitch('state',false);
      }
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
        mgoodsalias: $('#edit-mgoodsalias').val(),
        mgoodsremark: $('#edit-mgoodsremark').val(),
        mgoodsunit: $('#edit-mgoodsunit').val(),
        mgoodsunit2: $('#edit-mgoodsunit2').val(),
        mgoodsunit3: $('#edit-mgoodsunit3').val(),
        mgoodsactive: $('#edit-mgoodsactive').is(':checked'),
        mgoodspricein: $('#edit-mgoodspricein').val(),
        mgoodspriceout: $('#edit-mgoodspriceout').val(),
        mgoodstype: $('#edit-mgoodstype').val(),
        mgoodsbrand: $('#edit-mgoodsbrand').val(),
        mgoodsgroup1: $('#edit-mgoodsgroup1').val(),
        mgoodsgroup2: $('#edit-mgoodsgroup2').val(),
        mgoodsgroup3: $('#edit-mgoodsgroup3').val(),
        mgoodssuppliercode: $('#edit-mgoodssuppliercode').val(),
        mgoodssuppliername: $('#edit-mgoodssuppliername').val(),
        mgoodsbranches: $('#edit-mgoodsbranches').is(':checked'),
        mgoodsuniquetransaction: $('#edit-mgoodsuniquetransaction').is(':checked'),
        mgoodspicture: $('#edit-mgoodspicture').val(),
        mgoodscoapurchasing: $('#edit-mgoodscoapurchasing').val(),
        mgoodscoapurchasingname: $('#edit-mgoodscoapurchasingname').val(),
        mgoodscoacogs: $('#edit-mgoodscoacogs').val(),
        mgoodscoacogsname: $('#edit-mgoodscoacogsname').val(),
        mgoodscoaselling: $('#edit-mgoodscoaselling').val(),
        mgoodscoasellingname: $('#edit-mgoodscoasellingname').val(),
        mgoodscoareturnofselling: $('#edit-mgoodscoareturnofselling').val(),
        mgoodscoareturnofsellingname: $('#edit-mgoodscoareturnofsellingname').val(),
        mgoodscogs: $('#edit-mgoodscogs').val(),
        mgoodsmultiunit: $('#edit-mgoodsmultiunit').val(),
        mgoodsunit2conv: $('#edit-mgoodsunit2conv').val(),
        mgoodsunit3conv: $('#edit-mgoodsunit3conv').val(),
        mgoodstaxppn: $('#edit-mgoodstaxppn').val(),
        mgoodstaxppnbm: $('#edit-mgoodstaxppnbm').val(),
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
          resetbarang();
        },
        error: function(response){
          var err_msg = response.responseJSON.errorInfo[2];
          swal({
            title: "Pengubahan Gagal!",
            type: "error",
            text: err_msg,
            timer: 2000
          });
        }
      });
    }

  }
  function viewmgoods(id){
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
      $('#view-mgoodsunit').val(response.mgoodsunit).change();
      $('#view-mgoodsunit2').val(response.mgoodsunit2).change();
      $('#view-mgoodsunit3').val(response.mgoodsunit3).change();
      $('#view-mgoodspricein').val(response.mgoodspricein);
      $('#view-mgoodspriceout').val(response.mgoodspriceout);
      $('#view-mgoodstype').val(response.mgoodstype).change();
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
      },100);
      console.log(response.mgoodsactive);
      if(response.mgoodsactive == 1){
        $('#view-mgoodsactive').bootstrapSwitch('state',true);
        $('#view-mgoodsactive').bootstrapSwitch('readonly', true);
      } else {
        $('#view-mgoodsactive').bootstrapSwitch('state',false);
        $('#view-mgoodsactive').bootstrapSwitch('readonly', true);
      }

      if(response.mgoodsmultiunit == 1){
        $('#view-mgoodsmultiunit').bootstrapSwitch('state',true);
        $('#view-mgoodsmultiunit').bootstrapSwitch('readonly', true);
      } else {
        $('#view-mgoodsmultiunit').bootstrapSwitch('state',false);
        $('#view-mgoodsmultiunit').bootstrapSwitch('readonly', true);
      }

      if(response.mgoodsbranches == 1){
        $('#view-mgoodsbranches').bootstrapSwitch('state',true);
        $('#view-mgoodsbranches').bootstrapSwitch('readonly',true);
      }else {
        $('#view-mgoodsbranches').bootstrapSwitch('state',false);
        $('#view-mgoodsbranches').bootstrapSwitch('readonly',true);
      }
      if(response.mgoodsuniquetransaction == 1){
        $('#view-mgoodsuniquetransaction').bootstrapSwitch('state',true);
        $('#view-mgoodsuniquetransaction').bootstrapSwitch('readonly',true);
      } else {
        $('#view-mgoodsuniquetransaction').bootstrapSwitch('state',false);
        $('#view-mgoodsuniquetransaction').bootstrapSwitch('readonly',true);
      }
      setTimeout(function(){
          $("#mgoodsname").focus();
      },100);


      console.log(response);
    }

});
  window.location = "#main";
}

//observe mgoodsmultiunit

$('#insert-mgoodsmultiunit').on('switchChange.bootstrapSwitch',function(e){
  var check = $('#insert-mgoodsmultiunit').is(':checked');
  if(check){
    $('#insert-mgoodsunit2').removeAttr('disabled');
    $('#insert-mgoodsunit2conv').removeAttr('disabled');
    $('#insert-mgoodsunit3').removeAttr('disabled');
    $('#insert-mgoodsunit3conv').removeAttr('disabled');
    $('#insert-mgoodsunit3conv').val(144);
    $('#insert-mgoodsunit2conv').val(12);
  } else {
    $('#insert-mgoodsunit2').attr('disabled',true);
    $('#insert-mgoodsunit2conv').attr('disabled',true);
    $('#insert-mgoodsunit3').attr('disabled',true);
    $('#insert-mgoodsunit3conv').attr('disabled',true);
    $('#insert-mgoodsunit3conv').val('');
    $('#insert-mgoodsunit2conv').val('');
  }
});

$('#edit-mgoodsmultiunit').on('switchChange.bootstrapSwitch',function(e){
  var check = $('#edit-mgoodsmultiunit').is(':checked');
  if(check){
    $('#edit-mgoodsunit2').removeAttr('disabled');
    $('#edit-mgoodsunit2conv').removeAttr('disabled');
    $('#edit-mgoodsunit3').removeAttr('disabled');
    $('#edit-mgoodsunit3conv').removeAttr('disabled');
    $('#edit-mgoodsunit3conv').val(144);
    $('#edit-mgoodsunit2conv').val(12);
  } else {
    $('#edit-mgoodsunit2').attr('disabled',true);
    $('#edit-mgoodsunit2conv').attr('disabled',true);
    $('#edit-mgoodsunit3').attr('disabled',true);
    $('#edit-mgoodsunit3conv').attr('disabled',true);
    $('#edit-mgoodsunit3conv').val('');
    $('#edit-mgoodsunit2conv').val('');
  }
});


function resetmgoods(){
        $('#insert-mgoodscode').val(''),
        $('#insert-mgoodsbarcode').val(''),
        $('#insert-mgoodsname').val(''),
        $('#insert-mgoodsalias').val(''),
        $('#insert-mgoodsremark').val(''),
        $('#insert-mgoodsunit').val(''),
        $('#insert-mgoodsunit2').val(''),
        $('#insert-mgoodsunit3').val(''),
        $('#insert-mgoodsactive').is(':checked'),
        $('#insert-mgoodspricein').val(''),
        $('#insert-mgoodspriceout').val(''),
        $('#insert-mgoodstype').val(''),
        $('#insert-mgoodsbrand').val(''),
        $('#insert-mgoodsgroup1').val(''),
        $('#insert-mgoodsgroup2').val(''),
        $('#insert-mgoodsgroup3').val(''),
        $('#insert-mgoodssuppliercode').val(''),
        $('#insert-mgoodssuppliername').val(''),
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
