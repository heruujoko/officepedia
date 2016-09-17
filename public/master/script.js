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
    $('#insert-wrapper').parsley().validate();
    if($('#insert-wrapper').parsley().isValid()){
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
    $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
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
  }

  function resetgrandparent(){
    $('#insert-mcoagrandparentcode').val('');
    $('#insert-mcoagrandparentname').val('');
    $('#insert-mcoagrandparenttype').val('K');
    $('#edit-mcoagrandparentcode').val('');
    $('#edit-mcoagrandparentname').val('');
    $('#edit-mcoagrandparenttype').val('K');
    $('#insert-wrapper').parsley().reset();
    $('#edit-wrapper').parsley().reset();
  }

  function backgrandparent(){
		$('#mcoagrandparentid').val('');
    resetgrandparent();
		$('#formedit').hide();
		$('#formview').hide();
		$('#forminput').show();
	}

// MCOAParent

  function insertparent(){
    $('#insert-wrapper').parsley().validate();
    if($('#insert-wrapper').parsley().isValid()){
      var data = {
        mcoaparentcode: $('#insert-mcoaparentcode').val(),
        mcoaparentname: $('#insert-mcoaparentname').val(),
        mcoagrandparent: $('#insert-mcoagrandparent').val()
      }
      console.log(data);
      $.ajax({
        type: "POST",
        url: API_URL+"/mcoaparent",
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
  }

  function editparent(id){
    $.ajax({
      type: "GET",
      url: API_URL+"/mcoaparent/"+id,
      success: function(response){
        $('#mcoaparentid').val(response.id);
        $('#edit-mcoaparentcode').val(response.mcoaparentcode);
        $('#edit-mcoaparentname').val(response.mcoaparentname);
        $('#edit-mcoagrandparent').val(response.mcoagrandparentcode);
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

  function updateparent(){
    $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
      var updateid = $('#mcoaparentid').val();
      var data = {
        mcoaparentcode: $('#edit-mcoaparentcode').val(),
        mcoaparentname: $('#edit-mcoaparentname').val(),
        mcoagrandparent: $('#edit-mcoagrandparent').val()
      }
      $.ajax({
        type: "PUT",
        url: API_URL+"/mcoaparent/"+updateid,
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
  }

  function viewparent(id){
    $.ajax({
      type: "GET",
      url: API_URL+"/mcoaparent/"+id,
      success: function(response){
        $('#view-mcoaparentcode').val(response.mcoaparentcode);
        $('#view-mcoaparentname').val(response.mcoaparentname);
        $('#view-mcoagrandparent').val(response.mcoagrandparentcode);
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

  function resetparent(){
    $('#insert-mcoaparentcode').val('');
    $('#insert-mcoaparentname').val('');
    $('#insert-mcoagrandparent').val('1000.00');
    $('#edit-mcoaparentcode').val('');
    $('#edit-mcoaparentname').val('');
    $('#edit-mcoagrandparent').val('1000.00');
    $('#insert-wrapper').parsley().reset();
    $('#edit-wrapper').parsley().reset();
  }

  function backparent(){
		$('#mcoaparentid').val('');
    resetparent();
		$('#formedit').hide();
		$('#formview').hide();
		$('#forminput').show();
	}

// MCOA

  function insertmcoa(){
    $("#insert-wrapper").parsley().validate();
    if($("#insert-wrapper").parsley().isValid()){
      var data = {
        mcoacode: $('#insert-mcoacode').val(),
        mcoaname: $('#insert-mcoaname').val(),
        mcoatype: $('#insert-mcoatype').val(),
        mcoaparent: $('#insert-mcoaparent').val()
      }
      console.log(data);
      $.ajax({
        type: "POST",
        url: API_URL+"/mcoa",
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
  }

  function viewmcoa(id){
    $.ajax({
      type: "GET",
      url: API_URL+"/mcoa/"+id,
      success: function(response){
        $('#view-mcoacode').val(response.mcoacode);
        $('#view-mcoaname').val(response.mcoaname);
        $('#view-mcoatype').val(response.mcoatype);
        $('#view-mcoaparent').val(response.mcoaparentcode);
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

  function editmcoa(id){
    $.ajax({
      type: "GET",
      url: API_URL+"/mcoa/"+id,
      success: function(response){
        $('#mcoaid').val(response.id);
        $('#edit-mcoacode').val(response.mcoacode);
        $('#edit-mcoaname').val(response.mcoaname);
        $('#edit-mcoatype').val(response.mcoatype);
        $('#edit-mcoaparent').val(response.mcoaparentcode);
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

  function updatemcoa(){
    $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
      var updateid = $('#mcoaid').val();
      var data = {
        mcoacode: $('#edit-mcoacode').val(),
        mcoaname: $('#edit-mcoaname').val(),
        mcoatype: $('#edit-mcoatype').val(),
        mcoaparent: $('#edit-mcoaparent').val()
      }
      $.ajax({
        type: "PUT",
        url: API_URL+"/mcoa/"+updateid,
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
  }

  function resetmcoa(){
    $('#insert-mcoacode').val('');
    $('#insert-mcoaname').val('');
    $('#insert-mcoatype').val('K');
    $('#insert-mcoaparent').val('1101.00');
    $('#edit-mcoacode').val('');
    $('#edit-mcoaname').val('');
    $('#edit-mcoatype').val('K');
    $('#edit-mcoaparent').val('1101.00');
    $('#insert-wrapper').parsley().reset();
    $('#edit-wrapper').parsley().reset();
  }

  function backmcoa(){
		$('#mcoaid').val('');
    resetparent();
		$('#formedit').hide();
		$('#formview').hide();
		$('#forminput').show();
	}

// MPREFIX

  function insertprefix(){
    $("#insert-wrapper").parsley().validate();
    if($("#insert-wrapper").parsley().isValid()){
      var data = {
        mprefix: $('#insert-prefix').val(),
        mprefixtransaction: $('#insert-transaction').val(),
        mprefixremark: $('#insert-remark').val()
      }
      console.log(data);
      $.ajax({
        type: "POST",
        url: API_URL+"/mprefix",
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
  }

  function viewprefix(id){
    $.ajax({
      type: "GET",
      url: API_URL+"/mprefix/"+id,
      success: function(response){
        $('#view-mprefix').val(response.mprefix);
        $('#view-mprefixtransaction').val(response.mprefixtransaction).trigger("change");
        $('#view-mprefixremark').val(response.mprefixremark);
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

  function editprefix(id){
    $.ajax({
      type: "GET",
      url: API_URL+"/mprefix/"+id,
      success: function(response){
        console.log(response);
        $('#mprefixid').val(response.id);
        $('#edit-mprefix').val(response.mprefix);
        $('#edit-mprefixtransaction').val(response.mprefixtransaction).trigger("change");
        $('#edit-mprefixremark').val(response.mprefixremark);
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

  function updateprefix(){
    $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
      var updateid = $('#mprefixid').val();
      var data = {
        mprefix: $('#edit-mprefix').val(),
        mprefixtransaction: $('#edit-mprefixtransaction').val(),
        mprefixremark: $('#edit-mprefixremark').val()
      }
      $.ajax({
        type: "PUT",
        url: API_URL+"/mprefix/"+updateid,
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
  }

  function resetprefix(){
    $('#insert-prefix').val('');
    $('#insert-transaction').val('Master Barang').trigger('change');
    $('#insert-remark').val('');
    $('#edit-prefix').val('');
    $('#edit-transaction').val('').trigger('change');
    $('#edit-remark').val('');
    $('#insert-wrapper').parsley().reset();
    $('#edit-wrapper').parsley().reset();
  }

  function backprefix(){
    $('#mprefixid').val('');
    resetprefix();
		$('#formedit').hide();
		$('#formview').hide();
		$('#forminput').show();
  }


// MCUSTOMER

function resetcustomer(){
$('#insert-mcustomerid').val('');
$('#insert-mcustomername').val('');
$('#insert-mcustomeremail').val('');
$('#insert-mcustomerphone').val('');
$('#insert-mcustomerfax').val('');
$('#insert-mcustomerwebsite').val('');
$('#insert-mcustomeraddress').val('');
$('#insert-mcustomercity').val('');
$('#insert-mcustomerzipcode').val('');
$('#insert-mcustomerprovince').val('');
$('#insert-mcustomercountry').val('');
$('#insert-mcustomercontactname').val('');
$('#insert-mcustomercontactposition').val('');
$('#insert-mcustomercontactemail').val('');
$('#insert-mcustomercontactemailphone').val('');

}

// MCUSTOMER