function AJAX(url, data, event) {
	$.ajax({
		url: 'ajax/' + url,
		type: 'POST',
		data: data,
		success: event
	});
} 

$(document).ready(function() {	
	$(document).scroll(function() {		
    	var scroll_pos = $(this).scrollTop(); 
		if(scroll_pos > 0) {
			$('#menu').css({ "background-color" : "rgba(216,214,215,0.6)" });
			$('#menu ul').css({ "background-color" : "rgba(226,224,225,0.6)" });
		} else {
			$('#menu').css({ "background-color" : "rgba(255,255,255,0.6)" });
			$('#menu ul').css({ "background-color" : "rgba(255,255,255,0.6)" });
		}
	});	
});
