<?php echo $header ?>
<?php echo $modals ?>
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
				
				<!-- SUGGESTED USERS -->
				<?php if (!$is_guest && $is_your_profile && $suggested_users_count > 0) { ?>
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
		    	
		    	<!-- SHARE SECTION -->
		    	<?php if ($is_your_profile) { ?>
    		    	<div class="post-div well">
    		    	    <label id="counter"></label>
    					<textarea rows="3" class="input-block-level" id="post"></textarea>
    					<div class="progress progress-striped active" style="height:10px; display:none;">
      						<div class="bar" style="width:100%"></div>
    					</div>
    					<button class="btn btn-large btn-info btn-block" id="share">
    						<i class="icon-share icon-white"></i> Share your idea
    					</button>
    				</div>
				<?php } ?>
				<!-- END SHARE SECTION -->
				
				<!-- USER POSTS SECTION -->
				<div class="post-container">
                    <?php if ($user_posts_count > 0) { ?>
                        <?php foreach ($user_posts->result('Post_like_model') as $post) : ?>
                            <div class="post-contents">
                                <div class="img-username">
                                    <img class="p_dp" src="<?php echo base_url()."public/DP/".$post->image ?>"/>
                                    <a href="#" class="link"><?php echo $post->username ?></a><br>
                                    <label><?php echo filterPostDate($post->date_created) ?></label>
                                </div>
                                <blockquote>
                                    <p><?php echo filterPost($post->content) ?></p>
                                </blockquote>
                                <!-- Like and repost btn -->
                                <div class="pull-right">
                                    <div class="btn-group">
                                      <?php
                                        $like_count = $post->getLikersByPostId($post->id)->num_rows();
                                      ?>
                                        <button class="btn btn-small"><?php echo $like_count; ?> like/s.</button>
                                      <?php if (!$is_your_profile && !$is_guest) { ?>
                                          <?php $is_liked = $post->isLiked($session['id'], $post->id);
                                              if($is_liked) {
                                          ?>
                                              <button class="btn btn-primary btn-small unlikebtn" post-id="<?php echo $post->id ?>">
                                                  <i class="icon-thumbs-down icon-white"></i> Unlike
                                              </button>
                                          <?php } else { ?>
                                              <button class="btn btn-small likebtn" post-id="<?php echo $post->id ?>">
                                                  <i class="icon-thumbs-up"></i> Like
                                              </button>
                                          <?php } ?>
                                      <?php } elseif (!$is_guest && $is_your_profile) { ?>
                                      <button post-id="<?php echo $post->id ?>" class="delete-modal btn btn-danger btn-small">
                                           <i class="icon-trash icon-white"></i>
                                      </button>
                                      <?php } ?>
                                    </div>
                                </div>
                                <!-- end Like and btn -->
                            </div>
                        <?php endforeach; ?>

                        <?php if ($user_posts_count > 10) { ?>
                            <button class="btn btn-block btn-info" id="load-more" last-id="<?php echo $post->id ?>">
                                load more
                            </button>
                        <?php } ?>
                    <?php } ?>
                    <div id="no-post" style="display: none;" class="alert alert-info pagination-centered">
                        <strong>No current post</strong>
                    </div>
				</div>
				<!-- END USER POSTS SECTION -->
		    </div>
	    </div><!-- row -->
	</div><!-- row -->
</div><!-- container -->
<?php echo $footer; ?>