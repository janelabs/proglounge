<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Programmers Lounge</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/style.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/highlight.css'); ?>">
    <script type="text/javascript" src="<?php echo base_url('public/js/jquery.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('public/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('public/js/proglounge.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('public/js/highlight.js'); ?>"></script>
</head>
<body>
<div class="navbar navbar-static-top">
    <div class="navbar-inner">
        <div class="container">
            <a href="<?php echo site_url(); ?>" class="brand">{ Programmers Lounge }</a>
            <?php if (isset($session['id']) && isset($session['username'])) { ?>
            <div class="btn-group pull-right">
            <a href="<?php echo site_url() ?>" 
               class="btn btn-info">Home
            </a>
            <a href="<?php echo site_url($session['username']) ?>" 
               class="btn btn-info"><i class="icon-user"></i>   Profile
            </a>
			  <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
			    <i class="icon-chevron-down icon-white"></i>
			  </button>
			  <ul class="dropdown-menu">
				  <li><a href="#">Account Settings</a></li>
				  <li class="divider"></li>
				  <li><a href="<?php echo site_url('logout') ?>">Log out</a></li>
			  </ul>
            </div>
            <div class="btn-group pull-right" style="margin-right: 5px;">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    <span class="badge badge-important">6</span>
                    <span class="caret"></span>
                </a>
                <ul id="notif-center" class="dropdown-menu">
                    <li><a href="javascript:return false">Chorvs started following you.</a></li>
                </ul>
            </div>
            <?php } ?>
            
            <?php if (!isset($session['id']) || !isset($session['username'])) { ?>
            <div class="pull-right">
                <button id="register" class="btn btn-primary">Register</button>
	            <a href="<?php echo site_url('login'); ?>" class="btn btn-info">Log In</a>
            </div>
            <?php } ?>
        </div>
    </div>
</div>