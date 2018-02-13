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
                <h2 class="subheader">User Page</h2>
                <form action="<?php echo URL; ?>user/update" method="post">
                    <div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" name="fname" id="fname" value="<?php echo $_SESSION['userinfo'][2] ?>" />
                                <label for="fname">First Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" id="lname" name="lname" value="<?php echo $_SESSION['userinfo'][3] ?>" />
                                <label for="fname">Last Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="email" id="email" name="email" value="<?php echo $_SESSION['userinfo'][1] ?>" class="validate" />
                                <label for="email">Email</label>
                            </div>
                        </div>

                    </div>
                    <div>
                        <button class="btn waves-effect waves-light" type="submit" name="action">
                            Submit
                            <i class="material-icons right">done</i>
                        </button>
                        <a class="right" href="<?= URL; ?>user/changepassword">Change Password</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require 'views/footer.php'; ?>
</body>
</html>