<div class="hero-unit profile-header">
    <h4>function </h4>
    <h1 style="margin-left:0px;"><?php echo $user_info['username']; ?>() </h1>
    <?php if ($user_info['quote'] != '') { ?>
    <p>{ <span class="<?php echo ($is_your_profile) ? "p_to_text_q" : "" ?>"><?php echo $user_info['quote'] ?></span> }</p>
    <?php } else { ?>
    <p>{ <span class="<?php echo ($is_your_profile) ? "p_to_text_q" : "" ?>">Don't mess with the programmers...</span> }</p>
    <?php } ?>
</div>