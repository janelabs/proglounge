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
    <script type="text/javascript" src="<?php echo base_url('public/js/timeago.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('public/js/highlight.js'); ?>"></script>
</head>
<script>
    $(document).ready(function() {
        jQuery("abbr.timeago").timeago();
    });
</script>
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

            <!-- show notif modal -->
            <div id="notif-modal" class="modal hide fade">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 style="color: black;" id="notif-header"></h4>
                </div>
                <div class="modal-body">
                    <p id="notif-info" style="color: black;"></p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-info" data-dismiss="modal" aria-hidden="true">Close</a>
                </div>
            </div>
            <!-- end notif modal -->

            <div class="btn-group pull-right" style="margin-right: 5px;">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="icon-bell"></i>
                    <?php if ($new_notif_count > 0) { ?>
                        <span class="badge badge-important notif-count"><?php echo $new_notif_count ?></span>
                    <?php } ?>
                    <span class="caret"></span>
                </a>
                <ul id="notif-center" class="dropdown-menu" style="padding-bottom: 0px;">
                    <?php if (count($notif_center) > 0) { ?>
                        <?php foreach ($notif_center as $notif) : if ($notif['status'] == 1) { ?>
                            <li style="background-color: #149bdf;">
                                <a href="#" data-from="header" style="color: white;" id="<?php echo $notif['id']?>" class="show-notif">
                                    <?php echo $notif['message'] ?>
                                </a>
                            </li>
                         <?php } else { ?>
                            <li>
                                <a href="#" data-from="header" id="<?php echo $notif['id']?>" class="show-notif">
                                    <?php echo $notif['message'] ?>
                                </a>
                            </li>
                        <?php } ?>
                            <li class="divider"></li>
                        <?php endforeach; ?>
                        <a href="<?php echo site_url($session['username']."/notifications") ?>" class="btn" style="margin-top: -12px;">See all notification</a>
                    <?php } else { ?>
                        <li><a href="#" onclick="return false;">No new notification</a></li>
                    <?php } ?>
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