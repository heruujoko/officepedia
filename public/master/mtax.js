var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';


function insertmtax(){
  $('#insert-wrapper').parsley().validate();
  if($('#insert-wrapper').parsley().isValid()){
    var data = {
      mtaxtype: $('#insert-mtaxtype').val(),
      mtaxtdesc: $('#insert-mtaxtdesc').val(),
      mtaxtpercentage: $('#insert-mtaxtpercentage').val()
    };
    $.ajax({
      type: "POST",
      url: API_URL+"/mtax",
      data: data,
      success: function(response){
        console.log(response);
        table.ajax.reload();
        swal({
          title: "Input Berhasil!",
          type: "success",
          timer: 1000
        });
        resetmtax();
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

function viewmtax(id){
  $.ajax({
    url : API_URL+'/mtax/'+id,
    type : 'GET',
    success : function(response){
      $('#view-mtaxtype').val(response.mtaxtype);
      $('#view-mtaxtdesc').val(response.mtaxtdesc);
      $('#view-mtaxtpercentage').val(response.mtaxtpercentage);
      $('#forminput').hide();
      $('#formedit').hide();
      $('#formview').show();
      resetmtax();
      
    }

});
  window.location = "#main";
}

function editmtax(id){
  $.ajax({
    url : API_URL+'/mtax/'+id,
    type : 'GET',
    success : function(response){
      $('#taxid').val(response.id);
      $('#edit-mtaxtype').val(response.mtaxtype).change();
      $('#edit-mtaxtdesc').val(response.mtaxtdesc);
      $('#edit-mtaxtpercentage').val(response.mtaxtpercentage);
      $('#forminput').hide();
      $('#formview').hide();
      $('#formedit').show();
      resetmtax();
    }

});
  window.location = "#main";
}

function updatemtax(){
  $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
    var updateid = $('#taxid').val();
    var data = {
      mtaxtype: $('#edit-mtaxtype').val(),
      mtaxtdesc: $('#edit-mtaxtdesc').val(),
      mtaxtpercentage: $('#edit-mtaxtpercentage').val()
    };

   $.ajax({
        type: "PUT",
        url: API_URL+"/mtax/"+updateid,
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
          resetmtax();
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

function resetmtax(){
  $('#edit-mtaxtype').val('');
  $('#edit-mtaxtdesc').val('');
  $('#edit-mtaxtpercentage').val('');
  $('#insert-mtaxtype').val('');
  $('#insert-mtaxtdesc').val('');
  $('#insert-mtaxtpercentage').val('');
}

function backmtax(){
  resetmtax();
  $('#forminput').show();
  $('#formview').hide();
  $('#formedit').hide();
}
