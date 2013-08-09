jQuery(document).ready(function(){

  jQuery("#session_ref_btn").click(function(){

  		//Get reference id from the form
  		//Check for id
  		var reference_id = $('#form_session_reference').val()
  		if(!reference_id){
  			return; //if no id, return
  		}

  		jQuery.ajax({
  			url: '/rest/prolibraries/webinars',
  			data: {
  				//Testing
  				//reference_id: 'amt_s01_06_06_12'// does not have a session
  				//reference_id:'arrs_vcc_s03_05_02_11'
  				reference_id:reference_id
  			},
  			type:"GET",
  			dataType:"JSON",
  			error: function( xhr, status, thrownError ) {
  			
    		},
    		success:function(data){
    			console.log(data);
    		
    			if (data.Result == '1') {//found a webinar
					jQuery('#form_title').val(data.webinarName)
					var start = data.sessionDate + 'T' + data.startTime;
					var end = data.sessionDate + 'T' + data.endTime;
					jQuery('#form_start').val(start);
					jQuery('#form_end').val(end);
					jQuery('#form_association').val(data.libname);
					jQuery('#form_description').val(data.sessionDescription);
	   				
	   				if (data.webinarType == "Webinar"){
	   					jQuery('#form_type_1').attr('checked', 'checked');
	   				}

	   				jQuery(".add-by-ref").hide();
   			    }
   			    else{
   			    	alert('Webinar not found ('+ reference_id +')')
   			    }




    		}
    	});

  		//jQuery('#form_title').val("Success!!!!");
   		
  });
});