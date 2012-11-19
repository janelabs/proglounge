<?php echo $header; ?>
<style>
.profile-buttons {
	height: 55px;
}

.profile-picture {
	margin-top:20px;
	margin-right:20px;
	width:220px;
	height:176px;
}
</style>
<div class="container">
	<div class="row">
	    <div class="span12">
	    	<div class="thumbnail span3 pull-right profile-picture">
			   	<img src="http://placehold.it/500x400">
			</div>
	    	<div class="hero-unit" style="margin-bottom:0px; background-color:#fff;">
	    		<h4>function </h4>
	    		<h1 style="margin-left:10px;"><?php echo $user_info['username']; ?>() </h1>
	    		<?php if ($user_info['bio'] != '') { ?>
	    			<p>{ <?php echo $user_info['bio'] ?> }</p>
	    		<?php } else { ?>
	    			<p>{ " Don't mess with the programmers... " }</p>
	    		<?php } ?>
	    	</div>
	    </div>
	    <?php if (array_key_exists('is_new', $session) && $session['is_new'] && $is_your_profile) { ?>
		<div class="span12">
			<div class="alert alert-info">
				<h2>Welcome <?php echo $user_info['username']; ?>!</h2>
			</div>
		</div>
		<?php } ?>
	</div>
	
	<!-- PROFILE NAV -->
	<div class="row" style="margin-left:0px;">		
		<div class="navbar">
			<div class="navbar-inner">
				<ul class="nav">
		    		<li><a href="#" id="blogs">Blogs</a></li>
		      		<li><a href="#" id="followers">Followers : <?php echo $user_follower_count ?></a></li>
		      		<li><a href="#" id="following">Following : <?php echo $user_following_count ?></a></li>
		    	</ul>
		  	</div>
		</div>
	</div>
	<!-- END PROFILE NAV -->
	
	<div class="row">
		<div class="span8">
			<div id="blog-content">
				Blogs
			</div>
			
			<div id="followers-content" style="display: none;">
				Follower
			</div>
			
			<div id="following-content" style="display: none;">
				Following
			</div>
		</div>
		<div class="span4">
			Suggested Users
		</div>
	</div>
	
</div>
<script>
$('#blogs').click(function(){
	$('#followers-content').hide('fast');
	$('#blog-content').show('fast');
	$('#following-content').hide('fast');
});

$('#followers').click(function(){
	$('#followers-content').show('fast');
	$('#blog-content').hide('fast');
	$('#following-content').hide('fast');
});

$('#following').click(function(){
	$('#followers-content').hide('fast');
	$('#blog-content').hide('fast');
	$('#following-content').show('fast');
});
</script>
<?php echo $footer; ?>