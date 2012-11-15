<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Programmers Lounge</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/bootstrap.css'); ?>">
    <script type="text/javascript" src="<?php echo base_url('public/js/jquery.js'); ?>"></script>
</head>
<body>
<div class="navbar navbar-static-top">
    <div class="navbar-inner">
        <div class="container">
            <a href="#" class="brand"><strong>{ PL }</strong></a>
            <ul class="nav">
                <li class="active">
                    <a href="<?php echo site_url(); ?>">Home</a>
                </li>
                
                <?php if (isset($session['id']) && isset($session['username'])) { ?>
                <li><a href="<?php echo site_url($session['username']) ?>">Profile</a></li>
                <?php } ?>
                    
                <?php if (!isset($session['id']) || !isset($session['username'])) { ?>
                <li><a href="<?php echo site_url('register/'); ?>">Register</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>