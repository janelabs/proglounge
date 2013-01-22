<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PL - Log in</title>
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
        max-width: 300px;
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
    <script type="text/javascript">
    $(document).ready(function() {
	    $('#btnlog').click(function(){
	    	$('#btnlog').button('loading');
	    });
	
	    $('#btnlog').click(function(){
	    	$('#btnlog').button('loading');
	    });
	    $('#username').focus();
	    $('#username').tooltip('show');
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

  <body>
    <div class="container">
      <form class="form-signin" method="post" action="<?php echo site_url('validate') ?>">
        <h2 class="form-signin-heading">Log in</h2>
	    <?php if (!empty($login_error)) { ?>
	    <div class="alert alert-error">
	    	<strong>Error: </strong><?php echo $login_error ?>
	    </div>
	    <?php } ?>
        <input type="text" id="username" name="username" class="input-block-level" placeholder="Username"
        rel="tooltip" data-placement="right" data-original-title="Username">
        <input type="password" id="password" name="password" class="input-block-level" placeholder="Password"
        rel="tooltip" data-placement="right" data-original-title="Password">
        <button type="submit" id="btnlog" class="btn btn-info" data-loading-text="Logging in...">Log In</button>
        <a href="<?php echo site_url(); ?>" class="btn btn-info">Cancel</a>
        <a href="<?php echo site_url('recover_password'); ?>">Recover Password</a>
      </form>
    </div> <!-- /container -->
  </body>
</html>