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
		    	
		    	<!-- FOLLOWING USERS -->
		    	<div class="span8" style="margin-left:0px;">
		    		<div class="row" style="margin-bottom:5px;">
		    			<ul class="thumbnails" style="margin-left:0px;">
		    			<?php foreach ($user_follower->result('Follow_model') as $user_follow): ?>
							<li class="span2">
								<div class="thumbnail">
									<img src="http://placehold.it/170x170" alt="">
									<p></p>
									<p class="pagination-centered">
										<a href="<?php echo site_url($user_follow->username) ?>" 
										class="link">@<?php echo $user_follow->username ?></a>
									</p>
									<p class="pagination-centered">
									<?php if ($is_your_profile || !$is_guest) { ?>
    									<?php if ($user_follow->isFollowed($session['id'], $user_follow->id)) { ?>
    										<button user-id="<?php echo $user_follow->id ?>" 
    										class="unfollowbtn btn btn-danger">
    											<i class="icon-off icon-white"></i> Unfollow
    										</button>
    									<?php } else { ?>
    										<button user-id="<?php echo $user_follow->id ?>" 
    										class="followbtn btn btn-info">
    											<i class="icon-star icon-white"></i> Follow
    										</button>
    									<?php } ?>
									<?php } ?>
									</p>
								</div>
							</li>	
						<?php endforeach; ?>
						</ul>
					</div>
		    	</div>
		    	<!-- END FOLLOWING USERS -->
		    </div>
	    </div><!-- row -->
	</div><!-- row -->
</div><!-- container -->

<?php echo $footer; ?>