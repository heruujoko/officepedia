var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';

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
        level: $('#insert-category_name').val(),
        information: $('#insert-information').val(),
      }
      console.log(data);
      $.ajax({
        type: "POST",
        url: API_URL+"/memployeelevel",
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
    url : API_URL+'/memployeelevel/'+id,
    type : 'GET',
    success : function(response){
      $('#view-category_name').val(response.level);
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
    url : API_URL+'/memployeelevel/'+id,
    type : 'GET',
    success : function(response){
      $('#msupplierid').val(response.id);
      $('#edit-category_name').val(response.level);
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
         level: $('#edit-category_name').val(),
        information: $('#edit-information').val(),
  }

   $.ajax({
        type: "PUT",
        url: API_URL+"/memployeelevel/"+updateid,
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

if(document.getElementById('disableforminput')){
  document.getElementById('disableforminput').onchange = function() {
      document.getElementById('insert-mcategoryid').disabled = this.checked;
      if($('#disableforminput').is(':checked')){
        $('#insert-mcategoryid').removeAttr('required');
        $('#insert-wrapper').parsley().validate();
      } else{
        $('#insert-mcategoryid').attr('required','true');
        $('#insert-wrapper').parsley().validate();
      }
  };
}
