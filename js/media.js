//$('img#backimage').load(function() {
	
var maxheight;
var maxwidth;

$(document).ready(function() {	
	var arrows = '<div class="centerarrow left"><a href="javascript:void(0)" class="arrow left"></a></div><div class="centerarrow right"><a href="javascript:void(0)" class="arrow right"></a></div>';
	var dots = '<div class="centerdots"><div class="wrapdots"><div class="dots"><a class="dm1" href="javascript:void(0);"></a><a class="d0" href="javascript:void(0);"></a><a class="d1" href="javascript:void(0);" rel="-2"></a><a class="d2" href="javascript:void(0);" rel="-1"></a><a class="d3" href="javascript:void(0);" rel="0"></a><a class="d4" href="javascript:void(0);" rel="1"></a><a class="d5" href="javascript:void(0);" rel="2"></a><a class="d6" href="javascript:void(0);" rel="2"></a><a class="d7" href="javascript:void(0);" rel="2"></a></div></div></div>';	
	$('#backimagecontainer').append(arrows);
	$('#backimagecontainer').parent().append(dots);			
	
	var nextpid;
	var addline = false;	
	 	
	$('.arrow').click(function() {
		nextpid = 1;
		if ($(this).hasClass('left')) {
			nextpid = -1;			
		}				
		
		changeImage(nextpid, addline, $('img#backimage').height(), $('img#backimage').width());
		addline = true;
	});
	
	$('.dots a').click(function() {
		nextpid = $(this).attr("rel");
		changeImage(nextpid, addline, $('img#backimage').height(), $('img#backimage').width());
		addline = true;
	});		
	
	// Bühne	
	$('a.arrow').click(function() {
		if ($(this).hasClass("down")) {			
			$('#buehne').css({"height":"auto"});
			$('#buehne .wrapbuehne').css({"max-height":"none"});
			$(this).removeClass("down");		
			$(this).addClass("up");
		} else {
			$('#buehne').css({"height":"1200px"});
			$('#buehne .wrapbuehne').css({"max-height":"1060px"});
			$(this).removeClass("up");		
			$(this).addClass("down");
		}
		
	});
	
	$('a.parrow.up').click(function() {		
		var top = $(this).parents('.picslider').find('.wrapbigpics').css("top")
		if (top != "0px" && top != "auto") {
			$(this).parents('.picslider').find('.wrapbigpics').animate({"top" : "+=200px"}, 300);
		}
	});
	$('a.parrow.down').click(function() {
		var top = $(this).parents('.picslider').find('.wrapbigpics').css("top")
		var height = $(this).parents('.picslider').find('.wrapbigpics').height();
		var ptop = parseInt(top);			
		if (top == "auto" || ptop * -1 + 200 < height) {
			$(this).parents('.picslider').find('.wrapbigpics').animate({"top" : "-=200px"}, 300);
		}
	});
	
	var classnum = 0;
	$('.bcol .btxt').each(function() {			
		if ($(this)[0].scrollHeight > $(this).innerHeight()) {			
			$(this).parent().append('<a href="javascript:void(0)" class="contread a' + classnum + '">...weiterlesen</a>');
			$('.contread.a' + classnum++).bind('click', function() {
				if ($(this).html() == "Fertig") {
					$(this).parent().find('.btxt').css({"height" : "300px"});
					$(this).html("...weiterlesen");
				} else {
					$(this).parent().find('.btxt').css({"height" : "auto"});
					$(this).html("Fertig");
				}
			});			
		}
	});
				
	$('.fancyme').fancybox();
	
	// Stimme
	
	var i = 0;
	while ($('#jquery_jplayer_' + i).length) {
		$('#jquery_jplayer_' + i).jPlayer({  
			ready: function () {  
		    	$(this).jPlayer("setMedia", {  
		        	mp3: $(this).attr('music'),  			        	    	 
		    	});  
		    },  
		    swfPath: "../lib/jplayer",
		    solution: "flash, html",  
	    	supplied: "mp3",
	    	cssSelectorAncestor: "#jp_container_" + i,
	    	play: function() {	    				    	
	    		$(this).jPlayer("pauseOthers");
	    		
	    		$(this).parent().find('.jp-background .cont').animate({ "top" : "0px" }, 500);
	    		$(this).parent().find('.jp-gui').animate( { "height" : "30px" }, 500, function() {
	    			$(this).find('.jp-progress').css({"display" : "block"});
	    		});
			},
			pause: function() {
				$(this).parent().find('.jp-progress').css({"display" : "none"});		
	    		$(this).parent().find('.jp-background .cont').animate({ "top" : "170px" }, 500);
	    		$(this).parent().find('.jp-gui').animate( { "height" : "0px" }, 500);
			} 
		});		
		i++;
	}
	
});

function changeImage(nextpid, addline) {
	if (!addline) {						
		maxheight = $('img#backimage').height();
		maxwidth = $('img#backimage').width();
		
		$('#backimagecontainer').css({"border-bottom" : "1px solid #910C0C" });
		$('#backimagecontainer').css({ "height" : maxheight });
		$('#imagebanner').css({ "height" : maxheight });						
	}
	
	if (nextpid == -1) {
		$('.dots').animate( {left : "-=30px"}, 600, 'swing', function() {
			$('.dots').css( {left : "+=30px"});	
		});
	} else if (nextpid == 1) {
		$('.dots').animate( {left : "+=30px"}, 600, 'swing', function() {
			$('.dots').css( {left : "-=30px"});	
		});
	} else if (nextpid == -2) {
		$('.dots').animate( {left : "-=60px"}, 600, 'swing', function() {
			$('.dots').css( {left : "+=60px"});	
		});
	} else if (nextpid == 2){
		$('.dots').animate( {left : "+=60px"}, 500, 'swing', function() {
			$('.dots').css( {left : "-=60px"});	
		});
	}
	
	$('#imagebanner').animate( { opacity : 0}, 300, 'swing', function() {
		AJAX('slider.php', { 
			'picid' : $('#backimage').attr('rel'),
			'nextpicid' : nextpid,
			'maxheight' : maxheight,
			'maxwidth' : maxwidth
			}, function(res) {								
				$('#imagebanner').html(res);				
				$('#imagebanner').animate( { opacity : 1}, 600 );
				$('.cms a.icon').bind('click', function() {
					clickIcon(this);
				}); 			
		});
	});
}