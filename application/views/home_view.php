<?php echo $header; ?>
<div class="hero-unit">
	<div class="container">
		<h1>Welcome!</h1>
	</div>
</div>
<div class="container">
	<div class="row">
		<!-- SIDE NAV -->
		<div class="span3">
			<ul class="nav nav-tabs nav-stacked">
				<li class="active"><a href="#">Link<i class="icon-chevron-right" style="float:right;"></i></a></li>
				<li><a href="#">Link<i class="icon-chevron-right" style="float:right;"></i></a></li>
				<li><a href="#">Link<i class="icon-chevron-right" style="float:right;"></i></a></li>
				<li><a href="#">Link<i class="icon-chevron-right" style="float:right;"></i></a></li>
				<li><a href="#">Link<i class="icon-chevron-right" style="float:right;"></i></a></li>
				<li><a href="#">Link<i class="icon-chevron-right" style="float:right;"></i></a></li>
			</ul>
		</div>
		<!-- END SIDE NAV -->
		
		<div class="span9">
			<table class="table table-bordered table-stripped table-hover">
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Username</th>
					<th>Follow</th>
				</tr>
				<?php if ($user_count > 0) { foreach($users as $user) {	?>
					<tr class="clickable" id="<?php echo $user['id']; ?>">
						<td><?php echo $user['id']; ?></td>
						<td><?php echo $user['last_name'] . ", " . $user['first_name']; ?></td>
						<td><?php echo $user['username']; ?></td>
						<td>
							<a class="btn" 
							   href="<?php echo site_url('home/follow/'.$user['id']); ?>">
							<i class="icon-star"></i> Follow</a>
						</td>
					</tr>
				<?php } } else { ?>
					<tr>
						<td colspan="4">Empty user records.</td>
					</tr>
				<?php } ?>
			</table>
		</div>
		<div class="span9">
			<table class="table table-bordered table-stripped table-hover">
				<tr>
					<th colspan="3">Followers: <?php echo $user_follower_count; ?></th>
				</tr>
				<tr>
					<th>Name</th>
					<th>Username</th>
				</tr>
				<?php if ($user_follower_count > 0) { foreach($user_follower as $user1) {	?>
					<tr class="clickable" id="<?php echo $user1['id']; ?>">
						<td><?php echo $user1['last_name'] . ", " . $user1['first_name']; ?></td>
						<td><?php echo $user1['username']; ?></td>
					</tr>
				<?php } } else { ?>
					<tr>
						<td colspan="3">Empty user records.</td>
					</tr>
				<?php } ?>
			</table>
		</div>
		<div class="span9 offset3">
			<table class="table table-bordered table-stripped table-hover">
				<tr>
					<th colspan="3">Following: <?php echo $user_following_count; ?></th>
				</tr>
				<tr>
					<th>Name</th>
					<th>Username</th>
					<th>Unfollow</th>
				</tr>
				<?php if ($user_following_count > 0) { foreach($user_following as $user2) {	?>
					<tr class="clickable" id="<?php echo $user2['id']; ?>">
						<td><?php echo $user2['last_name'] . ", " . $user2['first_name']; ?></td>
						<td><?php echo $user2['username']; ?></td>
						<td>
							<a class="btn btn-danger" 
							   href="<?php echo site_url('home/unfollow/'.$user2['id'], true); ?>">
							<i class="icon-star icon-white"></i> Unfollow</a>
						</td>
					</tr>
				<?php } } else { ?>
					<tr>
						<td colspan="3">Empty user records.</td>
					</tr>
				<?php } ?>
			</table>
		</div>
	</div>
</div>
<script>
$('.clickable').click(function() {
	var id = $(this).attr('id');
	//alert(id);
});
</script>
<?php echo $footer; ?>
