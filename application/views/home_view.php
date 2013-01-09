<?php echo $header; ?>
<br>
<div class="container">
	<div class="row">
		<div class="span3">
			<ul class="nav nav-tabs nav-stacked">
				<li><a href="#news">News Feed<i class="pull-right icon-chevron-right"></i></a></li>
				<li><a href="#followers">Blog<i class="pull-right icon-chevron-right"></i></a></li>
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
        <div class="span9 offset3 post-container">
            <?php foreach ($news_feed->result('Post_like_model') as $post) : ?>
                <div class="post-contents" style="width: 700px;">
                    <div class="img-username">
                        <img class="p_dp" src="<?php echo base_url()."public/DP/".$post->image ?>"/>
                        <a href="<?php echo site_url($post->username) ?>" class="link"><?php echo $post->username ?></a><br>
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
                        </div>
                    </div>
                    <!-- end Like and btn -->
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
		<!-- end posts -->
	</div>
</div>

<?php echo $footer; ?>
