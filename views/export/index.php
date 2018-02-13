<html>
<head>
    <?php require 'views/head.php'; ?>
</head>
<body>
<?php require 'views/header.php'; ?>
<div class="container" style="height: 100%;">
    <div class="section" style="height: 100%;">
        <div class="row valign-wrapper" style="height: 100%;">
            <div class="col s12 m12 l12 valign" style="height: 100%;">
                <h2>Export Page!</h2>
                <div>
                    <a class="waves-effect waves-light btn" href="<?= URL; ?>export/fullreport"><i class="material-icons right">input</i>Full Report</a>
                    <a class="waves-effect waves-light btn" href="<?= URL; ?>export/memberreport">Individual Reports</a>
                    <a class="waves-effect waves-light btn" href="<?= URL; ?>export/companyreports">Company Reports</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'views/footer.php'; ?>
</body>
</html>
