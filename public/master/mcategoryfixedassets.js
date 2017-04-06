var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';
  $("#insert-mcategoryfixedassetgroupcode").focus();



$('#insert-mcategoryfixedassetshrink').on('change',function(event){
  console.log(event);
  if($('#insert-mcategoryfixedassetshrink').is(':checked')){
    $('#insert-mcategoryfixedassetdepreciaton').prop('disabled',false);
    $('#insert-mcategoryfixedassetcoaasset').prop('disabled',false);
    $('#insert-mcategoryfixedassetcoaaccudepr').prop('disabled',false);
    $('#insert-mcategoryfixedassetremark').prop('disabled',false);
    $('#insert-mcategoryfixedassetcoadeprexp').prop('disabled',false);

  } else {
    $('#insert-mcategoryfixedassetdepreciaton').prop('disabled',true);
    $('#insert-mcategoryfixedassetcoaasset').prop('disabled',true);
    $('#insert-mcategoryfixedassetcoaaccudepr').prop('disabled',true);
    $('#insert-mcategoryfixedassetremark').prop('disabled',true);
    $('#insert-mcategoryfixedassetcoadeprexp').prop('disabled',true);
  }
});


$('#edit-mcategoryfixedassetshrink').on('change',function(event){
  console.log(event);
  if($('#edit-mcategoryfixedassetshrink').is(':checked')){
    $('#edit-mcategoryfixedassetdepreciaton').prop('disabled',false);
    $('#edit-mcategoryfixedassetcoaasset').prop('disabled',false);
    $('#edit-mcategoryfixedassetcoaaccudepr').prop('disabled',false);
    $('#edit-mcategoryfixedassetremark').prop('disabled',false);
    $('#edit-mcategoryfixedassetcoadeprexp').prop('disabled',false);

  } else {
    $('#edit-mcategoryfixedassetdepreciaton').prop('disabled',true);
    $('#edit-mcategoryfixedassetcoaasset').prop('disabled',true);
    $('#edir-mcategoryfixedassetcoaaccudepr').prop('disabled',true);
    $('#edir-mcategoryfixedassetremark').prop('disabled',true);
    $('#edir-mcategoryfixedassetcoadeprexp').prop('disabled',true);

  }
});



function backmcategory(){
  $('#formedit').hide();
  $('#formview').hide();
  $('#forminput').show();
}

function resetmcategory(){
  $('#insert-mcategoryfixedassetgroupcode').val('');
  $('#insert-mcategoryfixedassetgroupname').val('');
  $('#insert-mcategoryfixedassetage').val('');
  $('#insert-mcategoryfixedassetdepreciaton').val('');
  $('#insert-mcategoryfixedassetcoaasset').val('');
  $('#insert-mcategoryfixedassetcoaaccudepr').val('');
  $('#insert-mcategoryfixedassetcoadeprexp').val('');
  $('#insert-mcategoryfixedassetremark').val('');

  $('#insert-wrapper').parsley().reset();
  $('#edit-wrapper').parsley().reset();
}

function insertmcategory(){
   $('#insert-wrapper').parsley().validate();
   console.log($('#insert-wrapper').parsley().isValid());
    if($('#insert-wrapper').parsley().isValid()){
      var data = {
        mcategoryfixedassetgroupcode: $('#insert-mcategoryfixedassetgroupcode').val(),
        mcategoryfixedassetgroupname: $('#insert-mcategoryfixedassetgroupname').val(),
        mcategoryfixedassetage: $('#insert-mcategoryfixedassetage').val(),
        mcategoryfixedassetshrink: $('#insert-mcategoryfixedassetshrink').is(':checked'),
        mcategoryfixedassetdepreciaton: $('#insert-mcategoryfixedassetdepreciaton').val(),
        mcategoryfixedassetcoaasset: $('#insert-mcategoryfixedassetcoaasset').val(),
        mcategoryfixedassetcoaaccudepr: $('#insert-mcategoryfixedassetcoaaccudepr').val(),
        mcategoryfixedassetcoadeprexp: $('#insert-mcategoryfixedassetcoadeprexp').val(),
        mcategoryfixedassetremark: $('#insert-mcategoryfixedassetremark').val(),
      }
      console.log(data);
      $.ajax({
        type: "POST",
        url: API_URL+"/mcategoryfixedassets",
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
    url : API_URL+'/mcategoryfixedassets/'+id,
    type : 'GET',
    success : function(response){
      $('#view-mcategoryfixedassetgroupcode').val(response.mcategoryfixedassetgroupcode);
      $('#view-mcategoryfixedassetgroupname').val(response.mcategoryfixedassetgroupname);
      $('#view-mcategoryfixedassetage').val(response.mcategoryfixedassetage);

      if(response.mcategoryfixedassetshrink == true){
        $('#view-mcategoryfixedassetshrink').attr('checked',true);
        $('#view-mcategoryfixedassetdepreciaton').prop('disabled',false);
        $('#view-mcategoryfixedassetcoaasset').prop('disabled',false);
        } else {
        $('#view-mcategoryfixedassetshrink').removeAttr('checked');
        $('#view-mcategoryfixedassetdepreciaton').prop('disabled',true);
       $('#view-mcategoryfixedassetcoaasset').prop('disabled',true);

      }

      $('#view-mcategoryfixedassetdepreciaton').val(response.mcategoryfixedassetdepreciaton);
      $('#view-mcategoryfixedassetcoaasset').val(response.mcategoryfixedassetcoaasset);
      $('#view-mcategoryfixedassetcoaaccudepr').val(response.mcategoryfixedassetcoaaccudepr);
      $('#view-mcategoryfixedassetcoadeprexp').val(response.mcategoryfixedassetcoadeprexp)
      $('#view-mcategoryfixedassetremark').val(response.mcategoryfixedassetremark)
      $('#forminput').hide();
      $('#formedit').hide();
      $('#formview').show();
    }

});
  window.location = "#main";
}

function editmcategory(id){
  $.ajax({
    url : API_URL+'/mcategoryfixedassets/'+id,
    type : 'GET',
    contentType: "application/json",
    dataType: 'json',
    success : function(response){
      $('#mfixedassetsid').val(response.id);
      $('#edit-mcategoryfixedassetgroupcode').val(response.mcategoryfixedassetgroupcode);
      $('#edit-mcategoryfixedassetgroupname').val(response.mcategoryfixedassetgroupname);
      $('#edit-mcategoryfixedassetage').val(response.mcategoryfixedassetage);
      $('#edit-mcategoryfixedassetdepreciaton').val(response.mcategoryfixedassetdepreciaton).change();
      $('#edit-mcategoryfixedassetcoaasset').val(response.mcategoryfixedassetcoaasset).change();
      $('#edit-mcategoryfixedassetcoaaccudepr').val(response.mcategoryfixedassetcoaaccudepr).change();
      $('#edit-mcategoryfixedassetcoadeprexp').val(response.mcategoryfixedassetcoadeprexp).change();
      $('#edit-mcategoryfixedassetremark').val(response.mcategoryfixedassetremark);

      if(response.mcategoryfixedassetshrink == 'true'){
        $('#edit-mcategoryfixedassetshrink').attr('checked',true);
        $('#edit-mcategoryfixedassetdepreciaton').prop('disabled',false);
        $('#edit-mcategoryfixedassetcoaasset').prop('disabled',false);
        console.log('true');
        } else {
        $('#edit-mcategoryfixedassetshrink').removeAttr('checked');
        $('#edit-mcategoryfixedassetdepreciaton').prop('disabled',true);
        $('#edit-mcategoryfixedassetcoaasset').prop('disabled',true);
         console.log('false');

      }
      $('#forminput').hide();
      $('#formedit').show();
      $('#formview').hide();
    }

});
  window.location = "#main";
}

function updatemcategory(){
  $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
    var updateid = $('#mfixedassetsid').val();
    var data = {
        mcategoryfixedassetgroupcode: $('#edit-mcategoryfixedassetgroupcode').val(),
        mcategoryfixedassetgroupname: $('#edit-mcategoryfixedassetgroupname').val(),
        mcategoryfixedassetage: $('#edit-mcategoryfixedassetage').val(),
        mcategoryfixedassetshrink: $('#edit-mcategoryfixedassetshrink').is(':checked'),
        mcategoryfixedassetdepreciaton: $('#edit-mcategoryfixedassetdepreciaton').val(),
        mcategoryfixedassetcoaasset: $('#edit-mcategoryfixedassetcoaasset').val(),
        mcategoryfixedassetcoaaccudepr: $('#edit-mcategoryfixedassetcoaaccudepr').val(),
        mcategoryfixedassetcoadeprexp: $('#edit-mcategoryfixedassetcoadeprexp').val(),
        mcategoryfixedassetremark: $('#edit-mcategoryfixedassetremark').val(),
      }

   $.ajax({
        type: "PUT",
        url: API_URL+"/mcategoryfixedassets/"+updateid,
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
