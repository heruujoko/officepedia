var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';

function backmwarehouse(){
  $('#formedit').hide();
  $('#formview').hide();
  $('#forminput').show();
}

function resetmwarehouse(){
  $('#insert-mwarehousename').val('');
  $('#insert-mwarehouseremark').val('');
  $('#insert-wrapper').parsley().reset();
  $('#edit-wrapper').parsley().reset();
}

function insertmwarehouse(){
   $('#insert-wrapper').parsley().validate();
   console.log($('#insert-wrapper').parsley().isValid());
    if($('#insert-wrapper').parsley().isValid()){
      var data = {
        mwarehousename: $('#insert-mwarehousename').val(),
        mwarehouseremark: $('#insert-mwarehouseremark').val(),
      }
      console.log(data);
      $.ajax({
        type: "POST",
        url: API_URL+"/mwarehouse",
        data: data,
        success: function(response){
          console.log(response);
          table.ajax.reload();
          swal({
            title: "Input Berhasil!",
            type: "success",
            timer: 1000
          });
          resetmwarehouse();
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

function viewmwarehouse(id){
  $.ajax({
    url : API_URL+'/mwarehouse/'+id,
    type : 'GET',
    success : function(response){
      $('#view-mwarehousename').val(response.mwarehousename);
      $('#view-mwarehouseremark').val(response.mwarehouseremark);
      $('#forminput').hide();
      $('#formedit').hide();
      $('#formview').show();
      console.log(response);
    }

});
  window.location = "#main";
}

function editmwarehouse(id){
  $.ajax({
    url : API_URL+'/mwarehouse/'+id,
    type : 'GET',
    success : function(response){
      $('#mwarehouseid').val(response.id);
      $('#edit-mwarehousename').val(response.mwarehousename);
      $('#edit-mwarehouseremark').val(response.mwarehouseremark);
      $('#forminput').hide();
      $('#formview').hide();
      $('#formedit').show();
    }

});
  window.location = "#main";
}

function updatemwarehouse(){
  $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
    var updateid = $('#mwarehouseid').val();
    var data = {
        mwarehousename: $('#edit-mwarehousename').val(),
        mwarehouseremark: $('#edit-mwarehouseremark').val(),
  }

   $.ajax({
        type: "PUT",
        url: API_URL+"/mwarehouse/"+updateid,
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
          resetmwarehouse();
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
