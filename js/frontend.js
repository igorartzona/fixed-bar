jQuery(document).ready(function($){

	$("#az-closed").click(function() {		
		$('#az-fixed').hide();		
		$("#az-open").show();
	});
	
	$("#az-open").click(function() {		
		$('#az-fixed').show(500);		
		$("#az-open").hide();
	});
	
});