<?php echo $header; ?>
<style>
.profile-buttons {
	height: 55px;
}
</style>
<div class="container">
	<div class="row">
		
		<div class="hero-unit">
			<h1><?php echo $user_info['username']; ?></h1>
			<p>" I am a programmer, I have no life :( "</p>
		</div>	
		
		<div class="span12">
			<div class="btn-group">
				<button class="btn btn-large btn-info span4 profile-buttons">
					Blogs <span class="badge badge-info">8</span>
				</button>
	  			<button class="btn btn-large btn-info span4 profile-buttons">
	  				Followers <span class="badge badge-info"><?php echo $user_follower_count ?></span>
	  			</button>
	  			<button class="btn btn-large btn-info span4 profile-buttons">
	  				Following <span class="badge badge-info"><?php echo $user_following_count ?></span>
	  			</button>
			</div>
		</div>
		
	</div>
</div>
<?php echo $footer; ?>