<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>PL - Change Password</title>
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

            .form-pwordRecover {
                max-width: 385px;
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
            .form-pwordRecover .form-pwordRecover-heading,
            .form-pwordRecover .checkbox {
                margin-bottom: 10px;
            }
            .form-pwordRecover input[type="text"],
            .form-pwordRecover input[type="password"] {
                font-size: 16px;
                height: auto;
                margin-bottom: 15px;
                padding: 7px 9px;
            }
        </style>

        <script type="text/javascript" src="<?php echo base_url('public/js/jquery.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('public/js/bootstrap.min.js'); ?>"></script>

        <script type="text/javascript">
            $(function(){
                $('#unmasked').css({'display' : 'none'});
                $('#chkShow').click(function(){
                    if($(this).attr('checked') == 'checked'){
                        $('#masked').css({'display' : 'none'});
                        $('#pword').val("");
                        $('#pword').val($('#password').val());
                        $('#unmasked').css({'display' : 'block'});
                    }
                    else{
                        $('#unmasked').css({'display' : 'none'});
                        $('#masked').css({'display' : 'block'});
                    }
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
            <form name="recover" class="form-pwordRecover" method="post" action="<?php echo site_url('changePassword') ?>">
                <h2 class="form-pwordRecover-heading">Change Password</h2>
                <?php $recover_error = $this->session->flashdata('change_error');
                    if (!empty($recover_error)) { ?>
                    <div class="alert alert-error">
                        <strong>Error: </strong><?php echo $recover_error ?>
                    </div>
                <?php } ?>

                <input type="hidden" id="uid" name="uid" readonly="readonly" value="<?php echo !empty($uid) ? $uid:''; ?>" />

                <div id="masked"><input type="password" id="password" name="password" class="input-block-level" placeholder="New Password" rel="tooltip" data-placement="right" data-original-title="New Password" /></div>

                <div id="unmasked"><input type="text" id="pword" name="pword" class="input-block-level" placeholder="New Password" rel="tooltip" data-placement="right" data-original-title="New Password" readonly="readonly" /></div>

                <input type="checkbox" class="" id="chkShow" />Show Password<br><br>

                <button type="submit" id="btnlog" class="btn btn-info" data-loading-text="Please wait...">Change Password</button>

                <a href="<?php echo site_url(); ?>" class="btn btn-info">Cancel</a>
            </form>
        </div> <!-- /container -->
    </body>
</html>