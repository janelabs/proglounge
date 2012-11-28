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
		    	<div class="navbar" style="margin-left:0px;">
		    		<div class="navbar-inner">
			    		<ul class="nav">
							<li class="active"><a href="#">Home</a></li>
						    <li><a href="#">Link</a></li>
						    <li><a href="#">Link</a></li>
	    				</ul>
		    		</div>
		    	</div>
		    	<!-- END PROFILE NAV -->
		    </div>
		   
	    
	    </div>
	</div>
	
</div>

<?php echo $footer; ?>