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

                <div class="span8" style="margin-left:0px;">
                    <?php foreach ($notifs->result_array() as $notif) : ?>
                        <?php if ($notif['status'] == 1) { ?>
                            <button class="btn btn-primary btn-block show-notif" data-from="page" style="text-align: left; padding-left: 10px;" id="<?php echo $notif['id'] ?>">
                                <?php echo $notif['message'] ?>
                                <?php $iso_date = date("c", strtotime($notif['created_at'])) ?>
                                <abbr class="pull-right timeago" title="<?php echo $iso_date ?>" style="font-size:13px; padding-right: 10px;">
                                    <?php echo date("M-d-Y H:i:s", strtotime($notif['created_at'])) ?>
                                </abbr>
                            </button>
                        <?php } else { ?>
                            <button class="btn btn-block show-notif" data-from="page" style="text-align: left; padding-left: 10px;" id="<?php echo $notif['id'] ?>">
                                <?php echo $notif['message'] ?>
                                <?php $iso_date = date("c", strtotime($notif['created_at'])) ?>
                                <abbr class="pull-right timeago" title="<?php echo $iso_date ?>" style="font-size:13px; padding-right: 10px;">
                                    <?php echo date("M-d-Y H:i:s", strtotime($notif['created_at'])) ?>
                                </abbr>
                            </button>
                        <?php } ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div><!-- row -->
    </div><!-- row -->
</div><!-- container -->

<?php echo $footer; ?>