<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PL - Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/bootstrap.min.css'); ?>">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 400px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
	<script type="text/javascript" src="<?php echo base_url('public/js/jquery.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('public/js/bootstrap.min.js'); ?>"></script>
    <script>
		$(document).ready(function(){
			$('#btnlog').click(function(){
	    		$('#btnlog').button('loading');
	    	});
			
			$('#last_name').focus();
			$('#last_name').tooltip('show');

			$('.input-block-level').hover(function(){
			 	$(this).tooltip('show');
			});

			$('.input-block-level').focus(function(){
				$(this).tooltip('show');
			});

			$('.input-block-level').blur(function(){
			  	$(this).tooltip('hide');
			});
		});
    </script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body onload="document.getElementById('last_name').focus();">
    <div class="container">
      <form class="form-signin" method="post" action="<?php echo site_url('save_user') ?>">
        <h2 class="form-signin-heading">Registration</h2>
	        <?php if (!empty($register_error)) { ?>
	      	<div class="alert alert-error">
	      		<strong>Error: </strong><?php echo $register_error ?>
	      	</div>
	      	<?php } ?>
        <input type="text" id="last_name" name="last_name" class="input-block-level" value="<?php echo $user_input['last_name'] ?>" placeholder="Last Name"
        rel="tooltip" data-placement="right" data-original-title="Last Name">
        <input type="text" name="first_name" class="input-block-level" value="<?php echo $user_input['first_name'] ?>" placeholder="First Name"
        rel="tooltip" data-placement="right" data-original-title="First Name">
        <input type="text" name="nickname" class="input-block-level" value="<?php echo $user_input['nickname'] ?>" placeholder="Nickname"
        rel="tooltip" data-placement="right" data-original-title="Nickname">
        <input type="text" name="email_address" class="input-block-level" value="<?php echo $user_input['email_address'] ?>" placeholder="Email Address"
        rel="tooltip" data-placement="right" data-original-title="Email Address">
        <textarea name="quote" class="input-block-level" placeholder="Simple programming quote"
      	rel="tooltip" data-placement="right" data-original-title="Simple programming quote"><?php echo $user_input['bio'] ?></textarea>
      	<textarea name="about_me" class="input-block-level" placeholder="Tell something about yourself..."
      	rel="tooltip" data-placement="right" data-original-title="Tell something about yourself..."><?php echo $user_input['about_me'] ?></textarea>
        <input type="text" name="username" class="input-block-level" value="<?php echo $user_input['username'] ?>" placeholder="Username"
        rel="tooltip" data-placement="right" data-original-title="Username">
        <input type="password" name="password" class="input-block-level" placeholder="Password"
        rel="tooltip" data-placement="right" data-original-title="Password">
        <input type="password" name="repassword" class="input-block-level" placeholder="Retype Password"
        rel="tooltip" data-placement="right" data-original-title="Retype Password">
        <button type="submit" id="btnlog" class="btn btn-info" data-loading-text="Registering...">Register</button>
        <a href="<?php echo site_url(); ?>" class="btn btn-info">Cancel</a>
        
      </form>
    </div> <!-- /container -->
  </body>
</html>