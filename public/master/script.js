$('#formedit').hide();
$('#formview').hide();

// MBRANCH SCRIPT
 function view(id){
	$.ajax({
		url : '/nano/public/admin-api/viewcabang/'+id,
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
function edit(id){
	$.ajax({
	
		url : '/nano/public/admin-api/editcabang/'+id,
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

function updatecabang(){
	
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
	$.post("/nano/public/admin-api/editcabang/"+id,data,function(data){
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
// MBRANCH SCRIPT

$('.sa-button-container'>'.cancel').hover(function(){
	$('.sa-confirm-button-container'>'button').removeClass('confirm');
});