jQuery(document).ready(function($){
	$('#color-picker').wpColorPicker();({	
		defaultColor: false,	
		change: function(event, ui){ },
		clear: function(){ },	
		hide: false,	
		palettes: true
	});
	
	$("input[name='pageID_ex']").focus(function() {	
		document.getElementById("ID_inc").removeAttribute("disabled");
		document.getElementById("ID_inc").removeAttribute("style");
		if ( document.getElementById("ID_inc").value !== "") {			
			alert("У вас заполнено поле для включения Fixed Bar на страницах. Используйте только одно из полей.");
			document.getElementById("ID_ex").setAttribute("disabled", "disabled");
			document.getElementById("ID_inc").setAttribute("style", "color:#891515;font-weight:bold;");
		}		
	});
	
	$("input[name='pageID_inc']").focus(function() {
		document.getElementById("ID_ex").removeAttribute("disabled");
		document.getElementById("ID_ex").removeAttribute("style");		
		if ( document.getElementById("ID_ex").value !== "") {			
			alert("У вас заполнено поле для выключения Fixed Bar на страницах. Используйте только одно из полей.");
			document.getElementById("ID_inc").setAttribute("disabled", "disabled");
			document.getElementById("ID_ex").setAttribute("style", "color:#891515;font-weight:bold;");
		} 	
	});
	

	
	
	
});
