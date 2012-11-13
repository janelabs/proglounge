<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Programmers Lounge</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/bootstrap.css'); ?>">
    <script type="text/javascript" src="<?php echo base_url('public/js/jquery.js'); ?>"></script>
</head>
<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a href="#" class="brand"><strong>{ PL }</strong></a>
            <ul class="nav">
                <li class="active">
                    <a href="<?php echo site_url(); ?>">Home</a>
                </li>
                <li><a href="<?php echo site_url('home/register'); ?>">Register</a></li>
                <li><a href="#">Link</a></li>
            </ul>
        </div>
    </div>
</div>