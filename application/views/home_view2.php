<?php echo $header; ?>

<!-- Register Modal -->
<div id="registerModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="registerModalLabel">1. Basic Information</h3>
    </div>
    <div class="modal-body">
        <p>
            <form class="form-horizontal" id="reg-form">
                <div id="1">
                    <div id="div-fname" class="control-group">
                        <label class="control-label" for="first_name">First Name</label>
                        <div class="controls">
                            <input type="text" id="first_name" name="first_name">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div id="div-lname" class="control-group">
                        <label class="control-label" for="last_name">Last Name</label>
                        <div class="controls">
                            <input type="text" id="last_name" name="last_name">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div id="div-nickname" class="control-group">
                        <label class="control-label" for="nickname">Nickname</label>
                        <div class="controls">
                            <input type="text" id="nickname" name="nickname">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div id="div-email" class="control-group">
                        <label class="control-label" for="email_address">Email</label>
                        <div class="controls">
                            <input type="text" id="email_address" name="email_address">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                </div>
                <div id="2" style="display: none;">
                    <div id="div-uname" class="control-group">
                        <label class="control-label" for="username">Username</label>
                        <div class="controls">
                            <input type="text" id="username" name="username" maxlength="20">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div id="div-pass" class="control-group">
                        <label class="control-label" for="password">Password</label>
                        <div class="controls">
                            <input type="password" id="password" name="password">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                    <div id="div-repass" class="control-group">
                        <label class="control-label" for="repassword">Retype Password</label>
                        <div class="controls">
                            <input type="password" id="repassword" name="password">
                            <span class="help-inline"></span>
                        </div>
                    </div>
                </div>
                <div id="3" style="display: none;">
                    <div class="control-group">
                        <label class="control-label" for="quote">Programming quote</label>
                        <div class="controls">
                            <textarea id="quote" name="quote" maxlength="60"></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="about_me">All about you</label>
                        <div class="controls">
                            <textarea rows="10" id="about_me" name="about_me" maxlength="1000"></textarea>
                        </div>
                    </div>
                </div>
                <div id="4" style="display: none;">
                    Registration Successful! You may now log in your account.
                </div>
            </form>
        </p>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" id="back"><i class="icon-chevron-left icon-white"></i> Back</button>
        <button id="next" class="btn btn-primary">Next <i class="icon-chevron-right icon-white"></i></button>
        <button id="close-reg-form" class="btn" style="display: none;">CLOSE</button>
    </div>
</div>
<!-- end register modal -->

<div class="container" style="margin-top: 5px;">
    <div class="row">
        <?php
        if($this->session->flashdata('stat_error')):
            ?>
            <div class="span12">
                <div class="alert alert-error">
                    <strong><?php echo $this->session->flashdata('stat_error'); ?></strong>
                </div>
            </div>
            <?php
        endif;
        ?>
        <?php
        if($this->session->flashdata('change_success')):
            ?>
            <div class="span12">
                <div class="alert alert-success">
                    <strong><?php echo $this->session->flashdata('change_success'); ?></strong>
                </div>
            </div>
            <?php
        endif;
        ?>
        <?php echo $carousel ?>
        <div class="span12">
            <div class="row">
                <div class="span3">
                    test
                </div>
                <div class="span6">
                    test
                </div>
                <div class="span3">

                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>