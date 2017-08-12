jQuery(document).ready(function($){
	$('#color-picker').wpColorPicker();({	
		defaultColor: false,	
		change: function(event, ui){ },
		clear: function(){ },	
		hide: false,	
		palettes: true
	});

	/*-- Visibility page check script--*/
		function blink(selector){		
			$(selector).fadeOut(600, function(){
				$(this).fadeIn(900, function(){						
				});
			});			
		}
		
		function focusCheck(ID1,ID2) {		
			document.getElementById(ID1).removeAttribute("disabled");
			document.getElementById(ID1).removeAttribute("style");
			if ( document.getElementById(ID1).value !== "") {			
				alert("Use only one input");
				document.getElementById(ID2).setAttribute("disabled", "disabled");
				document.getElementById(ID1).setAttribute("style", "color:#891515;font-weight:bold;");
				var ID1 = '#' + ID1;		
				blink(ID1);			
			}	
		}
		
		$("input[name='az_fixedbar_pageID_ex']").focus( function() {
			focusCheck('ID_inc','ID_ex');
		});
		
		$("input[name='az_fixedbar_pageID_inc']").focus( function() {
			focusCheck('ID_ex','ID_inc');
		});
	/*-- Visibility page check script end--*/


	/*-- Open\Closed button check script--*/	
		if($("input[name='az_fixedbar_close_button").prop("checked") == false){
			$('#open_button_title').attr('readonly', true); 
		}
		
		$("input[name='az_fixedbar_close_button']").click(function(){
			if($(this).prop("checked") == true){
				$('#open_button_title').removeAttr('readonly');  
			}else{
				$('#open_button_title').attr('readonly', true);  
			}
		});
	/*-- Open\Closed button check script end--*/
	
	
});
