var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';

$(document).ready(function(){
  $('#autogenemployee').attr('checked',true);
  document.getElementById('insert-memployeeid').disabled = $('#autogenemployee').is(':checked');
});

if(document.getElementById('autogenemployee')){
  document.getElementById('autogenemployee').onchange = function() {
      console.log('changed');
      document.getElementById('insert-memployeeid').disabled = this.checked;
      if($('#autogenemployee').is(':checked')){
        $('#insert-memployeeid').removeAttr('required');
        $('#insert-wrapper').parsley().validate();
      } else{
        $('#insert-memployeeid').attr('required','true');
        $('#insert-wrapper').parsley().validate();
      }
  };
}

function insertmemployee(){
  $('#insert-wrapper').parsley().validate();
  if($('#insert-wrapper').parsley().isValid()){
    var data = {
      memployeeid: $('#insert-memployeeid').val(),
      memployeetitle: $('#insert-memployeetitle').val(),
      memployeename: $('#insert-memployeename').val(),
      memployeeposition: $('#insert-memployeeposition').val(),
      memployeelevel: $('#insert-memployeelevel').val(),
      memployeephone: $('#insert-memployeephone').val(),
      memployeehomephone: $('#insert-memployeehomephone').val(),
      memployeebbmpin: $('#insert-memployeebbmpin').val(),
      memployeeidcard: $('#insert-memployeeidcard').val(),
      memployeecity: $('#insert-memployeecity').val(),
      memployeezipcode: $('#insert-memployeezipcode').val(),
      memployeeprovince: $('#insert-memployeeprovince').val(),
      memployeecountry: $('#insert-memployeecountry').val(),
      memployeecontactname: $('#insert-memployeecontactname').val(),
      memployeecontactposition: $('#insert-memployeecontactposition').val(),
      memployeecontactemail: $('#insert-memployeecontactemail').val(),
      memployeecontactemailphone: $('#insert-memployeecontactemailphone').val(),
      memployeearlimit: $('#insert-memployeearlimit').val(),
      memployeecoa: $('#insert-memployeecoa').val(),
      memployeetop: $('#insert-memployeetop').val(),
      memployeearmax: $('#insert-memployeearmax').val(),
      memployeedefaultar: $('#insert-memployeedefaultar').val(),
      autogen: $('#autogenemployee').is(':checked')
    };

    $.ajax({
      url: API_URL+"/memployee",
      method: "POST",
      data: data,
      success: function(response){
        console.log(response);
        table.ajax.reload();
        window.location = "#tableapi";
        swal({
          title: "Input Berhasil!",
          type: "success",
          timer: 1000
        });
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

function editmemployee(id){
  $('#forminput').hide();
  $('#formview').hide();
  $('#formedit').show();

  $.ajax({
    url: API_URL+"/memployee/"+id,
    method: "GET",
    success: function(response){
      $('#edit-idmemployeeid').val(response.id);
      $('#edit-memployeeid').val(response.memployeeid);
      $('#edit-memployeename').val(response.memployeename);
      $('#edit-memployeetitle').val(response.memployeetitle).change();
      $('#edit-memployeelevel').val(response.memployeelevel).change();
      $('#edit-memployeeposition').val(response.memployeeposition);
      $('#edit-memployeephone').val(response.memployeephone);
      $('#edit-memployeehomephone').val(response.memployeehomephone);
      $('#edit-memployeebbmpin').val(response.memployeebbmpin);
      $('#edit-memployeeidcard').val(response.memployeeidcard);
      $('#edit-memployeecity').val(response.memployeecity);
      $('#edit-memployeezipcode').val(response.memployeezipcode);
      $('#edit-memployeeprovince').val(response.memployeeprovince);
      $('#edit-memployeecountry').val(response.memployeecountry);
      $('#edit-memployeecontactname').val(response.memployeecontactname);
      $('#edit-memployeecontactposition').val(response.memployeecontactposition);
      $('#edit-memployeecontactemail').val(response.memployeecontactemail);
      $('#edit-memployeecontactemailphone').val(response.memployeecontactemailphone);
      $('#edit-memployeearlimit').val(response.memployeearlimit);
      $('#edit-memployeecoa').val(response.memployeecoa);
      $('#edit-memployeearmax').val(response.memployeearmax);
      $('#edit-memployeedefaultar').val(response.memployeedefaultar);
    },
    error : function(repsonse){

    }
  });
}

function updatememployee(){
  $('#edit-wrapper').parsley().validate();
  if($('#edit-wrapper').parsley().isValid()){
    var data = {
      memployeeid: $('#edit-memployeeid').val(),
      memployeetitle: $('#edit-memployeetitle').val(),
      memployeename: $('#edit-memployeename').val(),
      memployeeposition: $('#edit-memployeeposition').val(),
      memployeelevel: $('#edit-memployeelevel').val(),
      memployeephone: $('#edit-memployeephone').val(),
      memployeehomephone: $('#edit-memployeehomephone').val(),
      memployeebbmpin: $('#edit-memployeebbmpin').val(),
      memployeeidcard: $('#edit-memployeeidcard').val(),
      memployeecity: $('#edit-memployeecity').val(),
      memployeezipcode: $('#edit-memployeezipcode').val(),
      memployeeprovince: $('#edit-memployeeprovince').val(),
      memployeecountry: $('#edit-memployeecountry').val(),
      memployeecontactname: $('#edit-memployeecontactname').val(),
      memployeecontactposition: $('#edit-memployeecontactposition').val(),
      memployeecontactemail: $('#edit-memployeecontactemail').val(),
      memployeecontactemailphone: $('#edit-memployeecontactemailphone').val(),
      memployeearlimit: $('#edit-memployeearlimit').val(),
      memployeecoa: $('#edit-memployeecoa').val(),
      memployeetop: $('#edit-memployeetop').val(),
      memployeearmax: $('#edit-memployeearmax').val(),
      memployeedefaultar: $('#edit-memployeedefaultar').val()
    }

    $.ajax({
      url: API_URL+"/memployee/"+$('#edit-idmemployeeid').val(),
      method: "PUT",
      data: data,
      success:function(response){
        console.log(response);
        table.ajax.reload();
        window.location = "#tableapi";
        swal({
          title: "Input Berhasil!",
          type: "success",
          timer: 1000
        });
      },
      error: function(){
        var err_msg = response.responseJSON.errorInfo[2];
        swal({
          title: "Input Gagal!",
          text: err_msg,
          type: "error",
          timer: 1000
        });
      }
    })
  }
}

function viewmemployee(id){
  $('#forminput').hide();
  $('#formview').show();
  $('#formedit').hide();

  $.ajax({
    url: API_URL+"/memployee/"+id,
    method: "GET",
    success:function(response){
      $('#view-memployeeid').val(response.memployeeid);
      $('#view-memployeename').val(response.memployeename);
      $('#view-memployeetitle').val(response.memployeetitle).change();
      $('#view-memployeelevel').val(response.memployeelevel).change();
      $('#view-memployeeposition').val(response.memployeeposition);
      $('#view-memployeephone').val(response.memployeephone);
      $('#view-memployeehomephone').val(response.memployeehomephone);
      $('#view-memployeebbmpin').val(response.memployeebbmpin);
      $('#view-memployeeidcard').val(response.memployeeidcard);
      $('#view-memployeecity').val(response.memployeecity);
      $('#view-memployeezipcode').val(response.memployeezipcode);
      $('#view-memployeeprovince').val(response.memployeeprovince);
      $('#view-memployeecountry').val(response.memployeecountry);
      $('#view-memployeecontactname').val(response.memployeecontactname);
      $('#view-memployeecontactposition').val(response.memployeecontactposition);
      $('#view-memployeecontactemail').val(response.memployeecontactemail);
      $('#view-memployeecontactemailphone').val(response.memployeecontactemailphone);
      $('#view-memployeearlimit').val(response.memployeearlimit);
      $('#view-memployeecoa').val(response.memployeecoa);
      $('#view-memployeearmax').val(response.memployeearmax);
      $('#view-memployeedefaultar').val(response.memployeedefaultar);
    },
    error: function(response){

    }
  })
}

function resetmemployee(){
  $('#insert-idmemployeeid').val('');
  $('#insert-memployeeid').val('');
  $('#insert-memployeename').val('');
  $('#insert-memployeeposition').val('');
  $('#insert-memployeephone').val('');
  $('#insert-memployeehomephone').val('');
  $('#insert-memployeebbmpin').val('');
  $('#insert-memployeeidcard').val('');
  $('#insert-memployeecity').val('');
  $('#insert-memployeezipcode').val('');
  $('#insert-memployeeprovince').val('');
  $('#insert-memployeecountry').val('');
  $('#insert-memployeecontactname').val('');
  $('#insert-memployeecontactposition').val('');
  $('#insert-memployeecontactemail').val('');
  $('#insert-memployeecontactemailphone').val('');
  $('#insert-memployeearlimit').val('');
  $('#insert-memployeecoa').val('');
  $('#insert-memployeearmax').val('');
  $('#insert-memployeedefaultar').val('');

  $('#edit-idmemployeeid').val('');
  $('#edit-memployeeid').val('');
  $('#edit-memployeename').val('');
  $('#edit-memployeeposition').val('');
  $('#edit-memployeephone').val('');
  $('#edit-memployeehomephone').val('');
  $('#edit-memployeebbmpin').val('');
  $('#edit-memployeeidcard').val('');
  $('#edit-memployeecity').val('');
  $('#edit-memployeezipcode').val('');
  $('#edit-memployeeprovince').val('');
  $('#edit-memployeecountry').val('');
  $('#edit-memployeecontactname').val('');
  $('#edit-memployeecontactposition').val('');
  $('#edit-memployeecontactemail').val('');
  $('#edit-memployeecontactemailphone').val('');
  $('#edit-memployeearlimit').val('');
  $('#edit-memployeecoa').val('');
  $('#edit-memployeearmax').val('');
  $('#edit-memployeedefaultar').val('');
}

function backmemployee(){
  resetmemployee()
  $('#forminput').show();
  $('#formview').hide();
  $('#formedit').hide();
}
