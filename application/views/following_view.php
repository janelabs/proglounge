<?php echo $header; ?>
<div class="container">
	<div class="row">
		<?php if (array_key_exists('is_new', $session) && $session['is_new'] && $is_your_profile) { ?>
		<div class="span12">
			<div class="alert alert-info">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<h2>Welcome <?php echo $user_info['username']; ?>!</h2>
			</div>
		</div>
		<?php } ?>
		
		<div class="row">
		    <div class="span4" style="margin-right:0px;">
		    	<!-- ABOUT ME AND DP SECTION -->
		    	<div class="thumbnail span3 pull-left profile-picture">
				   	<img src="http://placehold.it/500x400">
				   	<div class="caption">
				   		<h3>About Me</h3>
				   		<?php if ($user_info['about_me'] != '') { ?>
	      					<p><?php echo $user_info['about_me'] ?></p>
	      				<?php } else {?>
	      					<p>I will say something about me later..</p>
	      				<?php } ?>
				   	</div>
				</div>
				<!-- END ABOUT ME AND DP SECTION -->
				
				<?php if (!$is_guest && $is_your_profile) { ?>
				<!-- SUGGESTED USERS -->
				<div class="span3" style="margin-top:10px;">
					<i class="icon-user"></i> Suggested Users<br><br>
					<?php foreach ($suggested_users as $suggested_user) : ?>
						<div class="suggested-content">
							<div class="row">
								<div class="span1">
								<img src="http://placehold.it/60x60" class="thumbnail" height="60" width="60">
								</div>
								<div class="span2">
								<a href="<?php echo site_url($suggested_user['username']) ?>"
								   class="link" style="margin-top:10px; float:left;">
								   @<?php echo $suggested_user['username'] ?>
								</a>
								</div>
								<div class="span2">
								<button user-id="<?php echo $suggested_user['id'] ?>" class="followbtn btn btn-info" 
								        style="margin-top:7px;">
									<i class="icon-star icon-white"></i> Follow
								</button>
								</div>
							</div>
						</div>
						<hr style="margin-top: 7px; margin-bottom: 7px;">
					<?php endforeach; ?>
				</div>
				<?php } ?>
				<!-- END SUGGESTED USERS -->
			</div>
			
			<div class="span8" style="margin-left:0px;">
				<!-- PROFILE HEADER SECTION -->
		    	<div class="hero-unit profile-header">
		    		<h4>function </h4>
		    		<h1 style="margin-left:0px;"><?php echo $user_info['username']; ?>() </h1>
		    		<?php if ($user_info['quote'] != '') { ?>
		    			<p>{ <?php echo $user_info['quote'] ?> }</p>
		    		<?php } else { ?>
		    			<p>{ " Don't mess with the programmers... " }</p>
		    		<?php } ?>
		    	</div>
		    	<!-- END PROFILE HEADER SECTION -->
		    	 
		    	<!-- PROFILE NAV -->
		    	<?php echo $profile_nav ?>
		    	<!-- END PROFILE NAV -->
		    </div>
	    </div><!-- row -->
	</div><!-- row -->
</div><!-- container -->

<?php echo $footer; ?>