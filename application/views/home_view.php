<?php echo $header; ?>

<div class="container">
	<?php echo $carousel ?>
	<div class="row">
		<div class="span3">
			<ul class="nav nav-tabs nav-stacked">
				<li><a href="#news">News Feed<i class="pull-right icon-chevron-right"></i></a></li>
				<li><a href="#followers">Followers Feed<i class="pull-right icon-chevron-right"></i></a></li>
				<li><a href="#following">Following Feed<i class="pull-right icon-chevron-right"></i></a></li>
			</ul>
		</div>
		<!-- share -->
		<div class="span9">
			<div class="post-div well">
				<textarea rows="3" class="input-block-level	"></textarea>
				<button id="share" class="btn btn-large btn-info btn-block">
					<i class="icon-share icon-white"></i> Share your idea
				</button>
			</div>
		</div>
		<!-- end share -->
		<!-- posts -->
		<div class="span9 offset3">
			<img src="http://placehold.it/70x70" class="thumbnail"/>
		</div>
		<!-- end posts -->
	</div>
</div>

<?php echo $footer; ?>
