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
                <h2>Edit user</h2>
                <div>
                    <form method="post" action="<?php echo URL; ?>admin/runedit/<?php echo $this->userinfo[0]; ?>">
                        <div>
                            <label>First Name: </label><input type="text" name="fname" value="<?php echo $this->userinfo[2] ?>" /><br />
                            <label>Last Name: </label><input type="text" name="lname" value="<?php echo $this->userinfo[3] ?>" /><br />
                            <label>Email: </label><input type="email" name="email" value="<?php echo $this->userinfo[1] ?>" /><br />
                            <select name="type">
                                <option value="1" <?php echo ( $this->userinfo[4] == 1 ) ? 'selected': '';?>>Admin</option>
                                <option value="2" <?php echo ( $this->userinfo[4] == 2 ) ? 'selected': '';?>>User</option>
                            </select>
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
