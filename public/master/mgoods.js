$('#formedit').hide();
$('#formview').hide();
var API_URL = '/nano/public/admin-api';
var WEB_URL = '/nano/public/admin-nano';


$(document).ready(function(){

  $('.nice-toggle').bootstrapSwitch({
    size: 'mini',
    onText: "Yes",
    offText: "No"
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
        mgoodscogs: $('#insert-mgoodscogs').val()

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
          swal({
            title: "Input Gagal!",
            type: "error",
            timer: 1000
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
      $('#edit-mgoodsunit').val(response.mgoodsunit);
      $('#edit-mgoodsunit2').val(response.mgoodsunit2);
      $('#edit-mgoodsunit3').val(response.mgoodsunit3);
      $('#edit-mgoodsactive').val(response.mgoodsactive);
      $('#edit-mgoodspricein').val(response.mgoodspricein);
      $('#edit-mgoodspriceout').val(response.mgoodspriceout);
      $('#edit-mgoodstype').val(response.mgoodstype);
      $('#edit-mgoodsbrand').val(response.mgoodsbrand);
      $('#edit-mgoodsgroup1').val(response.mgoodsgroup1);
      $('#edit-mgoodsgroup2').val(response.mgoodsgroup2);
      $('#edit-mgoodsgroup3').val(response.mgoodsgroup3);
      $('#edit-mgoodssuppliercode').val(response.mgoodssuppliercode);
      $('#edit-mgoodssuppliername').val(response.mgoodssuppliername).change();
      $('#edit-mgoodsbranches').val(response.mgoodsbranches).change();
      $('#edit-mgoodsuniquetransaction').val(response.mgoodsuniquetransaction);
      $('#edit-mgoodspicture').val(response.mgoodspicture);
      $('#edit-mgoodscoapurchasing').val(response.mgoodscoapurchasing);
      $('#edit-mgoodscoapurchasingname').val(response.mgoodscoapurchasingname);
      $('#edit-mgoodscoacogs').val(response.mgoodscoacogs);
      $('#edit-mgoodscoacogsname').val(response.mgoodscoacogsname);
      $('#edit-mgoodscoaselling').val(response.mgoodscoaselling);
      $('#edit-mgoodscoasellingname').val(response.mgoodscoasellingname);
      $('#edit-mgoodscoareturnofselling').val(response.mgoodscoareturnofselling);
      $('#edit-mgoodscoareturnofsellingname').val(response.mgoodscoareturnofsellingname);
      $('#edit-mgoodscogs').val(response.mgoodscogs);
      $('#forminput').hide();
      $('#formview').hide();
      $('#formedit').show();
      setTimeout(function(){
          $("#mgoodsname").focus();
      },100);
      if(response.mgoodsactive == 1){
        $('#edit-mgoodsactive').bootstrapSwitch('state',true);
      } else {
        $('#edit-mgoodsactive').bootstrapSwitch('state',false);
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
        mgoodscogs: $('#edit-mgoodscogs').val()
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
          swal({
            title: "Pengubahan Gagal!",
            type: "error",
            timer: 1000
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
      $('#view-mgoodsunit').val(response.mgoodsunit);
      $('#view-mgoodsunit2').val(response.mgoodsunit2);
      $('#view-mgoodsunit3').val(response.mgoodsunit3);
      if(response.mgoodsactive == 1){
        $('#view-mgoodsactive').bootstrapSwitch('state',true);
        $('#view-mgoodsactive').bootstrapSwitch('disabled', true);
      } else {
        $('#view-mgoodsactive').bootstrapSwitch('state',false);
        $('#view-mgoodsactive').bootstrapSwitch('disabled', true);
      }
      $('#view-mgoodspricein').val(response.mgoodspricein);
      $('#view-mgoodspriceout').val(response.mgoodspriceout);
      $('#view-mgoodstype').val(response.mgoodstype);
      $('#view-mgoodsbrand').val(response.mgoodsbrand);
      $('#view-mgoodsgroup1').val(response.mgoodsgroup1);
      $('#view-mgoodsgroup2').val(response.mgoodsgroup2);
      $('#view-mgoodsgroup3').val(response.mgoodsgroup3);
      $('#view-mgoodssuppliercode').val(response.mgoodssuppliercode);
      $('#view-mgoodssuppliername').val(response.mgoodssuppliername).change();
      if(response.mgoodsbranches == 1){
          $('#view-mgoodsbranches').bootstrapSwitch('state',true);
          $('#view-mgoodsbranches').bootstrapSwitch('disabled',true);
      } else {
        $('#view-mgoodsbranches').bootstrapSwitch('state',false);
        $('#view-mgoodsbranches').bootstrapSwitch('disabled',true);
      }
      if(response.mgoodsuniquetransaction == 1){
          $('#view-mgoodsuniquetransaction').bootstrapSwitch('state',true);
          $('#view-mgoodsuniquetransaction').bootstrapSwitch('disabled',true);
      } else {
        $('#view-mgoodsuniquetransaction').bootstrapSwitch('state',false);
        $('#view-mgoodsuniquetransaction').bootstrapSwitch('disabled',true);
      }

      $('#view-mgoodspicture').val(response.mgoodspicture);
      $('#view-mgoodscoapurchasing').val(response.mgoodscoapurchasing);
      $('#view-mgoodscoapurchasingname').val(response.mgoodscoapurchasingname);
      $('#view-mgoodscoacogs').val(response.mgoodscoacogs);
      $('#view-mgoodscoacogsname').val(response.mgoodscoacogsname);
      $('#view-mgoodscoaselling').val(response.mgoodscoaselling);
      $('#view-mgoodscoasellingname').val(response.mgoodscoasellingname);
      $('#view-mgoodscoareturnofselling').val(response.mgoodscoareturnofselling);
      $('#view-mgoodscoareturnofsellingname').val(response.mgoodscoareturnofsellingname);
      $('#view-mgoodscogs').val(response.mgoodscogs);
      $('#forminput').hide();
      $('#formedit').hide();
      $('#formview').show();
      setTimeout(function(){
          $("#mgoodsname").focus();
      },100);


      console.log(response);
    }

});
  window.location = "#main";
}


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
