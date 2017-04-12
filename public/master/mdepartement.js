var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';

$(document).ready(function(){
  $('#insert-departement_name').focus();
});

function backmdepartement(){
  $('#formedit').hide();
  $('#formview').hide();
  $('#forminput').show();
}

function resetmdepartement(){
  $('#insert-departement_name').val('');
  $('#insert-information').val('');
  $('#insert-wrapper').parsley().reset();
  $('#edit-wrapper').parsley().reset();
}

function insertmdepartement(){
   $('#insert-wrapper').parsley().validate();
   console.log($('#insert-wrapper').parsley().isValid());
    if($('#insert-wrapper').parsley().isValid()){
      var data = {
        departement_name: $('#insert-departement_name').val(),
        information: $('#insert-information').val(),
      }
      console.log(data);
      $.ajax({
        type: "POST",
        url: API_URL+"/mdepartement",
        data: data,
        success: function(response){
          console.log(response);
          table.ajax.reload();
          swal({
            title: "Input Berhasil!",
            type: "success",
            timer: 1000
          });
          resetmdepartement();
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

function viewmdepartement(id){
  $.ajax({
    url : API_URL+'/mdepartement/'+id,
    type : 'GET',
    success : function(response){
      $('#view-departement_name').val(response.departement_name);
      $('#view-information').val(response.information);
      $('#forminput').hide();
      $('#formedit').hide();
      $('#formview').show();
      resetmdepartement();
      console.log(response);
    }

});
  window.location = "#main";
}

function editmdepartement(id){
  $.ajax({
    url : API_URL+'/mdepartement/'+id,
    type : 'GET',
    success : function(response){
      $('#mdepartementid').val(response.id);
      $('#edit-departement_name').val(response.departement_name);
      $('#edit-information').val(response.information);
      $('#forminput').hide();
      $('#formview').hide();
      $('#formedit').show();
      resetmdepartement();
    }

});
  window.location = "#main";
}

function updatemdepartement(){
  $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
    var updateid = $('#mdepartementid').val();
    var data = {
         departement_name: $('#edit-departement_name').val(),
        information: $('#edit-information').val(),
  }

   $.ajax({
        type: "PUT",
        url: API_URL+"/mdepartement/"+updateid,
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
          resetmdepartement();
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
