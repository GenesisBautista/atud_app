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
                <h2>Deactivate Company</h2>
                <div>
                    <span class="red-text">Deactivating this company will also deactivate all of its members!</span>
                    <div>
                        <a class="btn waves-effect waves-light" href="<?= URL; ?>companies/rundeactivate/<?php echo $this->id; ?>">Deactivate Company</a>
                    </div>
                    <table>
                        <tr>
                            <th>Company</th>
                            <th>Name</th>
                            <th>Role</th>
                        </tr>
                        <?php foreach( $this->memberslist as $members ): ?>
                            <tr>
                                <td><?php echo $members['company']; ?></td>
                                <td><?php echo $members['firstname'].' '.$members['lastname']; ?></td>
                                <td><?php echo $members['title']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <div>
                        <a class="btn waves-effect waves-light" href="<?= URL; ?>companies/rundeactivate/<?php echo $this->id; ?>">Deactivate Company</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'views/footer.php'; ?>
</body>
</html>
