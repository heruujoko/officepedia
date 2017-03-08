var API_URL = '/admin-api';
var WEB_URL = '/admin-nano';

$(document).ready(function(){
  get_cash_total("1101.00");
  get_bank_total("1102.00");
  get_grand_total();
});

function refreshtotal(){
  get_cash_total("1101.00");
  get_bank_total("1102.00");
  get_grand_total();
}

function get_grand_total(){
  $.ajax({
    method: "GET",
    url: API_URL+"/cashbank/grandtotal",
    success: function(response){
      $('#grandtotal').html(response);
    }
  });
}

function get_bank_total(code){
  $.ajax({
    method: "GET",
    url: API_URL+"/cashbank/total/"+code,
    success: function(response){
      $('.totalbank').html(response);
    }
  });
}

function get_cash_total(code){
  $.ajax({
    method: "GET",
    url: API_URL+"/cashbank/total/"+code,
    success: function(response){
      $('.totalcash').html(response);
    }
  });
}

function add_master_kas(){
  $('#addkasmodal').modal('show');
}

function edit_kas(id){
  $('#editkasmodal').modal('show')
  $.ajax({
    method: "GET",
    url: API_URL+"/mcoa/"+id,
    success: function(response){
      $('#mcoaid').val(response.id);
      $('#edit-mcoaname').val(response.mcoaname);
    }
  });
}

function insert_kas(){
  $('#modalkas-wrapper').parsley().validate();
  if($('#modalkas-wrapper').parsley().isValid()){
    var data = {
      mcoaname: $('#insert-mcoaname').val(),
      automcoacode: true
    }
    $.ajax({
      type: "POST",
      url: API_URL+"/cashbank/cash",
      data: data,
      success: function(response){
        tablekas.ajax.reload();
        window.location = "#tableapi";
        refreshtotal();
        swal({
          title: "Input Berhasil!",
          type: "success",
          timer: 1000
        });
        $('#addkasmodal').modal('hide')
      },
      error: function(response){
        var err_msg = response.responseJSON.errorInfo[2];
        swal({
          title: "Input Gagal!",
              text: err_msg,
          type: "error",
          timer: 2000
        });
      }
    });
  }

}

function update_kas(){
  $('#editmodalkas-wrapper').parsley().validate();
  if($('#editmodalkas-wrapper').parsley().isValid()){
    id = $('#mcoaid').val();
    data = {
      mcoaname : $('#edit-mcoaname').val()
    };
    $.ajax({
      method: "PUT",
      data:data,
      url: API_URL+"/cashbank/cash/"+id,
      success: function(response){
        tablekas.ajax.reload();
        window.location = "#tableapi";
        refreshtotal();
        swal({
          title: "Input Berhasil!",
          type: "success",
          timer: 1000
        });
        $('#editkasmodal').modal('hide');
      },
      error: function(response){
        console.log(response);
        var err_msg = response.responseJSON.errorInfo[2];
        swal({
          title: "Input Gagal!",
              text: err_msg,
          type: "error",
          timer: 2000
        });
      }
    });
  }

}

function add_master_bank(){
  $('#addbankmodal').modal('show');
}

function edit_bank(id){
  $('#editbankmodal').modal('show');
  $.ajax({
    method: "GET",
    url: API_URL+"/mcoa/"+id,
    success: function(response){
      $('#mcoaidbank').val(response.id);
      $('#edit-mcoanamebank').val(response.mcoaname);
    }
  });
}

function insert_bank(){
  $('#modalbank-wrapper').parsley().validate();
  if($('#modalbank-wrapper').parsley().isValid()){
    var data = {
      mcoaname: $('#insert-mcoanamebank').val(),
      automcoacode: true
    }
    $.ajax({
      type: "POST",
      url: API_URL+"/cashbank/bank",
      data: data,
      success: function(response){
        refreshtbl();
        window.location = "#tablebank";
        refreshtotal();
        swal({
          title: "Input Berhasil!",
          type: "success",
          timer: 1000
        });
        $('#addbankmodal').modal('hide')
      },
      error: function(response){
        var err_msg = response.responseJSON.errorInfo[2];
        swal({
          title: "Input Gagal!",
              text: err_msg,
          type: "error",
          timer: 2000
        });
      }
    });
  }

}

function update_bank(){
  $('#editmodalbank-wrapper').parsley().validate();
  if($('#editmodalbank-wrapper').parsley().isValid()){
    id = $('#mcoaidbank').val();
    data = {
      mcoaname : $('#edit-mcoanamebank').val()
    };
    $.ajax({
      method: "PUT",
      data:data,
      url: API_URL+"/cashbank/bank/"+id,
      success: function(response){
        tablebank.ajax.reload();
        window.location = "#tablebank";
        refreshtotal();
        swal({
          title: "Input Berhasil!",
          type: "success",
          timer: 1000
        });
        $('#editbankmodal').modal('hide');
      },
      error: function(response){
        console.log(response);
        var err_msg = response.responseJSON.errorInfo[2];
        swal({
          title: "Input Gagal!",
              text: err_msg,
          type: "error",
          timer: 2000
        });
      }
    });
  }

}
