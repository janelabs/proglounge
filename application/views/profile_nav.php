<?php $uname = $user_info['username']; ?>
<div class="navbar" style="margin-left:0px;">
	<div class="navbar-inner">
		<div class="profile_nav">
	   		<ul class="nav">
				<li><a href="<?php echo site_url($uname) ?>">Posts</a></li>
			    <li><a href="<?php echo site_url($uname.'/followers'); ?>">Followers
			         <span class="badge badge-info"><?php echo $follower_count ?></span>
			        </a></li>
			    <li><a href="<?php echo site_url($uname.'/following'); ?>">Following
			         <span class="badge badge-info"><?php echo $following_count ?></span>
			        </a></li>
			</ul>
			<?php if (!$is_your_profile && !$is_guest) { ?>
				<?php if (!$is_followed) { ?>
				<button user-id="<?php echo $user_id ?>" class="followbtn btn btn-info" 
				        style="float:right;">
						<i class="icon-star icon-white"></i> Follow
				</button>
				<?php } else { ?>
				<button user-id="<?php echo $user_id ?>" class="unfollowbtn btn btn-danger" 
				        style="float:right;">
						<i class="icon-off icon-white"></i> Unfollow
				</button>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>