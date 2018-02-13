<html>
<head>
    <?php require 'views/head.php'; ?>
</head>
<body>
<?php require 'views/header.php'; ?>
<div class="container">
    <div class="section">
        <div class="row">
            <div class="col s12 m8 l6 offset-l3 offset-m2">
                <h2 class="subheader">Change Password</h2>
                <form action="<?php echo URL; ?>user/updatepassword" method="post">
                    <?php if( $this->msg == 'complete' ): ?>
                        <div class="green-text">
                            Password Changed
                        </div>
                    <?php elseif( $this->msg == 'wrongpass' ): ?>
                        <div class="red-text">
                            Old password incorrect. no changes made.
                        </div>
                    <?php elseif( $this->msg == 'noverify' ): ?>
                        <div class="red-text">
                            New password does not match. no changes made.
                        </div>
                    <?php endif;?>
                    <div>
                        <h4>Please enter your current password</h4>
                        <div class="row">
                            <div class="input-field col s12">

                                <input type="password" name="current" id="current" />
                                <label for="current">Current Password</label>
                            </div>
                        </div>
                        <h4>Please enter a new password and verify it</h4>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="password" name="new" id="new" />
                                <label for="new">New Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="password" name="verify" id="verify" />
                                <label for="verify">Verify New Password</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="btn waves-effect waves-light" type="submit" name="action">
                            Update
                            <i class="material-icons right">done</i>
                        </button>
                        <a class="right" href="<?= URL; ?>user">Change user info</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require 'views/footer.php'; ?>
</body>
</html>