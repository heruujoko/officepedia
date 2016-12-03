var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';

$(document).ready(function(){
  $('#insert-mgoodsunitname').focus();
});

function backmunit(){
  $('#formedit').hide();
  $('#formview').hide();
  $('#forminput').show();
}

function resetmunit(){
  $('#insert-mgoodsunitname').val('');
  $('#insert-mgoodsunitremark').val('');
  $('#insert-wrapper').parsley().reset();
  $('#edit-wrapper').parsley().reset();
}

function insertmunit(){
   $('#insert-wrapper').parsley().validate();
   console.log($('#insert-wrapper').parsley().isValid());
    if($('#insert-wrapper').parsley().isValid()){
      var data = {
        mgoodsunitname: $('#insert-mgoodsunitname').val(),
        mgoodsunitremark: $('#insert-mgoodsunitremark').val(),
      }
      console.log(data);
      $.ajax({
        type: "POST",
        url: API_URL+"/munits",
        data: data,
        success: function(response){
          console.log(response);
          table.ajax.reload();
          swal({
            title: "Input Berhasil!",
            type: "success",
            timer: 1000
          });
          resetmunit();
          window.location = "#tableapi";
        },
        error: function(response){
          var err_msg = response.responseJSON.errorInfo[2];
          swal({
            title: "Input Gagal!",
            text: err_msg,
            type: "error",
            timer: 1000
          });
        }
      });
    }
}

function viewmunit(id){
  $.ajax({
    url : API_URL+'/munits/'+id,
    type : 'GET',
    success : function(response){
      $('#view-mgoodsunitname').val(response.mgoodsunitname);
      $('#view-mgoodsunitremark').val(response.mgoodsunitremark);
      $('#forminput').hide();
      $('#formedit').hide();
      $('#formview').show();
      console.log(response);
      resetmunit();
    }

});
  window.location = "#main";
}

function editmunit(id){
  $.ajax({
    url : API_URL+'/munits/'+id,
    type : 'GET',
    success : function(response){
      $('#munitid').val(response.id);
      $('#edit-mgoodsunitname').val(response.mgoodsunitname);
      $('#edit-mgoodsunitremark').val(response.mgoodsunitremark);
      $('#forminput').hide();
      $('#formview').hide();
      $('#formedit').show();
      resetmunit();
    }

});
  window.location = "#main";
}

function updatemunit(){
  $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
    var updateid = $('#munitid').val();
    var data = {
        mgoodsunitname: $('#edit-mgoodsunitname').val(),
        mgoodsunitremark: $('#edit-mgoodsunitremark').val(),
  }

   $.ajax({
        type: "PUT",
        url: API_URL+"/munits/"+updateid,
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
          resetmunit();
        },
        error: function(response){
          var err_msg = response.responseJSON.errorInfo[2];
          swal({
            title: "Pengubahan Gagal!",
            text: err_msg,
            type: "error",
            timer: 1000
          });
        }
      });
    }

  }
