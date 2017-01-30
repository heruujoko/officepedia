var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';

$('#insert-musername').focus();
function backmuser(){
  $('#formedit').hide();
  $('#formview').hide();
  $('#forminput').show();
}

function resetmuser(){
  $('#insert-musername').val('');
  $('#insert-muserpass').val('');
  $('#insert-musercategory').val('');
  $('#insert-wrapper').parsley().reset();
  $('#edit-wrapper').parsley().reset();


}

function insertmuser(){
   $('#insert-wrapper').parsley().validate();
   console.log($('#insert-wrapper').parsley().isValid());
    if($('#insert-wrapper').parsley().isValid()){
      var data = {
        musername: $('#insert-musername').val(),
        museremail: $('#insert-museremail').val(),
        muserpass: $('#insert-muserpass').val(),
        musercategory: $('#insert-musercategory').val(),
        muserbranches: $('#insert-muserbranches').val(),
      }
      console.log(data);
      $.ajax({
        type: "POST",
        url: API_URL+"/muser",
        data: data,
        success: function(response){
          console.log(response);
          table.ajax.reload();
          swal({
            title: "Input Berhasil!",
            type: "success",
            timer: 1000
          });
          resetmuser();
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

function viewmuser(id){
  $.ajax({
    url : API_URL+'/muser/'+id,
    type : 'GET',
    success : function(response){
      $('#view-musername').val(response.musername);
      $('#view-muserpass').val(response.muserpass);
      $('#view-museremail').val(response.museremail);
      $('#view-musercategory').val(response.musercategory);
      $('#view-musercategory').trigger('change');
      var branches = [];

      for(var i=0;i<response.branches.length;i++){
          branches.push(response.branches[i].branchid);
      }
      console.log(branches);
      $("#view-muserbranches").val(branches);
      $("#view-muserbranches").trigger('change');
      $('#forminput').hide();
      $('#formedit').hide();
      $('#formview').show();

      console.log(response);
    }

});
  window.location = "#main";
}

function editmuser(id){
  $.ajax({
    url : API_URL+'/muser/'+id,
    type : 'GET',
    success : function(response){
      $('#mfixedassetsid').val(response.id);
      $('#edit-musername').val(response.musername);
      $('#edit-museremail').val(response.museremail);
    //   $('#edit-muserpass').val(response.muserpass);
      $('#edit-musercategory').val(response.musercategory);
      $('#edit-musercategory').trigger('change');

      var branches = [];

      for(var i=0;i<response.branches.length;i++){
          branches.push(response.branches[i].branchid);
      }
      console.log(branches);
      $("#edit-muserbranches").val(branches);
      $("#edit-muserbranches").trigger('change');

      $('#forminput').hide();
      $('#formview').hide();
      $('#formedit').show();
      $('#insert-musername').focus();
    }

});
  window.location = "#main";
}

function updatemuser(){
  $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
    var updateid = $('#mfixedassetsid').val();
    var data = {
         musername: $('#edit-musername').val(),
         muserpass: $('#edit-muserpass').val(),
        musercategory: $('#edit-musercategory').val(),
        museremail: $('#edit-museremail').val(),
        muserbranches: $('#edit-muserbranches').val()
  }

   $.ajax({
        type: "PUT",
        url: API_URL+"/muser/"+updateid,
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
          resetmuser();
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
