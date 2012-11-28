$(document).ready(function() {

	// back to top
	$('#top').click(function(){  
		$('html, body').animate({scrollTop:0}, 'fast');  
		return false;  
	});
	
	//follow ajax
	$('.followbtn').live("click", function(){
		var ajax_url = "follow";
		$.post(ajax_url, {id:$(this).attr('user-id')});
		$(this).attr('class', 'unfollowbtn btn btn-danger');
		$(this).html('<i class="icon-off icon-white"></i> Unfollow');
	});
	
	//unfollow ajax
	$('.unfollowbtn').live("click", function(){
		var ajax_url = "unfollow";
		$.post(ajax_url, {id:$(this).attr('user-id')});
		$(this).attr('class', 'followbtn btn btn-info');
		$(this).html('<i class="icon-star icon-white"></i> Follow');
	});
	
	//set active nav in profile navigation
	var active_menu = $('.nav').find($('a[href="'+window.location.href+'"]'));
	$(active_menu).parent('li').addClass('active');
	
});