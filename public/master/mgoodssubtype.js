var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';

function backmgoodssubtype(){
  $('#formedit').hide();
  $('#formview').hide();
  $('#forminput').show();
}

function resetmgoodssubtype(){
  $('#insert-mgoodssubtypename').val('');
  $('#insert-mgoodssubtyperemark').val('');
  $('#insert-wrapper').parsley().reset();
  $('#edit-wrapper').parsley().reset();
}

function insertmgoodssubtype(){
   $('#insert-wrapper').parsley().validate();
   console.log($('#insert-wrapper').parsley().isValid());
    if($('#insert-wrapper').parsley().isValid()){
      var data = {
        mgoodssubtypename: $('#insert-mgoodssubtypename').val(),
        mgoodssubtypeparent: $('#insert-mgoodssubtypeparent').val(),
        mgoodssubtyperemark: $('#insert-mgoodssubtyperemark').val(),
      }
      console.log(data);
      $.ajax({
        type: "POST",
        url: API_URL+"/mgoodssubtype",
        data: data,
        success: function(response){
          console.log(response);
          table.ajax.reload();
          swal({
            title: "Input Berhasil!",
            type: "success",
            timer: 1000
          });
          resetmgoodssubtype();
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

function viewmgoodssubtype(id){
  $.ajax({
    url : API_URL+'/mgoodssubtype/'+id,
    type : 'GET',
    success : function(response){
      $('#view-mgoodssubtypename').val(response.mgoodssubtypename);
      $('#view-mgoodssubtypeparent').val(response.mgoodssubtypeparent).change();
      $('#view-mgoodssubtyperemark').val(response.mgoodssubtyperemark);
      $('#forminput').hide();
      $('#formedit').hide();
      $('#formview').show();
      console.log(response);
    }

});
  window.location = "#main";
}

function editmgoodssubtype(id){
  $.ajax({
    url : API_URL+'/mgoodssubtype/'+id,
    type : 'GET',
    success : function(response){
      $('#mgoodssubtypeid').val(response.id);
      $('#edit-mgoodssubtypename').val(response.mgoodssubtypename);
      $('#edit-mgoodssubtypeparent').val(response.mgoodssubtypeparent).change();
      $('#edit-mgoodssubtyperemark').val(response.mgoodssubtyperemark);
      $('#forminput').hide();
      $('#formview').hide();
      $('#formedit').show();
    }

});
  window.location = "#main";
}

function updatemgoodssubtype(){
  $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
    var updateid = $('#mgoodssubtypeid').val();
    var data = {
        mgoodssubtypename: $('#edit-mgoodssubtypename').val(),
        mgoodssubtypeparent: $('#edit-mgoodssubtypeparent').val(),
        mgoodssubtyperemark: $('#edit-mgoodssubtyperemark').val(),
  }

   $.ajax({
        type: "PUT",
        url: API_URL+"/mgoodssubtype/"+updateid,
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
          resetmgoodssubtype();
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
