//fade in image after loading
function fadeInImg(obj){
    $(obj).attr('style', 'display:none;');
    $(obj).fadeIn('fast');
}

$(document).ready(function() {

/* -----------------------------------------------------------
 *  @MISC
 * -----------------------------------------------------------
 */
    //sets fade in to all image
    //$('img').attr('onload', 'fadeInImg(this);');

    //close reg-form
    $('#close-reg-form').live("click", function(){
        $('#registerModal').modal('hide');
    });

    /* profile pic upload */

    $('#choose-pic').click(function(){
        $('#upfile').click();
        return false;
    });

    $('#upfile').change(function(){
        var filename = $(this).val().replace("C:\\fakepath\\", "");
        if (filename == '') {
            $('#choose-pic').html("Change");
            $('#btn-upload').attr("disabled", "disabled");
            $('#btn-upload').addClass("disabled");
        } else {
            $('#choose-pic').html(filename);
            $('#btn-upload').removeAttr("disabled");
            $('#btn-upload').removeClass("disabled");
        }
    });

    /* end profile pic upload */



    //check if no current user post
    if ($('.post-contents').size() <= 0) {
        $('#no-post').fadeIn('fast');
    }

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

    //delete post confirmation modal
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

    /* REGISTRATION */

        var next = 1;
        var modalHeader1 = "1. Basic Information"
        var modalHeader2 = "2. Log in information"
        var modalHeader3 = "3. Profile"
        //register modal
        $('#register').click(function(){
            $('#registerModal').modal('show');
        });

        //next form
        $('#next').live("click", function(){
            if (next != 3) {
                var is_valid1 = validateInput(next);
                if (is_valid1) {
                    next++;
                    $('#'+(next - 1)).fadeOut(100, function(){
                        if ((next) == 2) {
                            $('#registerModalLabel').html(modalHeader2);
                        } else if (next == 3) {
                            $('#registerModalLabel').html(modalHeader3);
                            $('#next').html('Register');
                            $('#next').attr('id', 'btn-register');
                        }
                        $('#'+next).fadeIn("fast");
                    });
                }
            }
        });

        //previous form
        $('#back').live("click", function(){
            if (next != 1) {
                next--;
                $('#'+(next + 1)).fadeOut(100, function(){
                    if ((next) == 2) {
                        $('#registerModalLabel').html(modalHeader2);
                        $('#btn-register').html('Next');
                        $('#btn-register').attr('id', 'next');
                    } else if (next == 1) {
                        $('#registerModalLabel').html(modalHeader1);
                    }
                    $('#'+next).fadeIn("fast");
                });
            }
        });


        var is_existing_uname;

        $('#username').keyup(function(){
            checkUsername($(this).val());
        });

        function checkUsername(user_name)
        {
            $.post("check_uname", {username:user_name}, function(json){
                var data = $.parseJSON(json);
                if (!data.is_error) {
                    if (data.is_existing) {
                        $('#div-uname').addClass('error');
                        $('#div-uname span').html('username already exist');
                        is_existing_uname = true;
                    } else {
                        $('#div-uname').removeClass('error');
                        $('#div-uname span').html('');
                        is_existing_uname = false;
                    }
                } else {
                    alert("A problem occured!");
                }
            });
        }

        //input validation for registration
        function validateInput(id)
        {
            var fname    = $('#first_name').val();
            var lname    = $('#last_name').val();
            var nickname = $('#nickname').val();
            var email    = $('#email_address').val();
            var uname    = $('#username').val();
            var pass     = $('#password').val();
            var repass   = $('#repassword').val();
            var errcount = 0;

            if (id == 1) {
                if (fname == "") {
                    $('#div-fname').addClass('error');
                    $('#div-fname span').html('required field');
                    errcount++;
                } else {
                    $('#div-fname').removeClass('error');
                    $('#div-fname span').html('');
                }

                if (lname == "") {
                    $('#div-lname').addClass('error');
                    $('#div-lname span').html('required field');
                    errcount++;
                } else {
                    $('#div-lname').removeClass('error');
                    $('#div-lname span').html('');
                }

                if (nickname == "") {
                    $('#div-nickname').addClass('error');
                    $('#div-nickname span').html('required field');
                    errcount++;
                } else {
                    $('#div-nickname').removeClass('error');
                    $('#div-nickname span').html('');
                }

                if (email == "") {
                    $('#div-email').addClass('error');
                    $('#div-email span').html('required field');
                    errcount++;
                } else {
                    $('#div-email').removeClass('error');
                    $('#div-email span').html('');
                }

                if (errcount > 0) {
                    return false;
                }

                return true;
            }

            if (id==2) {
                if (uname == "") {
                    $('#div-uname').addClass('error');
                    $('#div-uname span').html('required field');
                    errcount++;
                } else if (is_existing_uname) {
                    $('#div-uname').addClass('error');
                    $('#div-uname span').html('username already exist');
                    errcount++;
                } else {
                    $('#div-uname').removeClass('error');
                    $('#div-uname span').html('');
                    is_existing_uname = false;
                }

                if (pass == "") {
                    $('#div-pass').addClass('error');
                    $('#div-pass span').html('required field');
                    errcount++;
                } else {
                    $('#div-pass').removeClass('error');
                    $('#div-pass span').html('');
                }

                if (repass == "") {
                    $('#div-repass').addClass('error');
                    $('#div-repass span').html('required field');
                    errcount++;
                } else if (pass != repass) {
                    $('#div-repass').addClass('error');
                    $('#div-pass').addClass('error');
                    $('#div-repass span').html('password did not match');
                    $('#div-pass span').html('password did not match');
                    errcount++;
                } else {
                    $('#div-pass').removeClass('error');
                    $('#div-pass span').html('');
                    $('#div-repass').removeClass('error');
                    $('#div-repass span').html('');
                }

                if (errcount > 0) {
                    return false;
                }

                return true;
            }
        }

    /* END REGISTRATION */
    
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
 *  @EDITING PROFILE
 * -----------------------------------------------------------
 */
    //for editing about me
    $('.p_to_text').live("click", function(){
        curr_about = $(this).html();
        text_input = '<textarea id="about_me" name="about_me" class="input-block-level" rows="3" maxlength="300">'+curr_about+'</textarea>';
        $(this).replaceWith(text_input);

        //focus cursor in the end of the value
        input_text = $('#about_me');
        input_text.focus();
        tmp_str = input_text.val();
        input_text.val('');
        input_text.val(tmp_str);

        input_text.keypress(function(e){
            if (e.which == 13 && !e.shiftKey) {
                input_text.addClass('disabled');
                input_text.attr('disabled', 'disabled');
                back_to_p = '<p class="p_to_text">'+input_text.val()+'</p>';

                $.post('/update', {about_me:input_text.val()}, function(){
                    input_text.replaceWith(back_to_p);
                });
            }
        });
    });

    //for editing quote
    $('.p_to_text_q').live("click", function(){
        curr_about = $(this).html();
        text_input = '<textarea id="quote" name="quote" class="input-block-level" rows="3" maxlength="60">'+curr_about+'</textarea>';
        $(this).replaceWith(text_input);

        //focus cursor in the end of the value
        input_text = $('#quote');
        input_text.focus();
        tmp_str = input_text.val();
        input_text.val('');
        input_text.val(tmp_str);

        input_text.keypress(function(e){
            if (e.which == 13 && !e.shiftKey) {
                input_text.addClass('disabled');
                input_text.attr('disabled', 'disabled');
                back_to_p = '<span class="p_to_text_q">'+input_text.val()+'</span>';

                $.post('/update', {quote:input_text.val()}, function(){
                    input_text.replaceWith(back_to_p);
                });
            }
        });
    });

/* -----------------------------------------------------------
 *  @END EDITING PROFILE
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

    //like post ajax
    $('.likebtn').live("click", function(){
        var ajax_url = "/like";
        $.post(ajax_url, {post_id:$(this).attr('post-id')});
        $(this).attr('class', 'unlikebtn btn btn-small btn-primary');
        $(this).html('<i class="icon-thumbs-down icon-white"></i> Unlike');
    });

    //like post ajax
    $('.unlikebtn').live("click", function(){
        var ajax_url = "/unlike";
        $.post(ajax_url, {post_id:$(this).attr('post-id')});
        $(this).attr('class', 'likebtn btn-small btn');
        $(this).html('<i class="icon-thumbs-up"></i> Like');
    });
	
	//delete post ajax
    $('#confirm-del').live("click", function(){
        var ajax_url = "delete_post";
        var remove_post_div = post_content_obj.parent().parent().parent('div.post-contents');
        $('#delete-modal').modal('hide');
        $.post(ajax_url, {post_id:del_id}, function(data){
            json_data = $.parseJSON(data);
            if (json_data.success) {
                remove_post_div.fadeOut('slow', function(){
                    remove_post_div.remove();
                    console.log($('.post-contents').size());
                    if ($('.post-contents').size() < 1) {
                        $('#no-post').fadeIn('fast');
                    }
                });
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
            alert("you can't share nothing :|");
            return false;
        }

        $('.progress').show('fast');
        $.post(ajax_url, {content:post}, function(data){
            $('.progress').hide('fast');
            $('#post').val('');
            var post_data = $.parseJSON(data);
            var append_data = '<div class="post-contents" style="display:none;">'+
                                '<div class="img-username">'+
                                  '<img src="'+post_data.user_image+'"/>'+
                                  '<a href="#" class="link">'+post_data.username+'</a><br>'+
                                  '<label>'+post_data.postdate+'</label>'+
                                '</div>'+
                                '<blockquote class="new"><p>'+post_data.content+'</p></blockquote>'+
                                '<div class="pull-right">'+
                                  '<div class="btn-group">'+
                                  '<button class="btn btn-small">0 like/s.</button>'+
                                  '<button post-id="'+post_data.post_id+'" class="delete-modal btn btn-small">'+
                                      '&times;'+
                                  '</button>'+
                                '</div>'+
                                '</div>'+
                                '<div class="comment-box'+post_data.post_id+'">'+
                                '</div>'+
                                '<div class="comment-txtbox">'+
                                    '<input id="'+post_data.post_id+'" type="text" class="input-block-level comment-txt" placeholder="write a comment...">'+
                                '</div>'+
                              '</div>';

            if (!post_data.is_error) {
                $('.post-container').prepend(append_data);
                $('.post-contents').fadeIn('slow');
                $('blockquote.new pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});
                $('blockquote.new').removeClass('new');
                $('#no-post').hide();
                if ($('.post-contents').size() > 10) {
                    $('.post-contents').each(function(i){
                        if (i == 10) {
                            $(this).fadeOut('slow');
                            $(this).remove();
                        }
                    });
                }
            }
        });
	});

    //share ajax (home)
    $('#share_home').live("click", function(){
        var ajax_url = "new_post";
        var post = $('#post').val();
        remaining = 1000;
        $("#counter").html("You have <strong>"+  remaining+"</strong> characters remaining");

        if (post == '') {
            alert("you can't share nothing :|");
            return false;
        }

        $('.progress').show('fast');
        $.post(ajax_url, {content:post}, function(data){
            $('.progress').hide('fast');
            $('#post').val('');
            var post_data = $.parseJSON(data);
            var append_data = '<div class="post-contents" style="width: 700px; display:none;">'+
                                '<div class="img-username">'+
                                    '<img src="'+post_data.user_image+'"/>'+
                                    '<a href="#" class="link">'+post_data.username+'</a><br>'+
                                    '<label>'+post_data.postdate+'</label>'+
                                '</div>'+
                                '<blockquote class="new" style="width: 700px;"><p>'+post_data.content+'</p></blockquote>'+
                                '<div class="pull-right">'+
                                    '<div class="btn-group">'+
                                    '<button class="btn btn-small">0 like/s.</button>'+
                                    '<button post-id="'+post_data.post_id+'" class="delete-modal btn btn-small">'+
                                    '&times;'+
                                    '</button>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="comment-box'+post_data.post_id+'">'+
                                '</div>'+
                                '<div class="comment-txtbox">'+
                                    '<input id="'+post_data.post_id+'" type="text" class="input-block-level comment-txt" placeholder="write a comment...">'+
                                '</div>'+
                              '</div>';

            if (!post_data.is_error) {
                $('.post-container').prepend(append_data);
                $('.post-contents').fadeIn('slow');
                $('blockquote.new pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});
                $('blockquote.new').removeClass('new');
                $('#no-post').hide();
                if ($('.post-contents').size() > 10) {
                    $('.post-contents').each(function(i){
                        if (i == 10) {
                            $(this).fadeOut('slow');
                            $(this).remove();
                        }
                    });
                }
            }
        });
    });

    //load more post ajax (profile)
    $('#load-more').live("click", function(){
        $(this).html('loading...');
        $(this).addClass('disabled');
        $(this).attr('disabled', 'disabled');
        var ajax_url = window.location.pathname.split( '/' )[1]+"/load_more";
        var id = $(this).attr("last-id");
        $.post(ajax_url, {post_id:id}, function(data){
            json_data = $.parseJSON(data);
            if (json_data.success) {
                $('.post-container').append(json_data.html);
                $('.post-contents').fadeIn('slow');
                $('blockquote.loadmore pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});
                $('blockquote.loadmore').removeClass('loadmore');
                $('#load-more').remove();
            }
        });
        return false;
    });

    //load more post ajax (news feed)
    $('#load-more-feed').live("click", function(){
        $(this).html('loading...');
        $(this).addClass('disabled');
        $(this).attr('disabled', 'disabled');
        var ajax_url = "load_more_feed";
        var id = $(this).attr("last-id");
        $.post(ajax_url, {post_id:id}, function(data){
            json_data = $.parseJSON(data);
            if (json_data.success) {
                $('.post-container').append(json_data.html);
                $('.post-contents').fadeIn('slow');
                $('blockquote.loadmore pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});
                $('blockquote.loadmore').removeClass('loadmore');
                $('#load-more-feed').remove();
            }
        });
        return false;
    });

    //register user ajax
    $('#btn-register').live("click", function(){
        var form_data = $('#reg-form').serialize();
        $.post("save_user", form_data, function(data){
            json_data = $.parseJSON(data);
            if (json_data.is_error) {
                alert('A problem encountered by the server. Please try again later.');
            } else {
                $('#3').fadeOut('fast', function(){
                    $('#4').fadeIn('fast');
                    $('#registerModalLabel').html("Registration Complete");
                    $('#btn-register').remove();
                    $('#back').remove();
                    $('#close-reg-form').show('fast');
                })
            }
        });
    });

    //notification ajax
    $('.show-notif').live("click", function(){
        var notif_count = $('.notif-count').html();
        var this_btn = $(this);
        $.post("/show_notif", {notif_id:$(this).attr('id')}, function(data){
            json_data = $.parseJSON(data);
            if (!json_data.is_valid) {
                alert(json_data.error_msg);
            } else {
                if (json_data.notif_info.type == 1) {
                    window.location.replace("/"+json_data.the_follower);
                }

                if (json_data.notif_info.type == 2 || json_data.notif_info.type == 3) {
                    //clear first
                    $('#notif-header').html('');
                    $('.modal-body').html('');

                    $('.modal-body').append('<p id="notif-info" style="color: black;"><blockquote>'+json_data.post_info.content+'</blockquote></p>');
                    $('#notif-header').html(json_data.notif_info.message);

                    //get comments
                    $.each(json_data.comments, function(i){
                        $('.modal-body').append('<blockquote>' +
                                                    '<p style="font-size: 13px;">' +
                                                        '<img class="thumbnails n_dp" src="/public/DP/'+json_data.comments[i].image+'">' +
                                                        ' <b>'+json_data.comments[i].username+'</b><br> ' +
                                                         json_data.comments[i].content +
                                                    '</p>' +
                                                '</blockquote>');
                    });

                    $('#notif-info blockquote pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});
                    $('.modal-body blockquote pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});
                    $('#notif-modal').modal('show', {
                        keyboard: true
                    });
                }

                if (json_data.notif_info.status == 1) {
                    $('.notif-count').html(notif_count - 1);
                    if ($('.notif-count').html() == 0) {
                        $('.notif-count').hide();
                    }

                    if (this_btn.attr('data-from') == 'page') {
                        this_btn.removeClass('btn-primary');
                    }
                }

                console.log(this_btn.attr('data-from'))

                if (this_btn.attr('data-from') == 'header') {
                    this_btn.parent().attr('style', '');
                    this_btn.attr('style', '');
                }
            }
        });
        return false;
    });

    //adding comment
    $('.comment-txt').live("keypress", function(e){
        if (e.which == 13 && !e.shiftKey) {
            if ($(this).val() == '') {
                alert('nothing to say? :(');
                return false;
            }
            comment_box = $(this);
            comment_box.addClass('disabled');
            comment_box.attr('disabled', 'disabled');
            $.post('/new_comment', {post_id:comment_box.attr('id'), content:comment_box.val()}, function(data){
                var comment = $.parseJSON(data);
                var append = '<div class="span7 comment_sec" style="display: none;">'+
                                 '<div class="img-username-comment">'+
                                     '<img src="'+comment.user_image+'"/>'+
                                     '<a href="#" class="link">'+comment.username+'</a><br>'+
                                     '<label>'+comment.commentdate+'</label>'+
                                 '</div>'+
                                 '<blockquote class="newcomment">'+
                                     '<p style="font-size: 13px;">'+comment.content+'</p>'+
                                 '</blockquote>'+
                             '</div>';

                $('.comment-box'+comment_box.attr('id')).append(append);
                $('.comment_sec').fadeIn('fast');
                $('.comment_sec blockquote.newcomment pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});
                comment_box.removeClass('disabled');
                comment_box.removeAttr('disabled');
                $('.comment-txt').val('');
            });
        }
    });

    //show more comment ajax (news feed)
    $('.show-more-comments').live("click", function(){
        this_btn = $(this);
        this_btn.html('loading...');
        this_btn.addClass('disabled');
        this_btn.attr('disabled', 'disabled');
        ajax_url = "show_more_comment";
        id = $(this).attr("last-id");
        post_id = $(this).parent().parent().children('.comment-txtbox').children('input').attr('id');

        $.post(ajax_url, {post_id:post_id, comment_id:id}, function(data){
            json_data = $.parseJSON(data);
            if (json_data.success) {
                this_btn.remove();
                $('.comment-box'+post_id).prepend(json_data.html);
                $('.comment_sec').fadeIn('slow');
                $('blockquote.new-comment pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});
                $('blockquote.new-comment').removeClass('loadmore');
            }
        });
        return false;
    });
	
/* -----------------------------------------------------------
 *  @END JQUERY AJAX 
 * -----------------------------------------------------------
 */
	
});