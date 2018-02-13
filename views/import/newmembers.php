<html>
<head>

</head>
<body>
<?php require 'views/header.php'; ?>
New Members Page!
<div>
    <p>Members that do not have past </p>
</div>
<div>
    <table>
        <tr>
            <th>Company ID</th>
            <th>Name</th>
            <th colspan="2">Actions</th>
        </tr>
        <?php $i = 1;
        foreach( $_SESSION['newmembers'] as $members ): ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $members['G']; ?></td>
                <td><?php echo $members['D']; ?></td>
                <td><a href="<?php echo URL; ?>members/update/<?php echo $members['id'] ?>">Edit</a></td>
                <td><a href="<?php echo URL; ?>members/deactivate/<?php echo $members['id'] ?>">Delete</a></td>
            </tr>
        <?php
            $i++;
        endforeach; ?>
    </table>
</div>
</body>
</html>
