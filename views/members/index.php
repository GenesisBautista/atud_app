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
                <h2>Members Page!</h2>
                <div>
                    <ul>
                        <a class="waves-effect waves-light btn" href="<?php echo URL ?>members/create">Add new member</a>
                        <a class="waves-effect waves-light btn" href="<?php echo URL ?>members/search">Advanced Search</a>
                    </ul>
                </div>
                <?php if( !empty($_SESSION['memberfunction']) ): ?>
                    <div class="red-text">
                        <?php echo $_SESSION['memberfunction']; ?>
                    </div>
                <?php endif; ?>
                <div>
                    <table class="highlight">
                        <tr>
                            <th>Company</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th colspan="3">Actions</th>
                        </tr>
                        <?php foreach( $this->memberslist as $members ): ?>
                            <tr>
                                <td><?php echo $members['company']; ?></td>
                                <td><?php echo $members['firstname'].' '.$members['lastname']; ?></td>
                                <td><?php echo $members['title']; ?></td>
                                <td><a href="<?php echo URL; ?>members/update/<?php echo $members['id'] ?>">Edit</a></td>
                                <td><a href="<?php echo URL; ?>members/dues/<?php echo $members['id'] ?>">Dues</a></td>
                                <td><a href="<?php echo URL; ?>members/deactivate/<?php echo $members['id'] ?>">Delete</a></td>
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
