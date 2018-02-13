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
                <h2>Edit Dues for <?= $this->memberinfo[2].' '.$this->memberinfo[3]; ?></h2>
                <div class="row">
                    <div class="col s12">
                        <a class="waves-effect waves-light btn" href="<?php echo URL ?>members/duescreate/<?= $this->memberinfo[0]; ?>">Add Dues</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 card blue lighten-5 z-depth-1">
                        <div class="card-content">
                            <span class="card-title"><?= $this->memberinfo[2].' '.$this->memberinfo[3]; ?> Dues</span>
                            <table class="striped bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Paid</th>
                                        <th colspan="2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach( $this->memberdues as $dues ): ?>
                                        <tr>
                                            <td><?php echo date('F j, Y', strtotime($dues['date'])); ?></td>
                                            <td><?php echo $dues['paid']; ?></td>
                                            <td><a href="<?php echo URL; ?>members/updatedues/<?= $this->memberinfo[0].':'.$dues['id'] ?>">Edit</a></td>
                                            <td><a href="<?php echo URL; ?>members/removedues/<?= $this->memberinfo[0].':'.$dues['id'] ?>">Remove</a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'views/footer.php'; ?>
<div class="fixed-action-btn">
    <a href="<?php echo URL ?>members/create" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('select').material_select();
    });
</script>
</body>
</html>
