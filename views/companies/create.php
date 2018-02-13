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
                <h2>Create New Companies</h2>
                <div>
                    <form method="post" action="<?php echo URL; ?>companies/runcreate">
                        <div>
                            <label>Company Name: </label><input type="text" name="name" /><br />
                        </div>
                        <div>
                            <button class="btn waves-effect waves-light" type="submit" name="action">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'views/footer.php'; ?>
</body>
</html>