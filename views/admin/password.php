<html>
<head>
    <?php require 'views/head.php'; ?>
</head>
<body>
<?php require 'views/header.php'; ?>
<div class="container">
    <div class="section">
        <div class="row">
            <div class="col s12 m12 l12">
                <h2>Change Password</h2>
                <form action="<?php echo URL; ?>admin/updatepassword/<?php echo $this->id; ?>" method="post">
                    <?php if( !empty($_SESSION['adminfunction']) ): ?>
                        <div>
                            New password does not match. no changes made.
                        </div>
                    <?php endif;?>
                    <div>
                        <label>New Password: </label><input type="password" name="new" /><br />
                        <label>Verify New Password: </label><input type="password" name="verify" /><br />
                    </div>
                    <button class="btn waves-effect waves-light" type="submit" name="action">
                        Submit
                        <i class="material-icons right">done</i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require 'views/footer.php'; ?>
</body>
</html>