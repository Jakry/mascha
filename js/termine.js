$(document).ready(function() {
	$('.fancyme').fancybox();
	
	var $this = $('.thead');
	$window = $(window);
	var pos = 0;
	
	$window.scroll(function (e) {
		if (pos < 60) {
			pos = $('#backimagecontainer').height() + 1;
		}
		
	    if ($window.scrollTop() < pos) {
	        $this.css({
	            position: 'relative',
	            top: 0	            	           
	        });
	        $this.find('.fullhead').css({
	        	left: 'calc(-50vw + 50%)'
	        });
	        $('#termine').css({
	        	top: '-50px'
	        });
	    } else {
	        $this.css({
	            position: 'fixed',
	            top: 51,	            
	        });
	        $this.find('.fullhead').css({
	        	left: '-50vw'
	        });
	        $('#termine').css({
	        	top: '0px'
	        });
	    }
	});
});

