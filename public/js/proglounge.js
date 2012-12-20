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
                        console.log($('#btn-register').html());
                        $('#btn-register').html('Next');
                        $('#btn-register').attr('id', 'next');
                    } else if (next == 1) {
                        $('#registerModalLabel').html(modalHeader1);
                    }
                    $('#'+next).fadeIn("fast");
                });
            }
        })


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
                $('blockquote.new').removeClass('new');
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
        var ajax_url = window.location.pathname.split( '/' )[1]+"/load_more";
        var id = $(this).attr("last-id");
        $.post(ajax_url, {post_id:id}, function(data){
            json_data = $.parseJSON(data);
            console.log(json_data);
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

    $('#close-reg-form').live("click", function(){
        $('#registerModal').modal('hide');
    });
	
/* -----------------------------------------------------------
 *  @END JQUERY AJAX 
 * -----------------------------------------------------------
 */
	
});