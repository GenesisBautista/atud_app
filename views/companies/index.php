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
                <h2>Companies Page!</h2>
                <div>
                    <ul>
                        <a class="waves-effect waves-light btn" href="<?php echo URL ?>companies/create">Add new Company</a>
                    </ul>
                </div>
                <?php if( !empty($_SESSION['memberfunction']) ): ?>
                    <div>
                        <?php echo $_SESSION['memberfunction']; ?>
                    </div>
                <?php endif; ?>
                <div>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Active</th>
                            <th colspan="2">Actions</th>
                        </tr>
                        <?php foreach( $this->companylist as $company ): ?>
                            <tr>
                                <td><?php echo $company['name']; ?></td>
                                <td><?php echo $company['active']? 'Active' : 'Inactive'; ?></td>
                                <td><a href="<?php echo URL; ?>companies/update/<?php echo $company['id'] ?>">Edit</a></td>
                                <?php if($company['active']): ?>
                                  <td><a href="<?php echo URL; ?>companies/deactivate/<?php echo $company['id'] ?>">Deactvate</a></td>
                                <?php else: ?>
                                  <td><a href="<?php echo URL; ?>companies/reactivate/<?php echo $company['id'] ?>">Reactvate</a></td>
                                <?php endif ?>
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
