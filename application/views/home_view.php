<?php echo $header; ?>
<?php echo $modals; ?>
<br>
<div class="container">
	<div class="row">
		<div class="span3">
			<ul class="nav nav-tabs nav-stacked">
				<li><a href="#news">News Feed<i class="pull-right icon-chevron-right"></i></a></li>
				<li><a href="#followers">Blog<i class="pull-right icon-chevron-right"></i></a></li>
			</ul>

            <!-- SUGGESTED USERS -->
            <?php if ($suggested_users_count > 0) { ?>
                <i class="icon-user"></i> Suggested Users<br><br>
                <?php foreach ($suggested_users as $suggested_user) : ?>
                <div class="suggested-content">
                    <div class="row">
                        <div class="span1">
                            <img src="<?php echo base_url()."public/DP/".$suggested_user['image_thumb'] ?>" class="thumbnail su_dp">
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
            <?php } ?>
            <!-- END SUGGESTED USERS -->
		</div>

		<div class="span9">
            <!-- share -->
            <div class="post-div well">
                <label id="counter"></label>
                <textarea rows="3" class="input-block-level" id="post"></textarea>
                <div class="progress progress-striped active" style="height:10px; display:none;">
                    <div class="bar" style="width:100%"></div>
                </div>
                <button class="btn btn-large btn-info btn-block" id="share_home">
                    <i class="icon-share icon-white"></i> Share your idea
                </button>
            </div>
            <!-- end share -->

            <!-- posts -->
            <div class="post-container">
                <?php foreach ($news_feed->result('Post_model') as $post) : ?>
                <div class="post-contents" style="width: 700px;">
                    <div class="img-username">
                        <img class="p_dp" src="<?php echo base_url()."public/DP/".$post->image_thumb ?>"/>
                        <a href="<?php echo site_url($post->username) ?>" class="link"><?php echo $post->username ?></a><br>
                        <label><?php echo filterPostDate($post->date_created) ?></label>
                    </div>
                    <blockquote style="width: 700px;">
                        <p><?php echo filterPost($post->content) ?></p>
                    </blockquote>

                    <!-- Like and Comment -->
                    <div class="pull-right">
                        <div class="btn-group">
                            <?php
                            $like_count = $post->getLikersByPostId($post->id)->num_rows();
                            ?>
                            <button class="btn btn-small"><?php echo $like_count; ?> like/s.</button>
                            <?php if ($is_logged_in && ($session['id'] == $post->user_id)) { ?>
                            <button post-id="<?php echo $post->id ?>" class="delete-modal btn btn-small">
                                &times;
                            </button>
                            <?php } else { ?>
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
                            <?php } ?>
                        </div>
                    </div>

                    <!-- comment section -->
                    <?php
                    $comments_count = $post->getCommentsCountByPostId($post->id);
                    $offset = getOffset($comments_count);
                    $comments = $post->getCommentsByPostId($post->id, $offset.", 3");
                    ?>
                    <div class="comment-box<?php echo $post->id ?>">
                        <?php if ($comments_count > 3) { ?>
                        <?php $last_id = $comments->first_row()->id; ?>
                        <button class="btn btn-link pull-left show-more-comments" last-id="<?php echo $last_id ?>">
                            Show previous comments
                        </button>
                        <?php } ?>
                        <?php
                        if ($comments_count > 0) { ?>
                            <?php foreach ($comments->result_array() as $comment) { ?>
                                <div class="span7 comment_sec" style="width:680px;">
                                    <div class="img-username-comment">
                                        <img src="<?php echo base_url()."public/DP/".$comment['image_thumb']; ?>"/>
                                        <a href="<?php echo site_url($comment['username']) ?>" class="link"><?php echo $comment['username'] ?></a><br>
                                        <label><?php echo filterPostDate($comment['date_created']) ?></label>
                                    </div>
                                    <blockquote>
                                        <p style="font-size: 13px;"><?php echo filterPost($comment['content']) ?></p>
                                    </blockquote>
                                </div>
                                <?php }} ?>
                    </div>
                    <div class="comment-txtbox pagination-centered">
                        <?php if($is_logged_in) { ?>
                        <input id="<?php echo $post->id ?>" type="text" class="input-block-level comment-txt" placeholder="write a comment...">
                        <?php } else { ?>
                        <input type="hidden" id="<?php echo $post->id ?>">
                        <?php } ?>
                    </div>
                    <!-- end comment section -->

                    <!-- end Like and Comment -->
                </div>
                <?php endforeach; ?>

                <?php if ($news_feed_count > 10) { ?>
                <button style="width: 700px;" class="btn btn-block btn-info" id="load-more-feed" last-id="<?php echo $post->id ?>">
                    load more
                </button>
                <?php } ?>
                <div id="no-post" style="display: none; width: 650px;" class="alert alert-info pagination-centered">
                    <strong>No current post</strong>
                </div>
            </div>
		</div>
		<!-- end posts -->
	</div>
</div>

<?php echo $footer; ?>
