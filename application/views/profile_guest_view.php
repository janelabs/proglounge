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
	    	<div class="hero-unit" style="margin-bottom:0px;">
	    		<h1 style="margin-left:10px;"><?php echo $user_info['username']; ?></h1>
	    		<p>" I am a Programmer, I have no life... "</p>
	    	</div>
	    </div>
	</div>
	
	<div class="row">		
		<div class="span12" style="margin-left:41px;">
			<div class="btn-group">
				<button id="blogs"  style="padding-left:0px;" class="btn btn-large btn-info span4 profile-buttons">
					Blogs <span class="badge badge-info">8</span>
				</button>
		  		<button id="followers" class="btn btn-large btn-info span4 profile-buttons">
		  			Followers <span class="badge badge-info"><?php echo $user_follower_count ?></span>
		  		</button>
		  		<button id="following" class="btn btn-large btn-info span4 profile-buttons">
		  			Following <span class="badge badge-info"><?php echo $user_following_count ?></span>
		  		</button>
			</div>				
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