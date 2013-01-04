var Proglounge = {
    initView:function () {
        $('#login_btn').click(function (e) {
            alert("This is a sample view.");
            e.preventDefault();
        });

        /* REGISTRATION */

        var next = 1;
        var modalHeader1 = "1. Basic Information"
        var modalHeader2 = "2. Log in information"
        var modalHeader3 = "3. Profile"
        //register modal
        $('#register').click(function () {
            $('#registerModal').modal('show');
        });

        //next form
        $('#next').live("click", function () {
            if (next != 3) {
                var is_valid1 = Proglounge.validateInput(next);
                if (is_valid1) {
                    next++;
                    $('#' + (next - 1)).fadeOut(100, function () {
                        if ((next) == 2) {
                            $('#registerModalLabel').html(modalHeader2);
                        } else if (next == 3) {
                            $('#registerModalLabel').html(modalHeader3);
                            $('#next').html('Register');
                            $('#next').attr('id', 'btn-register');
                        }
                        $('#' + next).fadeIn("fast");
                    });
                }
            }
        });

        //previous form
        $('#back').live("click", function () {
            if (next != 1) {
                next--;
                $('#' + (next + 1)).fadeOut(100, function () {
                    if ((next) == 2) {
                        $('#registerModalLabel').html(modalHeader2);
                        console.log($('#btn-register').html());
                        $('#btn-register').html('Next');
                        $('#btn-register').attr('id', 'next');
                    } else if (next == 1) {
                        $('#registerModalLabel').html(modalHeader1);
                    }
                    $('#' + next).fadeIn("fast");
                });
            }
        });

        //register user ajax
        $('#btn-register').live("click", function(){
            $('#3').fadeOut('fast', function(){
                $('#4').fadeIn('fast');
                $('#registerModalLabel').html("This is a sample view.");
                $('#btn-register').remove();
                $('#back').remove();
                $('#close-reg-form').show('fast');
            })
        });

        $('#close-reg-form').live("click", function(){
            $('#registerModal').modal('hide');
        });

        /* END REGISTRATION */

        // back to top
        $('#top').click(function () {
            $('html, body').animate({scrollTop:0}, 'fast');
            return false;
        });
    },

    validateInput: function(id){
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
};