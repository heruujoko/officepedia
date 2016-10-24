var API_URL = '/public/admin-api';
var WEB_URL = '/public/admin-nano';

function backmcategory(){
  $('#formedit').hide();
  $('#formview').hide();
  $('#forminput').show();
}

function resetmcategory(){
  $('#insert-category_name').val('');
  $('#insert-information').val('');
  $('#insert-wrapper').parsley().reset();
  $('#edit-wrapper').parsley().reset();
}

function insertmcategory(){
   $('#insert-wrapper').parsley().validate();
   console.log($('#insert-wrapper').parsley().isValid());
    if($('#insert-wrapper').parsley().isValid()){
      var data = {
        category_name: $('#insert-category_name').val(),
        information: $('#insert-information').val(),
      }
      console.log(data);
      $.ajax({
        type: "POST",
        url: API_URL+"/mcategorysupplier",
        data: data,
        success: function(response){
          console.log(response);
          table.ajax.reload();
          swal({
            title: "Input Berhasil!",
            type: "success",
            timer: 1000
          });
          resetmcategory();
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

function viewmcategory(id){
  $.ajax({
    url : API_URL+'/mcategorysupplier/'+id,
    type : 'GET',
    success : function(response){
      $('#view-category_name').val(response.category_name);
      $('#view-information').val(response.information);
      $('#forminput').hide();
      $('#formedit').hide();
      $('#formview').show();

      console.log(response);
    }

});
  window.location = "#main";
}

function editmcategory(id){
  $.ajax({
    url : API_URL+'/mcategorysupplier/'+id,
    type : 'GET',
    success : function(response){
      $('#msupplierid').val(response.id);
      $('#edit-category_name').val(response.category_name);
      $('#edit-information').val(response.information);
      $('#forminput').hide();
      $('#formview').hide();
      $('#formedit').show();
    }

});
  window.location = "#main";
}

function updatemcategory(){
  $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
    var updateid = $('#msupplierid').val();
    var data = {
         category_name: $('#edit-category_name').val(),
        information: $('#edit-information').val(),
  }

   $.ajax({
        type: "PUT",
        url: API_URL+"/mcategorysupplier/"+updateid,
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
          swal({
            title: "Pengubahan Gagal!",
            type: "error",
            timer: 1000
          });
        }
      });
    }

  }
