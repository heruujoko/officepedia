var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';

function backmgoodsbrand(){
  $('#formedit').hide();
  $('#formview').hide();
  $('#forminput').show();
}

function resetmgoodsbrand(){
  $('#insert-mgoodsbrandname').val('');
  $('#insert-mgoodsbrandremark').val('');
  $('#insert-wrapper').parsley().reset();
  $('#edit-wrapper').parsley().reset();
}

function insertmgoodsbrand(){
   $('#insert-wrapper').parsley().validate();
   console.log($('#insert-wrapper').parsley().isValid());
    if($('#insert-wrapper').parsley().isValid()){
      var data = {
        mgoodsbrandname: $('#insert-mgoodsbrandname').val(),
        mgoodsbrandremark: $('#insert-mgoodsbrandremark').val(),
      }
      console.log(data);
      $.ajax({
        type: "POST",
        url: API_URL+"/mgoodsbrand",
        data: data,
        success: function(response){
          console.log(response);
          table.ajax.reload();
          swal({
            title: "Input Berhasil!",
            type: "success",
            timer: 1000
          });
          resetmbrand();
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

function viewmgoodsbrand(id){
  $.ajax({
    url : API_URL+'/mgoodsbrand/'+id,
    type : 'GET',
    success : function(response){
      $('#view-mgoodsbrandname').val(response.mgoodsbrandname);
      $('#view-mgoodsbrandremark').val(response.mgoodsbrandremark);
      $('#forminput').hide();
      $('#formedit').hide();
      $('#formview').show();

      console.log(response);
    }

});
  window.location = "#main";
}

function editmgoodsbrand(id){
  $.ajax({
    url : API_URL+'/mgoodsbrand/'+id,
    type : 'GET',
    success : function(response){
      $('#mgoodsbrandid').val(response.id);
      $('#edit-mgoodsbrandname').val(response.mgoodsbrandname);
      $('#edit-mgoodsbrandremark').val(response.mgoodsbrandremark);
      $('#forminput').hide();
      $('#formview').hide();
      $('#formedit').show();
    }

});
  window.location = "#main";
}

function updatemgoodsbrand(){
  $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
    var updateid = $('#mgoodsbrandid').val();
    var data = {
        mgoodsbrandname: $('#edit-mgoodsbrandname').val(),
        mgoodsbrandremark: $('#edit-mgoodsbrandremark').val(),
  }

   $.ajax({
        type: "PUT",
        url: API_URL+"/mgoodsbrand/"+updateid,
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
          resetmcategory();
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
