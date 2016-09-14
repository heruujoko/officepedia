$('#formedit').hide();
$('#formview').hide();

var API_URL = '/nano/public/admin-api';

// MBRANCH SCRIPT
 function viewbranch(id){
	$.ajax({
		url : API_URL+'/viewcabang/'+id,
		type : 'GET',
		success : function(response){
			$('#mbranchid2').val(response.mbranch.id);
			$('#mbranchcode2').val(response.mbranch.mbranchcode);
			$('#mbranchname2').val(response.mbranch.mbranchname);
			$('#address2').val(response.mbranch.address);
			$('#phone2').val(response.mbranch.phone);
			$('#city2').val(response.mbranch.city);
			$('#person_in_charge2').val(response.mbranch.person_in_charge);
			$('#information2').val(response.mbranch.information);
			$('#created_at2').val(response.mbranch.created_at);
			$('#updated_at2').val(response.mbranch.updated_at);
			$('#forminput').hide();
			$('#formedit').hide();
			$('#formview').show();
		}
	});
	window.location = "#main";
}
function editbranch(id){
	$.ajax({

		url : API_URL+'/editcabang/'+id,
		type : 'GET',
		success : function(response){
			$('#mbranchid').val(response.mbranch.id);
			$('#mbranchcode').val(response.mbranch.mbranchcode);
			$('#mbranchname').val(response.mbranch.mbranchname);
			$('#address').val(response.mbranch.address);
			$('#phone').val(response.mbranch.phone);
			$('#city').val(response.mbranch.city);
			$('#person_in_charge').val(response.mbranch.person_in_charge);
			$('#information').val(response.mbranch.information);
			$('#forminput').hide();
			$('#formview').hide();
			$('#formedit').show();
		},

	});
	window.location = "#main";
}

function updatebranch(){

	var data = {
		mbranchcode : $('#mbranchcode').val(),
		mbranchname : $('#mbranchname').val(),
		address : $('#address').val(),
		phone : $('#phone').val(),
		city : $('#city').val(),
		person_in_charge : $('#person_in_charge').val(),
		information : $('#information').val(),

	}

	var id = $('#mbranchid').val();
	$.post(API_URL+"/editcabang/"+id,data,function(data){
			table.ajax.reload();
		 	var errcode = data.code;
			console.log(data.code);
			console.log(data);
			var strerr = "";

			if (errcode == 400) {
				for(i=0;i < data.errors.length; i++){
				strerr = strerr + data.errors[i];
			}
				window.location = "#main";
			  alert(strerr);

			}
			else{
			window.location = "#tableapi";

			swal({
						title: "Pengubahan Berhasil!",
						type: "success",
						timer: 1000

						});
			}


			});

			$('#forminput').show();
			$('#formview').hide();
			$('#formedit').hide();


}

	function back(){
		$('#insert-mbranchcode').val('');
		$('#insert-mbranchname').val('');
		$('#insert-address').val('');
		$('#insert-phone').val('');
		$('#insert-city').val('');
		$('#insert-person_in_charge').val('');
		$('#insert-information').val('');

		$('#formedit').hide();
		$('#formview').hide();
		$('#forminput').show();
	}

	function reset(){

		$('#insert-mbranchcode').val('');
		$('#insert-mbranchname').val('');
		$('#insert-address').val('');
		$('#insert-phone').val('');
		$('#insert-city').val('');
		$('#insert-person_in_charge').val('');
		$('#insert-information').val('');
		$('.alerthide').hide();
	}


  function validate(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /[0-9]|\./;
    if( !regex.test(key) ) {
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
    }
  }

// MCOAGrandParent

  function insertgrandparent(){
    var data = {
      mcoagrandparentcode: $('#insert-mcoagrandparentcode').val(),
      mcoagrandparentname: $('#insert-mcoagrandparentname').val(),
      mcoagrandparenttype: $('#insert-mcoagrandparenttype').val()
    }
    $.ajax({
      type: "POST",
      url: API_URL+"/mcoagrandparent",
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
        swal({
  				title: "Input Gagal!",
  				type: "error",
  				timer: 1000
  			});
      }
    });
  }

  function viewgrandparent(id){
    $.ajax({
      type: "GET",
      url: API_URL+"/mcoagrandparent/"+id,
      success: function(response){
        $('#view-mcoagrandparentcode').val(response.mcoagrandparentcode);
        $('#view-mcoagrandparentname').val(response.mcoagrandparentname);
        $('#view-mcoagrandparenttype').val(response.mcoagrandparenttype);
        $('#forminput').hide();
  			$('#formview').show();
  			$('#formedit').hide();
      },
      error: function(response){
        swal({
  				title: "Aksi Gagal!",
  				type: "error",
  				timer: 1000
  			});
      }
    });
    window.location = "#main";
  }

  function editgrandparent(id){
    $.ajax({
      type: "GET",
      url: API_URL+"/mcoagrandparent/"+id,
      success: function(response){
        $('#mcoagrandparentid').val(response.id);
        $('#edit-mcoagrandparentcode').val(response.mcoagrandparentcode);
        $('#edit-mcoagrandparentname').val(response.mcoagrandparentname);
        $('#edit-mcoagrandparenttype').val(response.mcoagrandparenttype);
        $('#forminput').hide();
  			$('#formview').hide();
  			$('#formedit').show();
      },
      error: function(response){
        swal({
  				title: "Aksi Gagal!",
  				type: "error",
  				timer: 1000
  			});
      }
    });
    window.location = "#main";
  }

  function updategrandparent(){
    var updateid = $('#mcoagrandparentid').val();
    var data = {
      mcoagrandparentcode: $('#edit-mcoagrandparentcode').val(),
      mcoagrandparentname: $('#edit-mcoagrandparentname').val(),
      mcoagrandparenttype: $('#edit-mcoagrandparenttype').val()
    }
    $.ajax({
      type: "PUT",
      url: API_URL+"/mcoagrandparent/"+updateid,
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

  function resetgrandparent(){
    $('#insert-mcoagrandparentcode').val('');
    $('#insert-mcoagrandparentname').val('');
    $('#insert-mcoagrandparenttype').val('K');
    $('#edit-mcoagrandparentcode').val('');
    $('#edit-mcoagrandparentname').val('');
    $('#edit-mcoagrandparenttype').val('K');
  }

  function backgrandparent(){
		$('#mcoagrandparentid').val('');
    resetgrandparent();
		$('#formedit').hide();
		$('#formview').hide();
		$('#forminput').show();
	}
