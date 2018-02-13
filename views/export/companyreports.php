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
                <h2>Download Company Reports</h2>
                <div class="center">
                    <?php foreach( $this->companylist as $company): ?>
                        <p><a class="waves-effect waves-light btn" href="<?= URL; ?>export/generatecompanyreports/<?= $company['id']; ?>"><i class="material-icons right">input</i><?=  $company['name']; ?> Full Report</a></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'views/footer.php'; ?>
</body>
</html>
