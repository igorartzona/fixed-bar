jQuery(document).ready(function($){
	$('#color-picker').wpColorPicker();({	
		defaultColor: false,	
		change: function(event, ui){ },
		clear: function(){ },	
		hide: false,	
		palettes: true
	});

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
	
	$("input[name='pageID_ex']").focus( function() {
		focusCheck('ID_inc','ID_ex');
	});
	
	$("input[name='pageID_inc']").focus( function() {
		focusCheck('ID_ex','ID_inc');
	});
	
});
