<div class="thumbnail span3 pull-left profile-picture">
    <?php
        $dp = base_url()."public/DP/".$user_info['image'];
    ?>
    <img src="<?php echo $dp ?>" class="thumbnails dp">
    <div class="caption">
        <?php if ($is_your_profile) { ?>
        <?php if ($this->session->flashdata('upload_status') == "error") { ?>
            <div class="alert alert-error">
                <?php echo $this->session->flashdata('upload_msg') ?>
            </div>
        <?php } else if ($this->session->flashdata('upload_status') == "success") { ?>
            <div class="alert alert-info">
                <?php echo $this->session->flashdata('upload_msg') ?>
            </div>
        <?php } ?>
        <form action="upload" class="form-search" method="POST" enctype="multipart/form-data">
            <a href="#" style="white-space: nowrap; overflow: hidden; max-width: 80px;" id="choose-pic" class="btn">Change</a>
            <input type="submit" id="btn-upload" class="btn disabled btn-info" disabled="disabled" value="Upload"/>
            <div style='height: 0px;width: 0px; overflow:hidden;'>
                <input id="upfile" name="upfile" type="file"/>
            </div>
        </form>
        <?php } ?>
        <h4>About Me</h4>
        <?php if ($user_info['about_me'] != '') { ?>
            <p><?php echo $user_info['about_me'] ?></p>
        <?php } else {?>
            <p>I will say something about me later..</p>
        <?php } ?>
    </div>
</div>