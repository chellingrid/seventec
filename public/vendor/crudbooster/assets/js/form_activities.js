$(document).ready(function() {
	$('input[name="child-online"]').each(function(){
		toggle($(this));
	});
	
	$('input[name="child-online"]').change(function(){
		toggle($(this));
	});
	
	function toggle(radio){
		if(radio.is(':checked')){
			if(radio.val() == '1'){//yes
				$("#dateslink").parent().parent().show(); //toggle divs 
				$("#datesroom_id").parent().parent().hide();
				/*
				$("#dateslink").prop("required", true);
            	$('#datesroom_id').find('input.input-label').removeAttr('required');*/
			}
			else{//no				
				$("#dateslink").parent().parent().hide();
				$("#datesroom_id").parent().parent().show();
				/* se quiser manipular os required
				$("#datesroom_id").find('input.input-label').prop("required", true);
            	$('#dateslink').removeAttr('required');*/
			}
		}
	}
});