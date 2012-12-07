$(document).ready(function() {

/* -----------------------------------------------------------
 *  @MISC
 * -----------------------------------------------------------
 */

    //syntax highlighting
    $('blockquote pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});

	// back to top
	$('#top').click(function(){
		$('html, body').animate({scrollTop:0}, 'fast');
		return false;
	});

	//set active nav in profile navigation
    var active_menu = $('.nav').find($('a[href="'+window.location.href+'"]'));
    $(active_menu).parent('li').addClass('active');

    //delete modal
    var del_id = 0;
    var post_content_obj;
    $('.delete-modal').live("click", function(){
        del_id = $(this).attr('post-id');
        $('#delete-modal').modal({
            keyboard: true 
        });
        post_content_obj = $(this);
        $('#delete-modal').modal('show'); 
    });
    
    $('#del-modal-close').live("click",function(){
        $('#delete-modal').modal('hide');
        return false;
    });
    
    //limit post characters
    var characters = 1000;
    $("#counter").append("You have <strong>"+  characters+"</strong> characters remaining");
    $("#post").keyup(function(){
        if ($(this).val().length > characters) {
            $(this).val($(this).val().substr(0, characters));
        }
        
        var remaining = characters -  $(this).val().length;
        $("#counter").html("You have <strong>"+  remaining+"</strong> characters remaining");
        if (remaining <= 10) {
            $("#counter").css("color","red");
        } else {
            $("#counter").css("color","black");
        }
    });


/* -----------------------------------------------------------
 *  @END MISC
 * -----------------------------------------------------------
 */


/* -----------------------------------------------------------
 *  @JQUERY AJAX 
 * -----------------------------------------------------------
 */

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
	
	//delete post ajax
    $('#confirm-del').live("click", function(){
        var ajax_url = "delete_post";
        var remove_post_div = post_content_obj.parent().parent().parent('div.post-contents');
        console.log(remove_post_div);
        $.post(ajax_url, {post_id:del_id}, function(data){
            json_data = $.parseJSON(data);
            if (json_data.success) {
                remove_post_div.fadeOut('slow', function(){
                    remove_post_div.remove();
                });
                $('#delete-modal').modal('hide');
                return false;
            } else {
                alert('you mother father hacker!');
            }
        });
        return false;
    });
	
	//share ajax (profile)
	$('#share').live("click", function(){
        var ajax_url = "new_post";
        var post = $('#post').val();
        remaining = 1000;
        $("#counter").html("You have <strong>"+  remaining+"</strong> characters remaining");

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
                                '<blockquote class="new"><p>'+post_data.content+'</p></blockquote>'+
                                '<div class="pull-right">'+
                                  '<div class="btn-group">'+
                                  '<button post-id="'+post_data.post_id+'" class="delete-modal btn btn-danger btn-mini">'+
                                            '<i class="icon-trash icon-white"></i>'+
                                      '</button>'+
                                  '</div>'+
                                '</div>'+
                              '</div>';

            if (!post_data.is_error) {
                $('.post-container').prepend(append_data);
                $('.post-contents').fadeIn('slow');
                $('blockquote.new pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});
                var count_posts = $('.post-contents').length;
            }
        });
	});

    //load more post ajax
    $('#load-more').live("click", function(){
        $(this).html('loading...');
        var ajax_url = "load_more";
        var id = $(this).attr("last-id");
        $.post(ajax_url, {post_id:id}, function(data){
            json_data = $.parseJSON(data);
            if (json_data.success) {
                $('.post-container').append(json_data.html);
                $('.post-contents').fadeIn('slow');
                $('blockquote.new pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});
                $('#load-more').remove();
            }
        });
        return false;
    })
	
/* -----------------------------------------------------------
 *  @END JQUERY AJAX 
 * -----------------------------------------------------------
 */
	
});