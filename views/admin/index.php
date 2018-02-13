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
                <h2>Admin Page</h2>
                <div>
                    <a class="waves-effect waves-light btn" href="<?php echo URL ?>admin/createuser">Create new user</a>
                </div>
                <?php if( !empty($_SESSION['adminfunction']) ): ?>
                    <div>
                        <?php echo $_SESSION['adminfunction']; ?>
                    </div>
                <?php endif; ?>
                <div>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th colspan="3">Actions</th>
                        </tr>
                        <?php foreach( $this->userlist as $user ): ?>
                            <tr>
                                <td><?php echo $user['firstName'].' '.$user['lastName']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo ($user['type'] == 1) ? 'admin' : 'user'; ?></td>
                                <td><a href="<?php echo URL; ?>admin/edit/<?php echo $user['id'] ?>">Edit</a></td>
                                <td><a href="<?php echo URL; ?>admin/delete/<?php echo $user['id'] ?>">Delete</a></td>
                                <td><a href="<?php echo URL; ?>admin/password/<?php echo $user['id'] ?>">Change Password</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'views/footer.php'; ?>
</body>
</html>