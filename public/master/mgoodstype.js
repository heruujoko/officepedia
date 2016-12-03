var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';

$(document).ready(function(){
  $('#insert-mgoodstypename').focus();
});

function backmgoodstype(){
  $('#formedit').hide();
  $('#formview').hide();
  $('#forminput').show();
}

function resetmgoodstype(){
  $('#insert-mgoodstypename').val('');
  $('#insert-mgoodstyperemark').val('');
  $('#insert-wrapper').parsley().reset();
  $('#edit-wrapper').parsley().reset();
}

function insertmgoodstype(){
   $('#insert-wrapper').parsley().validate();
   console.log($('#insert-wrapper').parsley().isValid());
    if($('#insert-wrapper').parsley().isValid()){
      var data = {
        mgoodstypename: $('#insert-mgoodstypename').val(),
        mgoodstyperemark: $('#insert-mgoodstyperemark').val(),
      }
      console.log(data);
      $.ajax({
        type: "POST",
        url: API_URL+"/mgoodstype",
        data: data,
        success: function(response){
          console.log(response);
          table.ajax.reload();
          swal({
            title: "Input Berhasil!",
            type: "success",
            timer: 1000
          });
          resetmgoodstype();
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

function viewmgoodstype(id){
  $.ajax({
    url : API_URL+'/mgoodstype/'+id,
    type : 'GET',
    success : function(response){
      $('#view-mgoodstypename').val(response.mgoodstypename);
      $('#view-mgoodstyperemark').val(response.mgoodstyperemark);
      $('#forminput').hide();
      $('#formedit').hide();
      $('#formview').show();
      resetmgoodstype();
      console.log(response);
    }

});
  window.location = "#main";
}

function editmgoodstype(id){
  $.ajax({
    url : API_URL+'/mgoodstype/'+id,
    type : 'GET',
    success : function(response){
      $('#mgoodstypeid').val(response.id);
      $('#edit-mgoodstypename').val(response.mgoodstypename);
      $('#edit-mgoodstyperemark').val(response.mgoodstyperemark);
      $('#forminput').hide();
      $('#formview').hide();
      $('#formedit').show();
      resetmgoodstype();
    }

});
  window.location = "#main";
}

function updatemgoodstype(){
  $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
    var updateid = $('#mgoodstypeid').val();
    var data = {
        mgoodstypename: $('#edit-mgoodstypename').val(),
        mgoodstyperemark: $('#edit-mgoodstyperemark').val(),
  }

   $.ajax({
        type: "PUT",
        url: API_URL+"/mgoodstype/"+updateid,
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
          resetmgoodstype();
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
