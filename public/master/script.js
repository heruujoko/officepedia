$('#formedit').hide();
$('#formview').hide();
$('.forminputcoa').hide();

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
      setTimeout(function(){
          $("#mbranchcode").focus();
      },100);
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
          var err_msg = response.responseJSON.errorInfo[2];
          swal({
            title: "Pengubahan Gagal!",
            text:err_msg,
            type: "error",
            timer: 1000
          });
        }
      });
    }

  }

  function backall(){
    $('#formviewgp').hide();
    $('#formviewp').hide();
    $('#formeditp').hide();
    $('#formeditgp').hide();
    $('#formeditp').hide();
    $('#forminputgp').hide();
    $('#forminputp').hide();
    $('#forminput').hide();
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
    $('#insert-wrapper').parsley().reset();
    $('#edit-wrapper').parsley().reset();
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
          // updatetree();
          refreshGrandParentList();
          window.location = "#tableapi";
          $('#forminputgp').hide();
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

  function viewmcoagp(id){
    $.ajax({
      type: "GET",
      url: API_URL+"/mcoagrandparent/"+id,
      success: function(response){
        $('#view-mcoagrandparentcode').val(response.mcoagrandparentcode);
        $('#view-mcoagrandparentname').val(response.mcoagrandparentname);
        $('#view-mcoagrandparenttype').val(response.mcoagrandparenttype).change();
        $('#formviewgp').show();
        $('#formviewp').hide();
        $('#formeditp').hide();
        $('#formeditgp').hide();
        $('#formeditp').hide();
        $('#forminputgp').hide();
        $('#forminputp').hide();
        $('#forminput').hide();
  			$('#formview').hide();
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

  function editmcoagp(id){
    $.ajax({
      type: "GET",
      url: API_URL+"/mcoagrandparent/"+id,
      success: function(response){
        $('#formeditgp').show();
        $('#mcoagrandparentid').val(response.id);
        $('#edit-mcoagrandparentcode').val(response.mcoagrandparentcode);
        $('#edit-mcoagrandparentname').val(response.mcoagrandparentname);
        $('#edit-mcoagrandparenttype').val(response.mcoagrandparenttype).change();
        $('#formviewgp').hide();
        $('#formviewp').hide();
        $('#formeditp').hide();
        $('#forminputgp').hide();
        $('#forminputp').hide();
        $('#forminput').hide();
  			$('#formview').hide();
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

  function updategrandparent(){
    $('#edit-wrapper-gp').parsley().validate();
    if($('#edit-wrapper-gp').parsley().isValid()){
      var updateid = $('#mcoagrandparentid').val();
      var data = {
        mcoagrandparentcode: $('#edit-mcoagrandparentcode').val(),
        mcoagrandparentname: $('#edit-mcoagrandparentname').val(),
        mcoagrandparenttype: $('#edit-mcoagrandparenttype').val()
      };
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
          $('#forminput').hide();
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
          refreshParentList();
          $('#forminputp').hide();
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

  function viewmcoaparent(id){
    $.ajax({
      type: "GET",
      url: API_URL+"/mcoaparent/"+id,
      success: function(response){
        $('#view-mcoaparentcode').val(response.mcoaparentcode);
        $('#view-mcoaparentname').val(response.mcoaparentname);
        $('#view-mcoagrandparent').val(response.mcoagrandparentcode).change();
        $('#formviewgp').hide();
        $('#formviewp').show();
        $('#formeditp').hide();
        $('#formeditgp').hide();
        $('#forminputgp').hide();
        $('#forminputp').hide();
        $('#forminput').hide();
  			$('#formview').hide();
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

  function editmcoaparent(id){
    $.ajax({
      type: "GET",
      url: API_URL+"/mcoaparent/"+id,
      success: function(response){
        $('#formeditp').show();
        $('#mcoaparentid').val(response.id);
        $('#edit-mcoaparentcode').val(response.mcoaparentcode);
        $('#edit-mcoaparentname').val(response.mcoaparentname);
        $('#edit-mcoagrandparent').val(response.mcoagrandparentcode).change();
        $('#formeditgp').hide();
        $('#forminputgp').hide();
        $('#forminputp').hide();
        $('#forminput').hide();
  			$('#formview').hide();
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

  function updateparent(){
    $('#edit-wrapper-parent').parsley().validate();
    if($('#edit-wrapper-parent').parsley().isValid()){
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
          $('#forminput').hide();
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
      },100);
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
    },100);
    window.location = "#forminputgp";
  }

  function addakun(){
    $('#formviewgp').hide();
    $('#formviewp').hide();
    $('#formeditp').hide();
    $('#formeditgp').hide();
    $('#forminputgp').hide();
    $('#forminputp').hide();
    $('#formview').hide();
    $('#formedit').hide();
    $('#forminput').show();
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
    },100);
    window.location = "#main";
  }

  function insertmcoa(){
    $("#insert-wrapper").parsley().validate();
    if($("#insert-wrapper").parsley().isValid()){
      var data = {
        mcoacode: $('#insert-mcoacode').val(),
        mcoaname: $('#insert-mcoaname').val(),
        mcoatype: $('#insert-mcoatype').val(),
        mcoaparent: $('#insert-mcoaparent').val(),
        automcoacode: $('#insert-automcoacode').is(':checked')
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
          // updatetree();
          $('#forminput').hide();
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
        $('#formviewgp').hide();
        $('#formviewp').hide();
        $('#formeditp').hide();
        $('#formeditgp').hide();
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
        $('#edit-mcoatype').val(response.mcoatype).trigger("change");
        $('#edit-mcoaparent').val(response.mcoaparentcode).trigger("change");
        $('#forminput').hide();
  			$('#formview').hide();
  			$('#formedit').show();
        $('#formviewgp').hide();
        $('#formviewp').hide();
        $('#formeditp').hide();
        $('#formeditgp').hide();
        $('#forminputgp').hide();
        $('#forminputp').hide();
        setTimeout(function(){
         $("#edit-mcoacode").focus();
       },100);
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
    $('#insert-automcoacode').prop('checked',false);
    $('#insert-mcoacode').prop('disabled',false);
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

  $('#insert-automcoacode').change(function(){
    if($('#insert-automcoacode').is(':checked')){
      $('#insert-mcoacode').prop('disabled',true);
      $('#insert-mcoacode').removeAttr('required');
      $('#insert-wrapper').parsley().reset();
      $('#insert-wrapper').parsley().validate();
    } else {
      $('#insert-mcoacode').prop('disabled',false);
      $('#insert-mcoacode').attr('required',true);
      $('#insert-wrapper').parsley().reset();
      $('#insert-wrapper').parsley().validate();
    }
  });

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
        setTimeout(function(){
            $("#edit-mprefix").focus();
        },100);
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

function backcustomer(){
  resetcustomer();
  $('#formedit').hide();
  $('#formview').hide();
  $('#forminput').show();
}

function resetcustomer(){
  $('#insert-idmcustomerid').val('');
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
  $('#insert-mcustomerarlimit').val('');
  $('#insert-mcustomercoa').val(8).change();
  $('#insert-mcustomertop').val('credit').change();
  $('#insert-mcustomerarmax').val('');
  $('#insert-mcustomerdefaultar').val('');

  $('#edit-idmcustomerid').val('');
  $('#edit-mcustomerid').val('');
  $('#edit-mcustomername').val('');
  $('#edit-mcustomeremail').val('');
  $('#edit-mcustomerphone').val('');
  $('#edit-mcustomerfax').val('');
  $('#edit-mcustomerwebsite').val('');
  $('#edit-mcustomeraddress').val('');
  $('#edit-mcustomercity').val('');
  $('#edit-mcustomerzipcode').val('');
  $('#edit-mcustomerprovince').val('');
  $('#edit-mcustomercountry').val('');
  $('#edit-mcustomercontactname').val('');
  $('#edit-mcustomercontactposition').val('');
  $('#edit-mcustomercontactemail').val('');
  $('#edit-mcustomercontactemailphone').val('');
  $('#edit-mcustomerarlimit').val('');
  $('#edit-mcustomercoa').val(8).change();
  $('#edit-mcustomertop').val('credit').change();
  $('#edit-mcustomerarmax').val('');
  $('#edit-mcustomerdefaultar').val('');

  $('#view-idmcustomerid').val('');
  $('#view-mcustomerid').val('');
  $('#view-mcustomername').val('');
  $('#view-mcustomeremail').val('');
  $('#view-mcustomerphone').val('');
  $('#view-mcustomerfax').val('');
  $('#view-mcustomerwebsite').val('');
  $('#view-mcustomeraddress').val('');
  $('#view-mcustomercity').val('');
  $('#view-mcustomerzipcode').val('');
  $('#view-mcustomerprovince').val('');
  $('#view-mcustomercountry').val('');
  $('#view-mcustomercontactname').val('');
  $('#view-mcustomercontactposition').val('');
  $('#view-mcustomercontactemail').val('');
  $('#view-mcustomercontactemailphone').val('');
  $('#view-mcustomerarlimit').val('');
  $('#view-mcustomercoa').val(8).change();
  $('#view-mcustomertop').val('credit').change();
  $('#view-mcustomerarmax').val('');
  $('#view-mcustomerdefaultar').val('');

  $('#insert-wrapper').parsley().reset();
  $('#edit-wrapper').parsley().reset();
}

function insertmcustomer(){
   $('#insert-wrapper').parsley().validate();
   console.log($('#insert-wrapper').parsley().isValid());
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
        mcustomercontactname: $('#insert-mcustomercontactname').val(),
        mcustomercontactposition: $('#insert-mcustomercontactposition').val(),
        mcustomercontactemail: $('#insert-mcustomercontactemail').val(),
        mcustomercontactemailphone: $('#insert-mcustomercontactemailphone').val(),
        autogen: $('#disableforminput').is(':checked'),
        mcustomerarlimit: $('#insert-mcustomerarlimit').val(),
        mcustomercoa: $('#insert-mcustomercoa').val(),
        mcustomertop: $('#insert-mcustomertop').val(),
        mcustomerarmax: $('#insert-mcustomerarmax').val(),
        mcustomerdefaultar: $('#insert-mcustomerdefaultar').val()
      }
      console.log(data);
      $.ajax({
        type: "POST",
        url: API_URL+"/pelanggan",
        data: data,
        success: function(response){
          console.log(response);
          table.ajax.reload();
          swal({
            title: "Input Berhasil!",
            type: "success",
            timer: 1000
          });
          resetcustomer();
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

    if($("#insert-mcustomerphone").parsley().isValid()){
      $("#phoneexample").addClass('phonemargin');
    } else {
      $("#phoneexample").removeClass('phonemargin');
    }

}

function viewmcustomer(id){
  $.ajax({
    url : API_URL+'/pelanggan/'+id,
    type : 'GET',
    success : function(response){
      $('#view-idmcustomerid').val(response.id);
      $('#view-mcustomerid').val(response.mcustomerid);
      $('#view-mcustomername').val(response.mcustomername);
      $('#view-mcustomeremail').val(response.mcustomercontactemail);
      $('#view-mcustomerphone').val(response.mcustomerphone);
      $('#view-mcustomerfax').val(response.mcustomerfax);
      $('#view-mcustomerwebsite').val(response.mcustomerwebsite);
      $('#view-mcustomeraddress').val(response.mcustomeraddress);
      $('#view-mcustomercity').val(response.mcustomercity);
      $('#view-mcustomerzipcode').val(response.mcustomerzipcode);
      $('#view-mcustomerprovince').val(response.mcustomerprovince);
      $('#view-mcustomercountry').val(response.mcustomercountry);
      $('#view-mcustomercontactname').val(response.mcustomercontactname);
      $('#view-mcustomercontactposition').val(response.mcustomercontactposition);
      $('#view-mcustomercontactemail').val(response.mcustomercontactemail);
      $('#view-mcustomercontactemailphone').val(response.mcustomercontactemailphone);
      $('#view-mcustomerarlimit').val(response.mcustomerarlimit);
      $('#view-mcustomercoa').val(response.mcustomercoa).change();
      $('#view-mcustomertop').val(response.mcustomertop).change();
      $('#view-mcustomerarmax').val(response.mcustomerarmax);
      $('#view-mcustomerdefaultar').val(response.mcustomerdefaultar);
      $('#forminput').hide();
      $('#formedit').hide();
      $('#formview').show();

      console.log(response);
    }

});
  window.location = "#main";
}

function editmcustomer(id){
  $.ajax({
    url : API_URL+'/pelanggan/'+id,
    type : 'GET',
    success : function(response){
      $('#edit-idmcustomerid').val(response.id);
      $('#edit-mcustomerid').val(response.mcustomerid);
      $('#edit-mcustomername').val(response.mcustomername);
      $('#edit-mcustomeremail').val(response.mcustomercontactemail);
      $('#edit-mcustomerphone').val(response.mcustomerphone);
      $('#edit-mcustomerfax').val(response.mcustomerfax);
      $('#edit-mcustomerwebsite').val(response.mcustomerwebsite);
      $('#edit-mcustomeraddress').val(response.mcustomeraddress);
      $('#edit-mcustomercity').val(response.mcustomercity);
      $('#edit-mcustomerzipcode').val(response.mcustomerzipcode);
      $('#edit-mcustomerprovince').val(response.mcustomerprovince);
      $('#edit-mcustomercountry').val(response.mcustomercountry);
      $('#edit-mcustomercontactname').val(response.mcustomercontactname);
      $('#edit-mcustomercontactposition').val(response.mcustomercontactposition);
      $('#edit-mcustomercontactemail').val(response.mcustomercontactemail);
      $('#edit-mcustomercontactemailphone').val(response.mcustomercontactemailphone);
      $('#edit-mcustomerarlimit').val(response.mcustomerarlimit);
      $('#edit-mcustomercoa').val(response.mcustomercoa).change();
      $('#edit-mcustomertop').val(response.mcustomertop).change();
      $('#edit-mcustomerarmax').val(response.mcustomerarmax);
      $('#edit-mcustomerdefaultar').val(response.mcustomerdefaultar);
      $('#forminput').hide();
      $('#formview').hide();
      $('#formedit').show();
      setTimeout(function(){
          $("#mcustomername").focus();
      },100);
    }

});
  window.location = "#main";
}

function updatemcustomer(){
  $('#edit-wrapper').parsley().validate();
    if($('#edit-wrapper').parsley().isValid()){
    var updateid = $('#edit-idmcustomerid').val();
    var data = {
        mcustomerid: $('#edit-mcustomerid').val(),
        mcustomername: $('#edit-mcustomername').val(),
        mcustomeremail: $('#edit-mcustomeremail').val(),
        mcustomerphone: $('#edit-mcustomerphone').val(),
        mcustomerfax: $('#edit-mcustomerfax').val(),
        mcustomerwebsite: $('#edit-mcustomerwebsite').val(),
        mcustomeraddress: $('#edit-mcustomeraddress').val(),
        mcustomercity: $('#edit-mcustomercity').val(),
        mcustomerzipcode: $('#edit-mcustomerzipcode').val(),
        mcustomerprovince: $('#edit-mcustomerprovince').val(),
        mcustomercountry: $('#edit-mcustomercountry').val(),
        mcustomercontactname: $('#edit-mcustomercontactname').val(),
        mcustomercontactposition: $('#edit-mcustomercontactposition').val(),
        mcustomercontactemail: $('#edit-mcustomercontactemail').val(),
        mcustomercontactemailphone: $('#edit-mcustomercontactemailphone').val(),
        autogen: $('#disableforminput').is(':checked'),
        mcustomerarlimit: $('#edit-mcustomerarlimit').val(),
        mcustomercoa: $('#edit-mcustomercoa').val(),
        mcustomertop: $('#edit-mcustomertop').val(),
        mcustomerarmax: $('#edit-mcustomerarmax').val(),
        mcustomerdefaultar: $('#edit-mcustomerdefaultar').val()
  }

   $.ajax({
        type: "PUT",
        url: API_URL+"/pelanggan/"+updateid,
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
          resetcustomer();
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

if(document.getElementById('disableforminput')){
  document.getElementById('disableforminput').onchange = function() {
      document.getElementById('insert-mcustomerid').disabled = this.checked;
      if($('#disableforminput').is(':checked')){
        $('#insert-mcustomerid').removeAttr('required');
        $('#insert-wrapper').parsley().validate();
      } else{
        $('#insert-mcustomerid').attr('required','true');
        $('#insert-wrapper').parsley().validate();
      }
  };
}



// MCUSTOMER
