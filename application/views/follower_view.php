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
                <?php echo $profile_pic; ?>
				<!-- END ABOUT ME AND DP SECTION -->
			</div>
			
			<div class="span8" style="margin-left:0px;">
                <!-- PROFILE HEADER SECTION -->
                <?php echo $profile_header ?>
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
                                    <?php
                                        $dp = base_url()."public/DP/".$user_follow->image;
                                    ?>
									<img class="f_dp" src="<?php echo $dp ?>" alt="">
									<p></p>
									<p class="pagination-centered">
										<a href="<?php echo site_url($user_follow->username) ?>" 
										class="link">@<?php echo $user_follow->username ?></a>
									</p>
									<p class="pagination-centered">
									<?php if ($is_your_profile || (!$is_guest && $user_follow->id != $session['id'])) { ?>
                                    <?php $is_followed_this = $user_follow->isFollowed($session['id'], $user_follow->id) ?>
    									<?php if ($is_followed_this) { ?>
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