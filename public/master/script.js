$('#formedit').hide();
$('#formview').hide();

var API_URL = '/nano/public/admin-api';
var WEB_URL = '/nano/public/admin-nano';
// MBRANCH SCRIPT
$("#insert-phone").keyup(function(){
  var val = $("#insert-phone").val();
  var cls = $("#phoneexample").hasClass("phonemargin")
  console.log(val != "");
  console.log(!cls);
  if((val != "")){
    console.log("add");
    $("#phoneexample").addClass('phonemargin');
  }
});

function insertmbranch(){
   $('#insert-wrapper').parsley().validate();
    if($('#insert-wrapper').parsley().isValid()){
      var data = {
        mbranchcode: $('#insert-mbranchcode').val(),
        mbranchname: $('#insert-mbranchname').val(),
        address: $('#insert-address').val(),
        phone: $('#insert-phone').val(),
        city: $('#insert-city').val(),
        person_in_charge: $('#insert-person_in_charge').val(),
        information: $('#insert-information').val()

      }
      $.ajax({
        type: "POST",
        url: API_URL+"/cabang",
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
    if($("#insert-phone").parsley().isValid()){
      $("#phoneexample").addClass('phonemargin');
    } else {
      $("#phoneexample").removeClass('phonemargin');
    }
}

 function viewmbranch(id){
  console.log(id);
	$.ajax({
    type : 'GET',
		url : API_URL+'/cabang/'+id,
		success : function(response){
      console.log(response);
			$('#mbranchid2').val(response.id);
			$('#mbranchcode2').val(response.mbranchcode);
			$('#mbranchname2').val(response.mbranchname);
			$('#address2').val(response.address);
			$('#phone2').val(response.phone);
			$('#city2').val(response.city);
			$('#person_in_charge2').val(response.person_in_charge);
			$('#information2').val(response.information);
			$('#created_at2').val(response.created_at);
			$('#updated_at2').val(response.updated_at);
			$('#forminput').hide();
			$('#formedit').hide();
			$('#formview').show();
		}
	});
	window.location = "#main";
}
function editmbranch(id){
	$.ajax({

		url : API_URL+'/cabang/'+id,
		type : 'GET',
		success : function(response){
			$('#mbranchid').val(response.id);
			$('#mbranchcode').val(response.mbranchcode);
			$('#mbranchname').val(response.mbranchname);
			$('#address').val(response.address);
			$('#phone').val(response.phone);
			$('#city').val(response.city);
			$('#person_in_charge').val(response.person_in_charge);
			$('#information').val(response.information);
			$('#forminput').hide();
			$('#formview').hide();
			$('#formedit').show();
		},

	});
	window.location = "#main";
}

function updatembranch(){

$('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
    var updateid = $('#mbranchid').val();
    var data = {
    mbranchcode : $('#mbranchcode').val(),
    mbranchname : $('#mbranchname').val(),
    address : $('#address').val(),
    phone : $('#phone').val(),
    city : $('#city').val(),
    person_in_charge : $('#person_in_charge').val(),
    information : $('#information').val(),

  }

   $.ajax({
        type: "PUT",
        url: API_URL+"/cabang/"+updateid,
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
    $('#insert-wrapper-gp').parsley().validate();
    if($('#insert-wrapper-gp').parsley().isValid()){
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
          updatetree();
          refreshGrandParentList();
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
      			timer: 2000
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
          var err_msg = response.responseJSON.errorInfo[2];
          swal({
            title: "Pengubahan Gagal!",
            type: "error",
            text: err_msg,
            timer: 2000
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
    $('#insert-wrapper-parent').parsley().validate();
    if($('#insert-wrapper-parent').parsley().isValid()){
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
          table.ajax.reload();
          updatetree();
          refreshParentList();
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

  function refreshParentList(){
      $.ajax({
          type: "GET",
          url: API_URL+"/mcoaparent/lists",
          success: function(response){
              $('#insert-mcoaparent').empty().append(response);
              $('#edit-mcoaparent').empty().append(response);
              $('#view-mcoaparent').empty().append(response);
          },
          error: function(response){

          }
      });
  }

  function refreshGrandParentList(){
      $.ajax({
          type: "GET",
          url: API_URL+"/mcoagrandparent/lists",
          success: function(response){
              $('#insert-mcoagrandparent').empty().append(response);
              $('#edit-mcoagrandparent').empty().append(response);
              $('#view-mcoagrandparent').empty().append(response);
          },
          error: function(response){

          }
      });
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
          var err_msg = response.responseJSON.errorInfo[2];
          swal({
            title: "Pengubahan Gagal!",
            text: err_msg,
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

  function updatetree(){
    $.ajax({
      type: "GET",
      url: API_URL+"/mcoa/tree",
      success: function(response){
        console.log(response);
        $("#mcoatree").html(response);
        $('.tree > ul').attr('role', 'tree').find('ul').attr('role', 'group');
        $('.tree').find('li:has(ul)').addClass('parent_li').attr('role', 'treeitem').find(' > span').attr('title', 'Collapse this branch').on('click', function(e) {
          var children = $(this).parent('li.parent_li').find(' > ul > li');
          if (children.is(':visible')) {
            children.hide('fast');
            $(this).attr('title', 'Expand this branch').find(' > i').removeClass().addClass('fa fa-lg fa-plus-circle');
          } else {
            children.show('fast');
            $(this).attr('title', 'Collapse this branch').find(' > i').removeClass().addClass('fa fa-lg fa-minus-circle');
          }
          e.stopPropagation();
        });
      },
      error: function(response){
        swal({
  				title: "Aksi Gagal!",
  				type: "error",
  				timer: 1000
  			});
      }
    });
  }

  function addparent(){
    resetmcoa();
    backmcoa();
    $('#forminputgp').hide();
    $('#forminputp').show();
    $('#forminput').hide();
    $('#formview').hide();
    $('#formedit').hide();
      setTimeout(function(){
          $("#insert-mcoaparentcode").focus();
      },300);
    window.location = "#forminputp";
  }

  function addgparent(){
    resetmcoa();
    backmcoa();
    $('#forminputgp').show();
    $('#forminputp').hide();
    $('#forminput').hide();
    $('#formview').hide();
    $('#formedit').hide();
    setTimeout(function(){
        $("#insert-mcoagrandparentcode").focus();
    },300);
    window.location = "#forminputgp";
  }

  function addcoa(parent,type){
    resetmcoa();
    backmcoa();
      $('#forminput').show();
      $('#formview').hide();
      $('#formedit').hide();
      $('#forminputgp').hide();
      $('#forminputp').hide();
    $('#insert-mcoaparent').val(parent);
    $('#insert-mcoatype').val(type);
    setTimeout(function(){
        $("#insert-mcoacode").focus();
    },300);
    window.location = "#main";
  }

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
          table.ajax.reload();
          window.location = "#tableapi";
      		swal({
      			title: "Input Berhasil!",
      			type: "success",
      			timer: 1000
      		});
          updatetree();
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
        $('#forminputgp').hide();
        $('#forminputp').hide();
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
        $('#forminputgp').hide();
        $('#forminputp').hide();
        setTimeout(function(){
         $("#edit-mcoacode").focus();
        },300);
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
          updatetree();
          resetmcoa();
          backmcoa();
        },
        error: function(response){
          var err_msg = response.responseJSON.errorInfo[2];
          swal({
            title: "Pengubahan Gagal!",
            text: err_msg,
            type: "error",
            timer: 2000
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

  function printmcoa(){
    var divToPrint = $("#mcoatree");
    var newWin=window.open('','Print-Window');
    newWin.document.open();
    newWin.document.write('<html><body onload="window.print()">'+divToPrint.html()+'</body></html>');
    newWin.document.close();
  }

// MPREFIX

  function insertprefix(){
    $("#insert-wrapper").parsley().validate();
    if($("#insert-wrapper").parsley().isValid()){
      var data = {
        mprefix: $('#insert-prefix').val(),
        mprefixtransaction: $('#insert-transaction').val(),
        mprefixremark: $('#insert-remark').val(),
        last_count: $('#insert-lastcount').val()
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
          var err_msg = response.responseJSON.errorInfo[2];
          console.log(response);
          swal({
      			title: "Input Gagal!",
            text: err_msg,
      			type: "error",
      			timer: 1000
      		});
        }
      });
      resetprefix();
      backprefix();
    }
  }

  function viewprefix(id){
    $.ajax({
      type: "GET",
      url: API_URL+"/mprefix/"+id,
      success: function(response){
        $('#view-mprefix').val(response.mprefix);
        $('#view-lastcount').val(response.last_count);
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
        $('#edit-lastcount').val(response.last_count);
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
        mprefixremark: $('#edit-mprefixremark').val(),
        last_count: $('#edit-lastcount').val()
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
      resetprefix();
      backprefix();
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

function insertmcustomerprofile(){
   $('#insert-wrapper').parsley().validate();
    if($('#insert-wrapper').parsley().isValid()){
      var data = {
        mcustomerid: $('#insert-mcustomerid').val(),
        mcustomername: $('#insert-mcustomername').val(),
        mcustomeremail: $('#insert-mcustomeremail').val(),
        mcustomerphone: $('#insert-mcustomerphone').val(),
        mcustomerfax: $('#insert-mcustomerfax').val(),
        mcustomerwebsite: $('#insert-mcustomerwebsite').val(),
        mcustomeraddress: $('#insert-mcustomeraddress').val(),
        mcustomercity: $('#insert-mcustomercity').val(),
        mcustomerzipcode: $('#insert-mcustomerzipcode').val(),
        mcustomerprovince: $('#insert-mcustomerprovince').val(),
        mcustomercountry: $('#insert-mcustomercountry').val(),
        autogen: $('#disableforminput').val()
      }
      $.ajax({
        type: "POST",
        url: API_URL+"/pelanggan",
        data: data,
        success: function(response){
          console.log(response);
          table.ajax.reload();
           document.location.href = WEB_URL+"/pelanggan/insert/"+response.id+"/2";
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

    if($("#insert-mcustomerphone").parsley().isValid()){
      $("#phoneexample").addClass('phonemargin');
    } else {
      $("#phoneexample").removeClass('phonemargin');
    }
}

 function insertloadcontact(id){
  console.log(id);
  var data = {
      mcustomercontactname: $('#insert-mcustomercontactname').val(),
      mcustomercontactposition: $('#insert-mcustomercontactposition').val(),
      mcustomercontactemail: $('#insert-mcustomercontactemail').val(),
      mcustomercontactemailphone: $('#insert-mcustomercontactemailphone').val()

    };
  $.ajax({
    type : 'POST',
    data : data,
    url : API_URL+'/pelanggan/insert/'+id,
    success : function(response){
      console.log(response);
      swal({
            title: "Input Berhasil!",
            type: "success",
            timer: 1000
          });
    }
  });
  document.location.href = WEB_URL+"/pelanggan";
}


function editmbranch(id){
  $.ajax({

    url : API_URL+'/cabang/'+id,
    type : 'GET',
    success : function(response){
      $('#mbranchid').val(response.id);
      $('#mbranchcode').val(response.mbranchcode);
      $('#mbranchname').val(response.mbranchname);
      $('#address').val(response.address);
      $('#phone').val(response.phone);
      $('#city').val(response.city);
      $('#person_in_charge').val(response.person_in_charge);
      $('#information').val(response.information);
      $('#forminput').hide();
      $('#formview').hide();
      $('#formedit').show();
    },

  });
  window.location = "#main";
}

function updatembranch(){

$('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
    var updateid = $('#mbranchid').val();
    var data = {
    mbranchcode : $('#mbranchcode').val(),
    mbranchname : $('#mbranchname').val(),
    address : $('#address').val(),
    phone : $('#phone').val(),
    city : $('#city').val(),
    person_in_charge : $('#person_in_charge').val(),
    information : $('#information').val(),

  }

   $.ajax({
        type: "PUT",
        url: API_URL+"/cabang/"+updateid,
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




function resetcustomer1(){
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
$('#insert-wrapper').parsley().reset();
$('#edit-wrapper').parsley().reset();
}
function resetcustomer2(){
$('#insert-mcustomercontactname').val('');
$('#insert-mcustomercontactposition').val('');
$('#insert-mcustomercontactemail').val('');
$('#insert-mcustomercontactemailphone').val('');
$('#insert-wrapper').parsley().reset();
$('#edit-wrapper').parsley().reset();
}
document.getElementById('disableforminput').onchange = function() {
    document.getElementById('insert-mcustomerid').disabled = this.checked;
    if($('#disableforminput').is(':checked')){
      $('#insert-mcustomerid').removeAttr('required');
    } else{
      $('#insert-mcustomerid').attr('required','true');
    }
};


// MCUSTOMER
