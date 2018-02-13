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
                <h2>New User</h2>
                <div>
                    <form method="post" action="<?php echo URL; ?>admin/runcreateuser">
                        <div>
                            <label>First Name: </label><input type="text" name="fname" /><br />
                            <label>Last Name: </label><input type="text" name="lname" /><br />
                            <label>Email: </label><input type="email" name="email" /><br />
                            <select name="type">
                                <option value="1">Admin</option>
                                <option value="2" selected>User</option>
                            </select>
                        </div>
                        <div>
                            <label>New Password: </label><input type="password" name="password" /><br />
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
</div>
<?php require 'views/footer.php'; ?>
</body>
</html>
