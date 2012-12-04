$(document).ready(function() {
    
    //syntax highlighting
    $('pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});
    
	// back to top
	$('#top').click(function(){  
		$('html, body').animate({scrollTop:0}, 'fast');  
		return false;  
	});
	
	//follow ajax
	$('.followbtn').live("click", function(){
		var ajax_url = "/follow";
		$.post(ajax_url, {id:$(this).attr('user-id')});
		$(this).attr('class', 'unfollowbtn btn btn-danger');
		$(this).html('<i class="icon-off icon-white"></i> Unfollow');
	});
	
	//unfollow ajax
	$('.unfollowbtn').live("click", function(){
		var ajax_url = "/unfollow";
		$.post(ajax_url, {id:$(this).attr('user-id')});
		$(this).attr('class', 'followbtn btn btn-info');
		$(this).html('<i class="icon-star icon-white"></i> Follow');
	});
	
	//set active nav in profile navigation
	var active_menu = $('.nav').find($('a[href="'+window.location.href+'"]'));
	$(active_menu).parent('li').addClass('active');
	
	//share ajax
	$('#share').live("click", function(){
	    var ajax_url = "/new_post";
	    var post = $('#post').val();
	    
	    if (post == '') {
	        alert('blank');
	        return false;
	    }
	    
	    $('.progress').show('fast');
	    $.post(ajax_url, {content:post}, function(data){
	        $('.progress').hide('fast');
	        $('#post').val('');
	        var post_data = $.parseJSON(data);
	        var append_data = '<div class="post-contents" style="display:none;">'+
	                            '<div class="img-username">'+
	                              '<img src="http://placehold.it/35x35"/>'+
	                              '<a href="#" class="link">'+post_data.username+'</a><br>'+
	                              '<label>'+post_data.postdate+'</label>'+
	                            '</div>'+
	                            '<div class="post-message">'+
	                              '<label class="new">'+post_data.content+'</label>'+
	                            '</div>'+
	                          '</div>';
	                          
	        if (!post_data.is_error) {
	            $('.post-container').prepend(append_data);
	            $('.post-contents').fadeIn('slow');
	            $('.new pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});
	            $('.post-message label').removeClass('new');
	        }
	    });		
	});
	
});