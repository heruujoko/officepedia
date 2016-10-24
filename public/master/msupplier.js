var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';

function backmsupplier(){
  resetmsupplier();
  $('#formedit').hide();
  $('#formview').hide();
  $('#forminput').show();
}

function resetmsupplier(){
  $('#insert-idmsupplierid').val('');
  $('#insert-msupplierid').val('');
  $('#insert-msuppliername').val('');
  $('#insert-msupplieremail').val('');
  $('#insert-msupplierphone').val('');
  $('#insert-msupplierfax').val('');
  $('#insert-msupplierwebsite').val('');
  $('#insert-msupplieraddress').val('');
  $('#insert-msuppliercity').val('');
  $('#insert-msupplierzipcode').val('');
  $('#insert-msupplierprovince').val('');
  $('#insert-msuppliercountry').val('');
  $('#insert-msuppliercontactname').val('');
  $('#insert-msuppliercontactposition').val('');
  $('#insert-msuppliercontactemail').val('');
  $('#insert-msuppliercontactemailphone').val('');
  $('#insert-msupplierarlimit').val('');
  $('#insert-msuppliercoa').val(8).change();
  $('#insert-msuppliertop').val('credit').change();
  $('#insert-msupplierarmax').val('');
  $('#insert-msupplierdefaultar').val('');

  $('#edit-idmsupplierid').val('');
  $('#edit-msupplierid').val('');
  $('#edit-msuppliername').val('');
  $('#edit-msupplieremail').val('');
  $('#edit-msupplierphone').val('');
  $('#edit-msupplierfax').val('');
  $('#edit-msupplierwebsite').val('');
  $('#edit-msupplieraddress').val('');
  $('#edit-msuppliercity').val('');
  $('#edit-msupplierzipcode').val('');
  $('#edit-msupplierprovince').val('');
  $('#edit-msuppliercountry').val('');
  $('#edit-msuppliercontactname').val('');
  $('#edit-msuppliercontactposition').val('');
  $('#edit-msuppliercontactemail').val('');
  $('#edit-msuppliercontactemailphone').val('');
  $('#edit-msupplierarlimit').val('');
  $('#edit-msuppliercoa').val(8).change();
  $('#edit-msuppliertop').val('credit').change();
  $('#edit-msupplierarmax').val('');
  $('#edit-msupplierdefaultar').val('');

  $('#view-idmsupplierid').val('');
  $('#view-msupplierid').val('');
  $('#view-msuppliername').val('');
  $('#view-msupplieremail').val('');
  $('#view-msupplierphone').val('');
  $('#view-msupplierfax').val('');
  $('#view-msupplierwebsite').val('');
  $('#view-msupplieraddress').val('');
  $('#view-msuppliercity').val('');
  $('#view-msupplierzipcode').val('');
  $('#view-msupplierprovince').val('');
  $('#view-msuppliercountry').val('');
  $('#view-msuppliercontactname').val('');
  $('#view-msuppliercontactposition').val('');
  $('#view-msuppliercontactemail').val('');
  $('#view-msuppliercontactemailphone').val('');
  $('#view-msupplierarlimit').val('');
  $('#view-msuppliercoa').val(8).change();
  $('#view-msuppliertop').val('credit').change();
  $('#view-msupplierarmax').val('');
  $('#view-msupplierdefaultar').val('');

  $('#insert-wrapper').parsley().reset();
  $('#edit-wrapper').parsley().reset();
}

function insertmsupplier(){
   $('#insert-wrapper').parsley().validate();
   console.log($('#insert-wrapper').parsley().isValid());
    if($('#insert-wrapper').parsley().isValid()){
      var data = {
        msupplierid: $('#insert-msupplierid').val(),
        msuppliername: $('#insert-msuppliername').val(),
        msupplieremail: $('#insert-msupplieremail').val(),
        msupplierphone: $('#insert-msupplierphone').val(),
        msupplierfax: $('#insert-msupplierfax').val(),
        msupplierwebsite: $('#insert-msupplierwebsite').val(),
        msupplieraddress: $('#insert-msupplieraddress').val(),
        msuppliercity: $('#insert-msuppliercity').val(),
        msupplierzipcode: $('#insert-msupplierzipcode').val(),
        msupplierprovince: $('#insert-msupplierprovince').val(),
        msuppliercountry: $('#insert-msuppliercountry').val(),
        msuppliercontactname: $('#insert-msuppliercontactname').val(),
        msuppliercontactposition: $('#insert-msuppliercontactposition').val(),
        msuppliercontactemail: $('#insert-msuppliercontactemail').val(),
        msuppliercontactemailphone: $('#insert-msuppliercontactemailphone').val(),
        autogen: $('#disableforminputspl').is(':checked'),
        msupplierarlimit: $('#insert-msupplierarlimit').val(),
        msuppliercoa: $('#insert-msuppliercoa').val(),
        msuppliertop: $('#insert-msuppliertop').val(),
        msupplierarmax: $('#insert-msupplierarmax').val(),
        msupplierdefaultar: $('#insert-msupplierdefaultar').val()
      }
      console.log(data);
      $.ajax({
        type: "POST",
        url: API_URL+"/msupplier",
        data: data,
        success: function(response){
          console.log(response);
          table.ajax.reload();
          swal({
            title: "Input Berhasil!",
            type: "success",
            timer: 1000
          });
          resetmsupplier();
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

    if($("#insert-msupplierphone").parsley().isValid()){
      $("#phoneexample").addClass('phonemargin');
    } else {
      $("#phoneexample").removeClass('phonemargin');
    }

}

function viewmsupplier(id){
  $.ajax({
    url : API_URL+'/msupplier/'+id,
    type : 'GET',
    success : function(response){
      $('#view-idmsupplierid').val(response.id);
      $('#view-msupplierid').val(response.msupplierid);
      $('#view-msuppliername').val(response.msuppliername);
      $('#view-msupplieremail').val(response.msuppliercontactemail);
      $('#view-msupplierphone').val(response.msupplierphone);
      $('#view-msupplierfax').val(response.msupplierfax);
      $('#view-msupplierwebsite').val(response.msupplierwebsite);
      $('#view-msupplieraddress').val(response.msupplieraddress);
      $('#view-msuppliercity').val(response.msuppliercity);
      $('#view-msupplierzipcode').val(response.msupplierzipcode);
      $('#view-msupplierprovince').val(response.msupplierprovince);
      $('#view-msuppliercountry').val(response.msuppliercountry);
      $('#view-msuppliercontactname').val(response.msuppliercontactname);
      $('#view-msuppliercontactposition').val(response.msuppliercontactposition);
      $('#view-msuppliercontactemail').val(response.msuppliercontactemail);
      $('#view-msuppliercontactemailphone').val(response.msuppliercontactemailphone);
      $('#view-msupplierarlimit').val(response.msupplierarlimit);
      $('#view-msuppliercoa').val(response.msuppliercoa).change();
      $('#view-msuppliertop').val(response.msuppliertop).change();
      $('#view-msupplierarmax').val(response.msupplierarmax);
      $('#view-msupplierdefaultar').val(response.msupplierdefaultar);
      $('#forminput').hide();
      $('#formedit').hide();
      $('#formview').show();

      console.log(response);
    }

});
  window.location = "#main";
}

function editmsupplier(id){
  $.ajax({
    url : API_URL+'/msupplier/'+id,
    type : 'GET',
    success : function(response){
      $('#edit-idmsupplierid').val(response.id);
      $('#edit-msupplierid').val(response.msupplierid);
      $('#edit-msuppliername').val(response.msuppliername);
      $('#edit-msupplieremail').val(response.msuppliercontactemail);
      $('#edit-msupplierphone').val(response.msupplierphone);
      $('#edit-msupplierfax').val(response.msupplierfax);
      $('#edit-msupplierwebsite').val(response.msupplierwebsite);
      $('#edit-msupplieraddress').val(response.msupplieraddress);
      $('#edit-msuppliercity').val(response.msuppliercity);
      $('#edit-msupplierzipcode').val(response.msupplierzipcode);
      $('#edit-msupplierprovince').val(response.msupplierprovince);
      $('#edit-msuppliercountry').val(response.msuppliercountry);
      $('#edit-msuppliercontactname').val(response.msuppliercontactname);
      $('#edit-msuppliercontactposition').val(response.msuppliercontactposition);
      $('#edit-msuppliercontactemail').val(response.msuppliercontactemail);
      $('#edit-msuppliercontactemailphone').val(response.msuppliercontactemailphone);
      $('#edit-msupplierarlimit').val(response.msupplierarlimit);
      $('#edit-msuppliercoa').val(response.msuppliercoa).change();
      $('#edit-msuppliertop').val(response.msuppliertop).change();
      $('#edit-msupplierarmax').val(response.msupplierarmax);
      $('#edit-msupplierdefaultar').val(response.msupplierdefaultar);
      $('#forminput').hide();
      $('#formview').hide();
      $('#formedit').show();
      setTimeout(function(){
          $("#msuppliername").focus();
      },100);
    }

});
  window.location = "#main";
}

function updatemsupplier(){
  $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
    var updateid = $('#edit-idmsupplierid').val();
    var data = {
        msupplierid: $('#edit-msupplierid').val(),
        msuppliername: $('#edit-msuppliername').val(),
        msupplieremail: $('#edit-msupplieremail').val(),
        msupplierphone: $('#edit-msupplierphone').val(),
        msupplierfax: $('#edit-msupplierfax').val(),
        msupplierwebsite: $('#edit-msupplierwebsite').val(),
        msupplieraddress: $('#edit-msupplieraddress').val(),
        msuppliercity: $('#edit-msuppliercity').val(),
        msupplierzipcode: $('#edit-msupplierzipcode').val(),
        msupplierprovince: $('#edit-msupplierprovince').val(),
        msuppliercountry: $('#edit-msuppliercountry').val(),
        msuppliercontactname: $('#edit-msuppliercontactname').val(),
        msuppliercontactposition: $('#edit-msuppliercontactposition').val(),
        msuppliercontactemail: $('#edit-msuppliercontactemail').val(),
        msuppliercontactemailphone: $('#edit-msuppliercontactemailphone').val(),
        autogen: $('#disableforminput').is(':checked'),
        msupplierarlimit: $('#edit-msupplierarlimit').val(),
        msuppliercoa: $('#edit-msuppliercoa').val(),
        msuppliertop: $('#edit-msuppliertop').val(),
        msupplierarmax: $('#edit-msupplierarmax').val(),
        msupplierdefaultar: $('#edit-msupplierdefaultar').val()
  }

   $.ajax({
        type: "PUT",
        url: API_URL+"/msupplier/"+updateid,
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
          resetmsupplier();
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

function resetmsupplier1(){
$('#insert-msupplierid').val('');
$('#insert-msuppliername').val('');
$('#insert-msupplieremail').val('');
$('#insert-msupplierphone').val('');
$('#insert-msupplierfax').val('');
$('#insert-msupplierwebsite').val('');
$('#insert-msupplieraddress').val('');
$('#insert-msuppliercity').val('');
$('#insert-msupplierzipcode').val('');
$('#insert-msupplierprovince').val('');
$('#insert-msuppliercountry').val('');
$('#insert-wrapper').parsley().reset();
$('#edit-wrapper').parsley().reset();
}
function resetmsupplier2(){
$('#insert-msuppliercontactname').val('');
$('#insert-msuppliercontactposition').val('');
$('#insert-msuppliercontactemail').val('');
$('#insert-msuppliercontactemailphone').val('');
$('#insert-wrapper').parsley().reset();
$('#edit-wrapper').parsley().reset();
}
