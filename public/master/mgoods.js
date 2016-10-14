$('#formedit').hide();
$('#formview').hide();
var API_URL = '/nano/public/admin-api';
var WEB_URL = '/nano/public/admin-nano';

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
        mgoodsactive: $('#insert-mgoodsactive').val(),
        mgoodspricein: $('#insert-mgoodspricein').val(),
        mgoodspriceout: $('#insert-mgoodspriceout').val(),
        mgoodstype: $('#insert-mgoodstype').val(),
        mgoodsbrand: $('#insert-mgoodsbrand').val(),
        mgoodsgroup1: $('#insert-mgoodsgroup1').val(),
        mgoodsgroup2: $('#insert-mgoodsgroup2').val(),
        mgoodsgroup3: $('#insert-mgoodsgroup3').val(),
        mgoodssuppliercode: $('#insert-mgoodssuppliercode').val(),
        mgoodssuppliername: $('#insert-mgoodssuppliername').val(),
        mgoodsbranches: $('#insert-mgoodsbranches').val(),
        mgoodsuniquetransaction: $('#insert-mgoodsuniquetransaction').val(),
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
          console.log(response);
          table.ajax.reload();
          swal({
            title: "Input Berhasil!",
            type: "success",
            timer: 1000
          });
          resetcustomer();
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